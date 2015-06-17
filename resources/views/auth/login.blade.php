@extends('layout')

@section('section_header')
<h2>Login</h2>
@stop

@section('content')

{!! Form::open( array( 'route' => 'auth.signin', 'class' => 'form-horizontal', 'role' => 'form' ) ) !!}

<div class="form-group">
	{!! Form::label('user_name', 'User name:', array( 'class' => 'col-sm-2 control-label' ) ) !!}
    <div class="col-sm-10">
        {!! Form::text('user_name', null, array( 'class' => 'form-control' ) ) !!}
    </div>
</div>

<div class="form-group">
	{!! Form::label('user_password', 'Password:', array( 'class' => 'col-sm-2 control-label' ) ) !!}
    <div class="col-sm-10">
        {!! Form::password('user_password', array( 'class' => 'form-control' ) ) !!}
    </div>
</div>

<div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
        {!! Form::submit('Login', array( 'class' => 'btn btn-primary' ) ) !!}
    </div>
</div>

<p>
    <a href="{{ route( 'password.email') }}">Reset password</a>
</p>

{!! Form::close() !!}

@stop
