@extends('layouts.default')

@section('content')
<article class="page-content">
    <h1 class="with-subtitle">
        {{ $role->title }}
    </h1>

    <h3 class="subtitle">{{ $role->company }}</h3>

    {!! str($role->content)->markdown() !!}
</article>


@endsection
