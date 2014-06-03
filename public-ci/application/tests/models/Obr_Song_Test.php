<?php

/**
 * Obr_Song_Test
 *
 * Unit tests for Obr_Song model.
 *
 * @author Greg Bueno
 */
class Obr_Song_Test extends CIUnit_TestCase
{
	protected $Obr_Song;
	private $token;

	public function __construct($name = NULL, array $data = array(), $dataName = '')
	{
		parent::__construct($name, $data, $dataName);
		$this->token = md5(time());
	}

	public function setUp()
	{
		parent::setUp();

		$this->CI->load->model('Obr_Song');
		$this->Obr_Song = $this->CI->Obr_Song;
	}

//	public function test_constructor()
//	{
//		$this->assertEquals('ep4_songs', $this->Obr_Song->table_name);
//		$this->assertEquals('song_id', $this->Obr_Song->primary_index_field);
//	}
//
//	public function test_retrieve()
//	{
//		//If no field and value are passed, the resulting query should return false.
//		$result = $this->Obr_Song->retrieve();
//		$this->assertFalse($result);
//
//		//If an invalid field is passed, the resulting query should return false.
//		$result = $this->Obr_Song->retrieve(NULL, 1);
//		$this->assertFalse($result);
//
//		$result = $this->Obr_Song->retrieve('invalid_field_name', 1);
//		$this->assertFalse($result);
//
//		//If an invalid value is passed, the resulting query should return no results.
//		$result = $this->Obr_Song->retrieve('song_id', 'id');
//		$this->assertEquals(0, $result->num_rows);
//
//		$result = $this->Obr_Song->retrieve('song_id', 0);
//		$this->assertEquals(0, $result->num_rows);
//
//		// If a valid field and value is passed, the resulting query should return results.
//		$result = $this->Obr_Song->retrieve('song_id', '1');
//		$this->assertGreaterThanOrEqual(1, $result->num_rows());
//
//		// NULL is a valid value on which to query, but if our data is good, zero results is an expected value.
//		$result = $this->Obr_Song->retrieve('song_title', NULL);
//		$this->assertGreaterThanOrEqual(0, $result->num_rows());
//	}
//
//	public function test_retrieve_all()
//	{
//		// No result is valid value, although there should at least be one.
//		$result = $this->Obr_Song->retrieve_all();
//		$this->assertGreaterThanOrEqual(0, count($result));
//
//		// Limit the selection to one field.
//		$result = $this->Obr_Song->retrieve_all('song_title');
//		// Test for the selected field.
//		$this->assertObjectHasAttribute('song_title', $result[0]);
//		// Test for non-selected fields that are in the table schema.
//		$this->assertObjectNotHasAttribute('song_id', $result[0]);
//		$this->assertObjectNotHasAttribute('song_primary_artist_id', $result[0]);
//		$this->assertObjectNotHasAttribute('song_alias', $result[0]);
//		$this->assertObjectNotHasAttribute('song_author', $result[0]);
//		$this->assertObjectNotHasAttribute('song_abstract', $result[0]);
//		$this->assertObjectNotHasAttribute('song_lyrics', $result[0]);
//		$this->assertObjectNotHasAttribute('song_influences', $result[0]);
//		$this->assertObjectNotHasAttribute('song_style', $result[0]);
//		$this->assertObjectNotHasAttribute('song_written_date', $result[0]);
//		$this->assertObjectNotHasAttribute('song_revised_date', $result[0]);
//		$this->assertObjectNotHasAttribute('song_recorded_date', $result[0]);
//		// Test for a non-selected field that's not in the table schema.
//		$this->assertObjectNotHasAttribute('invalid_field', $result[0]);
//
//		// Limit the selection to more than one field.
//		$result = $this->Obr_Song->retrieve_all(array('song_id', 'song_title', 'song_alias'));
//		// Test for the selected fields.
//		$this->assertObjectHasAttribute('song_id', $result[0]);
//		$this->assertObjectHasAttribute('song_title', $result[0]);
//		$this->assertObjectHasAttribute('song_alias', $result[0]);
//		// Test for a non-selected field that's in the table schema.
//		$this->assertObjectNotHasAttribute('song_primary_artist_id', $result[0]);
//		$this->assertObjectNotHasAttribute('song_author', $result[0]);
//		$this->assertObjectNotHasAttribute('song_abstract', $result[0]);
//		$this->assertObjectNotHasAttribute('song_lyrics', $result[0]);
//		$this->assertObjectNotHasAttribute('song_influences', $result[0]);
//		$this->assertObjectNotHasAttribute('song_style', $result[0]);
//		$this->assertObjectNotHasAttribute('song_written_date', $result[0]);
//		$this->assertObjectNotHasAttribute('song_revised_date', $result[0]);
//		$this->assertObjectNotHasAttribute('song_recorded_date', $result[0]);
//		// Test for a non-selected field that's not in the table schema.
//		$this->assertObjectNotHasAttribute('invalid_field', $result[0]);
//
//		// Order the selection by a field.
//
//		// Return the raw results of the query.
//		$result = $this->Obr_Song->retrieve_all(NULL, NULL, FALSE);
//		$this->assertObjectHasAttribute('conn_id', $result);
//	}
//
//	public function test_retrieve_by_id()
//	{
//		// The ID field should never be NULL, so there should be at least one returned result.
//		$result = $this->Obr_Song->retrieve_by_id(NULL, FALSE);
//		$this->assertLessThan(1, $result->num_rows);
//
//		// If an invalid ID is passed, the query result should be false
//		$result = $this->Obr_Song->retrieve_by_id('id');
//		$this->assertFalse($result);
//
//		// Make sure the raw results are returned when the return_recordset flag is set to FALSE.
//		$result = $this->Obr_Song->retrieve_by_id('id', FALSE);
//		$this->assertObjectHasAttribute('conn_id', $result);
//
//		$result = $this->Obr_Song->retrieve_by_id(1, FALSE);
//		$this->assertObjectHasAttribute('conn_id', $result);
//
//		// If a valid ID is passed, the query should contain a single result.
//		$result = $this->Obr_Song->retrieve_by_id(1);
//		$this->assertEquals(1, count($result));
//		$this->assertObjectHasAttribute('song_id', $result);
//		$this->assertObjectHasAttribute('song_primary_artist_id', $result);
//		$this->assertObjectHasAttribute('song_title', $result);
//		$this->assertObjectHasAttribute('song_alias', $result);
//		$this->assertObjectHasAttribute('song_author', $result);
//		$this->assertObjectHasAttribute('song_abstract', $result);
//		$this->assertObjectHasAttribute('song_lyrics', $result);
//		$this->assertObjectHasAttribute('song_influences', $result);
//		$this->assertObjectHasAttribute('song_style', $result);
//		$this->assertObjectHasAttribute('song_written_date', $result);
//		$this->assertObjectHasAttribute('song_revised_date', $result);
//		$this->assertObjectHasAttribute('song_recorded_date', $result);
//	}
//
//	public function test_create()
//	{
//		$input = array(
//			'song_title' => 'Test Song Title ' . $this->token,
//			'song_primary_artist_id' => 1,
//			'song_alias' => 'test_song_title_' . $this->token,
//			'song_author' => 'Vigilant Media',
//		);
//
//		// If no input is available, the query returns false
//		// unless $_POST data is sent.
//		$id = $this->Obr_Song->create();
//		$this->assertFalse($id);
//		$this->assertFalse(is_int($id));
//
//		// If no input is available, the query returns an ID
//		// if $_POST data is sent.
//		$_POST = $input;
//		$id = $this->Obr_Song->create();
//		$this->assertTrue(is_int($id));
//		$_POST = NULL;
//
//		// If input is passed, the query returns an ID.
//		$id = $this->Obr_Song->create($input);
//		$this->assertTrue(is_int($id));
//	}
	
	public function test_artists() {
		$this->CI->load->model('Obr_Artist');
		$result = $this->CI->Obr_Artist->get_all();
		print_R($result);
		$this->assertNotNull($result);
		
	}

	public function tearDown()
	{
		parent::tearDown();
	}
}

?>
