<?php

date_default_timezone_set('America/Los_Angeles');

$allGlobals['VENDOR'] = 'HealthSymmetric, Inc.';
$allGlobals['APPLICATION'] = 'SocialCare Connect';
$allGlobals['BINARY_ID'] = '000';
$allGlobals['VERSION'] = '0.1';

if ($translate_context == 'ccd') {
	
	$XMLGlobals = Array();
	$XMLGlobals['XSI'] = 'http://www.w3.org/2001/XMLSchema-instance';
	$XMLGlobals['XSD'] = 'http://xreg2.nist.gov:8080/hitspValidation/schema/cdar2c32/infrastructure/cda/C32_CDA.xsd';
	$XMLGlobals['XSCHEMA'] = 'urn:hl7-org:v3';
	$XMLGlobals['languageCode'] = 'en-US';

}

if ($translate_context == 'hl7') {

	//$lib_path = 'Net/'; // Load via PEAR
	$lib_path = '/var/www/vhosts/reyinteractive.com/dev1/hsutil/lib/';
	
	require_once $lib_path.'HL7.php';
	require_once $lib_path.'HL7/Message.php';
	require_once $lib_path.'HL7/Segment.php';
	require_once $lib_path.'HL7/Segments/MSH.php';

	if (!isset($hl7Globals['HL7_VERSION'])) {
		$hl7Globals['HL7_VERSION'] = '2.3.1';
	}
	$hl7Globals['FIELD_SEPARATOR'] = '|';
	$hl7Globals['COMPONENT_SEPARATOR'] = '^';
	$hl7Globals['REPETITION_SEPARATOR'] = '~';
	$hl7Globals['ESCAPE_CHARACTER'] = '\\';
	$hl7Globals['SUBCOMPONENT_SEPARATOR'] = '&';
	
	$hl7Header =& new Net_HL7_Segments_MSH(null,$hl7Globals);
	$hl7Header->setField(3, $allGlobals['APPLICATION']);
	$hl7Header->setField(4, $allGlobals['VENDOR']);
	$hl7Header->setField(11, 'T');
	
	$cs = $hl7Globals['COMPONENT_SEPARATOR'];
	$rs = $hl7Globals['REPETITION_SEPARATOR'];

}

require_once './functions.php';

?>