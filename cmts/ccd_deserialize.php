<?php

$translate_context = 'ccd';
require_once('globals.php');

/*////////////////////////////////////////////////////////////////////////////////////////////////*/
/*//// PREPARE INPUT & OUTPUT ////////////////////////////////////////////////////////////////////*/
/*////////////////////////////////////////////////////////////////////////////////////////////////*/

$postdata = file_get_contents("php://input");
#$postdata = file_get_contents('sample_ccd.xml');
if (empty($postdata)) { die('No input.'); }

$ns = 'n';
$xml = new SimpleXMLElement($postdata);
$xml->registerXPathNamespace($ns,$XMLGlobals['XSCHEMA']);

$obj = array();

/*////////////////////////////////////////////////////////////////////////////////////////////////*/
/*//// PATIENT ROLE //////////////////////////////////////////////////////////////////////////////*/
/*////////////////////////////////////////////////////////////////////////////////////////////////*/

$address = $xml->recordTarget->patientRole->addr;
$patient = $xml->recordTarget->patientRole->patient;

$obj['patient']['lastName'] = s($patient->name->family);
$obj['patient']['firstName'] = s($patient->name->given);
$obj['patient']['ssn'] = s($xml->recordTarget->patientRole->id['extension']);

$obj['patient']['address'][0]['address1'] = s($address->streetAddressLine[0]);
$obj['patient']['address'][0]['address2'] = s($address->streetAddressLine[1]);
$obj['patient']['address'][0]['city'] = s($address->city);
$obj['patient']['address'][0]['state'] = s($address->state);
$obj['patient']['address'][0]['postalCode'] = s($address->postalCode);
$obj['patient']['address'][0]['countryCode'] = s($address->country);

$telecom = $xml->recordTarget->patientRole->telecom;
$obj['patient']['address'][0]['phone'][] = array(
	'areaCode' => substr(s($telecom['value']),5,3),
	'prefix' => substr(s($telecom['value']),9,3),
	'suffix' => substr(s($telecom['value']),13,4),
	'type' => (strtoupper(s($telecom['use'])) == 'WP' ? 'OFFICE' : 'HOME')
);

$obj['patient']['dob'] = date('Y-m-d',strtotime(s($patient->birthTime['value'])));
$obj['patient']['gender'] = s($patient->administrativeGenderCode['code']);

/*////////////////////////////////////////////////////////////////////////////////////////////////*/
/*//// MEDICATIONS ///////////////////////////////////////////////////////////////////////////////*/
/*////////////////////////////////////////////////////////////////////////////////////////////////*/

$medications = $xml->component->structuredBody->component[2]->section->entry;
$medicationsTable = $xml->component->structuredBody->component[2]->section->text->table->tbody->tr;
$medicationsIndex = 0;

foreach ($medications as $medication) {
	$obj['medication'][]['patientPrescription'][]['prescribe']['sig'] = array(
		'drug' => array(
			'ndcid' => s($medication->substanceAdministration->consumable->manufacturedProduct->manufacturedMaterial->code['code']),
			'brandName' => s($medication->substanceAdministration->consumable->manufacturedProduct->manufacturedMaterial->code['displayName'])
		),
		'dose' => s($medication->substanceAdministration->doseQuantity['value']),
		'doseUnit' => s($medication->substanceAdministration->doseQuantity['unit']),
		'doseTiming' => s($medicationsTable[$medicationsIndex]->td[4])
		
	);
	$medicationsIndex++;
}

/*////////////////////////////////////////////////////////////////////////////////////////////////*/
/*//// ALLERGIES /////////////////////////////////////////////////////////////////////////////////*/
/*////////////////////////////////////////////////////////////////////////////////////////////////*/

$allergies = $xml->component->structuredBody->component[0]->section->entry;
$allergiesTable = $xml->component->structuredBody->component[0]->section->text->table->tbody->tr;
$allergiesIndex = 0;

foreach ($allergies as $allergy) {
	$obj['allergy'][] = array(
		'name' => s($allergiesTable[$allergiesIndex]->td[1]),
		'allergicReaction' => s($allergiesTable[$allergiesIndex]->td[2]),
		'allergicReactionDate' => date('Y-m-d',strtotime(s($allergy->act->entryRelationship->observation->effectiveTime->low['value']))),
		'snomed' => s($allergy->act->entryRelationship->observation->value['code'])
	);
	$allergiesIndex++;
}

/*////////////////////////////////////////////////////////////////////////////////////////////////*/
/*//// PROBLEMS //////////////////////////////////////////////////////////////////////////////////*/
/*////////////////////////////////////////////////////////////////////////////////////////////////*/

$problems = $xml->component->structuredBody->component[1]->section->entry;

foreach ($problems as $problem) {
	$obj['problem'][] = array(
		'icd9' => array(
			'code' => s($problem->act->entryRelationship->observation->value['code']),		
			'desc' => s($problem->act->entryRelationship->observation->value['displayName'])
		)
	);
}

/*////////////////////////////////////////////////////////////////////////////////////////////////*/
/*//// LABS //////////////////////////////////////////////////////////////////////////////////////*/
/*////////////////////////////////////////////////////////////////////////////////////////////////*/


$labs = $xml->component->structuredBody->component[3]->section->entry;
$labsTable = $xml->component->structuredBody->component[3]->section->text->table->tbody->tr;
$labsIndex = 0;

foreach ($labs->organizer as $battery) {

	$obj['lab'][$labsIndex] = array(
		'labOrder' => array(
			'summary' => s($battery->code['displayName'])
		),
		'labResult' =>array(
			'loincCode' => s($battery->code['code']),
			'labTestResult' => array()
		)
	);

	foreach($battery->component as $component) {
		if ($component->observation) {
			$obj['lab'][$labsIndex]['labResult']['labTestResult'][] = array(
				'type' => s($battery->code['displayName']),
				'name' => s($component->observation->code['displayName']),
				'value' => s($component->observation->value['value']),
				'unitOfMeasure' => s($component->observation->value['unit'])
			);
		}
	}

	$labsIndex++;

}

/*////////////////////////////////////////////////////////////////////////////////////////////////*/
/*//// OUTPUT ////////////////////////////////////////////////////////////////////////////////////*/
/*////////////////////////////////////////////////////////////////////////////////////////////////*/

echo json_encode($obj);

?>