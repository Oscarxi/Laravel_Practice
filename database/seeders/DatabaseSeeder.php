<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $else = \App\Models\User::factory(20)->create();
        $oscar = \App\Models\User::factory()->oscarChiu()->create();

        $users = $else->concat([$oscar]);

        $posts = \App\Models\BlogPost::factory(50)->make()->each(function($post) use ($users){
            $post->user_id = $users->random()->id;
            $post->save();
        });

        $comments = \App\Models\Comment::factory(150)->make()->each(function($comment) use ($posts){
            $comment->blog_post_id = $posts->random()->id;
            $comment->save();
        });
    }
}