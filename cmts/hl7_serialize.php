<?php

/*//// PREPARE INPUT /////////////////////////////////////////////////////////////////////////////*/

$postdata = file_get_contents("php://input");
$cleaned = preg_replace("!\s+!m",' ',urldecode($postdata));
$posted_obj = json_decode($cleaned); 

// Simulate a post
#require_once('sample_post.php');

$in = $posted_obj;

/*//// MSH SEGMENT ///////////////////////////////////////////////////////////////////////////////*/

if ($type_code == 'ORU_R01') {
	$hl7Globals['HL7_VERSION'] = '2.5.1';
	$pid3 = $in->patient->externalId.$cs.$cs.$cs.'MPI'.$ss.'2.16.840.1.113883.19.3.2.1'.$ss.'ISO'.$cs.'MR';
} else {
	$hl7Globals['HL7_VERSION'] = '2.3.1';
	$pid3 = $in->patient->externalId.$cs.$cs.$cs.$cs.'MPI';
}

$hl7Header =& new Net_HL7_Segments_MSH(null,$hl7Globals);

$hl7Header->setField(3, 'EHR Application^2.16.840.1.113883.3.72.7.1^HL7');
$hl7Header->setField(4, 'EHR Facility^2.16.840.1.113883.3.72.7.2^HL7');
$hl7Header->setField(5, 'PH Application^2.16.840.1.113883.3.72.7.3^HL7');
$hl7Header->setField(6, 'PH Facility^2.16.840.1.113883.3.72.7.4^HL7');
$hl7Header->setField(21, 'PHLabReport-Ack^^2.16.840.1.114222.4.10.3^ISO');

$hl7Header->setField(9, $type_string);
$hl7Header->setField(11, 'T');

$msg =& new Net_HL7_Message(null, $hl7Globals);
$msg->addSegment($hl7Header);

/*//// SFT SEGMENT ///////////////////////////////////////////////////////////////////////////////*/

if (in_array('SFT',$segments)) {
	$sft = new Net_HL7_Segment('SFT');
	$sft->setField(1, $allGlobals['VENDOR']);
	$sft->setField(2, $allGlobals['VERSION']);
	$sft->setField(3, $allGlobals['APPLICATION']);
	$sft->setField(4, $allGlobals['BINARY_ID']);
	$sft->setField(6, $allGlobals['INSTALL_DATE']);
	$msg->addSegment($sft);
}

/*//// PID SEGMENT ///////////////////////////////////////////////////////////////////////////////*/

if (in_array('PID',$segments)) {

	$HL7raceCodes = array(
		'A' => 'Asian or Pacific Islander',
		'B' => 'Black or African-American',
		'H' => 'Hispanic',
		'I' => 'American Indian or Alaska Native',
		'O' => 'Other',
		'U' => 'Unknown',
		'W' => 'White'
	);
	if (isset($HL7raceCodes[$in->patient->race])) {
		$codedRace = $in->patient->race.$cs.$HL7raceCodes[$in->patient->race].$cs.'HL70005';
	} else {
		$codedRace = 'U'.$cs.$HL7raceCodes['U'].$cs.'HL70005';
	}

	$HL7ethnicityCodes = array(
		'H' => 'Hispanic or Latino',
		'N' => 'not Hispanic or Latino',
		'NH' => 'not Hispanic or Latino',
		'U' => 'Unknown'
	);
	if (isset($HL7ethnicityCodes[$in->patient->ethnicity])) {
		$codedEthnicity = $in->patient->ethnicity.$cs.$HL7ethnicityCodes[$in->patient->ethnicity].$cs.'HL70189';
	} else {
		$codedEthnicity = 'U'.$cs.$HL7ethnicityCodes['U'].$cs.'HL70005';
	}

	$pid = new Net_HL7_Segment('PID');
	$pid->setField(3, $pid3);
	$pid->setField(5, implode($cs, array($in->patient->lastName,$in->patient->firstName)));
	$pid->setField(7, date('Ymd',strtotime($in->patient->dob)));
	$pid->setField(8, $in->patient->gender);
	$pid->setField(19, $in->patient->ssn);
	$pid->setField(10, $codedRace);
	$pid->setField(22, $codedEthnicity);
	
	$addr_collapsed = array();
	$countries = array();
	foreach ($in->patient->address as $address) {
		$addr_collapsed[] = implode($cs, array(
			$address->address1,
			$address->address2,
			$address->city,
			$address->state,
			$address->postalCode,
			$address->countryCode,
			'M'
		));
		foreach ($address->phone as $ph) {
			// First populate field 13 with whatever there is:
			$pid->setField(13, $cs.'PRN'.$cs.$cs.$cs.$cs.$ph->areaCode.$cs.$ph->prefix.$ph->suffix);
			// Then categorize corectly by type if possible:
			if ($ph->type == 'HOME') { $pid->setField(13, $cs.'PRN'.$cs.$cs.$cs.$cs.$ph->areaCode.$cs.$ph->prefix.$ph->suffix); }
			if ($ph->type == 'OFFICE') { $pid->setField(14, $cs.'WPN'.$cs.$cs.$cs.$cs.$ph->areaCode.$cs.$ph->prefix.$ph->suffix); }
		}
		$countries[] = $address->countryCode;
	}
	$pid->setField(11, implode($rs,$addr_collapsed));
	$pid->setField(12, implode($rs,array_unique($countries)));
		
	$msg->addSegment($pid);

}

/*//// PV1 SEGMENT ///////////////////////////////////////////////////////////////////////////////*/

if (in_array('PV1',$segments)) {
	foreach ($in->soapNote as $soap) {
		$pv1 = new Net_HL7_Segment('PV1');
		$pv1->setField(2, 'O');
		$pv1->setField(26, date('YmdHis',strtotime($soap->subjective->appointmentDate)));
		$msg->addSegment($pv1);
	}
}

/*//// AL1 SEGMENT ///////////////////////////////////////////////////////////////////////////////*/

if (in_array('AL1',$segments)) {
	foreach ($in->allergy as $allergy) {
		$al1 = new Net_HL7_Segment('AL1');
		$al1->setField(3, $allergy->snomed.$cs.$allergy->name.$cs.'SNOMED');
		$al1->setField(5, $allergy->allergicReaction);
		$al1->setField(6, date('YmdHis',strtotime($allergy->allergicReactionDate)));
		$msg->addSegment($al1);
	}
}

/*//// DG1 SEGMENT ///////////////////////////////////////////////////////////////////////////////*/

if (in_array('DG1',$segments)) {
	foreach ($in->problem as $problem) {
		$dg1 = new Net_HL7_Segment('DG1');
		$dg1->setField(4, $problem->icd9->code.$cs.$problem->icd9->desc);
		$dg1->setField(5, date('YmdHis',strtotime($problem->problemStartedAt)));
		$msg->addSegment($dg1);
	}
}

/*//// RXD SEGMENT ///////////////////////////////////////////////////////////////////////////////*/

if (in_array('RXD',$segments)) {
	foreach ($in->medication as $medication) {
		foreach ($medication->patientPrescription as $prescription) {
			$sig = $prescription->prescribe->sig;
			$rxd = new Net_HL7_Segment('RXD');
			$rxd->setField(2, $sig->drug->ndcid.$cs.$sig->drug->brandName.$cs.'NDC');
			$rxd->setField(3, date('YmdHis',strtotime($sig->writtenDate)));
			$rxd->setField(4, $sig->quantity);
			$rxd->setField(5, $sig->quantityUnits);
			$rxd->setField(6, $sig->drug->form);
			$msg->addSegment($rxd);
		}
	}
}

/*//// RXA SEGMENT ///////////////////////////////////////////////////////////////////////////////*/

if (in_array('RXA',$segments)) {
	foreach ($in->immunization as $immunization) {
		$admin_sub_id = 1;
		$rxa = new Net_HL7_Segment('RXA');
		$rxa->setField(1, 0);
		$rxa->setField(2, $admin_sub_id);
		$rxa->setField(3, date('YmdHis',strtotime($immunization->activityTime)));
		$rxa->setField(4, date('YmdHis',strtotime($immunization->activityTime)));
		$rxa->setField(5, $immunization->cvxCode.$cs.$immunization->vaccine.$cs.'CVX');
		$rxa->setField(6, $immunization->administeredAmount);
		$rxa->setField(7, $immunization->administeredUnit.$cs.$cs.'ANS+');
		$rxa->setField(9, $immunization->notes);
		$msg->addSegment($rxa);
		$admin_sub_id++;
	}
}

/*//// SET UP OBR & OBX SEGMENTS /////////////////////////////////////////////////////////////////*/

$specimens = array();
if (in_array('OBX',$segments)) {
	$setId = 1; foreach ($in->lab as $lab) {
		$results = $lab->labResult;

/*//// OBR SEGMENT ///////////////////////////////////////////////////////////////////////////////*/

		if (in_array('OBR',$segments)) {
			$obr = new Net_HL7_Segment('OBR');
			$obr->setField(1, '1');
			$obr->setField(3, '9700123^Lab^2.16.840.1.113883.19.3.1.6^ISO');
			$obr->setField(4, $results->loincCode.$cs.'Lab Description'.$cs.'LN'.$cs.'3456543'.$cs.'Alternate Description'.$cs.'99USI');
			$obr->setField(16, '1234^Admit^Alan^^^^^^ABC Medical Center&2.16.840.1.113883.19.4.6&ISO');
			$obr->setField(7, date('YmdHis'));
			$obr->setField(22, date('YmdHis'));
			$obr->setField(13, 'Diarrhea');
			$obr->setField(31, '787.91^DIARRHEA^I9CDX');
			$obr->setField(25, 'F');
			$msg->addSegment($obr);
		}

/*//// OBX SEGMENTS //////////////////////////////////////////////////////////////////////////////*/

		$subId = 1; foreach ($results->labTestResult as $result) {
			$specimens[] = $result->source;
			if (!empty($result->abnormal)) { $abnormal = 1; } else { $abnormal = 0; }
			preg_match_all("^\((.*?)\)^",$result->name, $nameParts, PREG_OFFSET_CAPTURE);
			$resultDescription = trim(substr($result->name,0,$nameParts[0][0][1]));
			$resultIdealRange = $nameParts[1][0][0];
			$obx = new Net_HL7_Segment('OBX');
			$obx->setField(1, $setId);
			$obx->setField(2, 'NM');
			$obx->setField(3, $results->loincCode.$cs.$resultDescription.$cs.'LN');
			$obx->setField(4, $subId);
			$obx->setField(7, $resultIdealRange);
			$obx->setField(5, $result->value);
			$obx->setField(6, $result->unitOfMeasure.$cs.$result->unitOfMeasure.$cs.'ANS+');
			$obx->setField(8, $abnormal);
			$obx->setField(11, 'F');
			$obx->setField(14, date('YmdHis',strtotime($result->date)));
			$obx->setField(19, date('YmdHis',strtotime($result->date)));
			$obx->setField(23, $results->facilityName.$cs.'L'.$cs.$cs.$cs.$cs.'CLIA'.$ss.'2.16.840.1.113883.19.4.6'.$ss.'ISO'.$cs.'XX'.$cs.$cs.$cs.'1236');
			$obx->setField(24, implode($cs, array(
				$results->facilityStreetAddress, '',
				$results->facilityCity,
				$results->facilityState,
				$results->facilityPostalCode, '',
				'B'
			)));
			$msg->addSegment($obx);
			$subId++;
		}
		$setId++;
	}
}

/*//// SPM SEGMENT ///////////////////////////////////////////////////////////////////////////////*/

if (in_array('SPM',$segments)) {
	$speciments = array_unique($specimens);
	foreach ($specimens as $specimen) {
		if (!empty($specimen)) {
			$spm = new Net_HL7_Segment('SPM');
			$spm->setField(4, implode($cs, array(
				'000',
				$specimen,
				'SCT',
				'Alt ID',
				'Alt Text',
				'HL70487',
				'20080131',
				'2.5.1'
			)));
			$msg->addSegment($spm);
		}
	}
}

/*//// IN1 SEGMENT ///////////////////////////////////////////////////////////////////////////////*/

if (in_array('IN1',$segments)) {
	foreach ($in->patient->insurance as $insurance) {
		$in1 = new Net_HL7_Segment('IN1');
		$in1->setField(4, $insurance->name);
		$in1->setField(49, $insurance->carrierPayerId);
		$msg->addSegment($in1);
	}
}

/*//// OUTPUT MESSAGE ////////////////////////////////////////////////////////////////////////////*/

$output = $msg->toString(1);

echo $output; ?>