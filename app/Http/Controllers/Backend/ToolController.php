<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Type;

class ToolController extends Controller
{
    //
    public function index() {
        $types = Type::all();
        return view('backend.tool.index', compact('types'));
    }

    public function getStory(Request $request) {
        $html = file_get_contents('http://truyensex88.net/ky-uc-da-qua.html');
        return htmlspecialchars($html);
    }

    public function siteStory(Request $request) {

        return redirect(route('tool'));
    }
}
