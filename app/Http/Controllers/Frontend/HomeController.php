<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Post;
use App\Type;
use Auth;

class HomeController extends Controller
{
    //
    public function index() {
        Auth::logout();
        $posts = Post::with('User')->whereStatus('1')->orderBy('created_at', 'DESC')->paginate(15);
        $types = Type::all();
        $tops_30 = Post::whereStatus('1')->where('created_at', '>=', date('Y-m-d', time() - 24*3600*30))->orderBy('view', 'DESC')->limit(5)->get();
        $tops_7 = Post::whereStatus('1')->where('created_at', '>=', date('Y-m-d', time() - 24*3600*7))->orderBy('view', 'DESC')->limit(7)->get();
        return view('frontend.index', compact('posts', 'types', 'tops_30', 'tops_7'));
    }
}
