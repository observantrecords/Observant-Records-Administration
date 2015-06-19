@extends('layout')

@section('section_header')
    <h2>Reset password</h2>
@stop

@section('content')

    {!! Form::open( array( 'route' => 'password.reset', 'class' => 'form-horizontal', 'role' => 'form' ) ) !!}

    <div class="form-group">
        {!! Form::label('user_email', 'Email:', array( 'class' => 'col-sm-2 control-label' ) ) !!}
        <div class="col-sm-10">
            {!! Form::text('user_email', null, array( 'class' => 'form-control' ) ) !!}
        </div>
    </div>

    <div class="form-group">
        {!! Form::label('user_password', 'Password:', array( 'class' => 'col-sm-2 control-label' ) ) !!}
        <div class="col-sm-10">
            {!! Form::password('user_password', null, array( 'class' => 'form-control' ) ) !!}
        </div>
    </div>

    <div class="form-group">
        {!! Form::label('user_password_confirmation', 'Confirmation:', array( 'class' => 'col-sm-2 control-label' ) ) !!}
        <div class="col-sm-10">
            {!! Form::password('user_password_confirmation', null, array( 'class' => 'form-control' ) ) !!}
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            {!! Form::hidden('token', $token) !!}
            {!! Form::submit('Reset password', array( 'class' => 'btn btn-primary' ) ) !!}
        </div>
    </div>

    {!! Form::close() !!}

@stop
