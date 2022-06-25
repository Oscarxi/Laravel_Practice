<?php

namespace App\Policies;

use App\Models\BlogPost;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class BlogPostPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        //
    }

    public function view(User $user, BlogPost $blogPost)
    {
        //
    }

    public function create(User $user)
    {
        //
    }

    public function update(User $user, BlogPost $blogPost)
    {
        return $user->id == $blogPost->user_id;
    }

    public function delete(User $user, BlogPost $blogPost)
    {
        return $user->id == $blogPost->user_id;
    }

    public function restore(User $user, BlogPost $blogPost)
    {
        //
    }

    public function forceDelete(User $user, BlogPost $blogPost)
    {
        //
    }
}
