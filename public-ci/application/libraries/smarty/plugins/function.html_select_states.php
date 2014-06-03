<?php
function smarty_function_html_select_states($params)
{
	$txt = '';
	
	$CI =& get_instance();
	
	$CI->db->from('vm_states');
	$CI->db->order_by('state_name');
	$rowStates = $CI->db->get();
	
	$txt .= '<select id="' . $params["field"] . '" name="' . $params["field"] . '">' . "\n";
	$txt .= '<option value="">&nbsp;</option>' . "\n";
	foreach ($rowStates->result() as $rs)
	{
		$value = ($params["name"] == true) ? $rs->state_name : $rs->state_abbr;
		$selected = ($params["default"] == $value) ? " selected" : "";
		$txt .= '<option value="' . $value . '"' . $selected. '> ' . $rs->state_name . "</option>\n";
	}
	$txt .= '</select>' . "\n";
	return $txt;
}

?>