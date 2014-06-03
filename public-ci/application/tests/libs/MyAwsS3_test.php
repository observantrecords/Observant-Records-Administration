<?php

use Aws\S3\S3Client;
use Aws\S3\Exception;
use Aws\S3\Iterator;

/**
 * MyAwsS3_test
 *
 * Unit tests for MyAwsS3 class.
 *
 * @author Greg Bueno
 */
class MyAwsS3_test extends CIUnit_TestCase
{
	private $s3;
	
	public function setUp()
	{
		parent::setUp();
		
		$params = array(
			'key' => ACCESS_KEY_ID,
			'secret' => SECRET_ACCESS_KEY,
		);
		$this->CI->load->library('ObservantS3', '', 'observants3');
		
		$this->s3 = Aws\S3\S3Client::factory($params);
	}

	public function test_bucket_exists()
	{
		// Test whether connection was successful.
		$result = $this->s3->doesBucketExist('observant-records');
		$this->assertTrue($result);
	}

	public function test_list_objects()
	{
		$args = array(
			'Bucket' => 'observant-records',
			'Prefix' => 'artists/eponymous-4/albums/enigmatics/obrc-000b/audio/mp3',
		);
		$results = $this->s3->getIterator('ListObjects', $args);
		$this->assertNotNull($results);
	}
	
	public function test_list_folders() {
		$results = $this->CI->observants3->list_folders('eponymous-4');
		$this->assertNotNull($results);
		
		print_r($results);
	}
}

?>
