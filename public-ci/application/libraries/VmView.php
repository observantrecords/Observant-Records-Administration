<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

/**
 * VmView
 *
 * 
 * @package CodeIgniter
 * @subpackage Vigilant Media Network
 * @category Libraries
 * @author Greg Bueno
 * @copyright (c) 2012 Greg Bueno
 */
class VmView {

	public $content_template;
	public $is_protected;
	public $protected_template;
	public $protected_var;
	public $layout_template;
	public $page_template;
	public $page_title;
	public $page_title_delim;
	public $section_head;
	public $section_label;
	public $section_sublabel;
	public $config = array();
	public $load_global_config;
	public $use_mobile_templates;
	public $error_codes = array('401' => 'Authentication required', '403' => 'Forbidden', '404' => 'Not found', '500' => 'Internal server error');
	protected $CI;


	public function __construct($params = null) {
		if (!empty($params)) {
			foreach ($params as $param => $value) {
				$this->$param = $value;
			}
		}

		$this->load_global_config = (isset($params['load_global_config'])) ? $params['load_global_config'] : true;
		$this->use_mobile_templates = (isset($params['use_mobile_templates'])) ? $params['use_mobile_templates'] : true;

		if ($this->load_global_config === true) {
			require_once(dirname(__FILE__) . '/../../includes/global.php');
			$this->config = array_merge($this->config, $config_url_base);
		}

		$this->CI = & get_instance();

		if ($this->use_mobile_templates === true) {
			if ($this->CI->agent->is_mobile() == true) {
				$this->CI->mysmarty->template_dir = APPPATH . "/views/templates_mobile/";
				$this->CI->mysmarty->compile_dir = APPPATH . '/views/templates_mobile_c';
			}
		}
		$this->CI->content_template = 'root_index.tpl';
	}

	public function format_section_head($section_head = null, $section_label = null, $section_sublabel = null, $delim = null) {
		$this->section_head = $section_head;
		$this->section_label = $section_label;
		$this->section_sublabel = $section_sublabel;
		$this->page_title_delim = empty($delim) ? ' » ' : $delim;

		if (!empty($this->section_head)) {
			$use_delim = !empty($this->section_label) ? true: false;
			$this->append_page_title($section_head, $use_delim, $delim);
		}
		if (!empty($this->section_label)) {
			$use_delim = !empty($this->section_sublabel) ? true: false;
			$this->append_page_title($section_label, $use_delim, $delim);
		}
		if (!empty($this->section_sublabel)) {
			$this->append_page_title($this->section_sublabel, false);
		}
	}

	public function append_page_title($title, $use_delim = true, $delim = null) {
		if (!empty($delim)) {
			$this->page_title_delim = $delim;
		}

		$this->page_title .= $title;
		if ($use_delim === true) {
			$this->page_title .= $this->page_title_delim;
		}
	}

	public function display($content_template = null, $is_protected = false) {

		if (empty($is_protected)) {
			$is_protected = $this->is_protected;
		}

		if ($is_protected === true && (empty($this->protected_template) || empty($this->protected_var))) {
			show_error('VmView::protected_template and VmView::protected_var must be set to enable template protection.');
		}

		if (empty($content_template)) {
			$content_template = $this->content_template;
		}

		$this->CI->mysmarty->content_template = ($is_protected === true) ? $this->protected_template : $content_template;
		$this->CI->mysmarty->layout_template = $this->layout_template;
		$this->CI->mysmarty->page_template = $this->page_template;

		$this->CI->mysmarty->assign('page_title', $this->page_title);
		$this->CI->mysmarty->assign('section_head', $this->section_head);
		$this->CI->mysmarty->assign('section_label', $this->section_label);
		$this->CI->mysmarty->assign('section_sublabel', $this->section_sublabel);
		$this->CI->mysmarty->assign('config', $this->config);

		($is_protected === true) ? $this->CI->mysmarty->display_protected($this->protected_var, $content_template) : $this->CI->mysmarty->display($content_template);
	}

	public function display_error_page($code, $error_template) {
		$this->format_section_head('Error', $code, $this->error_codes[$code]);
		$this->display($error_template);
	}
}

?>
