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
    @foreach($links as $key => $day)
        <section class="link-day">
            <div class="link-date">{{ $key }}</div>

            <div class="links">
                @foreach($day as $link)
                    <div class="link-content">
                        <h3><a href="{{ $link->url }}">{{ $link->title }}
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 19.5 15-15m0 0H8.25m11.25 0v11.25" />
                              </svg>

                        </a></h3>
                        <h5>{{ parse_url($link->url)['host'] ?? '' }}</h5>

                        {!! str($link->content)->markdown() !!}
                    </div>
                @endforeach
            </div>

        </section>
    @endforeach
</nav>

@endsection
