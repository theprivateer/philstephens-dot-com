@extends('layouts.default')

@section('content')
<article class="page-content">
    <h1 @if($post->subtitle) class="with-subtitle" @endif>
        {{ $post->title }}
    </h1>

    @if($post->subtitle)
    <h3 class="subtitle">{{ $post->subtitle }}</h3>
    @endif

    <p><em>Updated {{ $post->updated_at->format('F j, Y') }}</em></p>

    {!! str($post->content)->markdown() !!}

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
