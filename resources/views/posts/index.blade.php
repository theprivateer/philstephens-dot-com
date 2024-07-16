@extends('layouts.default')

@section('content')
<article class="page-content">
    <h1>{{ optional($page)->title }}</h1>

    {!! str(optional($page)->content)->markdown() !!}
</article>

<nav class="article-list">
    @foreach($posts as $post)
        <a href="{{ route('post.show', $post->slug) }}">
            <span>{{ $post->title }}</span>
            <hr>
            <time datetime="{{ $post->updated_at->format('Y-m-d') }}">{{ $post->updated_at->format('F j, Y') }}</time>
        </a>
    @endforeach
</nav>

@endsection
