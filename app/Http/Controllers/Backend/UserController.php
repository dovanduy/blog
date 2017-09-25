<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Role;
use Auth;
use Validator;
use Hash;

class UserController extends Controller
{
    //
    public function index() {
        $users = User::where('id', '<>', Auth::id())->paginate(10);
        $roles = Role::all();
        return view('backend.user.index', compact('users', 'roles'));
    }

    public function create(Request $request) {
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
}
