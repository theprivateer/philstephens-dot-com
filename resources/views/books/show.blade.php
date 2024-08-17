@extends('layouts.default')

@section('content')
<article class="page-content">
    <section>
        <img src="/storage/{{ $book->cover_artwork }}" alt="{{ $book->title }}">

        <h1>{{ $book->title }}</h1>
        <h2>{{ $book->author }}</h2>
        <p><a href="{{ $book->link }}" target="_blank">Read it</a></p>
    </section>

    {!! str($book->content)->markdown() !!}

    <p>
        <a href="mailto:hello@philstephens.com?subject={{ $book->title }}">Reply via email</a>
    </p>
</article>

@endsection
