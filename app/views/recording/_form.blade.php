@extends('layout')

@section('content')

<div class="form-group">
	<div class="form-group">
		{{ Form::label('recording_artist_id', 'Artist:', array( 'class' => 'col-sm-2' ) ) }}
		<div class="col-sm-10">
			{{ Form::select( 'recording_artist_id', $artists, $recording->recording_artist_id, array( 'class' => 'form-control' ) ) }}
		</div>
	</div>

	<div class="form-group">
		{{ Form::label('recording_song_id', 'Song:', array( 'class' => 'col-sm-2' ) ) }}
		<div class="col-sm-10">
			{{ Form::select( 'recording_song_id', $songs, $recording->recording_song_id, array( 'class' => 'form-control' ) ) }}
		</div>
	</div>

	<div class="form-group">
		{{ Form::label('recording_song_id', 'ISRC No.:', array( 'class' => 'col-sm-2' ) ) }}
		<div class="col-sm-10">
			@if (!empty($recording->recording_isrc_num))
			{{ $recording->recording_isrc_num }}
			{{ Form::hidden( 'recording_isrc_num', $recording->recording_isrc_num ) }}
			@else
			{{ Form::text( '_display_recording_isrc_num', null, array('disabled' => 'disabled') ) }}
			{{ Form::hidden( 'recording_isrc_num', null, array( 'id' => 'recording_isrc_num' ) ) }}
			{{ Form::hidden( 'recording_isrc_code', null, array( 'id' => 'recording_isrc_code' ) ) }}
			{{ Form::button( 'Generate', array('id' => 'generate_custom_isrc', 'class' => 'button') ) }}
			{{ Form::button( 'Clear', array('id' => 'clear_custom_isrc', 'class' => 'button') ) }}
			@endif
		</div>
	</div>

	<div class="col-sm-offset-2 col-sm-10">
		{{ Form::submit('Save', array('class' => 'button')) }}
	</div>
</div>

<script type="text/javascript">
	(function ($) {
		var Recording_Edit = {
			generate_isrc_code: function () {
				var _token = $('input[name=_token]').val();
				var data = {
					'_token': _token
				}
				$.ajax({
					url: '/recording/generate_isrc/',
					data: data,
					cache: false
				}).done(function (response) {
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
			Recording_Edit.generate_isrc_code();
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