@extends('layout')

@section('content')

    <div class="form-group">
        {!! Form::label( 'user_name', 'User name:', array( 'class' => 'col-sm-2 control-label' ) ) !!}
        <div class="col-sm-10">
            {!! Form::text( 'user_name', $user->user_name, array( 'class' => 'form-control' ) ) !!}
        </div>
    </div>

    <div class="form-group">
        {!! Form::label( 'user_email', 'E-mail:', array( 'class' => 'col-sm-2 control-label' ) ) !!}
        <div class="col-sm-10">
            {!! Form::text( 'user_email', $user->user_email, array( 'class' => 'form-control' ) ) !!}
        </div>
    </div>

    <h4>Password</h4>

    @if (!empty($user->user_password))
    <div class="form-group">
        {!! Form::label( 'old_password', 'Current:', array( 'class' => 'col-sm-2 control-label' ) ) !!}
        <div class="col-sm-10">
            {!! Form::password( 'old_password', null, array( 'class' => 'form-control' ) ) !!}
        </div>
    </div>

    <div class="form-group">
        {!! Form::label( 'new_password', 'New:', array( 'class' => 'col-sm-2 control-label' ) ) !!}
        <div class="col-sm-10">
            {!! Form::password( 'new_password', null, array( 'class' => 'form-control' ) ) !!}
        </div>
    </div>
    @else
    <div class="form-group">
        {!! Form::label( 'user_password', 'New:', array( 'class' => 'col-sm-2 control-label' ) ) !!}
        <div class="col-sm-10">
            {!! Form::password( 'user_password', null, array( 'class' => 'form-control' ) ) !!}
        </div>
    </div>
    @endif

    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <ul class="list-inline">
                <li>{!! Form::submit( 'Save', array( 'class' => 'btn btn-primary' ) ) !!}</li>
                <li>
                    @if (!empty( $user->user_id))
                        <a href="{{ route( 'user.show', array( 'id' => $user->user_id ) ) }}" class="btn btn-default">Cancel</a>
                    @else
                        <a href="{{ route( 'user.index' ) }}" class="btn btn-default">Cancel</a>
                    @endif
                </li>
            </ul>
        </div>
    </div>

@stop