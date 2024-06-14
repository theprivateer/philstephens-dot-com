@extends('layouts.default')

@section('content')
<article class="page-content">
    <section>
        <img src="/storage/{{ $album->album_artwork }}" alt="{{ $album->title }}">

        <h1>{{ $album->title }}</h1>
        <h2>{{ $album->artist }} ({{ $album->released }})</h2>
        <p><a href="{{ $album->listen_link }}">Listen Here</a></p>
    </section>

    {{ $album->body }}

    <p><em>This is an entry in the <a href="/albums">365 Albums Project</a> in which I plan on posting one album I enjoy every day for a full year.</em></p>

    <p>
        <a href="mailto:hello@philstephens.com?subject={{ $album->title }}">Reply via email</a>
    </p>
</article>

@endsection
