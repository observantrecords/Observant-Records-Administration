@extends('layout')

@section('page_title')
@stop

@section('section_header')
@stop

@section('section_label')
@stop

@section('content')
<p>
	@if (!empty($recording->recording_id))
	<a href="{{ route('audio.create', array( 'recording' => $recording->recording_id ) ) }}" class="btn btn-primary"><span class="glyphicon glyphicon-plus"></span> Add audio file</a>
	@else
	<a href="{{ route('audio.create') }}" class="btn btn-primary"><span class="glyphicon glyphicon-plus"></span> Add audio file</a>
	@endif
</p>

@if (!empty($audio_files))
<ul class="two-column-bubble-list">
	@foreach ($audio_files as $audio)
	<li>
		<div>
			<a href="{{ route('audio.edit', array('id' => $audio->audio_id) ) }}" title="[Edit]"><span class="glyphicon glyphicon-pencil"></span></a>
			<a href="{{ route('audio.delete', array('id' => $audio->audio_id) ) }}" title="[Delete]"><span class="glyphicon glyphicon-remove"></span></a>
			<a href="{{ route('audio.show', array('id' => $audio->audio_id) ) }}" title="{{ $audio->audio_file_server}}{{ $audio->audio_file_path }}/{{ $audio->audio_file_name }}">{{ $audio->audio_file_name }}</a>
		</div>
	</li>
	@endforeach
</ul>
@else
<p>
	This artist has no audio files. Please add one.
</p>
@endif
@stop
