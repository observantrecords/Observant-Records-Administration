@extends('layout')

@section('page_title')
 &raquo; {{ $song->artist->artist_display_name }}
 &raquo; {{ $song->song_title }}
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
<h3>Song information</h3>
@stop

@section('content')

<p>
	<a href="{{ route('song.edit', $song->song_id) }}" class="btn btn-primary">Edit</a>
	<a href="{{ route('song.delete', $song->song_id) }}" class="btn btn-warning">Delete</a>
</p>

<ul class="two-column-bubble-list">
	<li>
		<div>
			<label>Title</label> {{ $song->song_title }}
		</div>
	</li>
	<li>
		<div>
			<label>Alias</label> {{ $song->song_alias }}
		</div>
	</li>
	@if (!empty($rsSong->song_author))
	<li>
		<div>
			<label>Author</label> {{ $song->song_author }}
		</div>
	</li>
	@endif
	<li>
		<div>
			<label>Influences</label> {{ $song->song_influences }}
		</div>
	</li>
	<li>
		<div>
			<label>Style</label> {{ $song->song_style }}
		</div>
	</li>
	<li>
		<div>
			<label>Date written</label> {{ $song->song_written_date }}
		</div>
	</li>
	<li>
		<div>
			<label>Date revised</label> {{ $song->song_revised_date }}
		</div>
	</li>
	<li>
		<div>
			<label>Date recorded</label> {{ $song->song_recorded_date }}
		</div>
	</li>
</ul>

<h4>Recordings</h4>

@if (count($song->recordings) > 0)
<ol class="track-list">
	@foreach ($song->recordings as $recording)
	<li>
		<div>
			<a href="{{ route( 'recording.edit', $recording->recording_id ) }}"><span class="glyphicon glyphicon-pencil"></span></a>
			<a href="{{ route( 'recording.delete', $recording->recording_id ) }}"><span class="glyphicon glyphicon-remove"></span></a>
			<a href="{{ route( 'recording.show', $recording->recording_id ) }}">@if (empty($recording->recording_isrc_num)) (ISRC TBD) @else {{ $recording->recording_isrc_num }} @endif</a>
		</div>
	</li>
	@endforeach
</ol>
@else
<p>No recordings have been made.</p>
@endif

<h4>Tracks</h4>

@if (count($song->tracks) > 0)
<ol class="track-list">
	@foreach ($song->tracks as $track)
	<li>
		<div>
			<a href="{{ route( 'track.edit', $track->track_id ) }}"><span class="glyphicon glyphicon-pencil"></span></a>
			<a href="{{ route( 'track.delete', $track->track_id ) }}"><span class="glyphicon glyphicon-remove"></span></a>
			<em><a href="{{ route( 'track.show', $track->track_id ) }}">{{ $track->release->release_alias }}</a></em>
		</div>
	</li>
	@endforeach
</ol>
@else
<p>No tracks have been created.</p>
@endif

@if (!empty($rsSong->song_lyrics))
<h4>Lyrics</h4>

{{ $song->song_lyrics }}

@endif

@if (!empty($rsSong->song_abstract))
<h4>Abstract</h4>

{{ $song->song_abstract }}
@endif
@stop
