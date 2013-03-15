<?php

/*//// GET MESSAGE TYPE //////////////////////////////////////////////////////////////////////////*/

$request = str_replace("/cmts/", "", $_SERVER['REQUEST_URI']); 
$params = split("/", $request);

$mode = (!empty($params[0]) ? strtolower($params[0]) : 'serialize');
$type = (!empty($params[1]) ? strtoupper($params[1]) : 'ADT');

switch($type) {
	case 'HL7': $default_mvar = '000'; break;
	case 'ADT': $default_mvar = 'A01'; break;
	case 'ORU': $default_mvar = 'R01'; break;
	case 'VXU': $default_mvar = 'V04'; break;
	case 'CCD': $default_mvar = '025'; break;
}
$mvar = (isset($_GET['var']) ? strtoupper($_GET['var']) : $default_mvar);
$type_code = $type.'_'.$mvar;

switch($type_code) {
	case 'ADT_A01': // Admit
	case 'ADT_A02': // Transfer
	case 'ADT_A03': // Discharge
	case 'ADT_A04': // Registration
	case 'ADT_A05': // Pre-Admit
	case 'ADT_A08': // Information Update
	case 'ADT_A11': // Cancel Admit
	case 'ADT_A12': // Cancel Transfer
	case 'ADT_A13': // Cancel Discharge
	case 'ORU_R01': // Observation Report Update
	case 'VXU_V04': // Vaccination Update
	case 'HL7_000': // Undetermined HL7
		$translate_context = 'hl7';
		break;
	case 'CCD_025': // HITSP/C32 v2.5 CCD
		$translate_context = 'ccd';
		break;
}

require_once('globals.php');

if (!isset($cs)) { $cs = '^'; } 
$type_string = $type.$cs.$mvar.$cs.$type_code;

$segments = array('MSH');
switch($type) {
	case 'ADT':
		array_push($segments,
			'EVN',
			'PID',
			'PV1',
			'OBX',
			'AL1',
			'DG1'
		);
		break;
	case 'ORU':
		array_push($segments,
			'SFT',			
			'PID',
			'NTE',
			'PV1',
			'SPM',
			'ORC',
			'OBR',
			'OBX'
		);
		break;
	case 'VXU':
		array_push($segments,
			'PID',
			'PV1',
			'ORC',
			'RXA',
			'RXR'
		);
		break;
}

if (!empty($translate_context)) {
	switch($mode) {
		case 'serialize': include_once($translate_context.'_serialize.php'); break;
		case 'deserialize': include_once($translate_context.'_deserialize.php'); break;
	}
} else {
	die('No translation context provided.');
}

?>