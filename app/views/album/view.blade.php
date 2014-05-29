@extends('layout')

@section('page_title')
 &raquo; {{ $album->artist->artist_display_name }}
 &raquo; {{ $album->album_title }}
@stop

@section('section_header')
<hgroup>
	<h2>
		{{ $album->artist->artist_display_name }}
		<small>{{ $album->album_title }}</small>
	</h2>
</hgroup>
@stop

@section('section_label')
<h3>Album info</h3>
@stop

@section('content')

<p>
	<a href="{{ route('album.edit', array('id' => $album->album_id)) }}" class="button">Edit</a>
	<a href="{{ route('album.delete', array('id' => $album->album_id)) }}" class="button">Delete</a>
</p>

<ul class="two-column-bubble-list">
	<li>
		<div>
			<label>Title</label> {{ $album->album_title }}
		</div>
	</li>
	@if (!empty($album->album_ctype_locale))
	<li>
		<div>
			<label>Title locale</label> {{ $album->album_ctype_locale }}
		</div>
	</li>
	@endif
	@if (!empty($album->album_release_date))
	<li>
		<div>
			<label>Release Date</label> {{ date( 'm/d/Y', strtotime( $album->album_release_date ) ) }}
		</div>
	</li>
	@endif
	@if (!empty($album->album_alias))
	<li>
		<div>
			<label>Alias</label> {{ $album->album_alias }}
		</div>
	</li>
	@endif
	@if (!empty($album->album_image))
	<li>
		<div>
			<label>Image</label> {{ $album->album_image }}
		</div>
	</li>
	@endif
	@if (!empty($primary_release))
	<li>
		<div>
			<label>Primary release</label> {{ $primary_release->release_catalog_num }}
		</div>
	</li>
	@endif
	<li>
		<div>
			<label>Visible?</label> <input type="checkbox" disabled="disabled" value="1"
			@if ($album->album_is_visible==true)
			checked="checked"
			@endif />
		</div>
	</li>
</ul>


<h3>Releases</h3>

<p>
	<a href="{{ route('release.add', array( 'id' => $album->album_id )) }}" class="button"><span class="glyphicon glyphicon-plus"></span> Add a release</a>
</p>

@if (!empty($album->releases))
<table class="table">
	<thead>
	<tr>
		<th>&nbsp;</th>
		<th>Cover</th>
		<th>Catalog No.</th>
		<th>UPC</th>
	</tr>
	</thead>
	<tbody>
	</tbody>
	@foreach ($album->releases as $release)
	<tr>
		<td>
			<div>
				<a href="{{ route( 'release.edit', array( 'id' => $release->release_id ) ) }}/"><span class="glyphicon glyphicon-pencil" title="[Edit]"></span></a>
				<a href="{{ route( 'release.delete', array( 'id' => $release->release_id ) ) }}/"><span class="glyphicon glyphicon-remove" title="[Delete]"></span></a>
			</div>
		</td>
		<td>
			<a href="{{ route( 'release.view', array( 'id' => $release->release_id ) ) }}"><img src="{{ OBSERVANTRECORDS_CDN_BASE_URI }}/artists/{{ $artist->artist_alias }}/albums/{{ $album->album_alias }}/{{ strtolower($release->release_catalog_num) }}/images/cover_front_small.jpg" width="50" height="50" /></a>
		</td>
		<td>
			@if (!empty($release->release_catalog_num))
			{{ $release->release_catalog_num }}
			@else
			Unassigned
			@endif
		</td>
		<td>
			@if (!empty($release->release_upc_num))
			{{ $release->release_upc_num }}
			@else
			Unassigned
			@endif
		</td>
	</tr>
	@endforeach
</table>
@endif


@stop
