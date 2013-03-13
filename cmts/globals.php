<?php

date_default_timezone_set('America/Los_Angeles');

if ($translate_context == 'ccd') {
	
	$XMLGlobals = Array();
	$XMLGlobals['HL7_VERSION'] = '2.3.1';

}

if ($translate_context == 'hl7') {

	//$lib_path = 'Net/'; // Load via PEAR
	$lib_path = '/var/www/vhosts/reyinteractive.com/dev1/hsutil/lib/';
	
	require_once $lib_path.'HL7.php';
	require_once $lib_path.'HL7/Message.php';
	require_once $lib_path.'HL7/Segment.php';
	require_once $lib_path.'HL7/Segments/MSH.php';
	
	$hl7Globals = Array();
	$hl7Globals['HL7_VERSION'] = '2.3.1';
	$hl7Globals['FIELD_SEPARATOR'] = '|';
	$hl7Globals['COMPONENT_SEPARATOR'] = '^';
	$hl7Globals['REPETITION_SEPARATOR'] = '~';
	$hl7Globals['ESCAPE_CHARACTER'] = '\\';
	$hl7Globals['SUBCOMPONENT_SEPARATOR'] = '&';
	
	$hl7Header =& new Net_HL7_Segments_MSH(null,$hl7Globals);
	$hl7Header->setField(3, 'SocialCare Connect');
	$hl7Header->setField(4, 'HealthSymmetric, Inc.');
	$hl7Header->setField(11, 'T');
	
	$cs = $hl7Globals['COMPONENT_SEPARATOR'];
	$rs = $hl7Globals['REPETITION_SEPARATOR'];

}

require_once './functions.php';

?>