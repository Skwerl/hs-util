<?php

/*//// PREPARE INPUT /////////////////////////////////////////////////////////////////////////////*/

$postdata = file_get_contents("php://input");
$cleaned = preg_replace("!\s+!m",' ',urldecode($postdata));
$posted_obj = json_decode($cleaned); 

// Simulate a post
#require_once('sample_post.php');

$in = $posted_obj;

/*//// GET PRACTICE DETAILS //////////////////////////////////////////////////////////////////////*/

$practice_address = $in->practice->address[0];
$practice_phone = $in->practice->address[0]->phone[0];

/*//// MSH SEGMENT ///////////////////////////////////////////////////////////////////////////////*/

if ($type_code == 'ORU_R01') {
	$hl7Globals['HL7_VERSION'] = '2.5.1';
	$pid3 = $in->patient->ssn.$cs.$cs.$cs.'MPI'.$ss.'2.16.840.1.113883.19.3.2.1'.$ss.'ISO'.$cs.'MR';
} else {
	$hl7Globals['HL7_VERSION'] = '2.3.1';
	$pid3 = $in->patient->ssn.$cs.$cs.$cs.$cs.'SS';
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

/*//// EVN SEGMENT ///////////////////////////////////////////////////////////////////////////////*/

if (in_array('EVN',$segments)) {
	$evn = new Net_HL7_Segment('EVN');
	$evn->setField(1, $mvar);
	$evn->setField(2, date('YmdHis'));
	$evn->setField(6, 'PH Facility'.$cs.$in->user->groupNpi.$cs.'NPI');
	$msg->addSegment($evn);
}

/*//// PID SEGMENT ///////////////////////////////////////////////////////////////////////////////*/

if (in_array('PID',$segments)) {

	if (isset($HL7raceCodes[$in->patient->race])) {
		$codedRace = $in->patient->race.$cs.$HL7raceCodes[$in->patient->race].$cs.'HL70005';
	} else {
		$codedRace = 'U'.$cs.$HL7raceCodes['U'].$cs.'HL70005';
	}

	if (isset($HL7ethnicityCodes[$in->patient->ethnicity])) {
		$codedEthnicity = $in->patient->ethnicity.$cs.$HL7ethnicityCodes[$in->patient->ethnicity].$cs.'HL70189';
	} else {
		$codedEthnicity = 'U'.$cs.$HL7ethnicityCodes['U'].$cs.'HL70005';
	}

	$pid = new Net_HL7_Segment('PID');
	$pid->setField(3, $pid3);
	$pid->setField(5, implode($cs, array(
		$in->patient->lastName,
		$in->patient->firstName,
		'','','','','L'
	)));
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
		$officeFound = false;
		foreach ($address->phone as $ph) {
			if ($ph->type == 'MOBILE') {
				$pid->setField(13, $cs.'ORN'.$cs.$cs.$cs.$cs.$ph->areaCode.$cs.$ph->prefix.$ph->suffix);
			}
			if ($ph->type == 'OFFICE') {
				$officeFound = true;
				$pid->setField(14, $cs.'WPN'.$cs.$cs.$cs.$cs.$ph->areaCode.$cs.$ph->prefix.$ph->suffix);
			}
			if (($ph->type == 'FAX') && ($officeFound == false)) {
				$pid->setField(14, $cs.'NET'.$cs.$cs.$cs.$cs.$ph->areaCode.$cs.$ph->prefix.$ph->suffix);
			}
		}
		$countries[] = $address->countryCode;
	}
	$pid->setField(11, implode($rs,$addr_collapsed));
	$pid->setField(12, implode($rs,array_unique($countries)));
		
	$msg->addSegment($pid);

}

/*//// PV1 SEGMENT ///////////////////////////////////////////////////////////////////////////////*/

if ($type == 'ORU') {

	$pv1 = new Net_HL7_Segment('PV1');
	if (!empty($in->user->renderingNpi)) {
		$pv1->setField(8, implode($cs,array($in->user->renderingNpi,'','','','','','','NPI')));
	}
	$msg->addSegment($pv1);

} else {

	if (in_array('PV1',$segments)) {
		$visitNumber = 1;
		foreach ($in->soapNote as $soap) {
			$pv1 = new Net_HL7_Segment('PV1');
			$pv1->setField(2, 'O');
			$pv1->setField(19, $visitNumber);
			$pv1->setField(26, date('YmdHis',strtotime($soap->createdAt)));
			$pv1->setField(50, implode($cs,array($soap->identity,'','','','MR')));
			$msg->addSegment($pv1);
			$visitNumber++;
		}
	}

}

/*//// ADT OBX SEGMENTS //////////////////////////////////////////////////////////////////////////*/

if ($type == 'ADT') {

	# OBX SEGMENT FOR NPI
	$obx = new Net_HL7_Segment('OBX');
	$obx->setField(1, 1);
	$obx->setField(2, 'HD');
	$obx->setField(3, 'EHR Facility^2.16.840.1.113883.3.72.7.2^HL7');
	$obx->setField(5, 'PH Facility'.$cs.$in->user->groupNpi.$cs.'NPI');
	$obx->setField(11, 'F');	
	$obx->setField(14, date('YmdHis'));
	$msg->addSegment($obx);

	# OBX SEGMENT FOR AGE
	$obx = new Net_HL7_Segment('OBX');
	$obx->setField(1, 2);
	$obx->setField(2, 'NM');
	$obx->setField(3, implode($cs,array(
		'21612-7',
		'Reported Patient Age',
		'LN'
	)));
	$obx->setField(5, $in->patient->ageInYears);
	$obx->setField(6, implode($cs,array(
		'a',
		'year',
		'ANS+'
	)));
	$obx->setField(11, 'F');	
	$msg->addSegment($obx);

} else {

/*//// SET UP ORC, OBR, OBX, SPM SEGMENTS (ORU) //////////////////////////////////////////////////*/

	$obrIndex = 1;
	$obxIndex = 1;
	$spmIndex = 1;
	$nteIndex = 1;
	
	foreach ($in->lab as $lab) {
	
		$results = $lab->labResult;
		$specimens = array();
	
/*//// ORC & OBR SEGMENTs ////////////////////////////////////////////////////////////////////////*/
	
		$orc = new Net_HL7_Segment('ORC');
		$orc->setField(1, 'RE');
	
		$orc->setField(12, '1234'.$cs.'Admit'.$cs.'Alan'.$cs.$cs.$cs.$cs.$cs.$cs.$in->organization.$ss.'2.16.840.1.113883.19.4.6'.$ss.'ISO');
		$orc->setField(24, implode($cs, array(
			$practice_address->address1,
			$practice_address->address2,
			$practice_address->city,
			$practice_address->state,
			$practice_address->postalCode,
			$practice_address->countryCode,
			'B'
		)));
	
		$orc->setField(21, 'Lab Organization'.$cs.'L'.$cs.$cs.$cs.$cs.$results->facilityName.$ss.'2.16.840.1.113883.19.4.6'.$ss.'ISO'.$cs.'XX'.$cs.$cs.$cs.'1234');
		$orc->setField(22, $results->facilityStreetAddress.$cs.$cs.$results->facilityCity.$cs.$results->facilityState.$cs.$results->facilityPostalCode.$cs.$cs.'B');
		$orc->setField(23, $cs.$cs.$cs.$cs.$cs.$practice_phone->areaCode.$cs.$practice_phone->prefix.$practice_phone->suffix);
	
		if (in_array('ORC',$segments)) {
			$msg->addSegment($orc);
		}

		$obr = new Net_HL7_Segment('OBR');
		$obr->setField(1, $obrIndex);
		$obr->setField(3, '9700123^Lab^2.16.840.1.113883.19.3.1.6^ISO');
		$obr->setField(4, $results->loincCode.$cs.$results->description.$cs.'LN'.$cs.'3456543'.$cs.'Alternate Description'.$cs.'99USI');
		$obr->setField(16, '1234'.$cs.'Admit'.$cs.'Alan'.$cs.$cs.$cs.$cs.$cs.$cs.$in->organization.$ss.'2.16.840.1.113883.19.4.6'.$ss.'ISO');
		$obr->setField(7, date('YmdHis'));
		$obr->setField(22, date('YmdHis'));
		$obr->setField(13, $result->type);
		$obr->setField(31, '787.91^DIARRHEA^I9CDX~780.6^Fever^I9CDX~786.2^Cough^I9CDX');
		$obr->setField(25, 'F');
		$obrIndex++;
	
		if (in_array('OBR',$segments)) {
			$msg->addSegment($obr);
		}
		
/*//// OBX & NTE SEGMENTS ////////////////////////////////////////////////////////////////////////*/
	
		$subId = 1; foreach ($results->labTestResult as $result) {
	
			$abnormal = (string)$result->abnormal;
			$abnormal_flags = array_flip($HL7abnormalFlags);
			if (empty($abnormal) || !in_array($abnormal, $abnormal_flags)) {
				$abnormal = 'NULL';
			}
			$nameParts = splitLabDescription($result->description);
			$resultDescription = $nameParts['resultDescription'];
			$resultIdealRange = $nameParts['resultIdealRange'];
	
			$obx = new Net_HL7_Segment('OBX');
			$obx->setField(1, $obxIndex);
			$obx->setField(2, (is_numeric($result->value) ? 'NM' : 'ST'));
			$obx->setField(3, $result->loincCode.$cs.$resultDescription.$cs.'LN');
			$obx->setField(4, $subId);
			$obx->setField(7, $resultIdealRange);
			$obx->setField(5, $result->value);
			$obx->setField(6, $result->unitOfMeasure.$cs.$result->unitOfMeasure.$cs.'ANS+');
			$obx->setField(8, $abnormal);
			$obx->setField(11, 'F');
			$obx->setField(14, date('YmdHis',strtotime($result->date)));
			$obx->setField(15, implode($cs, array('',$result->facilityName)));
			$obx->setField(19, date('YmdHis',strtotime($result->date)));
			$obx->setField(23, $results->facilityName.$cs.'L'.$cs.$cs.$cs.$cs.'CLIA'.$ss.'2.16.840.1.113883.19.4.6'.$ss.'ISO'.$cs.'XX'.$cs.$cs.$cs.'1236');
			$obx->setField(24, implode($cs, array(
				$result->facilityStreetAddress, '',
				$result->facilityCity,
				$result->facilityState,
				$result->facilityPostalCode, '',
				'B'
			)));
			$obxIndex++;

			if (in_array('OBX',$segments)) {
				$msg->addSegment($obx);
			}

			if (in_array('NTE',$segments)) {
				foreach ($result->notes as $note) {
					$nte = new Net_HL7_Segment('NTE');
					$nte->setField(1, $nteIndex);
					$nte->setField(2, 'L');
					$nte->setField(3, $note);
					$nteIndex++;
					$msg->addSegment($nte);
				}
			}

			$nteIndex = 1;

		}

/*//// SPM SEGMENT ///////////////////////////////////////////////////////////////////////////////*/
	
		if (in_array('SPM',$segments)) {
			$spm = new Net_HL7_Segment('SPM');
			$spm->setField(1, $spmIndex);
			$spm->setField(4, implode($cs, array(
				'000',
				$results->source,
				'SCT',
				'Alt ID',
				'Alt Text',
				'HL70487',
				'20080131',
				'2.5.1'
			)));
			$spm->setField(24, $results->sourceCondition);
			$spmIndex++;
			$msg->addSegment($spm);
		}

/*////////////////////////////////////////////////////////////////////////////////////////////////*/

		$obxIndex = 1;
		$spmIndex = 1;
	
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