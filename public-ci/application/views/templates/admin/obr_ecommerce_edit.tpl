{include file=obr_global_header.tpl}

<div id="admin-column-1">

	<form action="/index.php/admin/ecommerce/{if !empty($ecommerce_id)}update/{$ecommerce_id}{else}create{/if}/" method="post" name="ecommerce-form">
		<p>
			<label for="ecommerce_label">Vendor Name:</label>
			<input type="text" id="ecommerce-url" name="ecommerce_label" value="{$rsEcommerce->ecommerce_label}" size="50" />
		</p>
		
		<p>
			<label for="ecommerce_url">URL:</label>
			<input type="text" name="ecommerce_url" value="{$rsEcommerce->ecommerce_url}" size="50" />
		</p>
		
		<p>
			<input type="submit" value="Save" class="button" />
			<input type="hidden" name="ecommerce_release_id" value="{$ecommerce_release_id}" />
		{if empty($ecommerce_id)}
			<input type="hidden" name="ecommerce_list_order" value="{$ecommerce_list_order}" />
		{/if}
		
		</p>
	</form>
	
	<script type="text/javascript">
	var labels = {$labels}
	</script>
	{literal}
	<script type="text/javascript">
	$(function () {
		$('#ecommerce-url').autocomplete({
			source: labels
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
