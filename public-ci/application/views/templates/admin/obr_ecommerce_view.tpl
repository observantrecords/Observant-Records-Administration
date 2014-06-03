<div id="admin-column-1">
{include file=obr_global_header.tpl}

	{if !empty($rsEcommerce)}
	<p>
		<a href="/index.php/admin/ecommerce/edit/{$track_id}/" class="button"><img src="{$smarty.const.OBSERVANTRECORDS_CDN_BASE_URI}/web/images/icons/edit-page-blue.gif" alt="[Edit]" title="[Edit]" /> Edit</a>
		<a href="/index.php/admin/ecommerce/delete/{$track_id}/" class="button"><img src="{$smarty.const.OBSERVANTRECORDS_CDN_BASE_URI}/web/images/icons/delete-page-blue.gif" alt="[Delete]" title="[Delete]" /> Delete</a>
	</p>

	<ul class="two-column-bubble-list">
		<li>
			<div>
				<label>Label</label> {$rsEcommerce->ecommerce_label}
			</div>
		</li>
		<li>
			<div>
				<label>URL</label> <a href="{$rsEcommerce->ecommerce_url}" title="[{$rsEcommerce->ecommerce_url}]">{$rsEcommerce->ecommerce_url|truncate:40:'...'}</a>
			</div>
		</li>
	</ul>
	
	{else}
	<p>This ecommerce link has no information.</p>
	{/if}
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
