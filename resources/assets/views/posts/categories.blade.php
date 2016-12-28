@extends('vendor.copya.layouts.frontend', ['title' => $category->name])

@section('content')
    <h1>{{ $category->name }}</h1>
    <div class="posts">
        <ul>
            @foreach($category->posts as $post)
                <li>
                    <a href="{{ url('post/'.$post->slug) }}">{{ $post->title }}</a>
                    <div class="content">
                        {{ $post->content }}
                    </div>
                </li>

            @endforeach
        </ul>
    </div>
@endsection