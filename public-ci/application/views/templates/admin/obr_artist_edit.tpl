{include file=obr_global_header.tpl}

	<form action="/index.php/admin/artist/{if !empty($artist_id)}update/{$artist_id}{else}create{/if}/" method="post" id="artist_form" name="artist_form">

		<p>
			<input type="submit" value="Save" class="button" />
		</p>

		<p>
			<label for="artist_display_name">Display name</label>
			<input type="text" name="artist_display_name" id="artist_display_name" value="{$rsArtist->artist_display_name}" size="50" />
		</p>

		<p>
			<label for="artist_last_name">Last name</label>
			<input type="text" name="artist_last_name" value="{$rsArtist->artist_last_name}" size="50" />
		</p>

		<p>
			<label for="artist_first_name">First name</label>
			<input type="text" name="artist_first_name" value="{$rsArtist->artist_first_name}" size="50" />
		</p>

		<p>
			<label for="artist_alias">Alias</label>
			<input type="text" name="artist_alias" id="artist_alias" value="{$rsArtist->artist_alias}" size="50" />
		</p>

		<p>
			<label for="artist_url">URL</label>
			<input type="text" name="artist_url" value="{$rsArtist->artist_url}" size="50" />
		</p>

		<p>
			<label for="artist_bio">Bio</label>
			<textarea name="artist_bio">{$rsArtist->artist_bio}</textarea>
		</p>

		<p>
			<label for="artist_bio_more">Bio (additional):</label>
			<textarea name="artist_bio_more">{$rsArtist->artist_bio_more}</textarea>
		</p>

		<p>
			<input type="submit" value="Save" class="button" />
		</p>

	</form>

{literal}
<script type="text/javascript">
	$(function () {
		$('#artist_display_name').keyup(function () {
			var alias = this.value.toLowerCase().replace(/\s+/g, '-').replace(/[^a-z0-9\-]+/g, '').replace(/(^-|-$)/, '');
			$('#artist_alias').val(alias);
		});
	});
</script>
{/literal}