<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    use HasFactory;
    use SoftDeletes;

    public function blogPost()
    {
        return $this->belongsTo('App\Models\BlogPost');
        // return $this->belongsTo('App\BlogPost', 'post_id', 'blog_post_id');
        // Second parameter for changing the name of foreign key

    }
}
