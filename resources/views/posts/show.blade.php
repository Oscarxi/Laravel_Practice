@extends('layouts.app')

{{-- title --}}
@section('title', $post['title'])

{{-- content --}}
@section('content')

<h1>{{ $post['title'] }}</h1>
<p>{{ $post['content'] }}</p>

{{-- @if ($post['is_new'])
<div>A new blog post...using if</div>
@else
<div>Blog post is old...using else</div>
@endif

@unless ($post['is_new'])
<div>It is an old post...using unless</div>
@endunless

@isset($post['has_comments'])
    <div>There is some comments...using isset</div>
@endisset

@endsection --}}