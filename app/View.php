<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class View extends Model
{
    //
    protected $table = 'views';

    public function Post() {
        return $this->hasOne(Post::class, 'id', 'post_id');
    }
}
