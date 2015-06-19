@extends('layout')

@section('page_title')
 &raquo; {{ $song->artist->artist_display_name }}
 &raquo; {{ $song->song_title }}
 &raquo; Delete
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
<h3>Delete</h3>
@stop

@section('content')

<p>
	You are about to delete <strong>{{ $song->song_title }}</strong> from the database.
</p>

<p>
	Are you sure you want to do this?
</p>

{!! Form::model( $song, array( 'route' => array( 'song.destroy', $song->song_id), 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'delete' ) ) !!}

<div class="form-group">
	<div class="col-sm-12">
		<div class="radio">
			<label>
				{!! Form::radio('confirm', '1') !!} Yes, I want to delete {{ $song->song_title }}.
			</label>
		</div>
		<div class="radio">
			<label>
				{!! Form::radio('confirm', '0') !!} No, I don't want to delete {{ $song->song_title }}.
			</label>
		</div>
	</div>
</div>

<div class="form-group">
	<div class="col-sm-12">
		{!! Form::submit('Confirm', array( 'class' => 'btn btn-danger' ) ) !!}
	</div>
</div>


{!! Form::close() !!}

@stop
