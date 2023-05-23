@extends('layout')

@section('content')

@foreach( $posts as $post )
    <article>
        <a href="/post/{{ $post->slug }}">
            <h1>{{  $post->title }}</h1>
        </a>
        <div>{{ $post->excerpt }}</div>
    </article>
 @endforeach

@endsection
