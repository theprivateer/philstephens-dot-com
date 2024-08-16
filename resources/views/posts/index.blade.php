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
    @foreach($posts as $key => $day)
        <section class="post-day">
            <div class="post-date">{{ $key }}</div>
            <div class="posts">
                @foreach($day as $post)
                    <div class="post-content">
                        <h3>
                            <a href="{{ route('post.show', $post->slug) }}">
                                {{ $post->title }}
                            </a>
                        </h3>

                        @if($post->subtitle)
                        <h5>{{ $post->subtitle }}</h5>
                        @endif
                    </div>
                @endforeach
            </div>
        </section>
    @endforeach
</nav>

@endsection
