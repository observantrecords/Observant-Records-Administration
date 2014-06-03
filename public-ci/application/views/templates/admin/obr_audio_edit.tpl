{include file=obr_global_header.tpl}

<form action="/index.php/admin/audio/{if $audio_id}update/{$audio_id}{else}create{/if}/" method="post" enctype="multipart/form-data">
			<p>
				<label for="audio_file_type">File Type:</label>
				<select name="audio_file_type" id="audio_file_type">
					<option value="audio/mpeg"{if $rsFile->audio_file_type=="audio/mpeg"} selected="selected"{/if}>mp3</option>
					<option value="audio/ogg"{if $rsFile->audio_file_type=="audio/ogg"} selected="selected"{/if}>ogg</option>
				</select>
			</p>
			
			<p>
				<label for="audio_recording_id">Recording:</label>
				<select name="audio_recording_id" id="audio_recording_id">
					<option value="0"> &nbsp;</option>
				{foreach item=rsRecording from=$rsRecordings}
					<option value="{$rsRecording->recording_id}"{if $recording_id==$rsRecording->recording_id} selected{/if}>{if empty($rsRecording->recording_isrc_num)}ISRC TBD{else}{$rsRecording->recording_isrc_num}{/if}: {$rsRecording->song->song_title}</option>
				{/foreach}
				</select>
			</p>
			
			<p>
				<label for="audio_display_label">Display Label:</label>
				<input type="text" name="audio_display_label" id="audio_display_label" value="{$rsFile->audio_display_label}" size="60" />
			</p>
			
			<p>
				<label for="audio_file_server">File server:</label>
				<select id="audio_file_server" name="audio_file_server">
					<option value="">&nbsp;</option>
					<option value="cdn.observantrecords.com"{if $rsFile->audio_file_server=="cdn.observantrecords.com"} selected="selected"{/if}>cdn.observantrecords.com</option>
					<option value="observantrecords.s3.amazonaws.com"{if $rsFile->audio_file_server=="observantrecords.s3.amazonaws.com"} selected="selected"{/if}>observantrecords.s3.amazonaws.com</option>
					<option value="www.observantrecords.com"{if $rsFile->audio_file_server=="www.observantrecords.com"} selected="selected"{/if}>www.observantrecords.com</option>
				</select>
			</p>
			
			<p>
				<label for="audio_file_path">File Path:</label>
				<input type="text" name="audio_file_path" id="audio_file_path" value="{$rsFile->audio_file_path}" size="60" />
			</p>
			
			<p>
				<label for="audio_file_name">File Name:</label>
				<input type="text" name="audio_file_name" id="audio_file_name" value="{$rsFile->audio_file_name}" size="60" />
			</p>
			
			<p>
				<input type="submit" value="Save" class="button" />
				<input type="hidden" id="audio_id" name="audio_id" value="{$audio_id}" />
				<input type="hidden" id="original_audio_id" name="original_audio_id" value="{$original_audio_id}" />
			</p>
			
		{if !empty($rsFile->audio_file_server) && !empty($rsFile->audio_file_name) && !empty($rsFile->audio_file_path)}
			<h4>Listen</h4>
			
			<p>
				<audio id="file_preview" controls>
					<source src="http://{$rsFile->audio_file_server}{$rsFile->audio_file_path}/{$rsFile->audio_file_name}" type="{$rsFile->audio_file_type}" />
				</audio>
			</p>
		{/if}
		</form>

		<script type="text/javascript">
			var artist_alias = '{$artist_alias}';
			var recordings = {$recordings};
			var s3_directories = {$s3_directories};
		</script>
		{literal}
		<script type="text/javascript">
			var Audio_Edit = {
				build_file_name: function (recording_id)
				{
					var recording;
					$.each(recordings, function () {
						if (recording_id == this.recording_id) {
							recording = this;
							return false;
						}
					});
					if (typeof recording == 'object') {
						var artist_name = recording.artist;
						var file_ext = $('#audio_file_type option:selected').text();
						var file_name = artist_name + ' - ' + recording.song_title + '.' + file_ext;
						file_name = file_name.replace(/[\'\(\)]/g, '');
						file_name = file_name.replace(/ /g, '_');
						

						$('#audio_file_name').val(file_name);
						$('#audio_display_label').val(recording.song_title);
					}
					else {
						$('#audio_file_name').val('');
						$('#audio_display_label').val('');
					}
				}
			};
				
			$(function () {
				$('#audio_file_type').chosen({
					width: '75px'
				});
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
				
		</script>
		{/literal}
