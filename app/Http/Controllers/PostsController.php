<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePost;
use App\Models\BlogPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class PostsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')
            ->only(['create', 'store', 'edit', 'update', 'destroy']);
    }

    public function index()
    {
        return view(
            'posts.index',
            ['posts' => BlogPost::withCount('comments')->get()]
        );
    }

    public function create()
    {
        return view('posts.create');
    }

    public function store(StorePost $request)
    {
        $validatedData = $request -> validated();
        $validatedData['user_id'] = $request->user()->id;
        $post = BlogPost::create($validatedData);

        $request -> session() -> flash('status', 'The blog post was created!');

        return redirect() -> route('posts.show', ['post' => $post->id]);
    }

    public function show($id)
    {
        // abort_if(!isset($this -> posts[$id]), 404);

        return view('posts.show', ['post' => BlogPost::with('comments')->findOrFail($id)]);
    }

    public function edit($id)
    {
        $post = BlogPost::findOrFail($id);

        $this->authorize('update', $post);

        return view('posts.edit', ['post' => $post]);
    }

    public function update(StorePost $request, $id)
    {
        $post = BlogPost::findOrFail($id);

        $this->authorize('update', $post);

        $validated = $request -> validated();
        $post -> fill($validated);
        $post -> save();

        $request -> session() -> flash('status', 'The blog post was updated!');

        return redirect() -> route('posts.show', ['post' => $post->id]);
    }

    public function destroy($id)
    {
        $post = BlogPost::findOrFail($id);

        $this->authorize('delete', $post);

        $post -> delete();

        session() -> flash('status', 'The blog post was deleted!');

        return redirect() -> route('posts.index');
    }
}
