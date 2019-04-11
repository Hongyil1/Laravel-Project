@extends('layouts.app')

@section('content')
  <h3>Create</h3>
  {!! Form::open(['action' => 'PostController@store', 'method' => 'Post']) !!}
    <div class="fore-group">
      {{form::label('title', 'title')}}
      {{form::text('title', '', ['class' => 'form-control', 'placeholder' => 'title'])}}
    </div>
  {!! Form::close() !!}
@endsection
