@extends('layouts.app')

@section('content')
  <h3>Edit Post</h3>
  {!! Form::open(['action' => ['PostController@update', $post->id], 'method' => 'Post', 'enctype'=> 'multipart/form-data']) !!}
    <div class="form-group">
      {{form::label('title', 'Title')}}
      {{form::text('title', $post->title, ['class' => 'form-control', 'placeholder' => 'Title'])}}
    </div>
    <div class="form-group">
      {{form::label('body', 'Body')}}
      {{form::textarea('body', $post->body, ['id'=>'article-ckeditor' ,'class' => 'form-control', 'placeholder' => 'Body Text'])}}
    </div>
    <div class="form-group">
        {{form::file('cover_image')}}
    </div>
    {{Form::hidden('_method','PUT')}}
    {{Form::submit('Submit', ['class'=>'btn btn-primary'])}}
  {!! Form::close() !!}
@endsection
