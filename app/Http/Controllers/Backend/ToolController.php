<?php
namespace App\Http\Controllers\Backend;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Type;
use App\Tool;
use App\Post;
use Auth;
use App\Test;

class ToolController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function codeHtml($url) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0");
// receive server response ...
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $server_output = curl_exec($ch);
//        curl_copy_handle($ch);
        curl_close($ch);
        return $server_output;
    }

    public function paginationCodeHtml($urls)
    {
        $count_site = count($urls);

        $curl_arr = array();
        $master = curl_multi_init();

        for($i = 0; $i < $count_site; $i++)
        {
            $url =$urls[$i];
            $curl_arr[$i] = curl_init($url);
            curl_setopt($curl_arr[$i], CURLOPT_USERAGENT, "Mozilla/5.0");
            curl_setopt($curl_arr[$i], CURLOPT_RETURNTRANSFER, true);
            curl_multi_add_handle($master, $curl_arr[$i]);
        }


        do {
            curl_multi_exec($master,$running);
        } while($running > 0);

        $results = array();
        for($i = 0; $i < $count_site; $i++)
        {
            $results[] = curl_multi_getcontent  ( $curl_arr[$i]  );
        }
        return $results;
    }

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
            'title' => [],
            'pagination' => '',
            'test' => []
        ];
        $site_pagination = array();
        $get_site = $request->get_site;
        $id = $request->select_site;
        $site_id = json_decode(Tool::pluck('id'));
        $tool = Tool::find($id);

        //content db
        $start_content_code = $tool->start_content_code;
        $end_content_code = $tool->end_content_code;
        //title db
        $start_title_code = $tool->start_title_code;
        $end_title_code = $tool->end_title_code;
        // pagination
        $start_url_child = $tool->start_url_child;
        $end_url_child = $tool->end_url_child;
        if ($get_site != null || in_array($id, $site_id)) {
            $server_output = (new Test())->test($get_site);

//            $server_output = $this->codeHtml($get_site);
//            $b = $this->codeHtml($get_site);
            // pagination
            if (strpos("$server_output", $end_url_child)) {
                $start_pagination = strpos("$server_output", $start_url_child) + strlen($start_url_child);
                $end_pagination = strpos("$server_output", $end_url_child) - $start_pagination;
                $pagination = substr($server_output, $start_pagination, $end_pagination);
                $pagination_strlen = strlen($pagination);
                $code['pagination'] = substr($pagination, $pagination_strlen - 1); //get end page
            }
//content
            $start_content = strpos("$server_output", $start_content_code) + strlen($start_content_code);
            $end_content = strpos("$server_output", $end_content_code) - $start_content;
            $code['content'] = substr($server_output, $start_content, $end_content);

            $str_content = $code['content'];

            for ($i =2 ; $i <=(int)$code['pagination']; $i++) {
                $site_pagination[] = $get_site . $tool->url_child . $i;
            }

//            $code['test'][] = $this->paginationCodeHtml($site_pagination);

//title
            $start_title = strpos("$server_output", $start_title_code) + strlen($start_title_code);
            $end_title = strpos("$server_output", $end_title_code) - $start_title;
            $code['title'] = substr($server_output, $start_title, $end_title);

            return $site_pagination;
        }
        $code['test'][] = $this->paginationCodeHtml($site_pagination);
        return $code;
//        $m =array();
//        $b = new Test();
//        $a = new Test();
//        $c = new Test();
//        $m[] = $a->test('http://php.net/');
////        $m[] = $b->test('https://www.google.com.vn');
////        $m[] = $c->test('https://www.google.com.vn');
////        $m[] = $c->test('http://truyensex88.net');
//        $m[] = $this->paginationCodeHtml(array('https://www.google.com.vn', 'https://www.google.com.vn', 'https://www.google.com.vn'));
//        return $m;
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