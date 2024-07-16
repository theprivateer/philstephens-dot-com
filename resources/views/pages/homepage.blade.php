@extends('layouts.default')

@section('content')
<article class="page-content">
    {!! str(optional($page)->content)->markdown() !!}
</article>
{{-- <h2>Recent Blog Articles</h2>

<nav class="article-list">
    @foreach($posts as $post)
        <a href="{{ route('post.show', $post->slug) }}">
            <span>{{ $post->title }}</span>
            <hr>
            <time datetime="{{ $post->published_at->format('Y-m-d') }}">{{ $post->published_at->format('F j') }}</time>
        </a>
    @endforeach
</nav> --}}

{{-- {{ /partial:blog/listing }} --}}

{{-- <div class="pill">
    <a href="/blog">See All Blog Articles</a>
</div> --}}

{{-- {{ partial:albums/listing limit="7" }} --}}
{{-- {{ /partial:albums/listing }} --}}

{{-- <nav class="article-list">
    <h2>365 Albums Project</h2>
    <p>I plan on posting one album I enjoy every day for a full year. Here are the latest entries:</p>
    @foreach($albums as $album)
    <a href="{{ route('album.show', $album->slug) }}">
        <span>{{ $album->title }}</span>
        <hr>
        <span>{{ $album->artist }}</span>
    </a>
    @endforeach
</nav>


<div class="pill">
    <a href="/albums">See All Albums</a>
</div> --}}

@endsection
