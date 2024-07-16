@extends('layouts.default')

@section('content')
<article class="page-content">
    <h1>{{ optional($page)->title }}</h1>

    {!! str(optional($page)->content)->markdown() !!}
</article>

<nav class="article-list">
    @foreach($albums as $album)
    <a href="{{ route('album.show', $album->slug) }}">
        <span>{{ $album->title }}</span>
        <hr>
        <span>{{ $album->artist }}</span>
    </a>
    @endforeach
</nav>

@endsection
