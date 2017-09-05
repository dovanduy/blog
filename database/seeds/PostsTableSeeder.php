<?php

use Illuminate\Database\Seeder;
use App\Post;

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
            $user_id = 1;
            $view = rand(0, 100000);
            $type = rand(1, 4);
            $status = rand(0, 1);
            $post->fill([
                'title' => $title,
                'title_seo' => str_replace(' ', '_', $title),
                'type' => $type,
                'content' => '<p>' . $faker->realText(rand(100, 100000)) . '</p>',
                'view' => $view,
                'user_id' => $user_id,
                'status' => $status
            ]);
            $post->save();
        }
    }
}
