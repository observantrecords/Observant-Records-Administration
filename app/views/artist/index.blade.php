@extends('layout')

@section('page_title')
 &raquo; Artists &raquo; Browse
@stop

@section('section_header')
<h2>Artists</h2>
@stop

@section('section_label')
<h3>Browse</h3>
@stop

@section('content')

<p>
	<a href="{{ route('artist.create') }}" class="button"><span class="glyphicon glyphicon-plus"></span> Add an artist</a>
</p>

@if (!empty($artists))

<ul class="two-column-bubble-list">
	@foreach ($artists as $artist)
	<li>
		<div>
			<a href="{{ route('artist.edit', array('id' => $artist->artist_id) ) }}"><span class="glyphicon glyphicon-pencil"></span></a>
			<a href="{{ route('artist.delete', array('id' => $artist->artist_id) ) }}"><span class="glyphicon glyphicon-remove"></span></a>
			<a href="{{ route('artist.show', array('id' => $artist->artist_id) ) }}" title="[View {{ $artist->artist_display_name }}]">{{ $artist->artist_display_name }}</a>
		</div>
	</li>
	@endforeach
</ul>

@else

<p>
	No artists found.
</p>

@endif

@stop
