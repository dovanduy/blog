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

    //id truyen trong role =2 ko phai id cua role 2
    public function authors_not_curent() {
        $authors_not_curent = Post::join('users', 'posts.user_id', '=', 'users.id')
            ->where('posts.user_id', '<>', Auth::id())
            ->where('users.role', '=', $this->role_leader)
            ->pluck('posts.id');
        return json_decode($authors_not_curent);
    }
    //id truyen trong role =2 và =3

    //all role
    public function role($user_id) {
        $role = User::where('id', $user_id)->pluck('role');
        return json_decode($role);
    }

    public function index()
    {
        $user_id = Auth::id();
        $authors = Post::with('User')->select('user_id')->get();

        if ($this->role($user_id)[0] == $this->role_admin) {
            $posts = Post::with('Type')->orderBy('id', 'DESC')->paginate(10);
        } elseif ($this->role($user_id)[0] == $this->role_leader) {
            $posts = Post::with('Type')
                ->join('users', 'posts.user_id', '=', 'users.id')
                ->selectRaw('posts.*, users.role')
                ->whereIn('users.role', [$this->role_leader, $this->role_bus])
                ->whereNotIn('posts.id', $this->authors_not_curent())
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
        $role_leader = Post::where('user_id', '<>', $this->role_admin)->where('user_id', '<>', $this->authors_not_curent())->pluck('id');
        $user_id = Auth::id();
        $story_user_id = Post::whereId($id)->pluck('user_id');
        $all_story_id = Post::pluck('id');

        if ($this->role($user_id)[0] == $this->role_admin && in_array($id, json_decode($all_story_id))) {
            $types = Type::all();
            $post = Post::find($id);
            return view('backend.post.edit', compact('types', 'post'));
        } else {
            if ($this->role($user_id)[0] == $this->role_bus && in_array($id, json_decode($story_user_id))) {
                $types = Type::all();
                $post = Post::find($id);
                return view('backend.post.edit', compact('types', 'post'));
            } elseif ($this->role($user_id)[0] == $this->role_leader) {
                if (!in_array($id, $this->authors_not_curent()) && in_array($id, json_decode($role_leader))) {
                    $types = Type::all();
                    $post = Post::find($id);
                    return view('backend.post.edit', compact('types', 'post'));
                } else return redirect(route('post'))->with('er', 'Không phải truyện của bạn...');
            } else return redirect(route('post'))->with('er', 'Không phải truyện của bạn...');
        }
    }

    public function postEdit($id, Request $request)
    {
        $role_leader = Post::where('user_id', '<>', $this->role_admin)->where('user_id', '<>', $this->authors_not_curent())->pluck('id');
        $user_id = Auth::id();
        $story_user_id = Post::whereId($id)->pluck('user_id');
        $all_story_id = Post::pluck('id');

        $count_title_seo = Post::whereTitle_seo($request->title_seo)->whereId($id)->count();
        $post = Post::find($id);
        $post->title = $request->title;
        $count_title_seo > 0 ? $post->title_seo = changeTitle($request->title) . '-' . time() : changeTitle($request->title);
        $post->title_seo = $request->title_seo;
        $post->content = $request->content_;
        $post->type = $request->type;
        $post->user_id = Auth::id();
        $request->status == '1' || $request->status == 1 ? $post->status = 1 : $post->status = 0;

        if ($this->role($user_id)[0] == $this->role_admin && in_array($id, json_decode($all_story_id))) {
            $post->save();
            return redirect(route('post'))->with('mes', 'Đã sửa truyện...');
        } else {
            if ($this->role($user_id)[0] == $this->role_bus && in_array($id, json_decode($story_user_id))) {
                $post->save();
                return redirect(route('post'))->with('mes', 'Đã sửa truyện...');
            } elseif ($this->role($user_id)[0] == $this->role_leader) {
                if (!in_array($id, $this->authors_not_curent()) && in_array($id, json_decode($role_leader))) {
                    $post->save();
                    return redirect(route('post'))->with('mes', 'Đã sửa truyện...');
                } else return redirect(route('post'))->with('er', 'Không phải truyện của bạn...');
            } else return redirect(route('post'))->with('er', 'Không phải truyện của bạn...');
        }
    }

    //xóa truyện
    public function delete($id)
    {
        $role_leader = Post::where('user_id', '<>', $this->role_admin)->where('user_id', '<>', $this->authors_not_curent())->pluck('id');
        $user_id = Auth::id();
        $story_user_id = Post::whereId($id)->pluck('user_id');
        $story_id = Post::pluck('user_id');
        $all_story_id = Post::pluck('id');
        if ($this->role($user_id)[0] == $this->role_admin && in_array($id, json_decode($all_story_id))) {
            $post = Post::find($id);
            $post->delete();
            return redirect(route('post'))->with('mes', 'Đã xóa truyện...');
        } else {
            if ($this->role($user_id)[0] == $this->role_bus && in_array($id, json_decode($story_id))) {
                if ($story_user_id[0] == Auth::id()) {
                    $post = Post::find($id);
                    $post->delete();
                    return redirect(route('post'))->with('mes', 'Đã xóa truyện...');
                } else return redirect(route('post'))->with('er', 'Không phải truyện của bạn...');
            } elseif ($this->role($user_id)[0] == $this->role_leader) {
                if (!in_array($id, $this->authors_not_curent()) && in_array($id, json_decode($role_leader))) {
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
