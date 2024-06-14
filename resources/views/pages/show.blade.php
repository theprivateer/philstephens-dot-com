@extends('layouts.default')

@section('content')
<article class="page-content">
    <h1>{{ $page->title }}</h1>
    {!! str($page->content)->markdown() !!}
</article>
@endsection
