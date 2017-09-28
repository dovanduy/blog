<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Type;
use App\Post;

class StoryController extends Controller
{
    //
    public function index($name) {

        $types = Type::all();
        $story = Post::where('title_seo', $name)->first();
        $view = $story->view;
        $story->view = $view + 1;
        $story->save();
        return view('frontend.story', compact('story', 'types'));
    }
}
