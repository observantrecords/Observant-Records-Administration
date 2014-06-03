<div id="admin-column-1">
{include file=obr_global_header.tpl}

{if !empty($rsSong)}
	<p>
		<a href="/index.php/admin/song/edit/{$song_id}/" class="button"><img src="{$smarty.const.OBSERVANTRECORDS_CDN_BASE_URI}/web/images/icons/edit-page-blue.gif" alt="[Edit]" title="[Edit]" /> Edit</a>
		<a href="/index.php/admin/song/delete/{$song_id}/" class="button"><img src="{$smarty.const.OBSERVANTRECORDS_CDN_BASE_URI}/web/images/icons/delete-page-blue.gif" alt="[Edit]" title="[Edit]" /> Delete</a>
	</p>

	<ul class="two-column-bubble-list">
		<li>
			<div>
				<label>Title</label> {$rsSong->song_title}
			</div>
		</li>
		<li>
			<div>
				<label>Alias</label> {$rsSong->song_alias}
			</div>
		</li>
	{if !empty($rsSong->song_author)}
		<li>
			<div>
				<label>Author</label> {$rsSong->song_author}
			</div>
		</li>
	{/if}
		<li>
			<div>
				<label>Influences</label> {$rsSong->song_influences}
			</div>
		</li>
		<li>
			<div>
				<label>Style</label> {$rsSong->song_style}
			</div>
		</li>
		<li>
			<div>
				<label>Date written</label> {$rsSong->song_written_date}
			</div>
		</li>
		<li>
			<div>
				<label>Date revised</label> {$rsSong->song_revised_date}
			</div>
		</li>
		<li>
			<div>
				<label>Date recorded</label> {$rsSong->song_recorded_date}
			</div>
		</li>
	</ul>
	<h4>Recordings</h4>
	
{if $rsSong->recordings}
	<ol class="track-list">
	{foreach item=rsRecording from=$rsSong->recordings}
		<li>
			<div>
				<a href="/index.php/admin/recording/edit/{$rsRecording->recording_id}/"><img src="{$smarty.const.OBSERVANTRECORDS_CDN_BASE_URI}/web/images/icons/edit-page-purple.gif" alt="[Edit]" title="[Edit]" /></a>
				<a href="/index.php/admin/recording/delete/{$rsRecording->recording_id}/"><img src="{$smarty.const.OBSERVANTRECORDS_CDN_BASE_URI}/web/images/icons/delete-page-purple.gif" alt="[Delete]" title="[Delete]" /></a>
				<a href="/index.php/admin/recording/view/{$rsRecording->recording_id}/">{if empty($rsRecording->recording_isrc_num)}(ISRC TBD){else}{$rsRecording->recording_isrc_num}{/if}</a>
			</div>
		</li>
	{/foreach}
	</ol>
{else}
	<p>No recordings have been made.</p>
{/if}

<h4>Tracks</h4>

{if $rsSong->tracks}
	<ol class="track-list">
	{foreach item=rsTrack from=$rsSong->tracks}
		<li>
			<div>
				<a href="/index.php/admin/track/edit/{$rsTrack->track_id}/"><img src="{$smarty.const.OBSERVANTRECORDS_CDN_BASE_URI}/web/images/icons/edit-page-purple.gif" alt="[Edit]" title="[Edit]" /></a>
				<a href="/index.php/admin/track/delete/{$rsTrack->track_id}/"><img src="{$smarty.const.OBSERVANTRECORDS_CDN_BASE_URI}/web/images/icons/delete-page-purple.gif" alt="[Delete]" title="[Delete]" /></a>
				<em><a href="/index.php/admin/track/view/{$rsTrack->track_id}/">{$rsTrack->release->release_alias}</a></em>
			</div>
		</li>
	{/foreach}
	</ol>
{else}
	<p>No tracks have been created.</p>
{/if}

{if !empty($rsSong->song_lyrics)}
	<h4>Lyrics</h4>
	
	{parse_line_breaks txt=$rsSong->song_lyrics}
{/if}
	
{if !empty($rsSong->song_abstract)}
	<h4>Abstract</h4>
	
	{parse_line_breaks txt=$rsSong->song_abstract}
{/if}
{else}
	<p>This song has no information.</p>
{/if}
</div>

<div id="admin-column-2">
</div>
