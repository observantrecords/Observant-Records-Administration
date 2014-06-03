<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

/**
 * VmModel
 *
 * 
 * @package CodeIgniter
 * @subpackage Vigilant Media Network
 * @category Libraries
 * @author Greg Bueno
 * @copyright (c) 2012 Greg Bueno
 */
class VmModel {

	public $table_name;
	public $primary_index_field;
	protected $db;
	protected $CI;
	protected $config;
	protected $error;

	public function __construct($params = null) {
		$this->CI = & get_instance();

		$dsn = !empty($params['dsn']) ? $params['dsn'] : 'default';
		$this->load_database($dsn);
	}

	public function get_config($field = null) {
		if (empty($field)) {
			return $this->config;
		} else {
			return $this->config[$field];
		}
		return false;
	}

	public function set_config($field, $value) {
		if (isset($this->config[$field])) {
			$this->config[$field] = $value;
			return true;
		}
		return false;
	}

	public function load_database($db_group = 'default') {
		if (!empty($db_group)) {
			$this->db_group = $db_group;
		}

		$this->db = $this->CI->load->database($this->db_group, true);
	}

	public function create($input = null) {
		if (empty($input)) {
			$input = $this->build_insert_data($this->table_name);
		}

		if (false !== $this->db->insert($this->table_name, $input)) {
			$id = $this->db->insert_id();
			return $id;
		}
		return false;
	}

	public function retrieve($field, $value) {
		if (false !== ($row = $this->db->get_where($this->table_name, array($field => $value)))) {
			return $row;
		}
		return false;
	}

	public function retrieve_by_id($id, $return_recordset = true) {
		$row = $this->retrieve($this->primary_index_field, $id);
		return ($return_recordset === true) ? $this->return_rs($row) : $row;
	}

	public function retrieve_all($select = null, $order_by = null, $return_recordset = true) {
		if (empty($select)) {
			$this->db->select('*');
		} else {
			if (is_array($select)) {
				foreach ($select as $field) {
					$this->db->select($field);
				}
			} else {
				$this->db->select($select);
			}
		}

		$this->db->from($this->table_name);

		if (!empty($order_by)) {
			$this->db->order_by($order_by);
		}
		$row = $this->db->get();
		return ($return_recordset === true) ? $this->return_smarty_array($row) : $row;
	}

	public function update($field, $value, $input) {
		if (empty($input)) {
			$this->error = 'No data was provided for the update query.';
			return false;
		}

		$this->db->where($field, $value);
		if (false !== $this->db->update($this->table_name, $input)) {
			return true;
		}

		$this->error = $this->db->_error_message();
		return false;
	}

	public function update_by_id($id, $input = null, $table_name = null, $form_values = null) {
		if (empty($input)) {
			$row = $this->retrieve_by_id($id);
			$input = $this->build_update_data($row, $form_values);
		}

		return $this->update($this->primary_index_field, $id, $input);
	}

	public function delete($field, $value) {
		$this->db->where($field, $value);
		if (false !== $this->db->delete($this->table_name)) {
			return true;
		}
		return false;
	}

	public function delete_by_id($id) {
		return $this->delete($this->primary_index_field, $id);
	}

	public function return_rs($row) {
		return ($row->num_rows() > 0) ? $row->row() : false;
	}

	public function return_smarty_array($row, $limit = null, $start = 1) {
		if (empty($limit)) {
			$limit = $row->num_rows();
		}
		$end = $start + ($limit - 1);
		if ($row->num_rows() > 0) {
			$i = 1;
			foreach ($row->result() as $rs) {
				if ($i >= $start && $i <= $end) {
					$array[] = $rs;
				}
				$i++;
			}
			return $array;
		}
		return false;
	}

	public function build_update_data($row, $form_values = null) {
		$updated_fields = array();

		foreach ($row as $row_field => $row_value) {
			if (false !== ($form_value = isset($form_values[$row_field]) ? $form_values[$row_field] : $this->CI->input->get_post($row_field))) {
				if ($form_value != $row_value) {
					$updated_fields[$row_field] = !isset($form_value) ? null : $form_value;
				}
			}
		}
		return $updated_fields;
	}

	public function build_insert_data($table_name = null, $form_values = null) {
		if (empty($table_name)) {
			$table_name = $this->table_name;
		}

		$inserted_fields = array();

		foreach ($this->db->list_fields($this->table_name) as $row_field) {
			if (false !== ($form_value = isset($form_values[$row_field]) ? $form_values[$row_field] : $this->CI->input->get_post($row_field))) {
				$inserted_fields[$row_field] = empty($form_value) ? null : $form_value;
			}
		}
		return $inserted_fields;
	}
}

?>
