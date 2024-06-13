@extends('layouts.default')

@section('content')
<article class="page-content">
    <h1>{{ optional($page)->title }}</h1>

    {!! str(optional($page)->body)->markdown() !!}
</article>

<nav class="article-list">
    @foreach($posts as $post)
        <a href="{{ route('post.show', $post->slug) }}">
            <span>{{ $post->title }}</span>
            <hr>
            <time datetime="{{ $post->published_at->format('Y-m-d') }}">{{ $post->published_at->format('F j') }}</time>
        </a>
    @endforeach
</nav>

@endsection
