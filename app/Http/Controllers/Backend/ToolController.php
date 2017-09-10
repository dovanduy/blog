<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Type;
use App\Tool;
use App\Post;
use Auth;

class ToolController extends Controller
{
    public function index()
    {
        $sites = Tool::all();
        $types = Type::all();
        return view('backend.tool.index', compact('types', 'sites'));
    }

    public function getStory(Request $request)
    {
        $code = [
            'content' => [],
            'title' => []
        ];
        $get_site = $request->get_site;
        $id = $request->select_site;
        $site_id = json_decode(Tool::pluck('id'));
        $tool = Tool::find($id);
        if ($get_site!=null || in_array($id, $site_id)) {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $get_site);
            curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0");
// receive server response ...
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            $server_output = curl_exec($ch);
            curl_close($ch);
//content
            $start_content = strpos("$server_output", "$tool->start_content_code")+strlen("$tool->start_content_code");
            $end_content = strpos("$server_output", "$tool->end_content_code")-$start_content;
            $code['content'] = substr($server_output, $start_content, $end_content);
//title
            $start_title = strpos("$server_output", "$tool->start_title_code")+strlen("$tool->start_title_code");
            $end_title = strpos("$server_output", "$tool->end_title_code")-$start_title;
            $code['title'] = substr($server_output, $start_title, $end_title);

            return $code;
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
            $tool->save();
            return redirect(route('tool'))->with('mes', 'Đã thêm site thành công...');
        } else {
            $tool = Tool::whereSite($choose_site)->first();
            $tool->start_title_code = $request->start_title_code;
            $tool->end_title_code = $request->end_title_code;
            $tool->start_content_code = $request->start_content_code;
            $tool->end_content_code = $request->end_content_code;
            $tool->save();
            return redirect(route('tool'))->with('mes', 'Đã sửa site thành công...');
        }
    }

    public function postCreate(Request $request) {
        date_default_timezone_set("Asia/Ho_Chi_Minh");
        $content = $request->content_;
        $this->validate($request, [
            'content_' => 'required|min:10'
        ], [
            'content_.required' => 'Bạn cần xem lại nội dung đã nhập...',
            'content_.min' => 'Nội dung của bạn phải từ 10 ký tự trở lên',
        ]);
        if (!isset($content)) {
            return redirect(url(route('post.create').'/create'))->with('er', 'Vui lòng bạn nhập lại');
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
        $search = json_decode(Tool::where('site', 'LIKE', "%$site%")->limit(5)->pluck('site'));
        return $search;
    }
}
