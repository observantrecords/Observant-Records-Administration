{include file=obr_global_header.tpl}

	<form action="/index.php/admin/album/remove/{$album_id}/" method="post" id="artist_form" name="artist_form">
		
		<p>You are about to delete the album <em>{$rsAlbum->album_title}</em> from the Observant Records database. <span class="caution">CAUTION:</span> Deletions cannot be undone!</p>
		
		<p>In addition to the album record, you will also be deleting associated records.</p>

		<p><strong>Are you sure you want to proceed?</strong></p>

		<p>
			<input type="submit" id="confirm_yes" name="confirm" value="Yes" class="button" />
			<input type="submit" id="confirm_no" name="confirm" value="No" class="button" />
			<input type="hidden" id="redirect" name="redirect" value="{$smarty.server.HTTP_REFERER}" />
			<input type="hidden" id="album_artist_id" name="album_artist_id" value="{$album_artist_id}" />
		</p>

	</form>


{include file=admin/obr_global_delete.tpl}
