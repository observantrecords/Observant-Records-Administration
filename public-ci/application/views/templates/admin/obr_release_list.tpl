{include file=obr_global_header.tpl}

	<p>
		<a href="/index.php/admin/release/add/{$album_id}/" class="button"><img src="{$smarty.const.OBSERVANTRECORDS_CDN_BASE_URI}/web/images/icons/add-page-blue.gif" alt="[Add a release]" title="[Add a release]" /> Add a release</a>
	</p>

	{if !empty($rsReleases)}
	<table>
		<thead>
			<tr>
				<th>&nbsp;</th>
				<th>Format</th>
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
					<a href="/index.php/admin/release/view/{$rsRelease->release_id}/">{$rsRelease->format->format_name}</a>
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

