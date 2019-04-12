@extends('layouts.app')

@section('content')
  <h3>Posts</h3>
  @if (count($posts) > 0)
    <ul class="list-group">
      @foreach ($posts as $post)
        <li class="list-group-item">
          <div class="well">
            <div class="row">
              <div class="col-md-4 col-sm-4">
                  <img style="width:100%" src="/storage/cover_images/{{$post->cover_image}}" alt="">
              </div>
              <div class="col-md-8 col-sm-8">
                <h3><a href="/posts/{{$post->id}}">{{ $post->title }}</a></h3>
                <small>Written by {{$post->user->name}}</small>
                <small>{{$post->created_at}}</small>
              </div>
            </div>
          </div>
        </li>
      @endforeach
    </ul>
    {{$posts->links()}}
  @else
    <p></p>
  @endif
@endsection
