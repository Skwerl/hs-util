<?php

$translate_context = 'ccr';
require_once('globals.php');

/*////////////////////////////////////////////////////////////////////////////////////////////////*/
/*//// PREPARE INPUT & OUTPUT ////////////////////////////////////////////////////////////////////*/
/*////////////////////////////////////////////////////////////////////////////////////////////////*/

$postdata = file_get_contents("php://input");
#$postdata = file_get_contents('sample_ccr.xml');
if (empty($postdata)) { die('No input.'); }

$xml = new SimpleXMLElement($postdata);
$obj = array();

/*////////////////////////////////////////////////////////////////////////////////////////////////*/
/*//// PATIENT DATA //////////////////////////////////////////////////////////////////////////////*/
/*////////////////////////////////////////////////////////////////////////////////////////////////*/

$patientActorIndex = s($xml->Patient->ActorID);
$patientActorData = '';

foreach ($xml->Actors->Actor as $actor) {
	if ($actor->ActorObjectID == $patientActorIndex) {
		$patientActorData = $actor;
		break;
	}
} if (empty($patientActorData)) { die('No patient actor.'); }

$patient = $patientActorData->Person;
$patientAddress = $patientActorData->Address;
$patientPhone = $patientActorData->Telephone;
$socialHistory = $xml->Body->SocialHistory->SocialHistoryElement;

$obj['patient']['lastName'] = s($patient->Name->CurrentName->Given);
$obj['patient']['firstName'] = s($patient->Name->CurrentName->Family);
$obj['patient']['middleName'] = s($patient->Name->CurrentName->Middle);
$obj['patient']['ssn'] = s($patientActorData->IDs->ID);

$obj['patient']['address'][0]['name'] = s($patientAddress->Type->Text);
$obj['patient']['address'][0]['address1'] = s($patientAddress->Line1);
$obj['patient']['address'][0]['address2'] = s($patientAddress->Line2);
$obj['patient']['address'][0]['city'] = s($patientAddress->City);
$obj['patient']['address'][0]['state'] = s($patientAddress->State);
$obj['patient']['address'][0]['postalCode'] = s($patientAddress->PostalCode);
$obj['patient']['address'][0]['countryCode'] = s($patientAddress->Country);

$phoneParts = explode('-',s($patientPhone->Value));
$obj['patient']['address'][0]['phone'][] = array(
	'areaCode' => $phoneParts[0],
	'prefix' => $phoneParts[1],
	'suffix' => $phoneParts[2],
	'type' => strtoupper(s($patientPhone->Type->Text))
);

$obj['patient']['dob'] = date('Y-m-d',strtotime(s($patient->DateOfBirth->ExactDateTime)));

$patientGender = s($patient->Gender->Text);
$obj['patient']['gender'] = (strtolower($patientGender) == 'female' ? 'F' : 'M');

foreach ($socialHistory as $socialHistoryElement) {
	$value = s($socialHistoryElement->Description->Text);
	switch(s($socialHistoryElement->Type->Text)) {
		case 'Marital Status':
			$statusCodes = array_flip($HL7martialCodes);
			if (isset($statusCodes[$value])) {
				$maritalStatusCode = $statusCodes[$value];
			} else {
				$maritalStatusCode = 'U';
			}
			$obj['patient']['maritalStatus'] = $maritalStatusCode;
			break;
		case 'Ethnicity':
			$ethnicityCodes = array_flip($HL7raceCodes);
			if (isset($ethnicityCodes[$value])) {
				$ethnicityCode = $ethnicityCodes[$value];
			} else {
				$ethnicityCode = 'U';
			}
			$obj['patient']['ethnicity'] = $ethnicityCode;
			break;
		case 'Tobacco Use':
			$smokingFrequency = s($socialHistoryElement->Description->ObjectAttribute[1]->AttributeValue->Value);
			$obj['patient']['smokingFrequency'] = $smokingFrequency;
			break;
	}
}

/*////////////////////////////////////////////////////////////////////////////////////////////////*/
/*//// MEDICATIONS ///////////////////////////////////////////////////////////////////////////////*/
/*////////////////////////////////////////////////////////////////////////////////////////////////*/

$medications = $xml->Body->Medications->Medication;
$medicationsIndex = 0;

foreach ($medications as $medication) {

	$directions = $medication->Directions->Direction;
	$strength = trim(s($medication->Product->Strength->Value).' '.s($medication->Product->Strength->Units->Unit));

	$ndcidCode = null;
	$rxnormCode = null;
	foreach ($medication->Product->BrandName->Code as $medicationCode) {
		if (strtoupper(s($medicationCode->CodingSystem)) == 'NDC') {
			$ndcidCode = s($medicationCode->Value);
		}
		if (strtoupper(s($medicationCode->CodingSystem)) == 'RXNORM') {
			$rxnormCode = s($medicationCode->Value);
		}
	}
	
	$obj['medication'][$medicationsIndex]['drug'] = array(
		'ndcid' => $ndcidCode,
		'rxNormId' => $rxnormCode,
		'brandName' => s($medication->Product->BrandName->Text),
		'genericName' => s($medication->Product->ProductName->Text),
		'form' => s($medication->Product->Form->Text),
		'strength' => $strength,
		'routeCode' => s($directions->Route->Text)
	);

	$obj['medication'][$medicationsIndex]['patientPrescription'][] = array('prescribe' => array('sig' => array(
		'drug' => array(
			'ndcid' => $ndcidCode,
			'rxNormId' => $rxnormCode,
			'brandName' => s($medication->Product->BrandName->Text),
			'genericName' => s($medication->Product->ProductName->Text),
			'form' => s($medication->Product->Form->Text),
			'strength' => $strength,
			'routeCode' => s($directions->Route->Text)
		),
		'dose' => s($directions->Dose->Value),
		'doseUnit' => s($directions->Dose->Units->Unit),
		'route' => s($directions->Route->Text),
		'doseTiming' => s($directions->Frequency->Value),
		'quantity' => s($medication->Quantity->Value),
		'quantityUnits' => s($medication->Quantity->Units->Unit),
		'patientNotes' => s(@$medication->PatientInstructions->Instruction->Text),
		'writtenDate' => s($medication->DateTime->ExactDateTime)
	)),
	'createdAt' => date('c',strtotime(s($medication->DateTime->ExactDateTime)))
	);
	
	$medicationsIndex++;

}

/*////////////////////////////////////////////////////////////////////////////////////////////////*/
/*//// PROBLEMS //////////////////////////////////////////////////////////////////////////////////*/
/*////////////////////////////////////////////////////////////////////////////////////////////////*/

$problems = $xml->Body->Problems->Problem;

foreach ($problems as $problem) {
	$obj['problem'][] = array(
		'icd9' => array(
			'code' => s($problem->Description->Code->Value),
			'desc' => s($problem->Description->Text)
		),
		'problemStartedAt' => date('Y-m-d', strtotime(s($problem->DateTime->ExactDateTime))),
		'active' => (strtolower(s($problem->Status->Text)) == 'active' ? true : false)
	);
}

/*////////////////////////////////////////////////////////////////////////////////////////////////*/
/*//// ALLERGIES /////////////////////////////////////////////////////////////////////////////////*/
/*////////////////////////////////////////////////////////////////////////////////////////////////*/

$allergies = $xml->Body->Alerts->Alert;

foreach ($allergies as $allergy) {
	$snomedCode = null;
	$rxnormCode = null;
	foreach ($allergy->Description->Code as $allergyCode) {
		if (strtoupper(s($allergyCode->CodingSystem)) == 'SNOMED') {
			$snomedCode = s($allergyCode->Value);
		}
		if (strtoupper(s($allergyCode->CodingSystem)) == 'RXNORM') {
			$rxnormCode = s($allergyCode->Value);
		}
	}
	$obj['allergy'][] = array(
		'name' => s($allergy->Description->Text),
		'allergicReaction' => s($allergy->Reaction->Description->Text),
		'allergicReactionDate' => date('Y-m-d',strtotime(s($allergy->DateTime->ExactDateTime))),
		'snomed' => $snomedCode,
		'rxnormId' => $rxnormCode,
		'active' => (strtolower(s($allergy->Status->Text)) == 'active' ? true : false)
	);
}

/*////////////////////////////////////////////////////////////////////////////////////////////////*/
/*//// IMMUNIZATIONS /////////////////////////////////////////////////////////////////////////////*/
/*////////////////////////////////////////////////////////////////////////////////////////////////*/

$immunizations = $xml->Body->Immunizations->Immunization;

foreach ($immunizations as $immunization) {
	$obj['immunization'][] = array(
		'vaccine' => s($immunization->Product->ProductName->Text),
		'activityTime' => s($immunization->DateTime->ExactDateTime),
		'cvxCode' => s($immunization->Product->ProductName->Code->Value)
	);
}

/*////////////////////////////////////////////////////////////////////////////////////////////////*/
/*//// LABS //////////////////////////////////////////////////////////////////////////////////////*/
/*////////////////////////////////////////////////////////////////////////////////////////////////*/

$labs = $xml->Body->Results->Result;
$labsIndex = 0;

foreach ($labs as $lab) {
	$obj['lab'][$labsIndex] = array();
	$abnormal = strtoupper(s($result->Flag->Text));
	$abnormalFlags = array_flip($HL7abnormalFlags);
	$abnormalFlags = array_change_key_case($abnormalFlags, CASE_UPPER);
	if (empty($abnormal) || !isset($abnormalFlags[$abnormal])) {
		$abnormalCode = 'NULL';
	} else {
		$abnormalCode = $abnormalFlags[$abnormal];
	}
	foreach ($lab->Test as $result) {
		$obj['lab'][$labsIndex]['labResult']['loincCode'] = s($result->Description->Code->Value);
		$obj['lab'][$labsIndex]['labResult']['description'] = s($lab->Description->Text);
		$obj['lab'][$labsIndex]['labResult']['labTestResult'][] = array(
			'date' => date('Y-m-d',strtotime(s($lab->DateTime->ExactDateTime))),
			'description' => s($result->Description->Text),
			'loincCode' => s($result->Description->Code->Value),
			'value' => s($result->TestResult->Value),
			'unitOfMeasure' => s($result->TestResult->Units->Unit),
			'abnormal' => $abnormalCode
		);
	}
	$labsIndex++;
}

/*////////////////////////////////////////////////////////////////////////////////////////////////*/
/*//// OUTPUT ////////////////////////////////////////////////////////////////////////////////////*/
/*////////////////////////////////////////////////////////////////////////////////////////////////*/

echo json_encode($obj);

?>