<?php

/**
 * Description of ObservantView
 *
 * @author Greg Bueno
 */
class ObservantView {
	
	public $CI;
	
	public function __construct() {
		$this->CI =& get_instance();
		$this->CI->load->library('VmView', array('use_mobile_templates' => false));
		
		// Configure VmView for all pages on the site.
		$this->CI->vmview->layout_template = 'obr_global_layout.tpl';
		$this->CI->vmview->page_template = 'obr_global_page.tpl';
		$this->CI->vmview->per_page = 10;
		$this->CI->vmview->page_title_delim = ' &raquo; ';
		$this->CI->vmview->protected_template = 'obr_root_content.tpl';
		$this->CI->vmview->protected_var = 'root_content';
		
		$this->CI->mysmarty->assign('session', $this->CI->phpsession);
		
		$this->CI->load->model('Obr_Artist');
	}
	
	public function _set_artist_header($artist_id, $section_label = null, $section_sublabel = null) {
		$rsArtist = $this->CI->Obr_Artist->get($artist_id);
		$this->CI->vmview->format_section_head($rsArtist->artist_display_name, $section_label, $section_sublabel);
		return $rsArtist;
	}
	
}

?>
