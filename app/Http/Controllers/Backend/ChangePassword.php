<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\User;


class ChangePassword extends Controller
{
    protected $password = 'Story123';

    private function adminCredentialRules(array $data)
    {
        $messages = [
            'current-password.required' => 'Please enter current password',
            'password.required' => 'Please enter password',
        ];

        $validator = Validator::make($data, [
            'current-password' => 'required',
            'password' => 'required|same:password',
            'password_confirmation' => 'required|same:password',
        ], $messages);

        return $validator;
    }

    public function postCredentials(Request $request)
    {
        date_default_timezone_set("Asia/Ho_Chi_Minh");
        if(Auth::Check())
        {
            $request_data = $request->All();
            $validator = $this->adminCredentialRules($request_data);
            if($validator->fails())
            {
                return redirect()->back()->with('pw-er', 'Bạn hãy xem lại!');
            }
            else
            {
                $current_password = Auth::User()->password;
                if(Hash::check($request_data['current-password'], $current_password))
                {
                    $user_id = Auth::User()->id;
                    $obj_user = User::find($user_id);
                    $obj_user->password = Hash::make($request_data['password']);;
                    $obj_user->save();
                    return redirect()->back()->with('pw', 'Đã thay đổi thành công!');
                }
                else
                {
                    return redirect()->back()->with('pw-er', 'Bạn hãy xem lại!');
                }
            }
        }
        else
        {
            return redirect()->back();
        }
    }

    public function resetPassword($id) {
        date_default_timezone_set("Asia/Ho_Chi_Minh");
        $obj_user = User::find($id);
        $obj_user->password = Hash::make($this->password);
        $obj_user->save();
        return redirect()->back()->with('pw', 'Đã reset Tài khoản ' . $obj_user->email);
    }

    public function postChangeUserPassword(Request $request){
        date_default_timezone_set("Asia/Ho_Chi_Minh");
        $id = $request->user_id;
        $pw = $request->pw;
        $obj_user = User::find($id);
        $obj_user->password = Hash::make($pw);
        $obj_user->save();
        return array('Đã được thay đổi mật khẩu');
    }
}
