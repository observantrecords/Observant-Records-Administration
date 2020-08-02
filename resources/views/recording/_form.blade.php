@extends('layout')

@section('content')

<div class="form-group">
	<div class="form-group">
		{!! Form::label('recording_artist_id', 'Artist:', array( 'class' => 'col-sm-2' ) ) !!}
		<div class="col-sm-10">
			{!! Form::select( 'recording_artist_id', $artists, $recording->recording_artist_id, array( 'class' => 'form-control' ) ) !!}
		</div>
	</div>

	<div class="form-group">
		{!! Form::label('recording_song_id', 'Song:', array( 'class' => 'col-sm-2' ) ) !!}
		<div class="col-sm-10">
			{!! Form::select( 'recording_song_id', $songs, $recording->recording_song_id, array( 'class' => 'form-control' ) ) !!}
		</div>
	</div>

	<div class="form-group">
		{!! Form::label('recording_song_id', 'ISRC No.:', array( 'class' => 'col-sm-2' ) ) !!}
		<div class="col-sm-10">
			@if (!empty($recording->recording_isrc_num))
			{{ $recording->recording_isrc_num }}
			{!! Form::hidden( 'recording_isrc_num', $recording->recording_isrc_num, array( 'id' => 'recording_isrc_num' ) ) !!}
			@else
			{!! Form::text( '_display_recording_isrc_num', null, array('disabled' => 'disabled', 'id' => '_display_recording_isrc_num') ) !!}
			{!! Form::hidden( 'recording_isrc_num', null, array( 'id' => 'recording_isrc_num' ) ) !!}
			{!! Form::hidden( 'recording_isrc_code', null, array( 'id' => 'recording_isrc_code' ) ) !!}
			{!! Form::button( 'Generate', array('id' => 'generate_custom_isrc', 'class' => 'btn btn-default') ) !!}
			{!! Form::button( 'Clear', array('id' => 'clear_custom_isrc', 'class' => 'btn btn-default') ) !!}
			@endif
		</div>
	</div>

	<div class="col-sm-offset-2 col-sm-10">
        <ul class="list-inline">
            <li>{!! Form::submit( 'Save', array( 'class' => 'btn btn-primary' ) ) !!}</li>
            <li>
                @if (!empty( $recording->recording_id))
                    <a href="{{ route( 'recording.show', $recording->recording_id ) }}" class="btn btn-default">Cancel</a>
                @elseif (!empty($recording->recording_artist_id))
                    <a href="{{ route( 'artist.show', $recording->recording_artist_id ) }}" class="btn btn-default">Cancel</a>
                @else
                    <a href="{{ route( 'recording.index' ) }}" class="btn btn-default">Cancel</a>
                @endif
            </li>
        </ul>
	</div>
</div>

<script type="text/javascript">
	(function ($) {
		var Recording_Edit = {
			generate_catalog_num: function () {
				var _token = $('input[name=_token]').val();
				var data = {
					'_token': _token
				}
				var url = '/recording/generate-isrc';
				$.post(url, data, function (response) {
					var result = $.parseJSON(response);
					$('#recording_isrc_code').val(result.isrc_code);
					$('#recording_isrc_num').val(result.isrc_code);
					$('#_display_recording_isrc_num').val(result.isrc_code);
				}).error(function (xmlreq, status, error_text) {
					alert(error_text);
				});
			}
		};
		$('#generate_custom_isrc').click(function () {
			Recording_Edit.generate_catalog_num();
		});
		$('#recording_artist_id').chosen();
		$('#recording_song_id').chosen();

		$('#clear_custom_isrc').click(function () {
			$('#_display_recording_isrc_num').val('');
			$('#recording_isrc_num').val('');
			$('#recording_isrc_code').val('');
		});

		$('#_display_recording_isrc_num').blur(function () {
			$('#_display_recording_isrc_num').attr('disabled', 'disabled');
			$('#recording_isrc_num').val($('#_display_recording_isrc_num').val());
		});
	})(jQuery);
</script>

@stop