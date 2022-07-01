<h3><a href="{{ route('posts.show', ['post' => $post->id]) }}" class="text-primary">{{ $post->title }}</a></h3>
@component('components.tags', ['tags' => $post->tags])
@endcomponent

@component('components.updated', ['date' => $post->created_at, 'name' => $post->user->name])
@endcomponent

@if ($post->comments_count)
    <p>{{ $post->comments_count }} comments</p>
@else
    <p>No comments yet!</p>
@endif
<div class="mb-3">
    @can('update', $post)
        <a href="{{ route('posts.edit', ['post' => $post->id]) }}" class="btn btn-primary">Edit</a>
    @endcan
    @can('delete', $post)
        <form class="d-inline" action="{{ route('posts.destroy', ['post' => $post->id]) }}" method="POST">
            @csrf
            @method('DELETE')
            <input type="submit" value="Delete!" class="btn btn-primary">
        </form>
    @endcan
</div>
