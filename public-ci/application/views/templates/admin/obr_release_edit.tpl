{include file=obr_global_header.tpl}
<div id="admin-column-1">

		<form action="/index.php/admin/release/{if $release_id}update/{$release_id}{else}create/{$album_artist_id}{/if}/" method="post" name="album">
			<p>
				<input type="submit" value="Save" class="button" />
			</p>

			<p>
				<label for="release_alternate_title">ID:</label>
				{if $release_id}{$release_id}<input type="hidden" name="release_id" value="{$release_id}">{else}TBD{/if}
			</p>

			<p>
				<label for="release_album_id">Album</label>
				<select name="release_album_id" id="release_album_id">
					<option value=""> &nbsp;
				{foreach item=rsAlbum from=$rsAlbums}
					<option value="{$rsAlbum->album_id}"{if ($rsRelease->release_album_id==$rsAlbum->album_id) || ($release_album_id==$rsAlbum->album_id)} selected{/if}> {$rsAlbum->album_title}
				{/foreach}
				</select>
			</p>

			<p>
				<label for="release_alternate_title">Alternate Title:</label>
				<input type="text" name="release_alternate_title" value="{$rsRelease->release_alternate_title}" size="40" />
			</p>

			<p>
				<label for="release_alias">Alias:</label>
				<input type="text" name="release_alias" id="release_alias" value="{$rsRelease->release_alias}" size="40" />
			</p>

			<p>
				<label for="release_label">Label:</label>
				<input type="text" name="release_label" value="{$rsRelease->release_label}" size="40" />
			</p>

			<p>
				<label for="release_label">Release Date:</label>
				<input type="text" id="release_release_date" name="release_release_date" value="{$rsRelease->release_release_date|date_format:"%Y-%m-%d"}" size="20" />
			</p>

			<p>
				<label for="release_upc_num">UPC No.:</label>
				<input type="text" name="release_upc_num" value="{$rsRelease->release_upc_num}" size="40" />
			</p>

			<p>
				<label for="release_catalog_num">Catalog No.:</label>
				<input type="text" name="release_catalog_num" value="{$rsRelease->release_catalog_num}" size="20" />
			</p>

			<p>
				<label for="release_format_id">Format:</label>
				<select name="release_format_id" name="release_format_id">
					<option value="0"> &nbsp;
				{foreach item=rsFormat from=$rsFormats}
					<option value="{$rsFormat->format_id}"{if $rsRelease->release_format_id==$rsFormat->format_id} selected{/if}> {$rsFormat->format_name}
				{/foreach}
				</select>
			</p>

			<p>
				<label for="release_image">Image:</label>
				<input type="text" name="release_image" value="{$rsRelease->release_image}" size="40" />
			</p>

			<p>
				<label for="release_is_visible">Visibility:</label>
				<input type="radio" name="release_is_visible" value="1"{if $rsRelease->release_is_visible==1} checked{/if} /> Show
				<input type="radio" name="release_is_visible" value="0"{if $rsRelease->release_is_visible==0} checked{/if} /> Hide
			</p>

			<p>
				<label for="release_credits">Credits:</label>
				<textarea name="release_credits" cols="50" rows="10">{$rsRelease->release_credits|escape:"html"}</textarea>
			</p>

			<p>
				<label for="release_store_description">Ecommerce Description:</label>
				<textarea name="release_store_description" cols="50" rows="10">{$rsRelease->release_store_description|escape:"html"}</textarea>
			</p>

			<p>
				<label for="release_music_description">Description:</label>
				<textarea name="release_music_description" cols="50" rows="10">{$rsRelease->release_music_description|escape:"html"}</textarea>
			</p>

			<p>
				<label for="release_music_description_more">Description (more):</label>
				<textarea name="release_music_description_more" cols="50" rows="10">{$rsRelease->release_music_description_more|escape:"html"}</textarea>
			</p>

			<p>
				<input type="submit" value="Save" class="button" />
			</p>

		</form>

		{literal}
		<script type="text/javascript">
			$(function () {
				$('#release_album_id').chosen();
				$('#release_format_id').chosen();
				
				// Date pickers.
				$('#release_release_date').datepicker({
					dateFormat: 'yy-mm-dd'
				});

				$('#release_album_id').change(function () {
					var alias = $('#release_album_id>option:selected').text().trim().toLowerCase().replace(/\s+/g, '-').replace(/[^a-z0-9\-]+/g, '').replace(/(^-|-$)/, '');
					if (alias != '') {alias += '-digital';}
					$('#release_alias').val(alias);
				});
			});
		</script>
		{/literal}
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
