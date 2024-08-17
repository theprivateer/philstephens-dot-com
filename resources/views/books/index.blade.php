@extends('layouts.default')

@section('content')
<article class="page-content">
    <h1 @if(optional($page)->subtitle) class="with-subtitle" @endif>
        {{ optional($page)->title }}
    </h1>

    @if(optional($page)->subtitle)
    <h3 class="subtitle">{{ optional($page)->subtitle }}</h3>
    @endif

    {!! str(optional($page)->content)->markdown() !!}
</article>

<div class="album-grid">
    @foreach($books as $book)
    <a href="{{ route('book.show', $book->slug) }}">
        <div>
            <p>
                {{ $book->title }}<br />
                <em>{{ $book->author }}</em>
            </p>
        </div>
        <img src="/storage/{{ $book->cover_artwork }}" alt="'{{ $book->title }}' by {{ $book->author }}">
    </a>
    @endforeach
</div>

@endsection
