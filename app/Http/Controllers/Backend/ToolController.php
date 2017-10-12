<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Type;
use App\Tool;
use App\Post;
use Auth;
use File;
use Response;

class ToolController extends Controller
{
    public function __construct()
    {
        date_default_timezone_set("Asia/Ho_Chi_Minh");
        $this->middleware('auth');
    }

    private function multiple_threads_request($nodes)
    {
        $mh = curl_multi_init();
        $curl_array = array();
        foreach ($nodes as $i => $url) {
            $curl_array[$i] = curl_init($url);
            curl_setopt($curl_array[$i], CURLOPT_RETURNTRANSFER, true);
            curl_multi_add_handle($mh, $curl_array[$i]);
        }
        $running = NULL;
        do {
            usleep(10000);
            curl_multi_exec($mh, $running);
        } while ($running > 0);

        $res = array();
        foreach ($nodes as $i => $url) {
            $res[$url] = curl_multi_getcontent($curl_array[$i]);
        }

        foreach ($nodes as $i => $url) {
            curl_multi_remove_handle($mh, $curl_array[$i]);
        }
        curl_multi_close($mh);
        return $res;
    }

    public function index(Request $request)
    {
        $sites = Tool::all();
        $types = Type::all();
        if($request->select_site) {
            //get site
            $get_site = $request->get_site;

            $site_id = $request->select_site;
            $page = Tool::find($site_id);
            //content
            $start_content = $page->start_content_code;
            $end_content = $page->end_content_code;
            //title
            $start_title = $page->start_title_code;
            $end_title = $page->end_title_code;

            $start_page = $page->start_url_child;
            $end_page = $page->end_url_child;
//cout total page
            $get_paginate = array_values($this->multiple_threads_request(array($get_site)));
            $start = strpos($get_paginate[0], $start_page);
            $str = substr($get_paginate[0], $start);
            $end = strpos($str, $end_page);
            $str = explode(' ', strip_tags(substr($str, 0, $end)));
            $total_page = $str[count($str) - 1];
            if ($total_page == null) {
                $total_page = 1;
            }
            //title
            $start = strpos($get_paginate[0], $start_title) + strlen($start_title);
            $str = substr($get_paginate[0], $start);
            $end = strpos($str, $end_title);
            $title = strip_tags(substr($str, 0, $end));
//content
            $site = array($get_site);
            for ($i = 2; $i <= $total_page; $i++) {
                $site[] = $get_site . '/' . $i;
            }
            $html = array_values($this->multiple_threads_request($site));

            for ($i = 0; $i < $total_page; $i++) {
                $start = strpos($html[$i], $start_content) + strlen($start_content);
                $str = substr($html[$i], $start);
                $end = strpos($str, $end_content);
                $body[] = substr($str, 0, $end);
            }

            $body = implode(' ', $body);
            $body = str_replace(' j ', ' gì ', $body);
            $title_seo = changeTitle($title);
            $count_title_seo = Post::whereTitle_seo($title_seo)->count();
            $count_title_seo==0?'':$title_seo=changeTitle($title.time());
            return view('backend.tool.request', compact('body', 'title', 'title_seo', 'sites', 'types'));
        } elseif ($request->select_site_download) {
            $full_site = array();
            $id = $request->select_site_download;
            $site = Tool::find($id);
            $url = $site->site;
            $start_url_parent = $site->start_url_parent;
            $end_url_parent = $site->end_url_parent;
            $url_parent = $site->url_parent;
//get total page
            $parent_code = array_values($this->multiple_threads_request(array($url)));
            $start = strpos($parent_code[0], $start_url_parent);
            $str = substr($parent_code[0], $start);
            $end = strpos($str, $end_url_parent)+strlen($end_url_parent);
            $ok_body[] = substr($str, 0, $end);
            $parent_paginate = explode($start_url_parent, $parent_code[0]);
            $end_parent_paginate = array_pop($parent_paginate);
            $last_code_parent = explode($url . $url_parent,$end_parent_paginate);
            $last_code_parent = str_replace("'", '"', $last_code_parent);
            $first_string_parent = explode('"',array_pop($last_code_parent));
            $total_good_page = array_shift($first_string_parent);

            for($i=$total_good_page; $i>=1;$i--) {
                $full_site[] = $url . $url_parent . $i;
            }

            $html = $this->multiple_threads_request($full_site);
            $count_site = count($html);
            $html = array_values($html);

            $result =array();
            for ($i=0;$i<$count_site; $i++) {
                $body[] = explode($start_url_parent, $html[$i]);
                array_shift($body[$i]);
                $count_page = count($body[$i]);
                for($j=0;$j<$count_page;$j++) {
                    preg_match_all('/<a[^>]+href=([\'"])(?<href>.+?)\1[^>]*>/i', $body[$i][$j], $result);
                    if (!empty($result)) {
                        # Found a link.
                        $m[] = $result['href'][0];
                    }
                }
            }
            $txt = implode(PHP_EOL ,$m);

            File::put(storage_path('site.txt'), $txt);

            $file= storage_path('site.txt');

            $headers = array(
                'Content-Type: application/text',
            );

            return Response::download($file, 'site.txt', $headers);
        } else {
            return view('backend.tool.index', compact('types', 'sites'));
        }
    }

    public function siteStory(Request $request)
    {
        $site = json_decode(Tool::pluck('site'));
        $choose_site = $request->site;
        if (count($site) == 0 || !in_array($choose_site, $site)) {
            $tool = new Tool();
            $tool->user_id = Auth::id();
            $tool->site = $choose_site;
            $tool->start_title_code = $request->start_title_code;
            $tool->end_title_code = $request->end_title_code;
            $tool->start_content_code = $request->start_content_code;
            $tool->end_content_code = $request->end_content_code;
            $tool->url_child = $request->url_child;
            $tool->start_url_child = $request->start_url_child;
            $tool->end_url_child = $request->end_url_child;
            $tool->url_parent = $request->url_parent;
            $tool->start_url_parent = $request->start_url_parent;
            $tool->end_url_parent = $request->end_url_parent;
            $tool->save();
            return redirect(route('tool'))->with('mes', 'Đã thêm site thành công...');
        } else {
            $tool = Tool::whereSite($choose_site)->first();
            $tool->start_title_code = $request->start_title_code;
            $tool->end_title_code = $request->end_title_code;
            $tool->start_content_code = $request->start_content_code;
            $tool->end_content_code = $request->end_content_code;
            $tool->url_child = $request->url_child;
            $tool->start_url_child = $request->start_url_child;
            $tool->end_url_child = $request->end_url_child;
            $tool->url_parent = $request->url_parent;
            $tool->start_url_parent = $request->start_url_parent;
            $tool->end_url_parent = $request->end_url_parent;
            $tool->save();
            return redirect(route('tool'))->with('mes', 'Đã sửa site thành công...');
        }
    }

    public function postCreate(Request $request)
    {
        date_default_timezone_set("Asia/Ho_Chi_Minh");
        $content = $request->content_;
        $this->validate($request, [
            'content_' => 'required|min:10'
        ], [
            'content_.required' => 'Bạn cần xem lại nội dung đã nhập...',
            'content_.min' => 'Nội dung của bạn phải từ 10 ký tự trở lên',
        ]);
        if (!isset($content)) {
            return redirect(url(route('post.create') . '/create'))->with('er', 'Vui lòng bạn nhập lại');
        } else {
            $count_title_seo = Post::whereTitle_seo(changeTitle($request->title))->count();
            $post = new Post();
            $post->title = $request->title;
            $count_title_seo > 0 ? $post->title_seo = changeTitle($request->title) . '-' . time() : $post->title_seo = changeTitle($request->title);
            $post->title_seo = $request->title_seo;
            $post->content = $content;
            $post->type = $request->type;
            $post->user_id = Auth::id();
            $request->status == '1' || $request->status == 1 ? $post->status = 1 : $post->status = 0;
            $post->save();
            return redirect(route('tool'))->with('mes', 'Đã thêm truyện...');
        }
    }

    public function siteDelete($id, Request $request)
    {
        $tool = Tool::find($id);
        $tool->delete();
        return redirect(route('tool'))->with('mes', 'Đã xóa site thành công...');
    }

    public function searchSite(Request $request)
    {
        $site = $request->search_site;
        $search = Tool::where('site', 'LIKE', "%$site%")->limit(5)->get();
        return $search;
    }
}