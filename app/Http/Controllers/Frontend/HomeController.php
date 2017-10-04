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
    public function __construct()
    {
        Auth::logout();
    }

    public function index(Request $request) {
        $truyenma = 4;
        $types = Type::all();
        $tops_30 = Post::whereStatus('1')->where('created_at', '>=', date('Y-m-d', time() - 24*3600*30))->orderBy('view', 'DESC')->limit(5)->get();
        $tops_7 = Post::whereStatus('1')->where('created_at', '>=', date('Y-m-d', time() - 24*3600*7))->orderBy('view', 'DESC')->limit(7)->get();
        if($request->timkiem) {
            if($request->timkiem == 'truyen-sex') {
                $posts = Post::whereStatus(1)
                    ->where('type', '<>', $truyenma)
                    ->orderBy('created_at', 'DESC')
                    ->paginate(15);
            } else {
                $posts = Post::whereStatus(1)
                    ->where('title', 'like', '%' . $request->timkiem . '%')
                    ->orderBy('created_at', 'DESC')
                    ->paginate(15);
            }
        } else {
            $posts = Post::with('User')->whereStatus('1')->orderBy('created_at', 'DESC')->paginate(15);
        }
        return view('frontend.index', compact('posts', 'types', 'tops_30', 'tops_7'));
    }
}
