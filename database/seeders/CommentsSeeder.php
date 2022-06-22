<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CommentsSeeder extends Seeder
{
    public function run()
    {
        $posts = \App\Models\BlogPost::all();

        if ($posts->count() === 0) {
            $this->command->info('There are no blog posts, so no comments will be added');
            return;
        }

        $commentCount = (int)$this->command->ask('How many comments would you like?', 150);

        \App\Models\Comment::factory($commentCount)->make()->each(function($comment) use ($posts){
            $comment->blog_post_id = $posts->random()->id;
            $comment->save();
        });
    }
}
