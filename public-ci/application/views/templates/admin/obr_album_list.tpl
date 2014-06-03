{include file=obr_global_header.tpl}

	<p>
		<a href="/index.php/admin/album/add/{$artist_id}/" class="button"><img src="{$smarty.const.OBSERVANTRECORDS_CDN_BASE_URI}/web/images/icons/add-page-blue.gif" /> Add album</a>
	</p>

	{if $rsAlbums}
		<ul class="album-list">
		{foreach item=rsAlbum from=$rsAlbums}
			<li>
				<a href="/index.php/admin/album/view/{$rsAlbum->album_id}/" alt="[{$rsAlbum->album_title}]" title="{$rsAlbum->album_title}"><img src="/images/_covers/_exm_front_120_{$rsAlbum->album_image}" /></a>
			</li>
		{/foreach}
		</ul>
	{else}
	<p>
		This artist has no albums. Please add one.
	</p>
	{/if}

