@extends('layout')

@section('page_title')
    &raquo; {{ $user->user_name }}
@stop

@section('section_header')
    <h2>{{ $user->user_name }}</h2>
@stop

@section('section_label')
    <h3>Profile</h3>
@stop

@section('content')

    <ul class="list-inline">
        <li><a href="{{ route('user.edit', array('id' => $user->user_id)) }}" class="btn btn-primary">Edit</a></li>
        <li><a href="{{ route('user.delete', array('id' => $user->user_id)) }}" class="btn btn-warning">Delete</a></li>
    </ul>

    <ul class="two-column-bubble-list">
        <li>
            <div>
                <label>User name:</label> {{ $user->user_name }}
            </div>
        </li>
        <li>
            <div>
                <label>User e-mail:</label> {{ $user->user_email }}
            </div>
        </li>
    </ul>

@stop
