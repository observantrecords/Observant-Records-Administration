<?php
function smarty_function_get_image_dimensions($params)
{
	$filePath = $params["file_path"];
	$dimensions = GetImageDimensions($filePath);
	return $dimensions;
}
?>