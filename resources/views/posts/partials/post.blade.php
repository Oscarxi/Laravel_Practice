{{-- <h3><a href="{{ route('posts.show', ['post' => $post->id]) }}">{{ $post->title }}</a></h3>

<div class="mb-3">
    <a href="{{ route('posts.edit', ['post' => $post->id]) }}" class="btn btn-primary">Edit</a>
    <form class="d-inline" action="{{ route('posts.destroy', ['post' => $post->id]) }}" method="POST">
        @csrf
        @method('DELETE')
        <input type="submit" value="Delete!" class="btn btn-primary">
    </form>
</div> --}}

@if ($loop->even)
<div>{{ $key + 1 }}.{{ $post->title }}</div>
@else
<div style="background-color: silver">{{ $key + 1 }}.{{ $post->title }}</div>
@endif

<div>
    <form action="{{ route('posts.destroy', ['post' => $post->id]) }}" method="POST">
        @csrf
        @method('DELETE')
        <input type="submit" value="Delete!" class="">
    </form>
</div>