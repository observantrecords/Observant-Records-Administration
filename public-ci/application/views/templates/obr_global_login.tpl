<form action="{$login_action}" method="post" name="loginForm">
	<p>
		<label>Username:</label>
		<input type="text" name="login" size="50"{if $user_login} value="{$user_login}"{/if} />
	</p>

	<p>
		<label>Password:</label>
		<input type="password" name="password" size="50" />
	</p>
	
	<p>
		<input type="hidden" name="redirect" value="{if $redirect}{$redirect}{else}{$smarty.server.REQUEST_URI}{/if}" />
		<input type="submit" name="do" value="Login" />
	</p>
</form>
