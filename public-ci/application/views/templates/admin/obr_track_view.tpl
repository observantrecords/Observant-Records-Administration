<div id="admin-column-1">
{include file=obr_global_header.tpl}

	{if !empty($rsTrack)}
	<p>
		<a href="/index.php/admin/track/edit/{$track_id}/" class="button"><img src="{$smarty.const.OBSERVANTRECORDS_CDN_BASE_URI}/web/images/icons/edit-page-blue.gif" alt="[Edit]" title="[Edit]" /> Edit</a>
		<a href="/index.php/admin/track/delete/{$track_id}/" class="button"><img src="{$smarty.const.OBSERVANTRECORDS_CDN_BASE_URI}/web/images/icons/delete-page-blue.gif" alt="[Delete]" title="[Delete]" /> Delete</a>
	</p>

	<ul class="two-column-bubble-list">
		<li>
			<div>
				<label>Title</label> {$rsTrack->song->song_title}
			</div>
		</li>
		<li>
			<div>
				<label>Disc no.</label> {$rsTrack->track_disc_num}
			</div>
		</li>
		<li>
			<div>
				<label>Track no.</label> {$rsTrack->track_track_num}
			</div>
		</li>
		{if $rsTrack->track_alias}
		<li>
			<div>
				<label>Alias</label> {$rsTrack->track_alias}
			</div>
		</li>
		{/if}
		<li>
			<div>
				<label>Visible?</label> <input type="checkbox" disabled="disabled" value="1"{if ($rsTrack->track_is_visible == true)} checked{/if} />
			</div>
		</li>
		<li>
			<div>
				<label>Playable?</label> <input type="checkbox" disabled="disabled" value="1"{if ($rsTrack->track_audio_is_linked == true)} checked{/if} />
			</div>
		</li>
		<li>
			<div>
				<label>Downloadable?</label> <input type="checkbox" disabled="disabled" value="1"{if ($rsTrack->track_audio_is_downloadable == true)} checked{/if} />
			</div>
		</li>
		<li>
			<div>
				<label>Recording</label> 
				{if $rsTrack->recording}
				<a href="/index.php/admin/recording/view/{$rsTrack->recording->recording_id}/">{if empty($rsTrack->recording->recording_isrc_num)}(No ISRC number set) {$rsTrack->song->song_title}{else}{$rsTrack->recording->recording_isrc_num}{/if}</a>
				{else}
				Not set.
				{/if}
			</div>
		</li>
		{if $rsTrack->track_uplaya_score}
		<li>
			<div>
				<label>uPlaya score</label> {$rsTrack->track_uplaya_score}
			</div>
		</li>
		{/if}
	</ul>
	
	{else}
	<p>This song has no information.</p>
	{/if}
</div>

<div id="admin-column-2">
	{if !empty($rsRelease)}
	<p>
		<img src="{$smarty.const.OBSERVANTRECORDS_CDN_BASE_URI}/artists/{$rsArtist->artist_alias}/albums/{$rsRelease->album->album_alias}/{$rsRelease->release_catalog_num|lower}/images/cover_front_medium.jpg" width="230" />
	</p>
	
	<ul>
		<li><a href="/index.php/admin/release/view/{$rsRelease->release_id}/">Back to <em>{$rsRelease->album->album_title}</em></a></li>
	</ul>
	{/if}
</div>
