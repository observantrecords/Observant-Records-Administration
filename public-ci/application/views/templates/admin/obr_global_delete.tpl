{literal}
<script type="text/javascript">
	$(function () {
		$('#confirm_no').click(function () {
			var redirect = $('#redirect').val();
			location.href = redirect;
			$('#confirm').val(false);
			return false;
		});
		$('#confirm_yes').click(function () {
			$('#confirm').val(true);
			return true;
		});
	});
</script>
{/literal}