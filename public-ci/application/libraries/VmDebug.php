<?php

/**
 * VmDebug
 * 
 * VmDebug is a library of debugging methods.
 * 
 * @package CodeIgniter
 * @subpackage Vigilant Media Network
 * @category Libraries
 * @author Greg Bueno
 * @copyright (c) 2012 Greg Bueno
 */
class VmDebug {

	public function __construct($params = null) {
		
	}
	
	/**
	 * debug_trace
	 * 
	 * debug_trace prints a message prefaced by "DEBUG" in a specified color,
	 * usually red.
	 * 
	 * @param string $msg A debug message.
	 * @param string $color A hexadecimal color.
	 */
	public function debug_trace($msg = '', $color = '#F00') {
		echo '<span style="color: ' . $color . ';">DEBUG: ' . $msg . '</span><br>' . "\n";
	}
	
	/**
	 * debug_print_r
	 * 
	 * debug_print_r print a message surrounded by pre-formatted tags. The second
	 * argument specifies whether to die after the message is printed.
	 * 
	 * @param string $msg A debug message.
	 * @param boolean $die_after_print A flag to die after the message is printed.
	 */
	public function debug_print_r($msg, $die_after_print = false) {
		echo '<pre>';
		print_r($msg);
		echo '</pre>';
		if ($die_after_print === true) {
			die();
		}
	}

}
