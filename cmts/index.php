<?php

require_once('globals.php');

/*//// PREPARE INPUT /////////////////////////////////////////////////////////////////////////////*/

$postdata = file_get_contents("php://input");
$cleaned = preg_replace("!\s+!m",' ',urldecode($postdata));
$posted_obj = json_decode($cleaned); 

// Simulate a post
require_once('sample_post.php');

$in = $posted_obj;

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

/*//// MSH SEGMENT ///////////////////////////////////////////////////////////////////////////////*/

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

$hl7Header->setField(9, $type_string);

$msg =& new Net_HL7_Message(null, $hl7Globals);
$msg->addSegment($hl7Header);

/*//// PID SEGMENT ///////////////////////////////////////////////////////////////////////////////*/

$pid = new Net_HL7_Segment('PID');
$pid->setField(3, $in->patient->externalId);
$pid->setField(4, implode($cs, array($in->patient->lastName,$in->patient->firstName)));
$pid->setField(7, date('Ymd',strtotime($in->patient->dob)));
$pid->setField(16, $in->patient->ssn);
$pid->setField(8, $in->patient->gender);
$pid->setField(10, $in->patient->race);
$pid->setField(22, $in->patient->ethnicity);

$addr_collapsed = array();
$countries = array();
foreach ($in->patient->address as $address) {
	$addr_collapsed[] = implode($cs, array(
		$address->address1,
		$address->address2,
		$address->city,
		$address->state,
		$address->postalCode
	));
	$countries[] = $address->countryCode;
}
$pid->setField(11, implode($rs,$addr_collapsed));
$pid->setField(12, implode($rs,array_unique($countries)));

foreach ($in->patient->phone as $ph) {
	if ($ph->type == 'HOME') { $pid->setField(13, '('.$ph->areaCode.')'.$ph->prefix.'-'.$ph->suffix); }
	if ($ph->type == 'OFFICE') { $pid->setField(14, '('.$ph->areaCode.')'.$ph->prefix.'-'.$ph->suffix); }
}

$msg->addSegment($pid);

/*//// PV1 SEGMENTS //////////////////////////////////////////////////////////////////////////////*/

foreach ($in->soapNote as $soap) {
	$pv1 = new Net_HL7_Segment('PV1');
	$pv1->setField(2, 'O');
	$pv1->setField(26, date('YmdHis',strtotime($soap->subjective->appointmentDate)));
	$msg->addSegment($pv1);
}

/*//// OUTPUT MESSAGE ////////////////////////////////////////////////////////////////////////////*/

$output = $msg->toString(1);

echo $output; ?>