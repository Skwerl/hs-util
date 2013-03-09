<?php

/*//// PREPARE INPUT /////////////////////////////////////////////////////////////////////////////*/

$postdata = file_get_contents("php://input");

// Simulate a post
#require_once('sample_hl7.php');

$in = explode("\n",$postdata);

$hl7Header->setField(9,$type_string);

$msg =& new Net_HL7_Message(null,$hl7Globals);
$msg->addSegment($hl7Header);

$header = array_shift($in);

foreach ($in as $segment) {
	$index = 1;
	$fields = explode('|',$segment);
	$seg_key = array_shift($fields);
	$seg_obj = new Net_HL7_Segment($seg_key);
	foreach ($fields as $field) {
		$seg_obj->setField($index,$field); $index++;
	}
	$msg->addSegment($seg_obj);	
}

/*//// PHP OBJECT /////////////////////////////////////////////////////////////////////////////////*/

$obj = array();

/*//// PID SEGMENT ///////////////////////////////////////////////////////////////////////////////*/

$pid = $msg->getSegmentsByName('PID');
$pid = $pid[0];

$name = explode($cs,$pid->getField(4));
$obj['patient']['lastName'] = $name[0];
$obj['patient']['firstName'] = $name[1];

$obj['patient']['externalId'] = $pid->getField(3);
$obj['patient']['dob'] = $pid->getField(7);
$obj['patient']['ssn'] = $pid->getField(16);
$obj['patient']['gender'] = $pid->getField(8);
$obj['patient']['race'] = $pid->getField(10);
$obj['patient']['ethnicity'] = $pid->getField(22);

$addresses = explode($rs,$pid->getField(11));

$obj['patient']['address'] = array();
foreach ($addresses as $address) {
	$address = explode($cs,$address);
	$address_org = array();
	$address_org['address1'] = $address[0]; 	
	$address_org['address2'] = $address[1]; 	
	$address_org['city'] = $address[2]; 	
	$address_org['state'] = $address[3]; 	
	$address_org['zip'] = $address[4]; 	
	$obj['patient']['address'][] = $address_org;
}

// We'll need to handle country code...
$countries = explode($rs,$pid->getField(12));

if ($pid->getField(13)) {
	$obj['patient']['phone'][] = array(
		'areaCode' => substr($number,1,3),
		'prefix' => substr($number,5,3),
		'suffix' => substr($number,9,4),
		'type' => 'HOME',	
	);
}
if ($pid->getField(14)) {

	$number = $pid->getField(14);
	$obj['patient']['phone'][] = array(
		'areaCode' => substr($number,1,3),
		'prefix' => substr($number,5,3),
		'suffix' => substr($number,9,4),
		'type' => 'OFFICE'
	);
}

/*//// PV1 SEGMENT ///////////////////////////////////////////////////////////////////////////////*/

$pv1 = $msg->getSegmentsByName('PV1');

foreach ($pv1 as $soap) {
	$obj['soapNote'][] = array(
		'subjective' => array(
			'appointmentDate' => $soap->getField(26)
		)
	);
}

/*//// DG1 SEGMENT ///////////////////////////////////////////////////////////////////////////////*/

$dg1 = $msg->getSegmentsByName('DG1');

foreach ($dg1 as $problem) {
	$code = explode($cs,$problem->getField(4));
	$obj['problem'][] = array(
		'icd9' => array(
			'code' => $code[0],
			'desc' => $code[1]
		),
		'problemStartedAt' => $problem->getField(5)
	);
}

/*//// RXD SEGMENT ///////////////////////////////////////////////////////////////////////////////*/

$rxd = $msg->getSegmentsByName('RXD');

foreach ($rxd as $prescription) {

	$drug = explode($cs,$prescription->getField(2));

	$obj['medicationProfile']['medication']['patientPrescription'][] = array(
		'prescribe' => array(
			'sig' => array(
				'drug' => array(
					'ndcid' => $drug[0],
					'brandName' => $drug[1],
					'form' => $prescription->getField(6),
				),
				'quantity' => $prescription->getField(4),
				'quantityUnits' => $prescription->getField(5),
				'writtenDate' => $problem->getField(3)
			)
		)
	);
}

/*//// AL1 SEGMENT ///////////////////////////////////////////////////////////////////////////////*/

$al1 = $msg->getSegmentsByName('AL1');

foreach ($al1 as $allergy) {
	$code = explode($cs,$allergy->getField(3));
	$obj['allergy'][] = array(
		'ndcidCode' => $code[0],
		'name' => $code[1],
		'allergicReaction' => $allergy->getField(5),
		'allergicReactionDate' => $allergy->getField(6)
	);
}

/*//// RXA SEGMENT ///////////////////////////////////////////////////////////////////////////////*/

$rxa = $msg->getSegmentsByName('RXA');

foreach ($rxa as $immunization) {
	$code = explode($cs,$immunization->getField(5));
	$obj['immunization'][] = array(
		'cvxCode' => $code[0],
		'vaccine' => $code[1],
		'activityTime' => $immunization->getField(3),
		'administeredAmount' => $immunization->getField(6),
		'administeredUnit' => $immunization->getField(7),
		'notes' => $immunization->getField(9)
	);
}

/*//// IN1 SEGMENT ///////////////////////////////////////////////////////////////////////////////*/

$in1 = $msg->getSegmentsByName('IN1');

foreach ($in1 as $insurance) {
	$obj['patient']['insurance'][] = array(
		'name' => $insurance->getField(4),
		'carrierPayerId' => $insurance->getField(49)
	);
}

/*//// OUTPUT MESSAGE ////////////////////////////////////////////////////////////////////////////*/

echo json_encode($obj); ?>