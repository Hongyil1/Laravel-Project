@extends('layouts.app')

@section('content')
  <a href="/posts" class="btn btn-default">Go Back</a>
  <h1>{{$post->title}}</h1>
  <img style="width:100%" src="/storage/cover_images/{{$post->cover_image}}" alt="">
  <hr><hr>
  <div class="">
    {!! $post->body !!}
  </div>
  <hr>
  <small>Written by {{$post->user->name}}</small>
  <small>{{$post->created_at}}</small>
  <hr>
  @if (!Auth::guest())
    @if (Auth::user()->id == $post->user->id)
      <a href="/posts/{{$post->id}}/edit" class="btn btn-default">Edit</a>
      {!!Form::open(['action'=>['PostController@destroy', $post->id], 'method'=> 'POST', 'class' => 'float-right'])!!}
        {{Form::hidden('_method', 'DELETE')}}
        {{Form::submit('Delete', ['class' => 'btn btn-danger'])}}
      {!!Form::close()!!}
    @endif
  @endif
@endsection
