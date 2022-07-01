@extends('layouts.app')

@section('title', $post->title)

@section('content')
    <h1>{{ $post->title }}</h1>
    <p>{{ $post->content }}</p>
    @component('components.updated', ['date' => $post->created_at, 'name' => $post->user->name])
    @endcomponent

    @component('components.updated', ['date' => $post->updated_at])
        Updated
    @endcomponent

    @component('components.tags', ['tags' => $post->tags])
    @endcomponent

    @if (now()->diffInMinutes($post->created_at) < 10)
        <x-alert type='info' message='New!'/>
    @endif

    <h4 class="text-info">Comments</h4>
    @forelse ($post->comments as $comment)
        <p>{{ $comment->content }}</p>
        @component('components.updated', ['date' => $comment->created_at])
        @endcomponent
    @empty
        <p>No comments yet!</p>
    @endforelse
@endsection
