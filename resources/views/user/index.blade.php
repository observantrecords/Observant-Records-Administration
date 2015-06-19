@extends('layout')

@section('page_title')
    &raquo; Profile &raquo; Browse
@stop

@section('section_header')
    <h2>Observant Records</h2>
@stop

@section('section_label')
    <h3>
        Profiles
        <small>Browse</small>
    </h3>
@stop

@section('content')

    <p>
        <a href="{{ route('user.create') }}" class="btn btn-primary"><span class="glyphicon glyphicon-plus"></span> Add a user</a>
    </p>

    @if (count($users) > 0)
        <ol class="track-list">
            @foreach ($users as $user)
                <li>
                    <div>
                        <a href="{{ route( 'user.edit', array( 'id' => $user->user_id ) ) }}"><span class="glyphicon glyphicon-pencil"></span></a>
                        <a href="{{ route( 'user.delete', array( 'id' => $user->user_id ) ) }}"><span class="glyphicon glyphicon-remove"></span></a>
                        <a href="{{ route( 'user.show', array( 'id' => $user->user_id ) ) }}">{{ $user->user_name }}</a>
                    </div>
                </li>
            @endforeach
        </ol>
    @endif

@stop
