<?php
function smarty_function_phpbb_get_newest_post($params)
{
	$last_post = phpbb_getNewestPost();
	echo "<h2>Newest BBS Post</h2>\n";
	echo "<p><a href=\"/xml_forum/bbs/viewtopic.php?t=" . $last_post["topic_id"] . "\">" . $last_post["subject"] . "</a></p>\n";
}
?>