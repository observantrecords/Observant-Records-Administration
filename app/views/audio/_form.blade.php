@extends('layout')

@section('content')

<div class="form-group">
	{{ Form::label( 'audio_file_type', 'File Type:', array( 'class' => 'col-sm-2' ) ) }}
	<div class="col-sm-10">
		{{ Form::select( 'audio_file_type', array( 'audio/mpeg' => 'mp3', 'audio/ogg' => 'ogg' ), $audio->audio_file_type, array( 'class' => 'form-control', 'id' => 'audio_file_type' ) ) }}
	</div>
</div>

<div class="form-group">
	{{ Form::label( 'audio_recording_id', 'Recording:', array( 'class' => 'col-sm-2' ) ) }}
	<div class="col-sm-10">
		{{ Form::select( 'audio_recording_id', $recordings, $audio->audio_recording_id, array( 'class' => 'form-control', 'id' => 'audio_recording_id' ) ) }}
	</div>
</div>

<div class="form-group">
	{{ Form::label( 'audio_display_label', 'Display label:', array( 'class' => 'col-sm-2' ) ) }}
	<div class="col-sm-10">
		{{ Form::text( 'audio_display_label', $audio->audio_display_label, array( 'class' => 'form-control', 'id' => 'audio_display_label' ) ) }}
	</div>
</div>

<div class="form-group">
	{{ Form::label( 'audio_file_server', 'File server:', array( 'class' => 'col-sm-2' ) ) }}
	<div class="col-sm-10">
		{{ Form::select( 'audio_file_server', array( 'cdn.observantrecords.com' => 'cdn.observantrecords.com', 'observantrecords.s3.amazonaws.com' => 'observantrecords.s3.amazonaws.com', 'www.observantrecords.com' => 'www.observantrecords.com' ), $audio->audio_file_server, array( 'class' => 'form-control', 'id' => 'audio_file_server' ) ) }}
	</div>
</div>

<div class="form-group">
	{{ Form::label( 'audio_file_path', 'File path:', array( 'class' => 'col-sm-2' ) ) }}
	<div class="col-sm-10">
		{{ Form::text( 'audio_file_path', $audio->audio_file_path, array( 'class' => 'form-control', 'id' => 'audio_file_path' ) ) }}
	</div>
</div>

<div class="form-group">
	{{ Form::label( 'audio_file_name', 'File name:', array( 'class' => 'col-sm-2' ) ) }}
	<div class="col-sm-10">
		{{ Form::text( 'audio_file_name', $audio->audio_file_name, array( 'class' => 'form-control', 'id' => 'audio_file_name' ) ) }}
	</div>
</div>

<div class="form-group">
	<div class="col-sm-offset-2 col-sm-10">
		{{ Form::submit('Save', array( 'class' => 'button' ) ) }}
		{{ Form::hidden( 'audio_id', $audio->audio_id, array( 'id' => 'audio_id' ) ) }}
		{{ Form::hidden( 'original_audio_id', $original_audio_id, array( 'id' => 'original_audio_id' ) ) }}
	</div>
</div>

<script type="text/javascript">
	(function ($) {
	@if (!empty($audio->recording->artist->artist_alias))
		var artist_alias = '{{ $audio->recording->artist->artist_alias }}';
	@endif

	@if (!empty($recordings_json))
			var recordings = {{ $recordings_json }};
	@endif

	@if (!empty($s3_directories))
		var s3_directories = {{ $s3_directories }};
	@endif

		var Audio_Edit = {
			build_file_name: function (recording_id)
			{
				var recording;
				$.each(recordings, function () {
					if (recording_id == Number(this.recording_id)) {
						recording = this;
						return false;
					}
				});
				if (typeof recording == 'object') {
					var artist_name = recording.artist.artist_display_name;
					var file_ext = $('#audio_file_type option:selected').text();
					var file_name = artist_name + ' - ' + recording.song.song_title + '.' + file_ext;
					file_name = file_name.replace(/[\'\(\)]/g, '');
					file_name = file_name.replace(/ /g, '_');


					$('#audio_file_name').val(file_name);
					$('#audio_display_label').val(recording.song.song_title);
				}
				else {
					$('#audio_file_name').val('');
					$('#audio_display_label').val('');
				}
			}
		};

		$(function () {
			$('#audio_file_type').chosen();
			$('#audio_file_server').chosen();
			$('#audio_recording_id').chosen();

			var enable_path_autocomplete = ($('#audio_file_server').val() == 'cdn.observantrecords.com' || $('#audio_file_server').val() == 'observantrecords.s3.amazonaws.com') ? false : true;
			$('#audio_file_path').autocomplete({
				source: s3_directories,
				disabled: enable_path_autocomplete
			});

			// Prepopulate some field based on how we initialize the recording ID for a new audio file.
			if ($('#audio_recording_id').val() > 0 && ($('#audio_id').val() == '' && $('#original_audio_id').val() == '')) {
				Audio_Edit.build_file_name($('#audio_recording_id').val());
			}

			$('#audio_file_server').change(function () {
				if ($('#audio_file_path').val() == '') {
					if (this.value == 'cdn.observantrecords.com' || this.value == 'observantrecords.s3.amazonaws.com') {
						$('#audio_file_path').autocomplete('enable');
					} else if (this.value == 'www.observantrecords.com') {
						$('#audio_file_path').autocomplete('disable');
						$('#audio_file_path').val('/music/audio/_mp3/_ex_machina');
					} else {
						$('#audio_file_path').autocomplete('disable');
					}
				}
			});
			$('#audio_file_type').change(function () {
				var matches = String($('#audio_file_name').val()).split(/\.(.+)$/);
				var file_name_base = matches[0];
				var file_name_extension = $('#audio_file_type :selected').html();
				var file_name = file_name_base + '.' + file_name_extension;
				$('#audio_file_name').val(file_name);
			});
			$('#audio_recording_id').change(function () {
				Audio_Edit.build_file_name(this.value);
			});
		});
	})(jQuery);
</script>

@stop