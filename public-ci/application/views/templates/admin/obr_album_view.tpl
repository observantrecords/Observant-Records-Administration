{include file=obr_global_header.tpl}

<div id="admin-column-1">
	{if !empty($rsAlbum)}
	<p>
		<a href="/index.php/admin/album/edit/{$album_id}/" class="button"><img src="{$smarty.const.OBSERVANTRECORDS_CDN_BASE_URI}/web/images/icons/edit-page-blue.gif" alt="[Edit]" title="[Edit]" /> Edit</a>
		<a href="/index.php/admin/album/delete/{$album_id}/" class="button"><img src="{$smarty.const.OBSERVANTRECORDS_CDN_BASE_URI}/web/images/icons/edit-page-blue.gif" alt="[Delete]" title="[Delete]" /> Delete</a>
	</p>

	<ul class="two-column-bubble-list">
		<li>
			<div>
				<label>Title</label> {$rsAlbum->album_title}
			</div>
		</li>
	{if !empty($rsAlbum->album_ctype_locale)}
		<li>
			<div>
				<label>Title locale</label> {$rsAlbum->album_ctype_locale}
			</div>
		</li>
	{/if}
	{if !empty($rsAlbum->album_release_date)}
		<li>
			<div>
				<label>Release Date</label> {$rsAlbum->album_release_date|date_format:"%m/%d/%Y"}
			</div>
		</li>
	{/if}
	{if !empty($rsAlbum->album_alias)}
		<li>
			<div>
				<label>Alias</label> {$rsAlbum->album_alias}
			</div>
		</li>
	{/if}
	{if !empty($rsAlbum->album_image)}
		<li>
			<div>
				<label>Image</label> {$rsAlbum->album_image}
			</div>
		</li>
	{/if}
	{if !empty($rsAlbum->album_primary_release_id)}
		<li>
			<div>
				<label>Primary release</label> {$rsAlbum->primary_release->release_catalog_num}
			</div>
		</li>
	{/if}
		<li>
			<div>
				<label>Visible?</label> <input type="checkbox" disabled="disabled" value="1" {if ($rsAlbum->album_is_visible==true)}checked{/if} />
			</div>
		</li>
	</ul>


	<h3>Releases</h3>

	<p>
		<a href="/index.php/admin/release/add/{$album_id}/" class="button"><img src="{$smarty.const.OBSERVANTRECORDS_CDN_BASE_URI}/web/images/icons/add-page-blue.gif" alt="[Add a release]" title="[Add a release]" /> Add a release</a>
	</p>

	{if !empty($rsReleases)}
	<table>
		<thead>
			<tr>
				<th>&nbsp;</th>
				<th>Cover</th>
				<th>Catalog No.</th>
				<th>UPC</th>
			</tr>
		</thead>
		<tbody>
		</tbody>
		{foreach item=rsRelease from=$rsReleases}
			<tr>
				<td>
					<div>
						<a href="/index.php/admin/release/edit/{$rsRelease->release_id}/"><img src="{$smarty.const.OBSERVANTRECORDS_CDN_BASE_URI}/web/images/icons/edit-page-purple.gif" alt="[Edit]" title="[Edit]" /></a>
						<a href="/index.php/admin/release/delete/{$rsRelease->release_id}/"><img src="{$smarty.const.OBSERVANTRECORDS_CDN_BASE_URI}/web/images/icons/delete-page-purple.gif" alt="[Delete]" title="[Delete]" /></a>
					</div>
				</td>
				<td>
					<a href="/index.php/admin/release/view/{$rsRelease->release_id}/"><img src="{$smarty.const.OBSERVANTRECORDS_CDN_BASE_URI}/artists/{$rsArtist->artist_alias}/albums/{$rsAlbum->album_alias}/{$rsRelease->release_catalog_num|lower}/images/cover_front_small.jpg" width="50" height="50" /></a>
				</td>
				<td>
					{if !empty($rsRelease->release_catalog_num)}{$rsRelease->release_catalog_num}{else}Unassigned{/if}
				</td>
				<td>
					{if !empty($rsRelease->release_upc_num)}{$rsRelease->release_upc_num}{else}Unassigned{/if}
				</td>
			</tr>
		{/foreach}
	{else}
		<tbody>
			<tr>
				<td colspan=4>
					This album has no releases.
				</td>
			</tr>
		</tbody>
	{/if}
	</table>

	{else}
		<p>Album information is not available.</p>
	{/if}
</div>

<div id="admin-column-2">
	{if !empty($rsAlbum)}
	<ul>
		<li><a href="/index.php/admin/artist/view/{$rsAlbum->album_artist_id}/">Back to artist</a></li>
	</ul>
	{/if}
</div>
