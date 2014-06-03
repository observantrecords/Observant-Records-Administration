{include file=obr_global_header.tpl}

<p>
	<a href="/index.php/admin/recording/add/{$artist_id}/" class="button"><img src="{$smarty.const.OBSERVANTRECORDS_CDN_BASE_URI}/web/images/icons/add-page-blue.gif" alt="[Add audio file]" title="[Add audio file]" /> Add recording</a>
</p>

<p>
{if (!empty($rsRecordings))}
<select id="recording_id" name="recording_id">
{foreach item=rsRecording from=$rsRecordings}
	<option value="{$rsRecording->recording_id}">{if $rsRecording->recording_isrc_num}{$rsRecording->recording_isrc_num}{else}ISRC TBD{/if}: {$rsRecording->song->song_title}</option>
{/foreach}
</select>
<input type="button" id="select_recording" value="Go" class="button" />
</p>

{literal}
<script type="text/javascript">
$(function () {
	$('#recording_id').chosen();
	
	var Recording_List = {
		select_recording: function (recording_id) {
			var url = '/index.php/admin/recording/view/' + recording_id + '/';
			location.href = url;
		}
	};
	
	$('#recording_id').change(function () {
		Recording_List.select_recording(this.value);
	});
	$('#select_recording').click(function () {
		Recording_List.select_recording($('#recording_id').val());
	});
});
</script>
{/literal}

{else}
<p>
	This artist has no songs. Please add one.
</p>
{/if}
