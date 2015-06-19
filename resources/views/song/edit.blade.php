@extends('song._form')

@section('page_title')
 &raquo; {{ $song->artist->artist_display_name }}
 &raquo; {{ $song->song_title }}
 &raquo; Edit
@stop

@section('section_header')
<hgroup>
	<h2>
		{{ $song->artist->artist_display_name }}
		<small>{{ $song->song_title }}</small>
	</h2>
</hgroup>
@stop

@section('section_label')
<h3>Edit</h3>
@stop

@section('content')
{!! Form::model( $song, array( 'route' => array('song.update', $song->song_id), 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'put' ) ) !!}
@parent
{!! Form::close() !!}
@stop
