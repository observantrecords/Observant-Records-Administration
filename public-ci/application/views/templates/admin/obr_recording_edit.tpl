{include file=obr_global_header.tpl}

		<form action="/index.php/admin/recording/{if $recording_id}update/{$recording_id}{else}create{/if}/" method="post">
			<p>
				<label for="recording_artist_id">Artist:</label>
				<select name="recording_artist_id" id="recording_artist_id">
					<option value="0"> &nbsp;</option>
				{foreach item=rsArtist from=$rsArtists}
					<option value="{$rsArtist->artist_id}"{if $recording_artist_id==$rsArtist->artist_id} selected{/if}>{$rsArtist->artist_display_name}</option>
				{/foreach}
				</select>
			</p>
			
			<p>
				<label for="recording_song_id">Song:</label>
				<select name="recording_song_id" id="recording_song_id">
					<option value="0"> &nbsp;</option>
				{foreach item=rsSong from=$rsSongs}
					<option value="{$rsSong->song_id}"{if $rsSong->song_id==$rsRecording->recording_song_id} selected{/if}>{$rsSong->song_title}</option>
				{/foreach}
				</select>
			</p>
			
			<p>
				<label for="recording_isrc_num">ISRC No.:</label>
			{if !empty($rsRecording->recording_isrc_num)}
				{$rsRecording->recording_isrc_num}
			{else}
				<input type="text" name="_display_recording_isrc_num" id="_display_recording_isrc_num" value="" size="60" disabled="disabled" />
				<input type="hidden" name="recording_isrc_num" id="recording_isrc_num" value="" />
				<input type="hidden" name="recording_isrc_code" id="recording_isrc_code" value="" />
				<a id="generate_custom_isrc" class="button">Generate</a>
				<a id="clear_custom_isrc" class="button">Clear</a>
			{/if}
			</p>
			
			<p>
				<input type="submit" value="Save" class="button" />
			</p>
		</form>
		
		{literal}
		<script type="text/javascript">
			var Recording_Edit = {
				generate_isrc_code: function () {
					$.ajax({
						url: '/index.php/admin/recording/generate_isrc/',
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
			
		</script>
		{/literal}
