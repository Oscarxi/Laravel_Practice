<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\BlogPost;
use App\Models\Comment;

class PostTest extends TestCase
{
    use RefreshDatabase;

    public function testNoBlogPostsWhenNothingInDatabase()
    {
        $response = $this->get('/posts');
        $response->assertSeeText('No blog posts yet!');
    }

    public function testSee1BlogPostWhenThereIs1WithNoComments()
    {
        // Arrange
        $post = $this->createDummyBlogPost();

        // Act
        $response = $this->get('/posts');

        // Assert
        $response->assertSeeText('New title');
        $response->assertSeeText('No comments yet!');
        $this->assertDatabaseHas('blog_posts', [
            'title' => 'New title',
            'content' => 'New content'
        ]);
    }

    public function testSee1BlogPostWhenThereIs1WithComments()
    {
        $post = $this->createDummyBlogPost();
        Comment::factory()->count(5)->create([
            'blog_post_id' => $post->id
        ]);

        $response = $this->get('/posts');

        $response->assertSeeText('5 comments');
    }

    public function testStoreValid()
    {
        $arguments = [
            'title' => 'Valid title',
            'content' => 'Valid content'
        ];

        $this->actingAs($this->user())
            ->post('/posts', $arguments)
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

        $this->actingAs($this->user())
            ->post('/posts', $arguments)
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

        $this->actingAs($this->user())
            ->put("/posts/{$post->id}", $arguments)
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

        $this->actingAs($this->user())
            ->delete("/posts/{$post->id}")
            ->assertStatus(302)
            ->assertSessionHas('status');

        $this->assertEquals(session('status'), 'The blog post was deleted!');

        // $this->assertDatabaseMissing('blog_posts', [
        //     'title' => 'New title',
        //     'content' => 'New content'
        // ]);
        $this->assertSoftDeleted('blog_posts', [
            'title' => 'New title',
            'content' => 'New content']);
    }

    private function createDummyBlogPost(): BlogPost
    {

        return BlogPost::factory()->newTitle()->create([
            'user_id' => $this->user()->id
        ]);
    }
}
