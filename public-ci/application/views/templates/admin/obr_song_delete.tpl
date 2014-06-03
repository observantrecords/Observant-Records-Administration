{include file=obr_global_header.tpl}

	<form action="/index.php/admin/song/remove/{$song_id}/" method="post" id="song_form" name="song_form">
		
		<p>You are about to delete the song <strong>{$rsSong->song_title}</strong> from the Observant Records database. <span class="caution">CAUTION:</span> Deletions cannot be undone!</p>
		
		<p>In addition to the song record, you will also be deleting associated records.</p>
		
		{if !empty($rsSong->audio)}
		<h3>Audio</h3>
		
		<ul>
		{foreach item=rsAudio from=$rsSong->audio}
			<li><code>{$rsAudio->audio_mp3_file_path}/{$rsAudio->audio_mp3_file_name}</code></li>
		{/foreach}
		</ul>
		{/if}
		
		{if !empty($rsSong->tracks)}
		<h3>Tracks</h3>
		
		<ul>
		{foreach item=rsTrack from=$rsSong->tracks}
			<li><a href="/index.php/admin/track/view/{$rsTrack->track_id}/">{$rsTrack->track_id}</a></li>
		{/foreach}
		</ul>
		{/if}

		<p><strong>Are you sure you want to proceed?</strong></p>

		<p>
			<input type="submit" id="confirm_yes" name="confirm_yes" value="Yes" class="button" />
			<input type="submit" id="confirm_no" name="confirm_no" value="No" class="button" />
			<input type="hidden" id="confirm" name="confirm" value="" />
			<input type="hidden" id="redirect" name="redirect" value="{$smarty.server.HTTP_REFERER}" />
		</p>

	</form>


{include file=admin/obr_global_delete.tpl}
