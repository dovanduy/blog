<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Role;
use Auth;

class UserController extends Controller
{
    //
    public function index() {
        $users = User::where('id', '<>', Auth::id())->paginate(10);
        $roles = Role::all();
        return view('backend.user.index', compact('users', 'roles'));
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
