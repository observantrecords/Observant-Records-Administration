{include file=obr_global_header.tpl}

<div id="admin-column-1">
		<form action="/index.php/admin/album/{if $album_id}update/{$album_id}{else}create{/if}/{$album_artist_id}/" method="post" name="album">
			<p>
				<input type="submit" value="Save" class="button" />
			</p>

			{if $album_artist_id}<input type="hidden" name="album_artist_id" value="{$album_artist_id}">{/if}

			{if $album_id}<p>
				<label for="album_id">ID:</label>
				{$album_id}<input type="hidden" name="album_id" value="{$album_id}" />
			</p>{/if}

			<p>
				<label for="album_title">Title:</label>
				<input type="text" name="album_title" id="album_title" value="{$rsAlbum->album_title}" size="50" />
			</p>

			<p>
				<label for="album_alias">Alias:</label>
				<input type="text" name="album_alias" id="album_alias" value="{$rsAlbum->album_alias}" size="50" />
			</p>

			<p>
				<label for="album_release_date">Release Date:</label>
				<input type="text" id="album_release_date" name="album_release_date" value="{$rsAlbum->album_release_date|date_format:"%Y-%m-%d"}" size="20" />
			</p>

			{if $album_id}<p>
				<label for="album_primary_release_id">Primary release:</label>
				<select name="album_primary_release_id" id="album_primary_release_id">
					<option value="">&nbsp;</option>
				{foreach item=rsRelease from=$rsAlbum->releases}
					<option value="{$rsRelease->release_id}">{$rsRelease->release_catalog_num}</option>
				{/foreach}
				</select>
			</p>{/if}

			<p>
				<label for="album_alias">Title locale:</label>
				<select name="album_ctype_locale" id="album_ctype_locale">
					<option value="">&nbsp;</option>
					<option value="en"{if $rsAlbum->album_ctype_locale=='en'} selected{/if}>en</option>
					<option value="ja"{if $rsAlbum->album_ctype_locale=='ja'} selected{/if}>ja</option>
				</select>
			</p>

			<p>
				<label for="album_format_mask">Format:</label>
				<select name="album_format_mask" id="album_format_mask">
					<option value="">&nbsp;</option>
				{foreach item=rsFormat from=$rsFormats}
					<option value="{$rsFormat->format_mask}"{if $rsAlbum->album_format_mask==$rsFormat->format_mask} selected{/if}> {$rsFormat->format_alias}</option>
				{/foreach}
				</select>
			</p>

			<p>
				<label for="album_image">Image File:</label>
				<input type="text" name="album_image" value="{$rsAlbum->album_image}" size="50" />
			</p>

			<p>
				<label for="album_music_description">Description:</label>
				<textarea name="album_music_description" cols="40" rows="7">{$rsAlbum->album_music_description|escape:"html"}</textarea>
			</p>

			<p>
				<label for="album_is_visible">Visibility:</label>
				<input type="radio" name="album_is_visible" value="1"{if $rsAlbum->album_is_visible==1} checked{/if} /> Show
				<input type="radio" name="album_is_visible" value="0"{if $rsAlbum->album_is_visible==0} checked{/if} /> Hide
			</p>


			<p>
				<input type="submit" value="Save" class="button" />
			</p>

		</form>

{literal}
<script type="text/javascript">
	$(function () {
		$('#album_primary_release_id').chosen();
		
		// Date pickers.
		$('#album_release_date').datepicker({
			dateFormat: 'yy-mm-dd'
		});

		$('#album_title').keyup(function () {
			var alias = this.value.toLowerCase().replace(/\s+/g, '-').replace(/[^a-z0-9\-]+/g, '').replace(/(^-|-$)/, '');
			$('#album_alias').val(alias);
		});
	});
</script>
{/literal}
</div>

<div id="admin-column-2">
	{if !empty($rsAlbum)}
	<ul>
		<li><a href="/index.php/admin/album/view/{$rsAlbum->album_id}/">Back to <em>{$rsAlbum->album_title}</em></a></li>
		<li><a href="/index.php/admin/artist/view/{$rsAlbum->album_artist_id}/">Back to artist</a></li>
	</ul>
	{/if}
</div>
