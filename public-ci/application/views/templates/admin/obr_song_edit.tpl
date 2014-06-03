{include file=obr_global_header.tpl}

<form action="/index.php/admin/song/{if $song_id}update/{$song_id}{else}create{/if}/" method="post">
	<input type="hidden" name="song_primary_artist_id" value="{$artist_id}" />

	<p>
		<input type="submit" value="Save" class="button" />
{if $song_id}
		<a href="/index.php/admin/song/save_lyrics/{$song_id}/" class="button"><img src="{$smarty.const.OBSERVANTRECORDS_CDN_BASE_URI}/web/images/icons/download-page-blue.gif" alt="[SAVE]" /> Save lyrics as text</a>
{/if}
	</p>

	<p>
		<label for="song_title">Song title:</label>
		<input type="text" name="song_title" id="song_title" value="{$rsSong->song_title|escape}" size="50">
	</p>

	<p>
		<label for="song_alias">Alias:</label>
		<input type="text" name="song_alias" id="song_alias" value="{$rsSong->song_alias|escape}" size="50">
	</p>

	<p>
		<label for="song_author">Author:</label>
		<input type="text" name="song_author" id="song_author" value="{$rsSong->song_author|escape}" size="50">
	</p>

	<p>
		<label for="song_influences">Influences:</label>
		<input type="text" name="song_influences" value="{$rsSong->song_influences}" size="50">
	</p>

	<p>
		<label for="song_style">Style:</label>
		<input type="text" name="song_style" value="{$rsSong->song_style}" size="50">
	</p>

	<p>
		<label for="song_written_date">Date written:</label>
		<input type="text" name="song_written_date" value="{$rsSong->song_written_date}" size="50" />
	</p>

	<p>
		<label for="song_revised_date">Date revised:</label>
		<input type="text" name="song_revised_date" value="{$rsSong->song_revised_date}" size="50" />
	</p>

	<p>
		<label for="song_recorded_date">Date recorded:</label>
		<input type="text" name="song_recorded_date" value="{$rsSong->song_recorded_date}" size="50" />
	</p>

	<p>
		<label for="song_lyrics">Lyrics:</label>
		<textarea name="song_lyrics" rows="10" cols="50">{$rsSong->song_lyrics|escape}</textarea>
	</p>

	<p>
		<label for="song_abstract">Abstract:</label>
		<textarea name="song_abstract" rows="10" cols="50">{$rsSong->song_abstract|escape}</textarea>
	</p>

	<p>
		<input type="submit" value="Save" class="button" />
{if $song_id}
		<a href="/index.php/admin/song/save_lyrics/{$song_id}/" class="button"><img src="{$smarty.const.OBSERVANTRECORDS_CDN_BASE_URI}/web/images/icons/download-page-blue.gif" alt="[SAVE]" /> Save lyrics as text</a>
{/if}
	</p>

</form>

{literal}
<script type="text/javascript">
	$(function () {
		$('#song_title').keyup(function () {
			var alias = this.value.toLowerCase().replace(/\s+/g, '-').replace(/[^a-z0-9\-]+/g, '').replace(/(^-|-$)/, '');
			$('#song_alias').val(alias);
		});
	});
</script>
{/literal}