{include file=obr_global_header.tpl}

		<form action="/index.php/admin/track/save_order/{$release_id}/" method="post" id="save-order-form">
			<p>
				<a href="/index.php/admin/track/add/{$release_id}/" class="button"><img src="{$smarty.const.OBSERVANTRECORDS_CDN_BASE_URI}/web/images/icons/add-page-blue.gif" alt="[Add]" title="[Add]" /> Add a track</a>
				<input type="button" value="Save track order" id="save-order" class="button" />
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
