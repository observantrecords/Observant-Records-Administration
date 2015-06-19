<?php
define('ISRC_COUNTRY_CODE', 'QM');
define('ISRC_REGISTRANT_CODE', 'G35');
define('OBSERVANTRECORDS_CDN_BASE_URI', env('OBSERVANTRECORDS_CDN_BASE_URI', '//cdn.observantrecords.com'));

return [
	'url_base' => array(
		'to_observant' => env('TO_OBSERVANT_ADMIN', '//admin.observantrecords.com'),
		'to_observant' => env('TO_OBSERVANT', '//observantrecords.com'),
		'to_eponymous4' => env('TO_EPONYMOUS4', '//eponymous4.com'),
		'to_emptyensemble' => env('TO_EMPTYENSEMBLE', '//emptyensemble.com'),
		'to_penziasandwilson' => env('TO_PENZIASANDWILSON', '//penziasandwilson.com'),
		'to_shinkyokuadvocacy' => env('TO_SHINKYOKUADVOCACY', '//shinkyokuadvocacy.com'),
	),
];
