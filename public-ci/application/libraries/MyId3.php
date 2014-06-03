<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once(APPPATH . "libraries/getid3/getid3.php");

/**
 * MyId3
 *
 * 
 * @package CodeIgniter
 * @subpackage Vigilant Media Network
 * @category Libraries
 * @author Greg Bueno
 * @copyright (c) 2012 Greg Bueno
 */
class MyId3 extends getid3
{
	var $id3;
	
	function MyId3()
	{
		log_message('debug', "Id3 Class Initialized");
		$id3 = new getID3;
		return $id3;
	}
	
	function id3_tagwriter()
	{
		require_once(BASEPATH . "libraries/getid3/write.php");
		$tag_writer = new getid3_writetags;
		return $tag_writer;
	}
}
?>