<?php

/*//// PREPARE INPUT & OUTPUT ////////////////////////////////////////////////////////////////////*/

$postdata = file_get_contents("php://input");

// Simulate a post
#require_once('sample_hl7.php');

if (empty($postdata)) { die('No input.'); }
$in = explode("\n",$postdata);

if ($type_code == 'ORU_R01') {
	$hl7Globals['HL7_VERSION'] = '2.5.1';
} else {
	$hl7Globals['HL7_VERSION'] = '2.3.1';
}

$hl7Header =& new Net_HL7_Segments_MSH(null,$hl7Globals);

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

$obj = array();

/*//// PID SEGMENT ///////////////////////////////////////////////////////////////////////////////*/

$pid = $msg->getSegmentsByName('PID');
$pid = $pid[0];

$name = explode($cs,$pid->getField(5));
$obj['patient']['lastName'] = $name[0];
$obj['patient']['firstName'] = $name[1];

$guid = array_shift(explode($cs,$pid->getField(3)));
$obj['patient']['externalId'] = $guid;
$obj['patient']['dob'] = $pid->getField(7);
$obj['patient']['ssn'] = $pid->getField(19);
$obj['patient']['gender'] = $pid->getField(8);

$codedRace = explode($cs,$pid->getField(10));
$obj['patient']['race'] = $codedRace[0];

$codedEthnicity = explode($cs,$pid->getField(22));
$obj['patient']['ethnicity'] = $codedEthnicity[0];

$phone_org = array();
if ($pid->getField(13)) {
	$number = explode($cs,$pid->getField(13));
	$phone_org[] = array(
		'areaCode' => $number[5],
		'prefix' => substr($number[6],0,3),
		'suffix' => substr($number[6],3,4),
		'type' => 'HOME',	
	);
}
if ($pid->getField(14)) {
	$number = explode($cs,$pid->getField(14));
	$phone_org[] = array(
		'areaCode' => $number[5],
		'prefix' => substr($number[6],0,3),
		'suffix' => substr($number[6],3,4),
		'type' => 'OFFICE'
	);
}

$addresses = explode($rs,$pid->getField(11));
$obj['patient']['address'] = array();
foreach ($addresses as $address) {
	$address = explode($cs,$address);
	$address_org = array();
	$address_org['address1'] = $address[0]; 	
	$address_org['address2'] = $address[1]; 	
	$address_org['city'] = $address[2]; 	
	$address_org['state'] = $address[3]; 	
	$address_org['postalCode'] = $address[4]; 	
	$address_org['countryCode'] = $address[5]; 	
	$address_org['phone'] = $phone_org; 	
	$obj['patient']['address'][] = $address_org;
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

/*//// AL1 SEGMENT ///////////////////////////////////////////////////////////////////////////////*/

$al1 = $msg->getSegmentsByName('AL1');

foreach ($al1 as $allergy) {
	$code = explode($cs,$allergy->getField(3));
	$obj['allergy'][] = array(
		'name' => $code[1],
		'snomed' => $code[0],
		'allergicReaction' => $allergy->getField(5),
		'allergicReactionDate' => $allergy->getField(6)
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
$medicationsIndex = 0;

foreach ($rxd as $prescription) {

	$drug = explode($cs,$prescription->getField(2));
	$drugDate = $prescription->getField(3);

	$obj['medication'][$medicationsIndex]['drug'] = array(
		'brandName' => $drug[1],
		'form' => $prescription->getField(6),
		'rxNormId' => $drug[0]
	);

	$obj['medication'][$medicationsIndex]['patientPrescription'][] = array('prescribe' => array('sig' => array(
		'drug' => array(
			'brandName' => $drug[1],
			'form' => $prescription->getField(6),
			'rxNormId' => $drug[0]
		),
		'quantity' => $prescription->getField(4),
		'quantityUnits' => $prescription->getField(5),
		'writtenDate' => date('c',strtotime($drugDate))
	)),
	'createdAt' => date('c',strtotime($drugDate))
	);
	
	$medicationsIndex++;
	
}

/*//// RXA SEGMENT ///////////////////////////////////////////////////////////////////////////////*/

$rxa = $msg->getSegmentsByName('RXA');

foreach ($rxa as $immunization) {
	$code = explode($cs,$immunization->getField(5));
	$unit = array_shift(explode($cs,$immunization->getField(7)));
	$obj['immunization'][] = array(
		'cvxCode' => $code[0],
		'vaccine' => $code[1],
		'activityTime' => $immunization->getField(3),
		'administeredAmount' => $immunization->getField(6),
		'administeredUnit' => $unit,
		'notes' => $immunization->getField(9)
	);
}

/*//// OBX SEGMENT ///////////////////////////////////////////////////////////////////////////////*/

$obr = $msg->getSegmentsByName('OBR');
$obrs = array();
foreach ($obr as $ord) {
	$obrs[$ord->getField(1)] = $ord;
}

$obx = $msg->getSegmentsByName('OBX');
$obxs = array();
foreach ($obx as $lab) {
	$obxs[$lab->getField(1)][] = $lab;
}

$segmentCount = 1;
$obxIndexes = array();
$spmIndexes = array();

foreach ($in as $segment) {
	if (strtoupper(substr($segment,0,3)) == 'OBX') {
		$obxIndexes[] = $segmentCount;
	}
	if (strtoupper(substr($segment,0,3)) == 'SPM') {
		$spmIndexes[] = $segmentCount;
	}
	$segmentCount++;
}

$obxIndex = array_shift($obxIndexes);
$spmIndex = array_shift($spmIndexes);

if (!empty($obr) && !empty($obx)) {
	$labsIndex = 0;
	foreach ($obxs as $index => $labs) {
		foreach ($labs as $lab) { // Yes, I know this is redundant...
			$order = $obrs[$index];
			$code = explode($cs,$lab->getField(3));
			$labName = explode($cs,$lab->getField(23));
			$labAddress = explode($cs,$lab->getField(24));
			$obj['lab'][$labsIndex] = array(
				'labResult' => array(
					'loincCode' => $code[0],
					'facilityName' => $labName[0],
					'facilityStreetAddress' => $labAddress[0],
					'facilityCity' => $labAddress[2],
					'facilityState' => $labAddress[3],
					'facilityPostalCode' => $labAddress[4],
				)
			);
		}
		foreach ($labs as $lab) {
			if ($obxIndex > $spmIndex) {
				$spmIndex = array_shift($spmIndexes);
			}
			$spm = $msg->getSegmentByIndex($spmIndex);
			$specimen = explode($cs,$spm->getField(4));
		
			$code = explode($cs,$lab->getField(3));
			$source = explode($cs,$lab->getField(4));
			$unit = explode($cs,$lab->getField(6));
			$abnormal = (string)$lab->getField(8);
			$abnormalFlags = array_flip($HL7abnormalFlags);
			if (empty($abnormal) || !in_array($abnormal, $abnormalFlags)) {
				$abnormal = 'NULL';
			}
			$labName = $code[1];
			$labIdealResult = $lab->getField(7);
			if (!empty($labIdealResult)) {
				$labName .= ' ('.$labIdealResult.')';
			}
			$obj['lab'][$labsIndex]['labResult']['labTestResult'][] = array(
				'date' => date('Y-m-d', strtotime($lab->getField(14))),
				'type' => $order->getField(13),
				'name' => $labName,
				'value' => $lab->getField(5),
				'unitOfMeasure' => $unit[1],
				'source' => $specimen[1],
				'condition' => $spm->getField(24),
				'abnormal' => $abnormal
			);
			$obxIndex = array_shift($obxIndexes);
		}
		$labsIndex++;
	}
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