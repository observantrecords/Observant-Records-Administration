{include file=obr_global_header.tpl}
<div id="admin-column-1">

	{if !empty($rsRelease)}
	<p>
		<a href="/index.php/admin/release/edit/{$release_id}/" class="button"><img src="{$smarty.const.OBSERVANTRECORDS_CDN_BASE_URI}/web/images/icons/edit-page-blue.gif" alt="[Edit]" title="[Edit]" /> Edit</a>
		<a href="/index.php/admin/release/delete/{$release_id}/" class="button"><img src="{$smarty.const.OBSERVANTRECORDS_CDN_BASE_URI}/web/images/icons/delete-page-blue.gif" alt="[Delete]" title="[Delete]" /> Delete</a>
	</p>

	<ul class="two-column-bubble-list">
		<li>
			<div>
				<label>Format</label> {$rsRelease->format->format_name}
			</div>
		</li>
	{if !empty($rsRelease->release_label)}
		<li>
			<div>
				<label>Label</label> {$rsRelease->release_label}
			</div>
		</li>
	{/if}
	{if !empty($rsRelease->release_alternate_title)}
		<li>
			<div>
				<label>Alternate title</label> {$rsRelease->release_alternate_title}
			</div>
		</li>
	{/if}
	{if !empty($rsRelease->release_upc_num)}
		<li>
			<div>
				<label>UPC No.</label> {$rsRelease->release_upc_num}
			</div>
		</li>
	{/if}
	{if !empty($rsRelease->release_catalog_num)}
		<li>
			<div>
				<label>Catalog No.</label> {$rsRelease->release_catalog_num}
			</div>
		</li>
	{/if}
	{if !empty($rsRelease->release_release_date)}
		<li>
			<div>
				<label>Release Date</label> {$rsRelease->release_release_date|date_format:"%m/%d/%Y"}
			</div>
		</li>
	{/if}
	{if !empty($rsRelease->release_alias)}
		<li>
			<div>
				<label>Alias</label> {$rsRelease->release_alias}
			</div>
		</li>
	{/if}
	{if !empty($rsRelease->release_image)}
		<li>
			<div>
				<label>Image</label> {$rsRelease->release_image}
			</div>
		</li>
	{/if}
		<li>
			<div>
				<label>Visibile?</label> <input type="checkbox" disabled="disabled" value="1" {if ($rsRelease->release_is_visible==true)}checked{/if} />
			</div>
		</li>
	</ul>
			
	<h3>Tracks</h3>

		<form action="/index.php/admin/track/save_order/{$release_id}/" method="post" id="save-order-form">
			<p>
				<a href="/index.php/admin/track/add/{$release_id}/" class="button"><img src="{$smarty.const.OBSERVANTRECORDS_CDN_BASE_URI}/web/images/icons/add-page-blue.gif" alt="[Add]" title="[Add]" /> Add a track</a>
	{if !empty($rsRelease->tracks)}
				<a href="/index.php/admin/release/export_id3/{$release_id}/" class="button">Export ID3 data</a>
				<input type="button" value="Save track order" id="save-order" class="button" />
	{/if}
				<input type="hidden" name="track_id" value="{$rsTrack->track_id}" />
			</p>
		</form>

	{if !empty($rsRelease->tracks)}
		<ol class="disc-list">
		{foreach item=rsDisc key=disc_num from=$rsRelease->tracks}
			<li> <h4>Disc: <span class="disc-num-display">{$disc_num}</span>:</h4>
				<ol class="track-list">
				{foreach item=rsTrack from=$rsDisc}
					<li>
						<div>
							<a href="/index.php/admin/track/edit/{$rsTrack->track_id}"><img src="{$smarty.const.OBSERVANTRECORDS_CDN_BASE_URI}/web/images/icons/edit-page-purple.gif" alt="[Edit]" title="[Edit]" /></a>
							<a href="/index.php/admin/track/delete/{$rsTrack->track_id}"><img src="{$smarty.const.OBSERVANTRECORDS_CDN_BASE_URI}/web/images/icons/delete-page-purple.gif" alt="[Delete]" title="[Delete]" /></a>
							<span class="track-num-display">{$rsTrack->track_track_num}</span>. <a href="/index.php/admin/track/view/{$rsTrack->track_id}">{$rsTrack->song->song_title}</a>
							<input type="hidden" name="track_id" value="{$rsTrack->track_id}" />
							<input type="hidden" name="track_disc_num" value="{$rsTrack->track_disc_num}" />
						</div>
					</li>
				{/foreach}
				</ol>
			</li>
		{/foreach}
		</ol>
		
		<div id="save-order-dialog">
			<p class="msg"></p>
		</div>
		{literal}
		<script type="text/javascript">
		$('.track-list').sortable({
			update: function (event, ui) {
				var new_track_num = 1;
				$(this).children().each(function () {
					$(this).find('.track-num-display').html(new_track_num);
					new_track_num++;
				});
			}
		});
		if ($('.disc-list').children().length > 1) {
			$('.disc-list').sortable({
				update: function (event, ui) {
					var new_disc_num = 1;
					$(this).children().each(function () {
						$(this).find('.disc-num-display').html(new_disc_num);
						$(this).find('.track-list li').each(function () {
							$(this).find('input[name=track_disc_num]').val(new_disc_num);
						});
						new_disc_num++;
					});
				}
			});
		}
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
			var tracks = [], track_disc, track_num, track_id, track_info;
			$('.track-list').children().each(function () {
				track_num = $(this).find('.track-num-display').html();
				track_id = $(this).find('input[name=track_id]').val();
				track_disc = $(this).find('input[name=track_disc_num]').val();
				track_info = {
					'track_id': track_id,
					'track_track_num': track_num,
					'track_disc_num': track_disc
				}
				tracks.push(track_info);
			});
			var url = $('#save-order-form').attr('action');
			var data = {
				'tracks': tracks
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
		<p>This release has no tracks.</p>
	{/if}
	
	<h4>Ecommerce links</h4>

		<form action="/index.php/admin/ecommerce/save_order/{$release_id}/" method="post" id="save-ecommerce-form">
			<p>
				<a href="/index.php/admin/ecommerce/add/{$release_id}/" class="button"><img src="{$smarty.const.OBSERVANTRECORDS_CDN_BASE_URI}/web/images/icons/add-page-blue.gif" alt="[Add]" title="[Add]" /> Add an ecommerce link</a>
	{if !empty($rsRelease->ecommerce)}
				<input type="button" value="Save ecommerce link order" id="save-ecommerce-order" class="button" />
	{/if}
			</p>
		</form>

	{if !empty($rsRelease->ecommerce)}
		<ul class="ecommerce-list">
		{foreach item=rsEcommerce from=$rsRelease->ecommerce}
			<li>
				<div>
					<a href="/index.php/admin/ecommerce/edit/{$rsEcommerce->ecommerce_id}/"><img src="{$smarty.const.OBSERVANTRECORDS_CDN_BASE_URI}/web/images/icons/edit-page-purple.gif" alt="[Edit]" title="[Edit]" /></a>
					<a href="/index.php/admin/ecommerce/delete/{$rsEcommerce->ecommerce_id}/"><img src="{$smarty.const.OBSERVANTRECORDS_CDN_BASE_URI}/web/images/icons/delete-page-purple.gif" alt="[Delete]" title="[Delete]" /></a>
					<span class="ecommerce-list-order">{$rsEcommerce->ecommerce_list_order}</span>. <a href="/index.php/admin/ecommerce/view/{$rsEcommerce->ecommerce_id}/">{$rsEcommerce->ecommerce_label}</a>
					<input type="hidden" name="ecommerce_id" value="{$rsEcommerce->ecommerce_id}" />
				</div>
			</li>
		{/foreach}
		</ul>
		
		<div id="save-list-order-dialog">
			<p class="msg"></p>
		</div>
		{literal}
		<script type="text/javascript">
		$('.ecommerce-list').sortable({
			update: function (event, ui) {
				var new_list_order = 1;
				$(this).children().each(function () {
					$(this).find('.ecommerce-list-order').html(new_list_order);
					new_list_order++;
				});
			}
		});
		$('#save-list-order-dialog').dialog({
			autoOpen: false,
			modal: true,
			buttons: {
				"OK": function () {
					$(this).dialog('close');
				}
			}
		});
		$('#save-ecommerce-order').click(function () {
			var ecomm_links = [], ecomm_list_order, ecomm_id, ecomm_info;
			$('.ecommerce-list').children().each(function () {
				ecomm_list_order = $(this).find('.ecommerce-list-order').html();
				ecomm_id = $(this).find('input[name=ecommerce_id]').val();
				ecomm_info = {
					'ecommerce_id': ecomm_id,
					'ecommerce_list_order': ecomm_list_order,
				}
				ecomm_links.push(ecomm_info);
			});
			var url = $('#save-ecommerce-form').attr('action');
			var data = {
				'ecommerce': ecomm_links
			};
			$.post(url, data, function (result) {
				$('#save-list-order-dialog').dialog('open');
				$('#save-list-order-dialog').find('.msg').html(result);
			}).error(function (result) {
				var error_msg = 'Your request could not be completed. The following error was given: ' + result.statusText;
				$('#save-list-order-dialog').dialog('open');
				$('#save-list-order-dialog').find('.msg').html(error_msg);
			});
		});
		</script>
		{/literal}
	{else}
		<p>This release has no ecommerce links.</p>
	{/if}
	

	{else}
		<p>This release has no information.</p>
	{/if}
</div>

<div id="admin-column-2">
	{if !empty($rsRelease)}
	<p>
		<img src="{$smarty.const.OBSERVANTRECORDS_CDN_BASE_URI}/artists/{$rsArtist->artist_alias}/albums/{$rsRelease->album->album_alias}/{$rsRelease->release_catalog_num|lower}/images/cover_front_medium.jpg" width="230" />
	</p>
	
	<ul>
		<li><a href="/index.php/admin/album/view/{$rsRelease->release_album_id}/">Back to <em>{$rsRelease->album->album_title}</em></a></li>
	</ul>
	{/if}
</div>
