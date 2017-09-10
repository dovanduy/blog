<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Type;
use App\Tool;
use Auth;

class ToolController extends Controller
{
    //
    public function index()
    {
        $sites = Tool::all();
        $types = Type::all();
        return view('backend.tool.index', compact('types', 'sites'));
    }

    public function getStory(Request $request)
    {
//        $code = [
//            'title' => [],
//            'content' => []
//        ];
//        $get_site = $request->get_site;
//        $site = json_decode(Tool::pluck('site'));
//        $code = file_get_contents('http://truyensex88.net/ky-uc-da-qua.html');
//        $start_content = strpos($code, '<div id="content" class="pad">')+strlen('<div id="content" class="pad">');
//        $end_content = strpos($code, '<a class="addthis_button_google_plusone"')-$start_content;
//        $code_body = substr($code,$start_content, $end_content);
//        return $request->all();

//        return array($code_body);
//        $code = [
//            'title' => [],
//            'content' => []
//        ];
//        $get_site = $request->get_site;
//        $id = $request->select_site;
//        $site = json_decode(Tool::pluck('site'));
////        if (in_array(, $site)) {
//
//            $tool = Tool::find((int)$request->select_site);
//        $code = file_get_contents('http://truyensex88.net/ky-uc-da-qua.html');
//        $start_content = strpos($code, '<div id="content" class="pad">')+strlen('<div id="content" class="pad">');


//            $test = 'http://truyensex88.net/cam-sung.html';
//            $code = file_get_contents("http://truyensex88.net/cam-sung.html");
//        $start_content = strpos($code, '<div id="content" class="pad">')+strlen('<div id="content" class="pad">');
//            $start_content = strpos($code, $tool->start_content_code + strlen($tool->start_content_code));
//            $end_content = strpos($code, $tool->end_content_code - $start_content);
//            $code_body = substr($code, $start_content, $end_content);
//        }


        $get_site = $request->get_site;
        $id = $request->select_site;

        $tool = Tool::find($id);


        $code = file_get_contents($get_site);
        $start_content = strpos($code, $tool->start_content_code)+strlen($tool->start_content_code);
        $end_content = strpos($code, '<a class="addthis_button_google_plusone"')-$start_content;
        $code_body = substr($code,$start_content, $end_content);

        return $code_body;
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
