<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $table = 'posts';

    public function Type() {
        return $this->belongsTo(Type::class, 'type', 'id');
    }
    public function User() {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

}
