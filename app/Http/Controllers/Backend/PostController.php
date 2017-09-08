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

    public function index()
    {
        $user_id = Auth::id();
        $role = User::where('id', $user_id)->pluck('role');
        $authors = Post::with('User')->select('user_id')->get();
        $authors_not_curent = Post::join('users', 'posts.user_id', '=', 'users.id')
            ->where('posts.user_id', '<>', $user_id)
            ->where('users.role', '=', $this->role_leader)
            ->pluck('posts.id');

        if ($role[0] == $this->role_admin) {
            $posts = Post::with('Type')->orderBy('id', 'DESC')->paginate(10);
        } elseif ($role[0] == $this->role_leader) {
            $posts = Post::with('Type')
                ->join('users', 'posts.user_id', '=', 'users.id')
                ->selectRaw('posts.*, users.role')
                ->whereIn('users.role', [$this->role_leader, $this->role_bus])
                ->whereNotIn('posts.id', $authors_not_curent)
                ->orderBy('id', 'DESC')->paginate(10);
        } else {
            $posts = Post::with('Type')->orderBy('id', 'DESC')->where('user_id', $user_id)->paginate(10);
        }
        $types = Type::all();
        return view('backend.post.index', compact('posts', 'types', 'role', 'authors'));
    }

    //Thêm truyện
    public function create()
    {
        $types = Type::all();
        return view('backend.post.create', compact('types'));
    }

    public function postCreate(Request $request)
    {
        date_default_timezone_set("Asia/Ho_Chi_Minh");
        $count_title_seo = Post::whereTitle_seo(changeTitle($request->title))->count();
        $post = new Post();
        $post->title = $request->title;
        $count_title_seo > 0 ? $post->title_seo = changeTitle($request->title) + '-' . time() : changeTitle($request->title);
        $post->title_seo = $request->title_seo;
        $post->content = $request->content_;
        $post->type = $request->type;
        $post->user_id = Auth::id();
        $request->status == '1' || $request->status == 1 ? $post->status = 1 : $post->status = 0;
        $post->save();
        return redirect(route('post'))->with('mes', 'Đã thêm truyện...');
    }

    //Sửa truyện
    public function edit($id)
    {
        $role = '';
        $user_id_ = Post::with('User')->whereId($id)->get();
        $ar_user_id = Post::whereId($id)->pluck('user_id');
        foreach ($user_id_ as $val) {
            if ($val->User()->first() == null) {
                $role = 1;
            } else {
                $role = $val->User()->first()->role;
            }
        }
        if ($role == $this->role_admin || $role == $this->role_leader) {
            $types = Type::all();
            $post = Post::find($id);
            return view('backend.post.edit', compact('types', 'post'));
        } elseif ($ar_user_id['id'] == Auth::id() && $role == $this->role_bus) {
        } else {
            return redirect(route('post'))->with('er', 'Không phải truyện của bạn...');
        }
    }

    public function postEdit($id, Request $request)
    {
        $count_title_seo = Post::whereTitle_seo($request->title_seo)->whereId($id)->count();
        $post = Post::find($id);
        $post->title = $request->title;
        $count_title_seo > 0 ? $post->title_seo = changeTitle($request->title) . '-' . time() : changeTitle($request->title);
        $post->title_seo = $request->title_seo;
        $post->content = $request->content_;
        $post->type = $request->type;
        $post->user_id = Auth::id();
        $request->status == '1' || $request->status == 1 ? $post->status = 1 : $post->status = 0;
        $post->save();
        return redirect(route('post'))->with('mes', 'Đã sửa truyện...');
    }

    //xóa truyện
    public function delete($id)
    {
        $role = User::whereId(Auth::id())->pluck('role');
        $story_user_id = Post::whereId($id)->pluck('user_id');

        $authors_not_curent = Post::join('users', 'posts.user_id', '=', 'users.id')
            ->where('posts.user_id', '<>', Auth::id())
            ->where('users.role', '=', $this->role_leader)
            ->pluck('posts.id');
        if ($role[0] == $this->role_admin) {
            $post = Post::find($id);
            $post->delete();
            return redirect(route('post'))->with('mes', 'Đã xóa truyện...');
        } else {
            if ($role[0] == $this->role_bus) {
                if ($story_user_id[0] == Auth::id()) {
                    $post = Post::find($id);
                    $post->delete();
                    return redirect(route('post'))->with('mes', 'Đã xóa truyện...');
                } else return redirect(route('post'))->with('er', 'Không phải truyện của bạn...');
            } elseif ($role[0] == $this->role_leader) {
                if (!in_array($id, json_decode($authors_not_curent))) {
                    $post = Post::find($id);
                    $post->delete();
                    return redirect(route('post'))->with('mes', 'Đã xóa truyện...');
                } else return redirect(route('post'))->with('er', 'Không phải truyện của bạn...');
            }
            else return redirect(route('post'))->with('er', 'Không phải truyện của bạn...');
        }

    }

    //xóa kiểu
    public function typeDelete($id)
    {
        $role = User::whereId(Auth::id())->pluck('role');
        if ($role[0] == $this->role_admin || $role[0] == $this->role_leader) {
            $post = Type::find($id);
            $post->delete();
            return redirect(route('post'))->with('mes', 'Đã xóa thể loại...');
        } else {
            return redirect(route('post'))->with('er', 'Bạn không có quyền...');
        }
    }

    public function ajaxEditShortContent(Request $request)
    {
        $id = $request->id;
        $title_Seo = $request->title_seo;
        $post = Post::find($id);
        $post->title_seo = $title_Seo;
        $post->save();
        return $post;
    }

    public function ajaxEditContent(Request $request)
    {
        $id = $request->id;
        $content = $request->content_;
        $post = Post::find($id);
        $post->content = $content;
        $post->save();
        return $post;
    }

    public function ajaxEditStatus(Request $request)
    {
        $id = $request->id;
        $status = $request->status;
        $post = Post::find($id);
        $post->status = $status;
        $post->save();
        return $post;
    }

    public function validateTitleSeo(Request $request)
    {
        $title_seo = changeTitle($request->title_seo);
        $val = Post::select('title_seo')->whereTitle_seo($title_seo)->get();

        $rt = null;
        if (count($val) == 0) {
            $a[] = $title_seo;
        } else {
            $a[] = $title_seo . '-' . time();
        }
        return $a;
    }

    public function addType(Request $request)
    {
        date_default_timezone_set("Asia/Ho_Chi_Minh");
        $type = new Type();
        $type->name = $request->type;
        $type->name_unicode = changeTitle($request->type);
        $type->save();
        return redirect(route('post'))->with('mes', 'Đã thêm truyện...');
    }
}
