<?php

switch (ENVIRONMENT) {
	case 'localhost':
		// Observant Records database connection.
		$local_db_host = 'localhost';
		$local_db_user = 'root';
		$local_db_password = '';
		define('OBSERVANTRECORDS_DB_HOST', $local_db_host);
		define('OBSERVANTRECORDS_DB_USER', $local_db_user);
		define('OBSERVANTRECORDS_DB_PASS', $local_db_password);
		define('OBSERVANTRECORDS_DB_DB', 'observantrecords_dev');

		// Vigilant Media database connection.
		define('VIGILANTMEDIA_DB_HOST', $local_db_host);
		define('VIGILANTMEDIA_DB_USER', $local_db_user);
		define('VIGILANTMEDIA_DB_PASS', $local_db_password);
		define('VIGILANTMEDIA_DB_DB', 'vigilantmedia_dev');
		break;
	default:
		// Observant Records database connection.
		define('OBSERVANTRECORDS_DB_HOST', 'mysql.observantrecords.com');
		define('OBSERVANTRECORDS_DB_USER', 'observantrecords');
		define('OBSERVANTRECORDS_DB_PASS', 'shinkyoku observant eponymous 4');
		define('OBSERVANTRECORDS_DB_DB', (ENVIRONMENT == 'development') ? 'observant_records_dev' : 'observant_records');

		// Vigilant Media database connection.
		define('VIGILANTMEDIA_DB_HOST', 'mysql.vigilantmedia.com');
		define('VIGILANTMEDIA_DB_USER', 'vigilantmedia');
		define('VIGILANTMEDIA_DB_PASS', 'vigilant crux crash');
		define('VIGILANTMEDIA_DB_DB', (ENVIRONMENT == 'development') ? 'vigilantmedia_dev' : 'vigilantmedia');
}

// Amazon Product Marketing API
define('SUBSCRIBER_ID','00GCWZENCGTF9HTN0F02'); //EWS 4.0
define('ACCESS_KEY_ID','AKIAJW4VFARJPZYPGQJA');
define('SECRET_ACCESS_KEY','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');

// US ISRC registrant code
define('ISRC_COUNTRY_CODE', 'QM');
define('ISRC_REGISTRANT_CODE', 'G35');

// File paths
$path_base = (ENVIRONMENT === 'localhost') ? '/home/nemesisv/websites-obrc' : 'D:/Websites';
define('OBSERVANTRECORDS_ROOT_PATH', $path_base . '/production/observantrecords.com/www');
define('OBSERVANTRECORDS_AUDIO_PATH', OBSERVANTRECORDS_ROOT_PATH . '/music/audio');
define('OBSERVANTRECORDS_MP3_PATH', OBSERVANTRECORDS_AUDIO_PATH . '/_mp3');
define('OBSERVANTRECORDS_ZIP_PATH', OBSERVANTRECORDS_AUDIO_PATH . '/_zip');
define('OBSERVANTRECORDS_FILES_PATH', OBSERVANTRECORDS_ROOT_PATH . '/files');

define('OBSERVANTRECORDS_CDN_BASE_URI', ENVIRONMENT != 'production' ? 'http://observantrecords.s3.amazonaws.com' : 'http://cdn.observantrecords.com');

define('OBSERVANTRECORDS_COVERS_PATH_LOCALHOST', 'D:/Websites/dev/observantrecords.com/www/images/_covers');
define('OBSERVANTRECORDS_COVERS_PATH_DEV', '/home/nemesisv/websites-obrc/development/observantrecords.com/www/images/_covers');
define('OBSERVANTRECORDS_COVERS_PATH_TEST', '/home/nemesisv/websites-obrc/testing/observantrecords.com/www/images/_covers');
define('OBSERVANTRECORDS_COVERS_PATH_PROD', '/home/nemesisv/websites-obrc/production/observantrecords.com/www/images/_covers');

