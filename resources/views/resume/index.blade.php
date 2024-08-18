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

<h2>Experience</h2>
@foreach($jobs as $job)
<article>
    <h3 class="with-subtitle"><a href="{{ route('resume.role', $job->slug)}}">{{ $job->title }} at {{ $job->company }}</a></h3>
    <h4 class="subtitle">
        {{ $job->started_at->format('Y') }} - {{ $job->finished_at ? $job->finished_at->format('Y') : 'Present' }}
    </h4>

    <div>
        {!! str($job->company_about)->markdown() !!}
    </div>

    <p><a href="{{ route('resume.role', $job->slug)}}">Read more...</a></p>
</article>
<hr />

@endforeach
@endsection
