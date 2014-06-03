<div id="admin-column-1">
{include file=obr_global_header.tpl}

{if !empty($rsRecording)}
	<p>
		<a href="/index.php/admin/recording/edit/{$recording_id}/" class="button"><img src="{$smarty.const.OBSERVANTRECORDS_CDN_BASE_URI}/web/images/icons/edit-page-blue.gif" alt="[Edit]" title="[Edit]" /> Edit</a>
		<a href="/index.php/admin/recording/delete/{$recording_id}/" class="button"><img src="{$smarty.const.OBSERVANTRECORDS_CDN_BASE_URI}/web/images/icons/edit-page-blue.gif" alt="[Delete]" title="[Delete]" /> Delete</a>
	</p>

	<ul class="two-column-bubble-list">
		<li>
			<div>
				<label>Song</label> {$rsRecording->song->song_title}
			</div>
		</li>
		<li>
			<div>
				<label>ISRC</label> {if empty($rsRecording->recording_isrc_num)}Not set{else}{$rsRecording->recording_isrc_num}{/if}
			</div>
		</li>
	</ul>
	
	<h3>Audio files</h3>
	
	<p>
		<a href="/index.php/admin/audio/add/{$recording_id}/" class="button"><img src="{$smarty.const.OBSERVANTRECORDS_CDN_BASE_URI}/web/images/icons/add-page-blue.gif" alt="[Add audio file]" title="[Add audio file]" /> Add an audio file</a>
	</p>
	
{if $rsRecording->audio}
	<ol class="track-list">
	{foreach item=rsAudio from=$rsRecording->audio}
		<li>
			<div>
				<a href="/index.php/admin/audio/edit/{$rsAudio->audio_id}/"><img src="{$smarty.const.OBSERVANTRECORDS_CDN_BASE_URI}/web/images/icons/edit-page-purple.gif" alt="[Edit]" title="[Edit]" /></a>
				<a href="/index.php/admin/audio/delete/{$rsAudio->audio_id}/"><img src="{$smarty.const.OBSERVANTRECORDS_CDN_BASE_URI}/web/images/icons/delete-page-purple.gif" alt="[Delete]" title="[Delete]" /></a>
				<a href="/index.php/admin/audio/view/{$rsAudio->audio_id}/" title="{$rsAudio->audio_file_server}{$rsAudio->audio_file_path}/{$rsAudio->audio_file_name}">{$rsAudio->audio_file_name}</a>
			</div>
		</li>
	{/foreach}
	</ol>
{else}
{/if}
	
{else}
	<p>This recording has no information.</p>
{/if}

</div>

<div id="admin-column-2">
</div>
