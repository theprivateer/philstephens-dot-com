@extends('layouts.default')

@section('content')
<article class="page-content">
    <h1>
        @if($post->link && $post->source)
            <a href="{{ $post->link }}">
        @endif
        {{ $post->title }}
        @if($post->link && $post->source)
            </a>
        @endif
    </h1>

    {!! str($post->content)->markdown() !!}

    @if($post->link && $post->source)
        <p><em>Via <a href="{{ $post->link }}">{{ $post->source }}</a></em></p>
    @endif

    <p>
        <a href="mailto:hello@philstephens.com?subject={{ $post->title }}">Reply via email</a>
    </p>
</article>

<link rel="stylesheet" href="/js/highlight_styles/atom-one-light.min.css">
<script src="/js/highlight.min.js"></script>
<script>
    hljs.highlightAll();
</script>
@endsection
