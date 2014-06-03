@extends('song._form')

@section('page_title')
@if (!empty($song->artist->artist_display_name))
 &raquo; {{ $song->artist->artist_display_name }}
@endif
 &raquo; Add
@stop

@section('section_header')
<hgroup>
	<h2>
		@if (!empty($song->artist->artist_display_name))
		{{ $song->artist->artist_display_name }}
		@else
		Observant Records
		@endif
	</h2>
</hgroup>
@stop

@section('section_label')
<h3>Add a new song</h3>
@stop

@section('content')
{{ Form::model( $song, array( 'route' => 'song.store', 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'post' ) ) }}
@parent
{{ Form::close() }}
@stop
