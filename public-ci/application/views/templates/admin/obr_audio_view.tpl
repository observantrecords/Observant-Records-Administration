<div id="admin-column-1">
{include file=obr_global_header.tpl}

	{if !empty($rsFile)}
	<p>
		<a href="/index.php/admin/audio/edit/{$audio_id}/" class="button"><img src="{$smarty.const.OBSERVANTRECORDS_CDN_BASE_URI}/web/images/icons/edit-page-blue.gif" alt="[Edit]" title="[Edit]" /> Edit</a>
		<a href="/index.php/admin/audio/duplicate/{$audio_id}/" class="button"><img src="{$smarty.const.OBSERVANTRECORDS_CDN_BASE_URI}/web/images/icons/add-page-blue.gif" alt="[Duplicate]" title="[Duplicate]" /> Duplicate</a>
		<a href="/index.php/admin/audio/delete/{$audio_id}/" class="button"><img src="{$smarty.const.OBSERVANTRECORDS_CDN_BASE_URI}/web/images/icons/edit-page-blue.gif" alt="[Delete]" title="[Delete]" /> Delete</a>
	</p>

	<ul class="two-column-bubble-list">
		<li>
			<div>
				<label>File server</label> <span title="{$rsFile->audio_file_server}">{$rsFile->audio_file_server|truncate:'50'}</span>
			</div>
		</li>
		<li>
			<div>
				<label>File path</label> {$rsFile->audio_file_path}
			</div>
		</li>
		<li>
			<div>
				<label>File name</label> <span title="{$rsFile->audio_file_name}">{$rsFile->audio_file_name|truncate:'50'}</span>
			</div>
		</li>
		<li>
			<div>
				<label>Display label</label> {$rsFile->audio_display_label}
			</div>
		</li>
		<li>
			<div>
				<label>File type</label> {$rsFile->audio_file_type}
			</div>
		</li>
		<li>
			<div>
				<label>Recording</label> <a href="/index.php/admin/recording/view/{$rsFile->recording->recording_id}/">{if empty($rsFile->recording->recording_isrc_num)}ISRC TBD{else}{$rsFile->recording->recording_isrc_num}{/if}</a>
			</div>
		</li>
	</ul>

	{if !empty($id3v2)}
	<h4>ID3v2 Tags</h4>

	<ul class="two-column-bubble-list">
		<li>
			<div>
				<label>Title</label> {$id3v2.title.0}
			</div>
		</li>
		<li>
			<div>
				<label>Artist</label> {$id3v2.artist.0}
			</div>
		</li>
		<li>
			<div>
				<label>Album</label> {$id3v2.album.0}
			</div>
		</li>
		<li>
			<div>
				<label>Track no.</label> {$id3v2.track_number.0}
			</div>
		</li>
		<li>
			<div>
				<label>Year</label> {$id3v2.year.0}
			</div>
		</li>
		<li>
			<div>
				<label>Copyright</label> {$id3v2.copyright_message.0}
			</div>
		</li>
	</ul>
	{/if}

	{if !empty($id3v1)}
	<h4>ID3v1 Tags</h4>

	<ul class="two-column-bubble-list">
		<li>
			<div>
				<label>Title</label> {$id3v1.title.0}
			</div>
		</li>
		<li>
			<div>
				<label>Artist</label> {$id3v1.artist.0}
			</div>
		</li>
		<li>
			<div>
				<label>Album</label> {$id3v1.album.0}
			</div>
		</li>
		<li>
			<div>
				<label>Track no.</label> {$id3v1.track_number.0}
			</div>
		</li>
		<li>
			<div>
				<label>Year</label> {$id3v1.year.0}
			</div>
		</li>
	</ul>
	{/if}

	{else}
		<p>This audio file has no information.</p>
	{/if}
</div>

<div id="admin-column-2">
{if !empty($rsFile->audio_file_name) && !empty($rsFile->audio_file_path) && !empty($rsFile->audio_file_server)}	
	<h3>Listen</h3>
	
	<p>
		<audio controls>
			<source src="http://{$rsFile->audio_file_server}{$rsFile->audio_file_path}/{$rsFile->audio_file_name}" type="{$rsFile->audio_file_type}" />
		</audio>
	</p>
{/if}
</div>
