<?php
function smarty_modifier_parse_line_breaks($string)
{
	$text = trim($string);
	/*
	$text = preg_replace("/(?:^|(?:\x0d\x0a){2,}|\x0a{2,}|\x0d{2,})(.+?)(?=(?:(\x0d\x0a){2,}|\x0d{2,}|\x0a{2,}|$))/s","<p>$1</p>",$text);
	$text = preg_replace("/(?:^|(?:\x0d\x0a){1,}|\x0a{1,}|\x0d{1,})(.+?)(?=(?:(\x0d\x0a){1,}|\x0d{1,}|\x0a{1,}|$))/s","$1<br/>",$text);
	$text = preg_replace("/<\/p><br\/>/","</p>",$text);
	$text = preg_replace("/<br\/>/","<br/>\n",$text);
	$text = preg_replace("/<\/p>/","</p>\n\n",$text);
	*/
	$paras = preg_split("/\r?\n\r?\n/", $text);
	foreach ($paras as $i => $p)
	{
		if (!preg_match("/^<(?:table|ol|ul|pre|select|form|blockquote|div|q|hr)/", $p))
		{
			$p = preg_replace("/\r?\n/", "<br />\n", $p);
			$p = "<p>$p</p>";
			$ntxt[] = $p;
		}
		else
		{
			$ntxt[] = $p;
		}
	}
	$text = implode("\n\n", $ntxt);

	return $text;
}
?>