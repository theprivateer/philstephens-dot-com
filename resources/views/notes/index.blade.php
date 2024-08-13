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

<nav class="article-list">
    @foreach($notes as $key => $day)
        <section class="note-day">
            <div class="note-date">{{ $key }}</div>

            <div class="notes">
                @foreach($day as $note)
                    <div class="note-content">
                        @if($note->image)
                        <img src="/storage/{{ $note->image }}" />
                        @endif

                        {!! str($note->content)->markdown() !!}

                        <time class="note-timestamp" datetime="{{ $note->created_at->format('Y-m-d H:i:s') }}">{{ $note->created_at->format('g:i a') }}</time>
                    </div>
                @endforeach
            </div>

        </section>
    @endforeach
</nav>

@endsection
