<?php

use Illuminate\Database\Seeder;
use App\Post;
use App\Type;
use App\User;

class PostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();

        for ($i = 0; $i <= 50; $i++) {
            $title = $faker->realText(rand(10, 40));
            $post = new Post();
            $user_id = array_random(json_decode(User::pluck('id')));
            $type = array_random(json_decode(Type::pluck('id')));
            $status = rand(0, 1);
            $post->fill([
                'title' => $title,
                'title_seo' => changeTitle($title),
                'type' => $type,
                'content' => '<p>' . $faker->realText(rand(1000, 100000)) . '</p>',
                'user_id' => $user_id,
                'status' => $status
            ]);
            $post->save();
        }
    }
}
