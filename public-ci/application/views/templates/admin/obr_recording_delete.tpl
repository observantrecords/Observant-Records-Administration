{include file=obr_global_header.tpl}

	<form action="/index.php/admin/recording/remove/{$recording_id}/" method="post" id="recording_form" name="recording_form">
		
		<p>You are about to delete a recording of <strong>{$rsRecording->song->song_title}</strong> from the Observant Records database. <span class="caution">CAUTION:</span> Deletions cannot be undone!</p>
		
		<p><strong>Are you sure you want to proceed?</strong></p>

		<p>
			<input type="submit" id="confirm_yes" name="confirm_yes" value="Yes" class="button" />
			<input type="submit" id="confirm_no" name="confirm_no" value="No" class="button" />
			<input type="hidden" id="confirm" name="confirm" value="" />
			<input type="hidden" id="redirect" name="redirect" value="{$smarty.server.HTTP_REFERER}" />
		</p>
		
	</form>

{include file=admin/obr_global_delete.tpl}
