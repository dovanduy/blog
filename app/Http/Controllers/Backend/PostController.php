<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Post;
use App\Type;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    //
    public $role_admin = 1;
    public $role_leader = 2;
    public $role_bus = 3;


    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index() {
        $user_id = Auth::id();
        $role = User::where('id', $user_id)->pluck('role');

        if ($role[0] == $this->role_admin || $role[0] == $this->role_leader) {
            $posts = Post::with('Type')->orderBy('id','DESC')->paginate(10);
        } else {
            $posts = Post::with('Type')->orderBy('id','DESC')->where('user_id', $user_id)->paginate(10);
        }

        return view('backend.post.index', compact('posts'));
    }
    //Thêm truyện
    public function create() {
        $types = Type::all();
        return view('backend.post.create', compact('types'));
    }

    public function postCreate(Request $request) {
        date_default_timezone_set("Asia/Ho_Chi_Minh");
        $count_title_seo = Post::whereTitle_seo(str_replace(' ', '_', $request->title))->count();
        $post = new Post();
        $post->title = $request->title;
        $count_title_seo > 0 ? $post->title_seo = stripUnicode(str_replace(' ', '_', $request->title) + '_' + time()) : stripUnicode($post->title_seo = str_replace(' ', '_', $request->title));
        $post->title_seo = $request->title_seo;
        $post->content = $request->content_;
        $post->type = $request->type;
        $post->user_id = Auth::id();
        $request->status == '1' || $request->status == 1 ? $post->status = 1 : $post->status = 0;
        $post->save();
        return redirect(route('post'))->with('mes', 'Đã thêm truyện...');
    }

    //Sửa truyện
    public function edit($id) {
        $role = '';
        $user_id_ = Post::with('User')->whereId($id)->get();
        $ar_user_id = Post::whereId($id)->pluck('user_id');
        foreach ($user_id_ as $val) {
            if ($val->User()->first() == null) {
                $role = 1;
            } else {
                $role =  $val->User()->first()->role;
            }
        }
        if ($role == $this->role_admin || $role == $this->role_leader) {
            $types = Type::all();
            $post = Post::find($id);
            return view('backend.post.edit', compact('types', 'post'));
        } elseif ($ar_user_id['id'] == Auth::id() &&  $role == $this->role_bus) {} else {
            return redirect(route('post'))->with('er', 'Không phải truyện của bạn...');
        }
    }

    public function postEdit($id, Request $request) {
        $count_title_seo = Post::whereTitle_seo($request->title_seo)->whereId($id)->count();
        $post = Post::find($id);
        $post->title = $request->title;
        $count_title_seo > 0 ? $post->title_seo = stripUnicode(str_replace(' ', '_', $request->title) + '_' + time()) : stripUnicode($post->title_seo = str_replace(' ', '_', $request->title));
        $post->title_seo = $request->title_seo;
        $post->content = $request->content_;
        $post->type = $request->type;
        $post->user_id = Auth::id();
        $request->status == '1' || $request->status == 1 ? $post->status = 1 : $post->status = 0;
        $post->save();
        return redirect(route('post'))->with('mes', 'Đã sửa truyện...');
    }

    //xóa truyện
    public function delete($id) {
        $role = '';
        $user_id_ = Post::with('User')->whereId($id)->get();
        $ar_user_id = Post::whereId($id)->pluck('user_id');
        foreach ($user_id_ as $val) {
            if ($val->User()->first() == null) {
                $role = 1;
            } else {
                $role =  $val->User()->first()->role;
            }
        }
        if ($role == $this->role_admin || $role == $this->role_leader) {
            $post = Post::find($id);
            $post->delete();
            return redirect(route('post'))->with('mes', 'Đã xóa truyện...');
        } elseif ($ar_user_id['id'] == Auth::id() &&  $role == $this->role_bus) {} else {
            return redirect(route('post'))->with('er', 'Không phải truyện của bạn...');
        }

    }

    public function ajaxEditShortContent(Request $request) {
        $id = $request->id;
        $title_Seo = $request->title_seo;
        $post = Post::find($id);
        $post->title_seo = $title_Seo;
        $post->save();
        return $post;
    }

    public function ajaxEditContent(Request $request) {
        $id = $request->id;
        $content = $request->content_;
        $post = Post::find($id);
        $post->content = $content;
        $post->save();
        return $post;
    }

    public function ajaxEditStatus(Request $request) {
        $id = $request->id;
        $status = $request->status;
        $post = Post::find($id);
        $post->status = $status;
        $post->save();
        return $post;
    }

    public function validateTitleSeo(Request $request) {
        return $request->title_seo;
    }
}
