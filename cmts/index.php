<?php

require_once('globals.php');

/*//// GET MESSAGE TYPE //////////////////////////////////////////////////////////////////////////*/

$request = str_replace("/cmts/", "", $_SERVER['REQUEST_URI']); 
$params = split("/", $request);

$mode = (!empty($params[0]) ? strtolower($params[0]) : 'serialize');
$type = (!empty($params[1]) ? strtoupper($params[1]) : 'ADT');
switch($type) {
	case 'ADT': $default_mvar = 'A01'; break;
	case 'ORU': $default_mvar = 'R01'; break;
	case 'VXU': $default_mvar = 'V04'; break;
}
$mvar = (isset($_GET['var']) ? strtoupper($_GET['var']) : $default_mvar);
$type_code = $type.'-'.$mvar;

switch($type_code) {
	case 'ADT-A01': // Admit
	case 'ADT-A02': // Transfer
	case 'ADT-A03': // Discharge
	case 'ADT-A04': // Registration
	case 'ADT-A05': // Pre-Admit
	case 'ADT-A08': // Information Update
	case 'ADT-A11': // Cancel Admit
	case 'ADT-A12': // Cancel Transfer
	case 'ADT-A13': // Cancel Discharge
	case 'ORU-R01': // Observation Report Update
	case 'VXU-V04': // Vaccination Update
		$type_string = $type.$cs.$mvar.$cs.$type_code;
		break;
}

switch($mode) {
	case 'serialize': include_once('serialize.php'); break;
	case 'deserialize': include_once('deserialize.php'); break;
}

?>