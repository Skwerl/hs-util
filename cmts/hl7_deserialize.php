<?php

/*//// PREPARE INPUT & OUTPUT ////////////////////////////////////////////////////////////////////*/

$postdata = file_get_contents("php://input");
$postdata = str_replace("\r","\n",trim($postdata));
$postdata = preg_replace("/[\n]+/", "\n", $postdata);

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

/*//// PROVIDE META //////////////////////////////////////////////////////////////////////////////*/

/*
$obj['meta']['transformationFormat'] = $type;
$obj['meta']['transformationFormatType'] = $mvar;
$obj['meta']['transformationFormatCode'] = $type_code;
$obj['meta']['transformationContext'] = strtoupper($translate_context);
$obj['meta']['transformationMode'] = $mode;
$obj['meta']['hl7Version'] = $hl7Globals['HL7_VERSION'];
*/

/*//// PID SEGMENT ///////////////////////////////////////////////////////////////////////////////*/

$pid = $msg->getSegmentsByName('PID');

if (isset($pid[0])) {

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
	
	if ($pid->getField(11)) {
		$addresses = explode($rs,$pid->getField(11));
		$obj['patient']['address'] = array();
		$addressType = strtoupper($HL7addressTypes[$address[6]]);
		if ($addressType == 'MAILING') { $addressType = 'BILLING'; } // SocialCare uses "BILLING" for HL7 address code M
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
			$address_org['addressType'] = $addressType; 	
			$obj['patient']['address'][] = $address_org;
		}
	}

}

/*//// PV1 SEGMENT ///////////////////////////////////////////////////////////////////////////////*/

$pv1 = $msg->getSegmentsByName('PV1');

foreach ($pv1 as $pv) {
	if ($pv->getField(26)) {
		$obj['soapNote'][] = array(
			'subjective' => array(
				'appointmentDate' => $pv->getField(26)
			)
		);
	}
	$referringDoc = explode($cs,$pv->getField(8));
	if (isset($referringDoc[7])) {
		if (strtoupper(trim($referringDoc[7])) === 'NPI') {
			$obj['user'] = array(
				'renderingNpi' => $referringDoc[0]
			);
		}
	}
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

$lineIndex = 0;
$labIndexer = -1;
$labGroups = array();

foreach ($in as $segPeek) {
	$segType = substr($segPeek,0,3);
	if (strtoupper($segType == 'OBR')) {
		$labIndexer++;
		$labGroups[$labIndexer]['OBR'] = $lineIndex; 
		$currentObx = -1;
	}
	if (strtoupper($segType == 'SPM')) {
		$labGroups[$labIndexer]['SPM'] = $lineIndex; 
	}
	if (strtoupper($segType == 'OBX')) {
		$currentObx++;
		$labGroups[$labIndexer]['OBX'][$currentObx]['OBX'] = $lineIndex;
	}
	if (strtoupper($segType == 'NTE')) {
		$labGroups[$labIndexer]['OBX'][$currentObx]['NTE'][] = $lineIndex; 
	}
	$lineIndex++;
}

$obr = $msg->getSegmentsByName('OBR');
$obx = $msg->getSegmentsByName('OBX');

if (!empty($obr) && !empty($obx)) {

	$labsIndex = 0;

	foreach ($labGroups as $labGroup) {

		$order = $msg->getSegmentByIndex($labGroup['OBR']+1);
		if (!empty($order)) {
			$orderMeta = explode($cs,$order->getField(4));
			$orderCode = $orderMeta[0];
			$orderName = $orderMeta[1];
			$orderType = '';
			$orderType = $order->getField(13);
			$specimenReceived = trim($order->getField(14));
			$resultsReceived = trim($order->getField(22));
			if (!empty($resultsReceived)) {
				$orderResultDate = date('Y-m-d', strtotime($resultsReceived));
			}
			if (empty($resultsReceived) && !empty($specimenReceived)) {
				$orderResultDate = date('Y-m-d', strtotime($specimenReceived));
			}
		}

		$specName = '';
		$specCond = '';
		@$specimen = $msg->getSegmentByIndex($labGroup['SPM']+1);
		if (!empty($specimen)) {
			@$specDesc = explode($cs,$specimen->getField(4));
			@$specName = $specDesc[1];			
			@$specCond = $specimen->getField(24);
		}

		$obj['lab'][$labsIndex] = array(
			'labResult' => array(
				'loincCode' => $orderCode,
				'description' => $orderName,
				'source' => $specName,
				'sourceCondition' => $specCond
			)
		);

		foreach ($labGroup['OBX'] as $result) {

			$lab = $msg->getSegmentByIndex($result['OBX']+1);

			$code = explode($cs,$lab->getField(3));
			$unit = explode($cs,$lab->getField(6));
			$unitOfMeasure = '';
			if (isset($unit[1])) {
				$unitOfMeasure = $unit[1];
			} elseif (isset($unit[0])) {
				$unitOfMeasure = $unit[0];
			}
			$abnormal = (string)$lab->getField(8);
			$abnormalFlags = array_flip($HL7abnormalFlags);
			if (empty($abnormal) || !in_array($abnormal, $abnormalFlags)) {
				$abnormal = 'NULL';
			}
			$labName = $code[1];
			$labIdealResult = $lab->getField(7);
			if (!empty($labIdealResult)) {
				$labName .= ' ('.trim($labIdealResult).')';
			}

			$loincCode = $code[0];

			$resultDate = '';
			if ($obxResultDate = $lab->getField(14)) {
				$resultDate = date('Y-m-d', strtotime($obxResultDate));			
			} elseif (!empty($orderResultDate)) {
				$resultDate = date('Y-m-d', strtotime($orderResultDate));			
			}

			$facilityName = explode($cs,$lab->getField(23));
			$facilityAddress = explode($cs,$lab->getField(24));
			$facilityName = $facilityName[0];

			if (empty($facilityName[0])) {
				$producerID = explode($cs,$lab->getField(15));
				$facilityName = $producerID[1];
			}
			if (empty($facilityAddress[0])) {
				$facilityAddress = array('','','','','');
			}

			$notesArray = array();
			if (isset($result['NTE'])) {
				foreach ($result['NTE'] as $noteSeg) {
					$note = $msg->getSegmentByIndex($noteSeg+1);
					$noteString = trim($note->getField(3));
					if (!empty($noteString)) {
						$notesArray[] = $noteString;					
					}
				}
			}

			$obj['lab'][$labsIndex]['labResult']['labTestResult'][] = array(
				'date' => $resultDate,
				'loincCode' => $loincCode,
				'description' => $labName,
				'value' => $lab->getField(5),
				'unitOfMeasure' => $unitOfMeasure,
				'abnormal' => $abnormal,
				'notes' => $notesArray,
				'facilityName' => @$facilityName,
				'facilityStreetAddress' => @$facilityAddress[0],
				'facilityCity' => @$facilityAddress[2],
				'facilityState' => @$facilityAddress[3],
				'facilityPostalCode' => @$facilityAddress[4]
			);

		}
	
		$labsIndex++;
	
	}

} else {

/*//// ADT OBX SEGMENTs //////////////////////////////////////////////////////////////////////////*/

	$adtobxs = $obx;
	foreach ($adtobxs as $obx) {
		$obxtype = $obx->getField(2);
		if (strtoupper($obxtype) == 'NM') {
			$obj['patient']['ageInYears'] = $obx->getField(5);
		}
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