<?php

if (function_exists('build_update_data') === FALSE) {
	function build_update_data($table_name, $form_values = null) {
		$CI =& get_instance();
		
		$updated_fields = array();

		foreach ($CI->db->list_fields($table_name) as $row_field) {
			if (false !== ($form_value = isset($form_values[$row_field]) ? $form_values[$row_field] : $CI->input->get_post($row_field))) {
				$updated_fields[$row_field] = !isset($form_value) ? null : $form_value;
			}
		}
		return $updated_fields;
	}
}

if (function_exists('make_placeholder') === FALSE) {
	function make_placeholder($table_name) {
		$CI =& get_instance();
		
		$fields = $CI->db->list_fields($table_name);
		$placeholder = array();
		foreach ($fields as $field) {
			$placeholder[$field] = null;
		}
		return $placeholder;
	}
}

/**
 * search_array_of_objects
 * 
 * search_array_of_objects() iterates through an array of objects and returns
 * an object if a specofoed property matches.
 * 
 * @todo This function is generic enough to be categorized in a different helper.
 */
if (!function_exists('search_array_of_objects')) {
	function search_array_of_objects($objects_array, $key, $value) {
		foreach ($objects_array as $object) {
			if ($object->$key == $value) {
				return $object;
			}
		}
		return false;
	}
}
