@extends('layout')

@section('page_title')
@if (!empty($artist->artist_display_name))
 &raquo; {{ $artist->artist_display_name }}
@endif
 &raquo; Songs
@stop

@section('section_header')
<h2>
	@if (!empty($artist->artist_display_name))
	&raquo; {{ $artist->artist_display_name }}
	@else
	Observant Records
	@endif
</h2>
@stop

@section('section_label')
<h3>
	Songs
	<small>Browse</small>
</h3>
@stop

@section('content')

<p>
	@if (!empty($artist->artist_id))
	<a href="{{ route('song.create', array( 'artist' => $artist->artist_id ) ) }}" class="button"><span class="glyphicon glyphicon-plus"></span> Add a song</a>
	@else
	<a href="{{ route('song.create') }}" class="button"><span class="glyphicon glyphicon-plus"></span> Add a song</a>
	@endif
</p>

@if (!empty($songs))
<ul class="two-column-bubble-list">
	@foreach ($songs as $song)
	<li @if (!empty($rsSong->song_author)) class="cover" @endif>
	<div>
		<a href="{{ route('song.edit', array( 'id' => $song->song_id ) ) }}" title="[Edit]"><span class="glyphicon glyphicon-pencil"></span></a>
		<a href="{{ route('song.delete', array( 'id' => $song->song_id ) ) }}" title="[Delete]"><span class="glyphicon glyphicon-remove"></span></a>
		<a href="{{ route('song.show', array( 'id' => $song->song_id ) ) }}">{{ $song->song_title }}</a>
	</div>
	</li>
	@endforeach
</ul>
@else
<p>
	This artist has no songs. Please add one.
</p>
@endif

@stop
