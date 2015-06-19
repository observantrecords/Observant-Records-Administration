@extends('audio._form')

@section('page_title')
@if (!empty($audio->recording->artist->artist_display_name))
 &raquo; {{ $audio->recording->artist->artist_display_name }}
@endif
 &raquo; Audio
 &raquo; Add
@stop

@section('section_header')
<h2>
	@if (!empty($audio->recording->artist->artist_display_name))
	{{ $audio->recording->artist->artist_display_name }}
	@else
	Observant Records
	@endif
</h2>
@stop

@section('section_label')
<h3>
	Add an audio file
</h3>
@stop

@section('content')
{!! Form::model( $audio, array( 'route' => 'audio.store', 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'post' ) ) !!}
@parent
{!! Form::close() !!}
@stop
