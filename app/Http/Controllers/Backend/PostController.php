<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Post;
use App\Type;
use App\PostStoryLeader;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    //
    public $role_admin = 1;
    public $role_leader = 2;
    public $role_bus = 3;

    public function __construct()
    {
        date_default_timezone_set("Asia/Ho_Chi_Minh");
        $this->middleware('auth');
    }

    //all role
    public function role($user_id)
    {
        $role = User::where('id', $user_id)->pluck('role');
        return json_decode($role);
    }

    public function index(Request $request)
    {
        $types_all = json_decode(Type::pluck('name_unicode'));
        $get_type = $request->type;
        $search = $request->search;

        $story_role_leader = new PostStoryLeader();
        $user_id = Auth::id();
        $authors = Post::with('User')->select('user_id')->get();

        if ($this->role($user_id)[0] == $this->role_admin) {
            if(in_array($get_type, $types_all)) {
                $id = Type::select('id')->whereName_unicode($get_type)->first();
                $posts = Post::with('Type')->whereType($id->id)->orderBy('id', 'DESC')->paginate(10);
            } elseif ($search) {
                $posts = Post::with('Type')->where('title', 'like', '%' . $search . '%')->orderBy('id', 'DESC')->paginate(10);
            } else {
                $posts = Post::with('Type')->orderBy('id', 'DESC')->paginate(10);
            }
        } elseif ($this->role($user_id)[0] == $this->role_leader) {
            if(in_array($get_type, $types_all)) {
                $id = Type::select('id')->whereName_unicode($get_type)->first();
                $posts = Post::with('Type')
                    ->join('users', 'posts.user_id', '=', 'users.id')
                    ->selectRaw('posts.*, users.role')
                    ->whereIn('users.role', [$this->role_leader, $this->role_bus])
                    ->whereNotIn('posts.id', $story_role_leader->StoryIdNotLeader($user_id))
                    ->where('posts.type',$id->id)
                    ->orderBy('id', 'DESC')->paginate(10);
            } elseif ($search) {
                $posts = Post::with('Type')
                    ->join('users', 'posts.user_id', '=', 'users.id')
                    ->selectRaw('posts.*, users.role')
                    ->whereIn('users.role', [$this->role_leader, $this->role_bus])
                    ->whereNotIn('posts.id', $story_role_leader->StoryIdNotLeader($user_id))
                    ->where('posts.title', 'like', '%' . $search . '%')
                    ->orderBy('id', 'DESC')->paginate(10);
            } else {
                $posts = Post::with('Type')
                    ->join('users', 'posts.user_id', '=', 'users.id')
                    ->selectRaw('posts.*, users.role')
                    ->whereIn('users.role', [$this->role_leader, $this->role_bus])
                    ->whereNotIn('posts.id', $story_role_leader->StoryIdNotLeader($user_id))
                    ->orderBy('id', 'DESC')->paginate(10);
            }
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
        $content = $request->content_;
        $this->validate($request, [
            'content_' => 'required|min:10'
        ], [
            'content_.required' => 'Bạn cần xem lại nội dung đã nhập...',
            'content_.min' => 'Nội dung của bạn phải từ 10 ký tự trở lên',
        ]);
        if (!isset($content)) {
            return redirect(url(route('post.create') . '/create'))->with('er', 'Vui lòng bạn nhập lại');
        } else {
            $count_title_seo = Post::whereTitle_seo(changeTitle($request->title))->count();
            $post = new Post();
            $post->title = $request->title;
            $count_title_seo > 0 ? $post->title_seo = changeTitle($request->title . '-' . time()) : $post->title_seo = changeTitle($request->title);
            $post->content = $content;
            $post->type = $request->type;
            $post->user_id = Auth::id();
            $request->status == '1' || $request->status == 1 ? $post->status = 1 : $post->status = 0;
            $post->save();
            return redirect(route('post'))->with('mes', 'Đã thêm truyện...');
        }
    }

    //Sửa truyện
    public function edit($id)
    {
        $story_role_leader = new PostStoryLeader();
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
                if (!in_array($id, $story_role_leader->StoryIdNotLeader($user_id)) && in_array($id, $story_role_leader->PostStoryLeader($user_id))) {
                    $types = Type::all();
                    $post = Post::find($id);
                    return view('backend.post.edit', compact('types', 'post'));
                } else return redirect(route('post'))->with('er', 'Không phải truyện của bạn...');
            } else return redirect(route('post'))->with('er', 'Không phải truyện của bạn...');
        }
    }

    public function postEdit($id, Request $request)
    {
        $story_role_leader = new PostStoryLeader();
        $user_id = Auth::id();
        $this->validate($request, [
            'content_' => 'required|min:10'
        ], [
            'content_.required' => 'Bạn cần xem lại nội dung đã nhập...',
            'content_.min' => 'Nội dung của bạn phải từ 10 ký tự trở lên',
        ]);
        if (count($story_role_leader->StoryIdNotLeader($user_id)) > 0) {
            $role_leader = Post::where('user_id', '<>', $this->role_admin)->where('user_id', '<>', $story_role_leader->StoryIdNotLeader($user_id))->pluck('id');
        } else {
            $role_leader = Post::where('user_id', '<>', $this->role_admin)->pluck('id');
        }
        $user_id = Auth::id();
        $story_user_id = Post::whereId($id)->pluck('user_id');
        $all_story_id = Post::pluck('id');

        $count_title_seo = Post::whereTitle_seo($request->title_seo)->where('id','<>',$id)->count();
        $post = Post::find($id);
        $post->title = $request->title;
        $count_title_seo > 0 ? $post->title_seo = changeTitle($request->title . '-' . time()) : $post->title_seo = changeTitle($request->title);
        $post->content = $request->content_;
        $post->type = $request->type;
        $post->user_id = Auth::id();
        if (isset($request->status)) {
            $post->status = 1;
        } else {
            $post->status = 0;
        }

        if ($this->role($user_id)[0] == $this->role_admin && in_array($id, json_decode($all_story_id))) {
            $post->save();
            return redirect()->back()->with('mes', 'Đã sửa truyện...');
        } else {
            if ($this->role($user_id)[0] == $this->role_bus && in_array($id, json_decode($story_user_id))) {
                $post->save();
                return redirect()->back()->with('mes', 'Đã sửa truyện...');
            } elseif ($this->role($user_id)[0] == $this->role_leader) {
                if (!in_array($id, $story_role_leader->StoryIdNotLeader($user_id)) && in_array($id, json_decode($role_leader))) {
                    $post->save();
                    return redirect()->back()->with('mes', 'Đã sửa truyện...');
                } else return redirect(route('post'))->with('er', 'Không phải truyện của bạn...');
            } else return redirect(route('post'))->with('er', 'Không phải truyện của bạn...');
        }
    }

    //xóa truyện
    public function delete($id)
    {
        $story_role_leader = new PostStoryLeader();
        $user_id = Auth::id();
        if (count($story_role_leader->StoryIdNotLeader($user_id)) > 0) {
            $role_leader = Post::where('user_id', '<>', $this->role_admin)->whereIn('user_id', '<>', $story_role_leader->StoryIdNotLeader($user_id))->pluck('id');
        } else {
            $role_leader = Post::where('user_id', '<>', $this->role_admin)->pluck('id');
        }
        $story_user_id = Post::whereId($id)->pluck('user_id');
        $all_story_id = Post::pluck('id');
        if ($this->role($user_id)[0] == $this->role_admin && in_array($id, json_decode($all_story_id))) {
            $post = Post::find($id);
            $post->delete();
            return redirect(route('post'))->with('mes', 'Đã xóa truyện...');
        } else {
            if ($this->role($user_id)[0] == $this->role_bus && in_array($id, json_decode($all_story_id))) {
                if ($story_user_id[0] == Auth::id()) {
                    $post = Post::find($id);
                    $post->delete();
                    return redirect(route('post'))->with('mes', 'Đã xóa truyện...');
                } else return redirect(route('post'))->with('er', 'Không phải truyện của bạn...');
            } elseif ($this->role($user_id)[0] == $this->role_leader) {
                if (!in_array($id, $story_role_leader->StoryIdNotLeader($user_id)) && in_array($id, json_decode($role_leader))) {
                    $post = Post::find($id);
                    $post->delete();
                    return redirect(route('post'))->with('mes', 'Đã xóa truyện...');
                } else return redirect(route('post'))->with('er', 'Không phải truyện của bạn...');
            } else return redirect(route('post'))->with('er', 'Không phải truyện của bạn...');
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

    public function ajaxChangeTitleSeo(Request $request)
    {
        $id = $request->id;
        $title_Seo = $request->title_seo;
        $count_title_seo = Post::whereTitle_seo($title_Seo)->where('id', '<>', $id)->count();
        $post = Post::find($id);
        $count_title_seo > 0 ? $post->title_seo = changeTitle(str_replace('.html', '', $title_Seo) .'-'. time()) : $post->title_seo = changeTitle(str_replace('.html', '', $title_Seo));
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
        $title_seo = changeTitle(str_replace('.html', '', $request->title_seo));
        $val = Post::select('title_seo')->whereTitle_seo($title_seo)->get();

        $rt = null;
        if (count($val) == 0) {
            $a[] = $title_seo;
        } else {
            $a[] = changeTitle($request->title_seo . '-' . time());
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

    public function editType(Request $request)
    {
        date_default_timezone_set("Asia/Ho_Chi_Minh");
        $id = $request->id;
        $type = Type::find($id);
        $type->name = $request->name;
        $type->save();
        return redirect()->back()->with('mes', 'Đã sửa thể loại...');
    }

    public function mainContent(Request $request)
    {
        $id = $request->id;
        return Post::select('content')->whereId($id)->first();
    }

    public function ajaxEditType(Request $request)
    {
        $id = $request->id;
        $type = $request->type_id;
        $post = Post::find($id);
        $post->type = $type;
        $post->save();
        return $post;
    }

    public function search(Request $request) {
        $keyword = $request->keyword;
        if ($request->type == 'stories') {
            $responses = Post::select('id', 'title', 'view')
                ->where('title', 'like', '%' . $keyword . '%')
                ->limit(10)
                ->get();
        } else {
            $responses = Post::select('id', 'title', 'view')
                ->where('title', 'like', '%' . $keyword . '%')
                ->limit(10)
                ->get();
        }
        return response()->json($responses);
    }
}