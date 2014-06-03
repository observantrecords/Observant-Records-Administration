<?php
function smarty_function_eval_entry($params)
{
	eval("?>\n" . $params['txt']);
}
?>