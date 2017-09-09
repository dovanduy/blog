<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

class RoleCurrent
{
    //
    public function RoleCurrent($id_user) {
        $role = User::where('id', $id_user)->pluck('role');
        return json_decode($role);
    }
}
