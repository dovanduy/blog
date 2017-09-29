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
            $type_name = Type::whereName_unicode($name)->first();
            $type_id = $type_name->id;
            $posts = Post::with('User')->whereType($type_id)->whereStatus('1')->orderBy('created_at', 'DESC')->paginate(15);

            $types = Type::all();
            $tops_30 = Post::whereStatus('1')->where('created_at', '>=', date('Y-m-d', time() - 24*3600*30))->orderBy('view', 'DESC')->limit(5)->get();
            $tops_7 = Post::whereStatus('1')->where('created_at', '>=', date('Y-m-d', time() - 24*3600*7))->orderBy('view', 'DESC')->limit(7)->get();
            return view('frontend.category', compact('posts', 'types', 'tops_30', 'tops_7', 'type_name'));
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
