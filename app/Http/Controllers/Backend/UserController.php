<?php

namespace App\Http\Controllers\Backend;

use App\IP;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Role;
use Auth;
use Validator;
use Hash;

class UserController extends Controller
{
    public function __construct()
    {
        date_default_timezone_set("Asia/Ho_Chi_Minh");
        $this->middleware('auth');
    }
    //
    public function index() {
        $users = User::where('id', '<>', Auth::id())->paginate(10);
        $alluser = User::all();
        $roles = Role::where('id', '<>', Auth::id())->get();
        $ips = IP::orderBy('id', 'desc')->get();
        return view('backend.user.index', compact('users', 'roles', 'ips', 'alluser'));
    }

    public function create(Request $request) {
        date_default_timezone_set("Asia/Ho_Chi_Minh");
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required',
            'password'  =>  'required|confirmed',
            'confirm_password'  =>  'confirmed'
        ], [
            'name.required' => 'Bạn cần xem lại tên đã nhập...',
            'email.required' => 'Bạn cần xem lại tên đăng nhập đã nhập...',
            'password.required' => 'Bạn cần xem lại mật khẩu',
            'password.confirmed' => 'Mật khảu không  khớp'
        ]);
        date_default_timezone_set("Asia/Ho_Chi_Minh");
        $data_name = json_decode(User::pluck('email'));
        $email = $request->email;
        if(Auth::id() == 1 && !in_array($email, $data_name)) {
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $request->role_new_user==null?$user->role='':$user->role = $request->role_new_user;
            $user->save();
            return redirect()->back()->with('pw', 'Đã thêm tài khoản ');
        } else {
            return redirect()->back()->with('pw-er', 'Bạn cần xem lại tài khoản đã tạo...');
        }
    }

    public function delete($id) {
        if(Auth::id() == 1 && $id != 1) {
            $user  = User::find($id);
            $name = $user->name;
            $user->delete();
            return redirect()->back()->with('pw', 'Đã xóa tài khoản ' . $name);
        } else {
            return redirect()->back()->with('pw-er', 'Bạn không thể xóa thành viên này...');
        }
    }

    public function ajaxChangeRole(Request $request) {
        $id = $request->id;
        $role_user = $request->role;
        $role = User::find($id);
        $role->role = $role_user;
        $role->save();
        return array('Thay đổi thành công');
    }
}
