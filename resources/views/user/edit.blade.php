@extends('user._form')

@section('page_title')
    &raquo; {{ $user->user_name }}
    &raquo; Edit Profile
@stop

@section('section_header')
    <h2>{{ $user->user_name }}</h2>
@stop

@section('section_label')
    <h3>Edit Profile</h3>
@stop

@section('content')
    {!! Form::model( $user, array( 'route' => array('user.update', $user->user_id), 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'put' ) ) !!}
    @parent
    {!! Form::close() !!}
@stop
