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

    public function getStory() {

    }
}
