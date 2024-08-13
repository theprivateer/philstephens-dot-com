@extends('layouts.default')

@section('content')
<article class="page-content">
    <h1>{{ optional($page)->title }}</h1>

    {!! str(optional($page)->content)->markdown() !!}
</article>

<div class="album-grid">
    @foreach($albums as $album)
    <a href="{{ route('album.show', $album->slug) }}">
        <img src="/storage/{{ $album->album_artwork }}" alt="'{{ $album->title }}' by {{ $album->artist }}">
    </a>
    @endforeach
</div>

@endsection
