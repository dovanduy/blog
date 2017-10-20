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
        $types = Type::all();
        $type_dcd = json_decode(Type::pluck('name_unicode'));

        if($request->timkiem) {
            if($request->timkiem == 'truyenxxx' || categoryStory($request->timkiem) == 'truyen-nguoi-lon') {
                $posts = Post::whereStatus(1)
                    ->orderBy('created_at', 'DESC')
                    ->paginate(15);
            } elseif (in_array(categoryStory($request->timkiem), $type_dcd)) {
                $id = Type::select('id')->whereName_unicode(categoryStory($request->timkiem))->first();
                $posts = Post::whereStatus(1)
                    ->whereType($id->id)
                    ->orderBy('created_at', 'DESC')
                    ->paginate(15);
            } else {
                $posts = Post::whereStatus(1)
                    ->where('title_seo', 'like', '%' . categoryStory($request->timkiem) . '%')
                    ->orderBy('created_at', 'DESC')
                    ->paginate(15);
            }
        } else {
            $posts = Post::with('User')->whereStatus('1')->orderBy('created_at', 'DESC')->paginate(15);
        }
        $tops_30 = Post::whereStatus('1')->where('created_at', '>=', date('Y-m-d', time() - 24*3600*30))->orderBy('view', 'DESC')->limit(5)->get();
        $tops_7 = Post::whereStatus('1')->where('created_at', '>=', date('Y-m-d', time() - 24*3600*7))->orderBy('view', 'DESC')->limit(7)->get();
        return view('frontend.index', compact('posts', 'types', 'tops_30', 'tops_7'));
    }
}
