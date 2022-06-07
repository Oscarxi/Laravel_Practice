<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    public function blogPost()
    {
        return $this->belongsTo('App\Models\BlogPost');
        // return $this->belongsTo('App\BlogPost', 'post_id', 'blog_post_id');
        // Second parameter for changing the name of foreign key

    }
}
