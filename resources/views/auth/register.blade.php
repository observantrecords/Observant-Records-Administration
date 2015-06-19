@extends('layout')

@section('section_header')
    <h2>Register</h2>
@stop

@section('content')

    {!! Form::open( array( 'route' => 'auth.signup', 'class' => 'form-horizontal', 'role' => 'form' ) ) !!}

    <div class="form-group">
        {!! Form::label('name', 'User name:', array( 'class' => 'col-sm-2 control-label' ) ) !!}
        <div class="col-sm-10">
            {!! Form::text('name', null, array( 'class' => 'form-control' ) ) !!}
        </div>
    </div>

    <div class="form-group">
        {!! Form::label('email', 'Email:', array( 'class' => 'col-sm-2 control-label' ) ) !!}
        <div class="col-sm-10">
            {!! Form::text('email', null, array( 'class' => 'form-control' ) ) !!}
        </div>
    </div>

    <div class="form-group">
        {!! Form::label('password', 'Password:', array( 'class' => 'col-sm-2 control-label' ) ) !!}
        <div class="col-sm-10">
            {!! Form::password('password', array( 'class' => 'form-control' ) ) !!}
        </div>
    </div>

    <div class="form-group">
        {!! Form::label('password_confirmation', 'Confirm:', array( 'class' => 'col-sm-2 control-label' ) ) !!}
        <div class="col-sm-10">
            {!! Form::password('password_confirmation', array( 'class' => 'form-control' ) ) !!}
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            {!! Form::submit('Register', array( 'class' => 'btn btn-primary' ) ) !!}
        </div>
    </div>

    {!! Form::close() !!}

@stop
