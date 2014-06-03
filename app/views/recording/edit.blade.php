@extends('recording._form')

@section('page_title')
 &raquo; {{ $recording->artist->artist_display_name }}
@if (!empty($recording->recording_isrc_num))
 &raquo; {{ $recording->recording_isrc_num }}
@endif
 &raquo; Edit
@stop

@section('section_header')
<h2>
	{{ $recording->artist->artist_display_name }}
	@if (!empty($recording->song->song_title))
	<small>{{ $recording->song->song_title }}</small>
	@endif
</h2>
@stop

@section('section_label')
<h3>
	Edit
	@if (!empty($recording->recording_isrc_num))
	<small>{{ $recording->recording_isrc_num }}</small>
	@endif
</h3>
@stop

@section('content')
{{ Form::model( $recording, array( 'route' => array('recording.update', $recording->recording_id), 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'put' ) ) }}
@parent
{{ Form::close() }}
@stop
