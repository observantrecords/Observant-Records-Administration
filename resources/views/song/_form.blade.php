@extends('layout')

@section('content')

<div class="form-group">
	{!! Form::label( 'song_primary_artist_id', 'Primary artist:', array( 'class' => 'col-sm-2' ) ) !!}
	<div class="col-sm-10">
		{!! Form::select( 'song_primary_artist_id', $artists, $song->song_primary_artist_id, array( 'class' => 'form-control' ) ) !!}
	</div>
</div>

<div class="form-group">
	{!! Form::label( 'song_title', 'Song title:', array( 'class' => 'col-sm-2' ) ) !!}
	<div class="col-sm-10">
		{!! Form::text( 'song_title', $song->song_title, array( 'class' => 'form-control' ) ) !!}
	</div>
</div>

<div class="form-group">
	{!! Form::label( 'song_alias', 'Alias:', array( 'class' => 'col-sm-2' ) ) !!}
	<div class="col-sm-10">
		{!! Form::text( 'song_alias', $song->song_alias, array( 'class' => 'form-control' ) ) !!}
	</div>
</div>

<div class="form-group">
	{!! Form::label( 'song_author', 'Author:', array( 'class' => 'col-sm-2' ) ) !!}
	<div class="col-sm-10">
		{!! Form::text( 'song_author', $song->song_author, array( 'class' => 'form-control' ) ) !!}
	</div>
</div>

<div class="form-group">
	{!! Form::label( 'song_influences', 'Influences:', array( 'class' => 'col-sm-2' ) ) !!}
	<div class="col-sm-10">
		{!! Form::text( 'song_influences', $song->song_influences, array( 'class' => 'form-control' ) ) !!}
	</div>
</div>

<div class="form-group">
	{!! Form::label( 'song_style', 'Style:', array( 'class' => 'col-sm-2' ) ) !!}
	<div class="col-sm-10">
		{!! Form::text( 'song_style', $song->song_style, array( 'class' => 'form-control' ) ) !!}
	</div>
</div>

<div class="form-group">
	{!! Form::label( 'song_written_date', 'Date written:', array( 'class' => 'col-sm-2' ) ) !!}
	<div class="col-sm-10">
		{!! Form::text( 'song_written_date', $song->song_written_date, array( 'class' => 'form-control' ) ) !!}
	</div>
</div>

<div class="form-group">
	{!! Form::label( 'song_revised_date', 'Date revised:', array( 'class' => 'col-sm-2' ) ) !!}
	<div class="col-sm-10">
		{!! Form::text( 'song_revised_date', $song->song_revised_date, array( 'class' => 'form-control' ) ) !!}
	</div>
</div>

<div class="form-group">
	{!! Form::label( 'song_recorded_date', 'Date recorded:', array( 'class' => 'col-sm-2' ) ) !!}
	<div class="col-sm-10">
		{!! Form::text( 'song_recorded_date', $song->song_recorded_date, array( 'class' => 'form-control' ) ) !!}
	</div>
</div>

<div class="form-group">
	{!! Form::label( 'song_lyrics', 'Lyrics:', array( 'class' => 'col-sm-2' ) ) !!}
	<div class="col-sm-10">
		{!! Form::textarea( 'song_lyrics', $song->song_lyrics, array( 'class' => 'form-control' ) ) !!}
	</div>
</div>

<div class="form-group">
	{!! Form::label( 'song_abstract', 'Abstract:', array( 'class' => 'col-sm-2' ) ) !!}
	<div class="col-sm-10">
		{!! Form::textarea( 'song_abstract', $song->song_abstract, array( 'class' => 'form-control' ) ) !!}
	</div>
</div>

<div class="col-sm-offset-2 col-sm-10">
    <ul class="list-inline">
        <li>{!! Form::submit( 'Save', array( 'class' => 'btn btn-primary' ) ) !!}</li>
        <li>
            @if (!empty( $song->song_id))
                <a href="{{ route( 'song.show', $song->song_id ) }}" class="btn btn-default">Cancel</a>
            @elseif (!empty($song->song_primary_artist_id))
                <a href="{{ route( 'artist.show', $song->song_primary_artist_id ) }}" class="btn btn-default">Cancel</a>
            @else
                <a href="{{ route( 'song.index' ) }}" class="btn btn-default">Cancel</a>
            @endif
        </li>
    </ul>
</div>

<script type="text/javascript">
	(function ($) {
		$('#song_title').keyup(function () {
			var alias = this.value.toLowerCase().replace(/\s+/g, '-').replace(/[^a-z0-9\-]+/g, '').replace(/(^-|-$)/, '');
			$('#song_alias').val(alias);
		});
		$('#song_primary_artist_id').chosen();
	})(jQuery);
</script>

@stop