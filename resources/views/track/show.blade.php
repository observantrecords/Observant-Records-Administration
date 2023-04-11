@extends('layout')

@section('page_title')
 &raquo; {{ $track->release->album->artist->artist_display_name }}
 &raquo; {{ $track->release->album->album_title }}
@if (!empty($release->release_catalog_num)) &raquo; {{ $release->release_catalog_num }} @endif
 &raquo; {{ $track->track_title }}
@stop

@section('section_header')
<hgroup>
	<h2>
		{{ $track->release->album->artist->artist_display_name }}
		<small>{{ $track->release->album->album_title }}</small>
	</h2>
</hgroup>
@stop

@section('section_label')
<h3>
	Track info
	<small>
		{{ $track->track_title }}
	</small>
</h3>
@stop

@section('content')

<p>
	<a href="{{ route( 'track.edit', $track->track_id ) }}" class="btn btn-primary">Edit</a>
	<a href="{{ route( 'track.delete', $track->track_id ) }}" class="btn btn-default">Delete</a>
</p>

<ul class="two-column-bubble-list">
	<li>
		<div>
			<label>Title</label>
			{{ $track->track_title }}
		</div>
	</li>
	<li>
		<div>
			<label>Disc no.</label> {{ $track->track_disc_num }}
		</div>
	</li>
	<li>
		<div>
			<label>Track no.</label> {{ $track->track_track_num }}
		</div>
	</li>
	@if (!empty($track->track_alias))
	<li>
		<div>
			<label>Alias</label> {{ $track->track_alias }}
		</div>
	</li>
	@endif
	@if (!empty($track->track_artist_id))
		<li>
			<div>
				<label>Artist</label> {{ $track->artist->artist_display_name }}
			</div>
		</li>
	@endif
	<li>
		<div>
			<label>Visible?</label> <input type="checkbox" disabled="disabled" value="1" @if ($track->track_is_visible == true) checked @endif />
		</div>
	</li>
	<li>
		<div>
			<label>Playable?</label> <input type="checkbox" disabled="disabled" value="1"@if ($track->track_audio_is_linked == true) checked @endif />
		</div>
	</li>
	<li>
		<div>
			<label>Downloadable?</label> <input type="checkbox" disabled="disabled" value="1"@if ($track->track_audio_is_downloadable == true) checked @endif />
		</div>
	</li>
	<li>
		<div>
			<label>Recording</label>
			@if (!empty($track->track_recording_id))
			<a href=" {{ route('recording.show', $track->track_recording_id ) }}/">
				@if (empty($track->recording->recording_isrc_num))
				(No ISRC number set) {{ $track->song->song_title }}
				@else
				{{ $track->recording->recording_isrc_num }}
				@endif
			</a>
			@else
			Not set.
			@endif
		</div>
	</li>
	@if ($track->track_uplaya_score)
	<li>
		<div>
			<label>uPlaya score</label> {{ $track->track_uplaya_score }}
		</div>
	</li>
	@endif
</ul>
@stop

@section('sidebar')
	@if (!empty($track->release->get_cdn_image() ))
		<p>
			<img src="{{ $track->release->get_cdn_image('medium') }}" width="230" />
		</p>
	@endif

<ul class="list-unstyled">
	<li>&laquo; <a href="{{ route('release.show', $track->track_release_id ) }}/">Back to <em>{{ $track->release->album->album_title }}</em> @if (!empty($track->release->release_catalog_num)) ({{ $track->release->release_catalog_num }}) @endif</a></li>
</ul>

@stop