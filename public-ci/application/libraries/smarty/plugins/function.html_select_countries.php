<?php
function smarty_function_html_select_countries($params)
{
	$txt = '';
	
	$CI =& get_instance();
	
	$CI->db->from('vm_countries');
	$CI->db->order_by('country_name');
	$rowCountries = $CI->db->get();
	
	$txt .= '<select id="' . $params["field"] . '" name="' . $params["field"] . '">' . "\n";
	$txt .= '<option value="">&nbsp;</option>' . "\n";
	foreach ($rowCountries->result() as $rs)
	{
		$selected = ($params["default"] == $rs->country_name) ? " selected" : "";
		$txt .= '<option value="' . $rs->country_name . '"' . $selected. '> ' .  $rs->country_name . "</option>\n";
	}
	$txt .= '</select>' . "\n";
	return $txt;
}

?>