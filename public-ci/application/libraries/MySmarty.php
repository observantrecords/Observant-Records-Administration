<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * MySmarty
 *
 * 
 * @package CodeIgniter
 * @subpackage Vigilant Media Network
 * @category Libraries
 * @author Greg Bueno
 * @copyright (c) 2012 Greg Bueno
 */
require_once(APPPATH . "libraries/smarty/Smarty.class.php");

class MySmarty extends Smarty
{
	
	public $content_template;
	public $layout_template;
	public $page_template;
	public $cache_control;
	public $charset;
	
	public function __construct()
	{
		$this->config_dir = APPPATH . "/views/configs";
		$this->cache_dir = APPPATH . "/views/cache";
		$this->template_dir = APPPATH . "/views/templates";
		$this->compile_dir = APPPATH . "/views/templates_c";
		log_message('debug', "Smarty Class Initialized");
		
		$this->cache_control = 'private';
		$this->charset = 'utf-8';
	}
	
	
	public function display($template = 'global_page.tpl', $cache_id = null, $compile_id = null)
	{
		if (!empty($this->page_template)) {
			header('Content-Type: text/html; charset=' . $this->charset);
			header('Cache-Control: ' . $this->cache_control);

			$this->assign('content_template', $this->content_template);
			$this->assign('layout_template', $this->layout_template);
			parent::display($this->page_template, $cache_id, $compile_id);
		} else {
			parent::display($template, $cache_id, $compile_id);
		}
	}
	
	public function display_protected($content_var, $content_template) {
		$this->assign($content_var, $content_template);
		$this->display();
	}
}
?>