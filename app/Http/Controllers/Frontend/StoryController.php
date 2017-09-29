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
        $array_category = json_decode(Type::pluck('name_unicode'));
        $admin = 'admin';
        if ($name == $admin) {
            return redirect()->route('login');
        } elseif (in_array($name, $array_category)) {

        } else {
            $types = Type::all();
            $story = Post::where('title_seo', $name)->first();
            $view = $story->view;
            $story->view = $view + 1;
            $story->save();
            return view('frontend.story', compact('story', 'types'));
        }

    }
}
