@extends('recording._form')

@section('page_title')
@if (!empty($recording->artist->artist_display_name))
 &raquo; {{ $recording->artist->artist_display_name }}
@endif
 &raquo; Add a new recording
@stop

@section('section_header')
<h2>
	@if (!empty($recording->artist->artist_display_name))
	{{ $recording->artist->artist_display_name }}
	@else
	Observant Records
	@endif
</h2>
@stop

@section('section_label')
<h3>Add a new recording</h3>
@stop

@section('content')
{{ Form::model( $recording, array( 'route' => 'recording.store', 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'post' ) ) }}
@parent
{{ Form::close() }}
@stop
