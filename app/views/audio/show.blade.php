@extends('layout')

@section('page_title')
@if (!empty($audio->recording->artist->artist_display_name))
&raquo; {{ $audio->recording->artist->artist_display_name }}
@endif
&raquo; {{ $audio->audio_file_name }}
&raquo; View
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
	Audio information
	<small>{{ $audio->audio_file_name }}</small>
</h3>
@stop

@section('content')
<p>
	<a href="{{ route( 'audio.edit', array( 'id' => $audio->audio_id ) ) }}" class="button">Edit</a>
	<a href="{{ route( 'audio.delete', array( 'id' => $audio->audio_id ) ) }}" class="button">Delete</a>
</p>

<ul class="two-column-bubble-list">
	<li>
		<div>
			<label>File server</label> <span title="{{ $audio->audio_file_server }}">{{ $audio->audio_file_server }}</span>
		</div>
	</li>
	<li>
		<div>
			<label>File path</label> {{ $audio->audio_file_path }}
		</div>
	</li>
	<li>
		<div>
			<label>File name</label> <span title="{{ $audio->audio_file_name }}">{{ $audio->audio_file_name }}</span>
		</div>
	</li>
	<li>
		<div>
			<label>Display label</label> {{ $audio->audio_display_label }}
		</div>
	</li>
	<li>
		<div>
			<label>File type</label> {{ $audio->audio_file_type }}
		</div>
	</li>
	<li>
		<div>
			<label>Recording</label>
			<a href="{{ route( 'recording.show', array( 'id' => $audio->recording->recording_id ) ) }}">
				@if (empty($audio->recording->recording_isrc_num))
				ISRC TBD
				@else
				{{ $audio->recording->recording_isrc_num }}
				@endif
			</a>
		</div>
	</li>
</ul>

@stop

@section('sidebar')
@if (!empty($audio->audio_file_server) && !empty($audio->audio_file_name) && !empty($audio->audio_file_path))
<h4>Listen</h4>

<p>
	<audio id="file_preview" controls>
		<source src="http://{{ $audio->audio_file_server }}{{ $audio->audio_file_path }}/{{ $audio->audio_file_name }}" type="{{ $audio->audio_file_type }}" />
	</audio>
</p>
@endif

@stop