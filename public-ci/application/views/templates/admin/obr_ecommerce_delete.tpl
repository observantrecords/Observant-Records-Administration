{include file=obr_global_header.tpl}

	<form action="/index.php/admin/ecommerce/remove/{$ecommerce_id}/" method="post" id="artist_form" name="ecomerce_form">
		
		<p>You are about to delete a link to <strong>{$rsEcommerce->ecommerce_label}</strong> from the Observant Records database. <span class="caution">CAUTION:</span> Deletions cannot be undone!</p>
		
		<p><strong>Are you sure you want to proceed?</strong></p>

		<p>
			<input type="submit" id="confirm_yes" name="confirm" value="Yes" class="button" />
			<input type="submit" id="confirm_no" name="confirm" value="No" class="button" />
			<input type="hidden" id="redirect" name="redirect" value="{$smarty.server.HTTP_REFERER}" />
			<input type="hidden" id="ecommerce_release_id" name="ecommerce_release_id" value="{$ecommerce_release_id}" />
		</p>

	</form>


{include file=admin/obr_global_delete.tpl}
