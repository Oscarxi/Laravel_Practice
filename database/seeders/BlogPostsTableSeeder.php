<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class BlogPostsTableSeeder extends Seeder
{
    public function run()
    {
        $users = \APP\Models\User::all();
        $postCount = (int)$this->command->ask('How many blog posts would you like?', 50);

        \App\Models\BlogPost::factory($postCount)->make()->each(function($post) use ($users){
            $post->user_id = $users->random()->id;
            $post->save();
        });
    }
}
