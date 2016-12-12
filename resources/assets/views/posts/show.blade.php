@extends('vendor.copya.layouts.frontend', ['title' => $post->title])

@section('content')
    <h1>{{ $post->title }}</h1>

    <img src="{{ url('/images/medium/'.$post->featured_image) }}" />
    <div class="row">
        <div class="col-md-12">
            {!!  $post->content  !!}
        </div>
    </div>

@endsection