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

<ul class="list-inline">
	<li><a href="{{ route('artist.edit', $artist->artist_id) }}" class="btn btn-primary">Edit</a></li>
	<li><a href="{{ route('artist.delete', $artist->artist_id) }}" class="btn btn-warning">Delete</a></li>
</ul>

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

{!! Form::open( array( 'route' => array( 'album.save-order' ), 'id' => 'save-order-form' ) ) !!}
<ul class="list-inline">
	<li><a href="{{ route( 'album.create', array( 'artist' => $artist->artist_id ) ) }}" class="btn btn-primary"><span class="glyphicon glyphicon-plus"></span> Add album</a></li>
	<li>
		{!! Form::button( 'Save album order', array('id' => 'save-order', 'class' => 'btn btn-default') ) !!}
		{!! Form::hidden('album_id', null) !!}
	</li>
</ul>
{!! Form::close() !!}

@if (count($artist->albums) > 0)
<ol class="disc-list">
	@foreach ($artist->albums as $album)
	<li>
		<div>
			<ul class="list-inline">
				<li><a href="{{ route( 'album.edit', $album->album_id ) }}"><span class="glyphicon glyphicon-pencil"></span></a></li>
				<li><a href="{{ route( 'album.delete', $album->album_id ) }}"><span class="glyphicon glyphicon-remove"></span></a></li>
				<li>
					<span class="album-order-display">{{ $album->album_order }}</span>. <a href="{{ route( 'album.show', $album->album_id ) }}">{{ $album->album_title }}</a>
					{!! Form::hidden('album_id', $album->album_id) !!}
					{!! Form::hidden('album_order', $album->album_order) !!}
				</li>
			</ul>
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

<div id="save-order-dialog">
	<p class="msg"></p>
</div>

<script type="text/javascript">
	$('.disc-list').sortable({
		update: function (event, ui) {
			var new_album_order = 1;
			$(this).children().each(function () {
				$(this).find('.album-order-display').html(new_album_order);
				new_album_order++;
			});
		}
	});
	$('#save-order-dialog').dialog({
		autoOpen: false,
		modal: true,
		buttons: {
			"OK": function () {
				$(this).dialog('close');
			}
		}
	});
	$('#save-order').click(function () {
		var albums = [], album_order, album_id, album_info;
		$('.disc-list').children().each(function () {
			album_order = $(this).find('.album-order-display').html();
			album_id = $(this).find('input[name=album_id]').val();
			album_info = {
				'album_id': album_id,
				'album_order': album_order
			}
			albums.push(album_info);
		});
		var _token = $('input[name=_token]').val();
		var url = $('#save-order-form').attr('action');
		var data = {
			'albums': albums,
			'_token': _token
		};
		$.post(url, data, function (result) {
			$('#save-order-dialog').dialog('open');
			$('#save-order-dialog').find('.msg').html(result);
		}).error(function (result) {
			var error_msg = 'Your request could not be completed. The following error was given: ' + result.statusText;
			$('#save-order-dialog').dialog('open');
			$('#save-order-dialog').find('.msg').html(error_msg);
		});
	});
</script>
@stop
