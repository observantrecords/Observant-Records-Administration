@extends('user._form')

@section('page_title')
 &raquo; Users &raquo; Add a new user
@stop

@section('section_header')
<h2>Users</h2>
@stop

@section('section_label')
<h3>Add a new user</h3>
@stop

@section('content')
{!! Form::model( $user, array( 'route' => 'user.store', 'class' => 'form-horizontal', 'role' => 'form' ) ) !!}
@parent
{!! Form::close() !!}
@stop
