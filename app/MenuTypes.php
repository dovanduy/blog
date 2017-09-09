<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Type;

class MenuTypes extends Model
{
    //
    public function AllType() {
        return json_decode(Type::pluck('name_unicode'));
    }
}
