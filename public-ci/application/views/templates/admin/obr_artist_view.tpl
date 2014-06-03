<div id="admin-column-1">
{include file=obr_global_header.tpl}

	{if !empty($rsArtist)}
	<h3>Artist Info</h3>

	<p>
		<a href="/index.php/admin/artist/edit/{$rsArtist->artist_id}/" class="button"><img src="{$smarty.const.OBSERVANTRECORDS_CDN_BASE_URI}/web/images/icons/edit-page-blue.gif" /> Edit</a>
		<a href="/index.php/admin/artist/delete/{$rsArtist->artist_id}/" class="button"><img src="{$smarty.const.OBSERVANTRECORDS_CDN_BASE_URI}/web/images/icons/delete-page-blue.gif" /> Delete</a>
	</p>

	<ul class="two-column-bubble-list">
		<li>
			<div>
				<label>Last name:</label> {$rsArtist->artist_last_name}
			</div>
		</li>
	{if !empty($rsArtist->artist_first_name)}
		<li>
			<div>
				<label>First name:</label> {$rsArtist->artist_first_name}
			</div>
		</li>
	{/if}
	{if !empty($rsArtist->artist_display_name)}
		<li>
			<div>
				<label>Display name:</label> {$rsArtist->artist_display_name}
			</div>
		</li>
	{/if}
	{if !empty($rsArtist->artist_alias)}
		<li>
			<div>
				<label>Alias:</label> {$rsArtist->artist_alias}
			</div>
		</li>
	{/if}
	{if !empty($rsArtist->artist_url)}
		<li>
			<div>
				<label>URL:</label> <a href="{$rsArtist->artist_url}">{$rsArtist->artist_url}</a>
			</div>
		</li>
	{/if}
	</ul>

	<h3>Albums</h3>

	<form action="/index.php/admin/album/save_order/" method="post" id="save-order-form">
		<p>
			<a href="/index.php/admin/album/add/{$artist_id}/" class="button"><img src="{$smarty.const.OBSERVANTRECORDS_CDN_BASE_URI}/web/images/icons/add-page-blue.gif" /> Add album</a>
			<input type="button" value="Save album order" id="save-order" class="button" />
			<input type="hidden" name="album_id" value="" />
		</p>
	</form>

	{if $rsAlbums}
		<ol class="track-list">
		{foreach item=rsAlbum from=$rsAlbums}
			<li>
				<div>
					<a href="/index.php/admin/album/edit/{$rsAlbum->album_id}/"><img src="{$smarty.const.OBSERVANTRECORDS_CDN_BASE_URI}/web/images/icons/edit-page-blue.gif" alt="[Edit]" title="[Edit]" /></a>
					<a href="/index.php/admin/album/delete/{$rsAlbum->album_id}/"><img src="{$smarty.const.OBSERVANTRECORDS_CDN_BASE_URI}/web/images/icons/delete-page-blue.gif" alt="[Delete]" title="[Delete]" /></a>
					<span class="album-order-display">{$rsAlbum->album_order}</span>. <a href="/index.php/admin/album/view/{$rsAlbum->album_id}/">{$rsAlbum->album_title}</a>
					<input type="hidden" name="album_id" value="{$rsAlbum->album_id}" />
					<input type="hidden" name="album_order" value="{$rsAlbum->album_order}" />
				</div>
			</li>
		{/foreach}
		</ol>
	{else}
	<p>
		This artist has no albums. Please add one.
	</p>
	{/if}

	<h3>Catalogs</h3>

	<ul>
		<li><a href="/index.php/admin/song/browse/{$artist_id}/">Songs</a></li>
		<li><a href="/index.php/admin/recording/browse/{$artist_id}/">Recordings</a></li>
	</ul>

	<div id="save-order-dialog">
		<p class="msg"></p>
	</div>
	{literal}
	<script type="text/javascript">
	$('.track-list').sortable({
		update: function (event, ui) {
			var new_album_order = 1;
			$(this).children().each(function () {
				$(this).find('.album-order-display').html(new_album_order);
				new_album_order++;
			});
		}
	});
	$('#save-order-dialog').dialog({
		autoOpen: false,
		modal: true,
		buttons: {
			"OK": function () {
				$(this).dialog('close');
			}
		}
	});
	$('#save-order').click(function () {
		var albums = [], album_order, album_id, album_info;
		$('.track-list').children().each(function () {
			album_order = $(this).find('.album-order-display').html();
			album_id = $(this).find('input[name=album_id]').val();
			album_info = {
				'album_id': album_id,
				'album_order': album_order
			}
			albums.push(album_info);
		});
		var url = $('#save-order-form').attr('action');
		var data = {
			'albums': albums
		};
		$.post(url, data, function (result) {
			$('#save-order-dialog').dialog('open');
			$('#save-order-dialog').find('.msg').html(result);
		}).error(function (result) {
			var error_msg = 'Your request could not be completed. The following error was given: ' + result.statusText;
			$('#save-order-dialog').dialog('open');
			$('#save-order-dialog').find('.msg').html(error_msg);
		});
	});
	</script>
	{/literal}
	{else}
		<p>Artist information is not available.</p>
	{/if}
</div>

<div id="admin-column-2">
</div>
