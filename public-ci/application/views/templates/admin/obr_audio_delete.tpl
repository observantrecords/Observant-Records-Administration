{include file=obr_global_header.tpl}

	<form action="/index.php/admin/audio/remove/{$audio_id}/" method="post" id="audio_form" name="audio_form">
		
		<p>You are about to delete the audio file <strong>{$rsAudio->audio_mp3_file_path}/{$rsAudio->audio_mp3_file_name}</strong> from the Observant Records database. <span class="caution">CAUTION:</span> Deletions cannot be undone!</p>
		
		<p><strong>Are you sure you want to proceed?</strong></p>

	{if $display_remove_file}
		<p>
			<input type="checkbox" name="remove_file" value="1" /> Remove file from server as well.
		</p>
	{/if}

		<p>
			<input type="submit" id="confirm_yes" name="confirm_yes" value="Yes" class="button" />
			<input type="submit" id="confirm_no" name="confirm_no" value="No" class="button" />
			<input type="hidden" id="confirm" name="confirm" value="" />
			<input type="hidden" id="redirect" name="redirect" value="{$smarty.server.HTTP_REFERER}" />
		</p>
		
	</form>

{include file=admin/obr_global_delete.tpl}
