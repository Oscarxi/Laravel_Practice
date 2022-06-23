<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BlogPost extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['title', 'content'];

    public function comments()
    {
        return $this->hasMany('App\Models\Comment');
    }

    public function tags()
    {
        return $this->belongsToMany('App\Models\Tag')->withTimestamps();
    }

    // public static function boot()
    // {
    //     parent::boot();

    //     static::deleting(function (BlogPost $blogpost){
    //         $blogpost->comments()->delete();
    //     });
    // }
}