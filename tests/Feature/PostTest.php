<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\BlogPost;

class PostTest extends TestCase
{
    use RefreshDatabase;

    public function testNoBlogPostsWhenNothingInDatabase()
    {
        $this->get('/posts')
            ->assertSeeText('No blog posts yet!');
    }

    public function testSeeOneBlogPostWhenThereIsOne()
    {
        $post = $this->createDummyBlogPost();

        $this->get('/posts')
            ->assertSeeText('New title');

        $this->assertDatabaseHas('blog_posts', [
            'title' => 'New title',
            'content' => 'New content'
        ]);
    }

    public function testStoreValid()
    {
        $arguments = [
            'title' => 'Valid title',
            'content' => 'Valid content'
        ];

        $this->post('/posts', $arguments)
            ->assertStatus(302)
            ->assertSessionHas('status');

        $this->assertEquals(session('status'), 'The blog post was created!');
    }

    public function testStoreFail()
    {
        $arguments = [
            'title' => 's',
            'content' => 's'
        ];

        $this->post('/posts', $arguments)
            ->assertStatus(302)
            ->assertSessionHas('errors');

        $message = session('errors')->getMessages();  // dd(session('errors'))

        $this->assertEquals($message['title'][0], 'The title must be at least 2 characters.');
        $this->assertEquals($message['content'][0], 'The content must be at least 5 characters.');
    }

    public function testUpdateValid()
    {
        $post = $this->createDummyBlogPost();

        $this->assertDatabaseHas('blog_posts', [
            'title' => 'New title',
            'content' => 'New content'
        ]);

        $arguments = [
            'title' => 'Update title',
            'content' => 'Update content'
        ];

        $this->put("/posts/{$post->id}", $arguments)
            ->assertStatus(302)
            ->assertSessionHas('status');

        $this->assertEquals(session('status'), 'The blog post was updated!');

        $this->assertDatabaseMissing('blog_posts', [
            'title' => 'New title',
            'content' => 'New content'
        ]);

        $this->assertDatabaseHas('blog_posts', [
            'title' => 'Update title',
            'content' => 'Update content'
        ]);
    }

    public function testDelete()
    {
        $post = $this->createDummyBlogPost();

        $this->assertDatabaseHas('blog_posts', [
            'title' => 'New title',
            'content' => 'New content'
        ]);

        $this->delete("/posts/{$post->id}")
            ->assertStatus(302)
            ->assertSessionHas('status');

        $this->assertEquals(session('status'), 'The blog post was deleted!');

        $this->assertDatabaseMissing('blog_posts', [
            'title' => 'New title',
            'content' => 'New content'
        ]);
    }

    private function createDummyBlogPost(): BlogPost
    {
        $post = new BlogPost();
        $post->title = 'New title';
        $post->content = 'New content';
        $post->save();

        return $post;
    }
}
