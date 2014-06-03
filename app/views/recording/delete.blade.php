@extends('layout')

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
	Delete
	@if (!empty($recording->recording_isrc_num))
	<small>{{ $recording->recording_isrc_num }}</small>
	@endif
</h3>
@stop

@section('content')

<p>
	You are about to delete <strong>{{ $recording->recording_isrc_num  }}</strong> from the database.
</p>

<p>
	Are you sure you want to do this?
</p>

{{ Form::model( $recording, array( 'route' => array( 'recording.destroy', $recording->recording_id), 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'delete' ) ) }}

<div class="form-group">
	<div class="col-sm-12">
		<div class="radio">
			<label>
				{{ Form::radio('confirm', '1') }} Yes, I want to delete {{ $recording->recording_isrc_num }}.
			</label>
		</div>
		<div class="radio">
			<label>
				{{ Form::radio('confirm', '0') }} No, I don't want to delete {{ $recording->recording_isrc_num }}.
			</label>
		</div>
	</div>
</div>

<div class="form-group">
	<div class="col-sm-12">
		{{ Form::submit('Confirm', array( 'class' => 'button' )) }}
	</div>
</div>

{{ Form::close() }}

@stop
