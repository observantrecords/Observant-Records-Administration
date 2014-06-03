{include file=obr_global_header.tpl}

<p>
	<a href="/index.php/admin/artist/add/" class="button"><img src="{$smarty.const.OBSERVANTRECORDS_CDN_BASE_URI}/web/images/icons/add-page-blue.gif" alt="[Add an artist]" title="[Add an artist]" /> Add an artist</a>
</p>

{if $rsArtists}
<ul>
	{foreach item=rsArtist from=$rsArtists}
	<li><a href="/index.php/admin/artist/view/{$rsArtist->artist_id}/">{$rsArtist->artist_display_name}</a></li>
	{/foreach}
</ul>
{/if}
