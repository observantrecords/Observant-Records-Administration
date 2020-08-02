@extends('layout')

@section('page_title')
 &raquo; {{ $recording->artist->artist_display_name }}
@if (!empty($recording->recording_isrc_num))
 &raquo; {{ $recording->recording_isrc_num }}
@endif
@stop

@section('section_header')
<hgroup>
	<h2>
		{{ $recording->artist->artist_display_name }}
		<small>{{ $recording->song->song_title }}</small>
	</h2>
</hgroup>
@stop

@section('section_label')
<h3>
	Recording info
	@if (!empty($recording->recording_isrc_num))
	<small>{{ $recording->recording_isrc_num }}</small>
	@endif
</h3>
@stop

@section('content')

<p>
	<a href="{{ route( 'recording.edit', $recording->recording_id ) }}" class="btn btn-primary">Edit</a>
	<a href="{{ route( 'recording.delete', $recording->recording_id ) }}" class="btn btn-warning">Delete</a>
</p>

<ul class="two-column-bubble-list">
	<li>
		<div>
			<label>Song</label> {{ $recording->song->song_title }}
		</div>
	</li>
	<li>
		<div>
			<label>ISRC</label>
			@if (empty($recording->recording_isrc_num))
			Not set
			@else
			{{ $recording->recording_isrc_num }}
			@endif
		</div>
	</li>
</ul>

<h3>Audio files</h3>

<p>
	<a href="{{ route( 'audio.create', array('recording' => $recording->recording_id) ) }}" class="btn btn-primary"><span class="glyphicon glyphicon-plus"></span> Add an audio file</a>
</p>

@if (count($recording->audio) > 0)
<ol class="disc-list">
	@foreach ($recording->audio as $audio)
	<li>
		<div>
			<ul class="list-inline">
				<li><a href="{{ route( 'audio.edit', $audio->audio_id ) }}" title="[Edit audio]"><span class="glyphicon glyphicon-pencil"></span></a></li>
				<li><a href="{{ route( 'audio.delete', $audio->audio_id ) }}" title="[Remove audio]"><span class="glyphicon glyphicon-remove"></span></a></li>
				<li><a href="{{ route( 'audio.show', $audio->audio_id ) }}" title="[{{ $audio->audio_file_server }}{{ $audio->audio_file_path }}/{{ $audio->audio_file_name }}]">{{ $audio->audio_file_name }}</a></li>
			</ul>
		</div>
	</li>
	@endforeach
</ol>
@else
<p>
	This recording has no audio files associated with it.
</p>
@endif

@stop
