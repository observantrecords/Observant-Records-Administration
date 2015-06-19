@extends('layout')

@section('content')

	<div class="form-group">
		{!! Form::label( 'track_release_id', 'Release:', array( 'class' => 'col-sm-2' ) ) !!}
		<div class="col-sm-10">
			{!! Form::select( 'track_release_id', $releases, $track->track_release_id, array( 'class' => 'form-control' ) ) !!}
		</div>
	</div>

	<div class="form-group">
		{!! Form::label( 'track_disc_num', 'Disc no.:', array( 'class' => 'col-sm-2' ) ) !!}
		<div class="col-sm-10">
			{!! Form::text( 'track_disc_num', $track->track_disc_num, array( 'class' => 'form-control' ) ) !!}
		</div>
	</div>

	<div class="form-group">
		{!! Form::label( 'track_track_num', 'Track no.:', array( 'class' => 'col-sm-2' ) ) !!}
		<div class="col-sm-10">
			{!! Form::text( 'track_track_num', $track->track_track_num, array( 'class' => 'form-control' ) ) !!}
		</div>
	</div>

	<div class="form-group">
		{!! Form::label( 'track_song_id', 'Song:', array( 'class' => 'col-sm-2' ) ) !!}
		<div class="col-sm-10">
			{!! Form::select( 'track_song_id', $songs, $track->track_song_id, array( 'class' => 'form-control' ) ) !!}
		</div>
	</div>

	<div class="form-group">
		{!! Form::label( 'track_alias', 'Alias:', array( 'class' => 'col-sm-2' ) ) !!}
		<div class="col-sm-10">
			{!! Form::text( 'track_alias', $track->track_alias, array( 'class' => 'form-control' ) ) !!}
		</div>
	</div>

	<div class="form-group">
		{!! Form::label( 'track_is_visible', 'Visibility:', array( 'class' => 'col-sm-2' ) ) !!}
		<div class="col-sm-10">
			<div class="radio">
				<label>
					{!! Form::radio( 'track_is_visible', 1, ($track->track_is_visible == 1) ) !!} Show
				</label>
			</div>
			<div class="radio">
				<label>
					{!! Form::radio( 'track_is_visible', 0, ($track->track_is_visible == 0) ) !!} Hide
				</label>
			</div>
		</div>
	</div>

	<div class="form-group">
		{!! Form::label( 'track_audio_is_linked', 'Playable:', array( 'class' => 'col-sm-2' ) ) !!}
		<div class="col-sm-10">
			<div class="radio">
				<label>
					{!! Form::radio( 'track_audio_is_linked', 1, ($track->track_audio_is_linked == 1) ) !!} Yes
				</label>
			</div>
			<div class="radio">
				<label>
					{!! Form::radio( 'track_audio_is_linked', 0, ($track->track_audio_is_linked == 0) ) !!} No
				</label>
			</div>
		</div>
	</div>

	<div class="form-group">
		{!! Form::label( 'track_audio_is_downloadable', 'Downloadable:', array( 'class' => 'col-sm-2' ) ) !!}
		<div class="col-sm-10">
			<div class="radio">
				<label>
					{!! Form::radio( 'track_audio_is_downloadable', 1, ($track->track_audio_is_downloadable == 1) ) !!} Yes
				</label>
			</div>
			<div class="radio">
				<label>
					{!! Form::radio( 'track_audio_is_downloadable', 0, ($track->track_audio_is_downloadable == 0) ) !!} No
				</label>
			</div>
		</div>
	</div>

	<div class="form-group">
		{!! Form::label( 'track_recording_id', 'Recording:', array( 'class' => 'col-sm-2' ) ) !!}
		<div class="col-sm-10">
			{!! Form::select( 'track_recording_id', $recordings, $track->track_recording_id, array( 'class' => 'form-control' ) ) !!}
		</div>
	</div>

	<div class="form-group">
		<div class="col-sm-offset-2 col-sm-10">
            <ul class="list-inline">
                <li>{!! Form::submit( 'Save', array( 'class' => 'btn btn-primary' ) ) !!}</li>
                <li>
                    @if (!empty( $track->track_id))
                        <a href="{{ route( 'track.show', array( 'id' => $track->track_id ) ) }}" class="btn btn-default">Cancel</a>
                    @elseif (!empty($track->track_release_id))
                        <a href="{{ route( 'release.show', array( 'id' => $track->track_release_id ) ) }}" class="btn btn-default">Cancel</a>
                    @else
                        <a href="{{ route( 'track.index' ) }}" class="btn btn-default">Cancel</a>
                    @endif
                </li>
            </ul>
		</div>
	</div>

<script type="text/javascript">
	(function ($) {
		$('#track_song_id').chosen();
		$('#track_recording_id').chosen();
		$('#track_release_id').chosen();

		$('#track_song_id').change(function () {
			var alias = $('#track_song_id>option:selected').text().trim().toLowerCase().replace(/\s+/g, '-').replace(/[^a-z0-9\-]+/g, '').replace(/(^-|-$)/, '');
			$('#track_alias').val(alias);
		});
	})(jQuery);
</script>

@stop