@extends('layout')

@section('page_title')
@if (!empty($audio->recording->artist->artist_display_name))
&raquo; {{ $audio->recording->artist->artist_display_name }}
@endif
&raquo; {{ $audio->audio_file_name }}
&raquo; Delete
@stop

@section('section_header')
<h2>
	@if (!empty($audio->recording->artist->artist_display_name))
	{{ $audio->recording->artist->artist_display_name }}
	<small>{{ $audio->recording->song->song_title }}</small>
	@else
	{{ $audio->recording->song->song_title }}
	@endif
</h2>
@stop

@section('section_label')
<h3>
	Delete
	<small>{{ $audio->audio_file_name }}</small>
</h3>
@stop

@section('content')

<p>
	You are about to delete <strong>{{ $audio->audio_file_name }}</strong> from the database.
</p>

<p>
	Are you sure you want to do this?
</p>

{{ Form::model( $audio, array( 'route' => array( 'audio.destroy', $audio->audio_id), 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'delete' ) ) }}

<div class="form-group">
	<div class="col-sm-12">
		<div class="radio">
			<label>
				{{ Form::radio('confirm', '1') }} Yes, I want to delete {{ $audio->audio_file_name }}.
			</label>
		</div>
		<div class="radio">
			<label>
				{{ Form::radio('confirm', '0') }} No, I don't want to delete {{ $audio->audio_file_name }}.
			</label>
		</div>
	</div>
</div>

<div class="form-group">
	<div class="col-sm-12">
		{{ Form::hidden('audio_recording_id', $audio->audio_recording_id) }}
		{{ Form::submit('Confirm', array( 'class' => 'button' )) }}
	</div>

</div>


{{ Form::close() }}

@stop
