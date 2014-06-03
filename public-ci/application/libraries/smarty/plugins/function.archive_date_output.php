<?php
function smarty_function_archive_date_output($params)
{
	$CI =& get_instance();
	$url = $params["url"];
	$blog_id = $params["blog_id"];
	$include_month = ($params["include_month"] == -1) ? false : true;
	$limit_year = $params["limit_year"] ? $params["limit_year"] : NULL;
	
	$rowCalendar = $CI->Mw_mt_model->get_calendar($blog_id, $include_month, $limit_year);
	
	$prev = '';
	$next = '';
	$txt = '';
	
	foreach ($rowCalendar->result() as $rs)
	{
		$archive_path = preg_replace("/XXXXXX/", $rs->entry_month . "/" . $rs->entry_year, $url);
		if ($include_month==true)
		{
			$prev = $rs->entry_year;
			if ($prev != $next)
			{
				if (!empty($next)) {$txt .= "<br>" . "\n";}
				$txt .= $rs->entry_year . ": ";
			}
			$date_output = sprintf("%02s", $rs->entry_month);
			$next = $prev;
		}
		else
		{
			$date_output = $rs->entry_year;
		}
		$txt .= '<a href="' . $archive_path . '">' . $date_output . '</a> ';
	}
	return $txt;
}
?>
