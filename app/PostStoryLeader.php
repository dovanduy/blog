<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Post;

class PostStoryLeader
{
    //
    public $role_admin = 1;
    public $role_leader = 2;

    public function AllStory($story_id) {
        return Post::whereId($story_id)->pluck('user_id');
    }

    //role leader
    public function StoryIdNotLeader($id_user) {
        $authors_not_curent = Post::join('users', 'posts.user_id', '=', 'users.id')
            ->where('posts.user_id', '<>', $id_user)
            ->where('users.role', '=', $this->role_leader)
            ->pluck('posts.id');
        return json_decode($authors_not_curent);
    }

    public function PostStoryLeader($id_user) {
        $not_leader_current = $this->StoryIdNotLeader($id_user);
        return json_decode(Post::where('user_id', '<>', $this->role_admin)->where('user_id', '<>', $not_leader_current)->pluck('id'));
    }
}
