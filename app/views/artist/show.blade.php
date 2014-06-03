@extends('layout')

@section('page_title')
 &raquo; {{ $artist->artist_display_name }}
@stop

@section('section_header')
<h2>{{ $artist->artist_display_name }}</h2>
@stop

@section('section_label')
<h3>Profile</h3>
@stop

@section('content')

<p>
	<a href="{{ route('artist.edit', array('id' => $artist->artist_id)) }}" class="button">Edit</a>
	<a href="{{ route('artist.delete', array('id' => $artist->artist_id)) }}" class="button">Delete</a>
</p>

<ul class="two-column-bubble-list">
	<li>
		<div>
			<label>Last name:</label> {{ $artist->artist_last_name }}
		</div>
	</li>
	@if (!empty($artist->artist_first_name))
	<li>
		<div>
			<label>First name:</label> {{ $artist->artist_first_name }}
		</div>
	</li>
	@endif
	@if (!empty($artist->artist_display_name))
	<li>
		<div>
			<label>Display name:</label> {{ $artist->artist_display_name }}
		</div>
	</li>
	@endif
	@if (!empty($artist->artist_alias))
	<li>
		<div>
			<label>Alias:</label> {{ $artist->artist_alias }}
		</div>
	</li>
	@endif
	@if (!empty($artist->artist_url))
	<li>
		<div>
			<label>URL:</label> <a href="{{ $artist->artist_url }}">{{ $artist->artist_url }}</a>
		</div>
	</li>
	@endif
</ul>

<h3>Albums</h3>

<p>
	<a href="{{ route( 'album.create', array( 'artist' => $artist->artist_id ) ) }}" class="button"><span class="glyphicon glyphicon-plus"></span> Add album</a>
</p>


@if (count($artist->albums) > 0)
<ol class="track-list">
	@foreach ($artist->albums as $album)
	<li>
		<div>
			<a href="{{ route( 'album.edit', array( 'id' => $album->album_id ) ) }}"><span class="glyphicon glyphicon-pencil"></span></a>
			<a href="{{ route( 'album.delete', array( 'id' => $album->album_id ) ) }}"><span class="glyphicon glyphicon-remove"></span></a>
			<span class="album-order-display">{{ $album->album_order }}</span>. <a href="{{ route( 'album.show', array( 'id' => $album->album_id ) ) }}">{{ $album->album_title }}</a>
			{{ Form::hidden('album_id', $album->album_id) }}
			{{ Form::hidden('album_order', $album->album_order) }}
		</div>
	</li>
	@endforeach
</ol>
@else
<p>
	This artist has no albums. Please <a href="{{ route( 'album.create', array( 'id' => $artist->artist_id ) ) }}">add one</a>.
</p>
@endif

<h3>Catalogs</h3>

<ul>
	<li><a href="{{ route( 'song.index', array( 'artist' => $artist->artist_id ) ) }}">Songs</a></li>
	<li><a href="{{ route( 'recording.index', array( 'artist' => $artist->artist_id ) ) }}">Recordings</a></li>
</ul>

@stop
