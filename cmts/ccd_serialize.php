<?php

$translate_context = 'ccd';
require_once('globals.php');

/*////////////////////////////////////////////////////////////////////////////////////////////////*/
/*//// PREPARE INPUT /////////////////////////////////////////////////////////////////////////////*/
/*////////////////////////////////////////////////////////////////////////////////////////////////*/

$postdata = file_get_contents("php://input");
$cleaned = preg_replace("!\s+!m",' ',urldecode($postdata));
$posted_obj = json_decode($cleaned); 

// Simulate a post
//require_once('sample_post.php');

$in = $posted_obj;

/*////////////////////////////////////////////////////////////////////////////////////////////////*/
/*//// CREATE XML DOC ////////////////////////////////////////////////////////////////////////////*/
/*////////////////////////////////////////////////////////////////////////////////////////////////*/

$xsi = $XMLGlobals['XSI'];
$xsd = $XMLGlobals['XSD'];
$xsl = 'cda.xsl';
$xschema = $XMLGlobals['XSCHEMA'];
$ccdXML = new SimpleXMLElement('<?xml-stylesheet type="text/xsl" href="'.$xsl.'" ?><ClinicalDocument xmlns="'.$xschema.'" xmlns:xsi="'.$xsi.'" xsi:schemaLocation="'.$xschema.' '.$xsd.'"></ClinicalDocument>');

/*////////////////////////////////////////////////////////////////////////////////////////////////*/
/*//// SET UP CCD HEADER /////////////////////////////////////////////////////////////////////////*/
/*////////////////////////////////////////////////////////////////////////////////////////////////*/

$ccdXML->addChild('realmCode')->addAttribute('code','US');
XMLaddManyAttributes($ccdXML->addChild('typeId'), array(
	'root' => '2.16.840.1.113883.1.3',
	'extension' => 'POCD_HD000040'
));

XMLaddManyChildren($ccdXML, array('templateId' => array('root' => '2.16.840.1.113883.3.27.1776', 'assigningAuthorityName' => 'CDA/R2')));
XMLaddManyChildren($ccdXML, array('templateId' => array('root' => '2.16.840.1.113883.10.20.3', 'assigningAuthorityName' => 'HL7/CDT Header')));
XMLaddManyChildren($ccdXML, array('templateId' => array('root' => '1.3.6.1.4.1.19376.1.5.3.1.1.1', 'assigningAuthorityName' => 'IHE/PCC')));
XMLaddManyChildren($ccdXML, array('templateId' => array('root' => '2.16.840.1.113883.3.88.11.32.1', 'assigningAuthorityName' => 'HITSP/C32')));

$generatedTime = date('YmdHis');
$generatedTime = substr($generatedTime,0,8).'000000';

XMLaddManyChildren($ccdXML, array(
	'id' => array(
		'root' => '2.16.840.1.113883.3.72',
		'extension' => 'MU_Rev2_HITSP_C32C83',
		'assigningAuthorityName' => 'NIST Healthcare Project'
	),
	'code' => array(
		'code' => '34133-9',
		'displayName' => 'Summarization of episode note',
		'codeSystem' => '2.16.840.1.113883.6.1',
		'codeSystemName' => 'LOINC'
	),
	'title' => array(
		// null
	),
	'effectiveTime' => array(
		'value' => $generatedTime
	),
	'confidentialityCode' => array(
		// null
	),
	'languageCode' => array(
		'code' => $XMLGlobals['LANGUAGE_CODE']
	)
));

/*////////////////////////////////////////////////////////////////////////////////////////////////*/
/*//// PATIENT ROLE //////////////////////////////////////////////////////////////////////////////*/
/*////////////////////////////////////////////////////////////////////////////////////////////////*/

$patientRole = $ccdXML->addChild('recordTarget')->addChild('patientRole');

XMLaddManyAttributes($patientRole->addChild('id'), array(
	'root' => '2.16.840.1.113883.4.1',
	'extension' => $in->patient->ssn	
));

$inputPatient = $in->patient;
$phoneString = '';
$phoneType = 'HP';

foreach($inputPatient->address as $addressData) {

	$address = $patientRole->addChild('addr');
	$address->addAttribute('use', 'HP');
	$address->addChild('streetAddressLine', $addressData->address1);
	$address->addChild('streetAddressLine', $addressData->address2);
	$address->addChild('city', $addressData->city);
	$address->addChild('state', $addressData->state);
	$address->addChild('postalCode', $addressData->postalCode);
	$address->addChild('country', $addressData->countryCode);

	if (empty($phoneString)) {	
		foreach($addressData->phone as $phoneData) {
			$phoneString = 'tel:('.$phoneData->areaCode.')'.$phoneData->prefix.'-'.$phoneData->suffix;
			if (strtolower($phoneData->type) == 'office') {
				$phoneType = 'WP';
				$phoneString = 'tel:('.$phoneData->areaCode.')'.$phoneData->prefix.'-'.$phoneData->suffix;
			}
		}
	}
	
}

$telecom = $patientRole->addChild('telecom');
if (!empty($phoneString)) {
	$telecom->addAttribute('use', $phoneType);
	$telecom->addAttribute('value', $phoneString);
}

$patient = $patientRole->addChild('patient');
$patientName = $patient->addChild('name');
$patientName->addChild('given', $inputPatient->firstName);
$patientName->addChild('family', $inputPatient->lastName);

XMLaddManyAttributes($patient->addChild('administrativeGenderCode'), array(
	'code' => $inputPatient->gender,
	'displayName' => ($inputPatient->gender == 'M' ? 'Male' : 'Female'),
	'codeSystem' => '2.16.840.1.113883.5.1',
	'codeSystemName' => 'HL7 AdministrativeGender'
));

$patient->addChild('birthTime')->addAttribute('value', date('Ymd',strtotime($inputPatient->dob)));

if (!empty($inputPatient->maritalStatus)) {
	$inputMaritalStatus = $inputPatient->maritalStatus;
	XMLaddManyAttributes($patient->addChild('maritalStatusCode'), array(
		'code' => $inputMaritalStatus,
		'displayName' => $HL7martialCodes[$inputMaritalStatus],
		'codeSystem' => '2.16.840.1.113883.5.2',
		'codeSystemName' => 'HL7 Marital status'
	));
}

$languageCommunication = $patient->addChild('languageCommunication');
XMLaddManyAttributes($languageCommunication->addChild('templateId'), array(
	'root' => '2.16.840.1.113883.3.88.11.83.2',
	'assigningAuthorityName' => 'HITSP/C83'
));
XMLaddManyAttributes($languageCommunication->addChild('templateId'), array(
	'root' => '1.3.6.1.4.1.19376.1.5.3.1.2.1',
	'assigningAuthorityName' => 'IHE/PCC'
));

$languageCommunication->addChild('languageCode')->addAttribute('code', $XMLGlobals['LANGUAGE_CODE']);

/*////////////////////////////////////////////////////////////////////////////////////////////////*/
/*//// AUTHOR ////////////////////////////////////////////////////////////////////////////////////*/
/*////////////////////////////////////////////////////////////////////////////////////////////////*/

$author = $ccdXML->addChild('author');
$author->addChild('time')->addAttribute('value', $generatedTime);
$assignedAuthor = $author->addChild('assignedAuthor');
$assignedAuthor->addChild('id');
$assignedAuthor->addChild('addr');
$assignedAuthor->addChild('telecom');
$assignedAuthor->addChild('assignedPerson')->addChild('name', 'Staff');

$assignedAuthorRepresentedOrganization = $assignedAuthor->addChild('representedOrganization');

XMLaddManyNodes($assignedAuthorRepresentedOrganization, array(
	'name' => 'NIST Healthcare Testing Laboratory',
	'telecom' => '',
	'addr' => ''
));

/*////////////////////////////////////////////////////////////////////////////////////////////////*/
/*//// CUSTODIAN /////////////////////////////////////////////////////////////////////////////////*/
/*////////////////////////////////////////////////////////////////////////////////////////////////*/

$representedCustodianOrganization = $ccdXML->addChild('custodian')->addChild('assignedCustodian')->addChild('representedCustodianOrganization');
XMLaddManyNodes($representedCustodianOrganization, array(
	'id' => '',
	'name' => '',
	'telecom' => '',
	'addr' => ''
));

/*////////////////////////////////////////////////////////////////////////////////////////////////*/
/*//// SET UP BODY ///////////////////////////////////////////////////////////////////////////////*/
/*////////////////////////////////////////////////////////////////////////////////////////////////*/

$ccdBody = $ccdXML->addChild('component')->addChild('structuredBody');

/*////////////////////////////////////////////////////////////////////////////////////////////////*/
/*//// ALLERGIES /////////////////////////////////////////////////////////////////////////////////*/
/*////////////////////////////////////////////////////////////////////////////////////////////////*/

$allergiesSchema = array('ALGSUMMARY' => array(
	'SNOMED' => 'SNOMED',
	'RxNorm' => 'ALGRXN',
	'Type' => 'ALGTYPE',
	'Substance' => 'ALGSUB',
	'Reaction' => 'ALGREACT',
	'Status' => 'ALGSTATUS',
	'Adverse Event Date' => 'ALGDATE'
));

$allergiesData = array();
$inputAllergies = $in->allergy;

foreach ($inputAllergies as $inputAllergy) {
	$allergiesData[] = array(
		$inputAllergy->snomed,
		$inputAllergy->rxnormId,
		'Drug Allergy',
		$inputAllergy->name,
		$inputAllergy->allergicReaction,
		(@$inputAllergy->active == '1' ? 'active' : 'completed'),
		$inputAllergy->allergicReactionDate,
		'Meta' => array(
			'typeCode' => 'SUBJ',
			'statusCode' => (@$inputAllergy->active == '1' ? 'active' : 'completed'),
			'inversionInd' => 'false',
			'allergyDate' => $inputAllergy->allergicReactionDate,
			'allergyCode' => $inputAllergy->snomed,
			'allergyName' => $inputAllergy->name
		)
	);
}

$allergies = $ccdBody->addChild('component')->addChild('section');
XMLaddManyChildren($allergies, array('templateId' => array('root' => '2.16.840.1.113883.3.88.11.83.102', 'assigningAuthorityName' => 'HITSP/C83')));
XMLaddManyChildren($allergies, array('templateId' => array('root' => '1.3.6.1.4.1.19376.1.5.3.1.3.13', 'assigningAuthorityName' => 'IHE PCC')));
XMLaddManyChildren($allergies, array('templateId' => array('root' => '2.16.840.1.113883.10.20.1.2', 'assigningAuthorityName' => 'HL7 CCD')));
XMLaddManyAttributes($allergies->addChild('code'), array(
	'code' => '48765-2',
	'codeSystem' => '2.16.840.1.113883.6.1',
	'codeSystemName' => 'LOINC',
	'displayName' => 'Allergies'
));

$allergies->addChild('title', 'Allergies and Adverse Reactions');

XMLaddTableSection($allergies->addChild('text'), $allergiesSchema, $allergiesData);

$allergyIndex = 1;

foreach ($allergiesData as $allergyData) {

	$allergyDataGroup = array_shift(array_keys($allergiesSchema));
	$allergyDataReference = '#'.$allergyDataGroup.'_'.$allergyIndex;
	$allergyDataSchema = array_shift(array_values($allergiesSchema));
	$allergyMeta = $allergiesData[$allergyIndex-1]['Meta'];
	
	$allergy = $allergies->addChild('entry');
	$allergy->addAttribute('typeCode','DRIV');

	$allergyAct = $allergy->addChild('act');
	$allergyAct->addAttribute('classCode', 'ACT');
	$allergyAct->addAttribute('moodCode', 'EVN');

	XMLaddManyChildren($allergyAct, array('templateId' => array('root' => '2.16.840.1.113883.3.88.11.83.6', 'assigningAuthorityName' => 'HITSP/C83')));
	XMLaddManyChildren($allergyAct, array('templateId' => array('root' => '2.16.840.1.113883.10.20.1.27', 'assigningAuthorityName' => 'CCD')));
	XMLaddManyChildren($allergyAct, array('templateId' => array('root' => '1.3.6.1.4.1.19376.1.5.3.1.4.5.1', 'assigningAuthorityName' => 'IHE PCC')));
	XMLaddManyChildren($allergyAct, array('templateId' => array('root' => '1.3.6.1.4.1.19376.1.5.3.1.4.5.3', 'assigningAuthorityName' => 'IHE PCC')));

	XMLaddManyChildren($allergyAct, array(
		'id' => array(
			'root' => '36e3e930-7b14-11db-9fe1-0800200c9a66'
		),
		'code' => array(
			'nullFlavor' => 'NA'
		),
		'statusCode' => array(
			'code' => 'completed'
		)
	));

	XMLaddManyChildren($allergyAct->addChild('effectiveTime'), array(
		'low' => array(
			'nullFlavor' => 'UNK'
		),
		'high' => array(
			'nullFlavor' => 'UNK'
		)
	));

	$entryRelationship = $allergyAct->addChild('entryRelationship');
	$entryRelationship->addAttribute('typeCode', $allergyMeta['typeCode']);
	$entryRelationship->addAttribute('inversionInd', $allergyMeta['inversionInd']);

	$observation = $entryRelationship->addChild('observation');
	$observation->addAttribute('classCode', 'OBS');
	$observation->addAttribute('moodCode', 'EVN');

	XMLaddManyChildren($observation, array('templateId' => array('root' => '2.16.840.1.113883.10.20.1.18', 'assigningAuthorityName' => 'CCD')));
	XMLaddManyChildren($observation, array('templateId' => array('root' => '2.16.840.1.113883.10.20.1.28', 'assigningAuthorityName' => 'CCD')));
	XMLaddManyChildren($observation, array('templateId' => array('root' => '1.3.6.1.4.1.19376.1.5.3.1.4.5', 'assigningAuthorityName' => 'IHE PCC')));
	XMLaddManyChildren($observation, array('templateId' => array('root' => '1.3.6.1.4.1.19376.1.5.3.1.4.6', 'assigningAuthorityName' => 'IHE PCC')));
	XMLaddManyChildren($observation, array('templateId' => array('root' => '2.16.840.1.113883.10.20.1.18')));

	$observation->addChild('id')->addAttribute('root', '4adc1020-7b14-11db-9fe1-0800200c9a66');

	XMLaddManyAttributes($observation->addChild('code'), array(
		'code' => '416098002',
		'codeSystem' => '2.16.840.1.113883.6.96',
		'displayName' => 'drug allergy',
		'codeSystemName' => 'SNOMED CT'
	));

	$observation->addChild('text')->addChild('reference')->addAttribute('value', $allergyDataReference);
	$observation->addChild('statusCode')->addAttribute('code', 'completed');

	$effectiveTime = $observation->addChild('effectiveTime');
	$allergicReactionDate = $effectiveTime->addChild('low');
	$allergicReactionDate->addAttribute('value', date('Ymd',strtotime($allergyMeta['allergyDate'])));

	$observationValue = $observation->addChild('value');
	XMLaddManyAttributes($observationValue, array(
		'code' => $allergyMeta['allergyCode'],
		'codeSystem' => '2.16.840.1.113883.6.96',
		'displayName' => $allergyMeta['allergyName'],
		'codeSystemName' => 'SNOMED CT'
	));
	$observationValue->addAttribute('xsi:type', 'CD', $xsi);
	$observationValue->addChild('originalText')->addChild('reference')->addAttribute('value', '#'.$allergyDataSchema['Substance'].'_'.$allergyIndex);

	$observationParticipant = $observation->addChild('participant');
	$observationParticipant->addAttribute('typeCode', 'CSM');
	$observationParticipantRole = $observationParticipant->addChild('participantRole');
	$observationParticipantRole->addAttribute('classCode', 'MANU');
	$observationParticipantRole->addChild('addr');
	$observationParticipantRole->addChild('telecom');
	$observationParticipantRolePlayingEntity = $observationParticipantRole->addChild('playingEntity');
	$observationParticipantRolePlayingEntity->addAttribute('classCode', 'MMAT');
	$observationParticipantRolePlayingEntityCode = $observationParticipantRolePlayingEntity->addChild('code');
	$observationParticipantRolePlayingEntityCode->addChild('originalText')->addChild('reference')->addAttribute('value', '#'.$allergyDataSchema['Substance'].'_'.$allergyIndex);
	XMLaddManyAttributes($observationParticipantRolePlayingEntityCode, array(
		'code' => $allergyMeta['allergyCode'],
		'codeSystem' => '2.16.840.1.113883.6.96',
		'displayName' => $allergyMeta['allergyName'],
		'codeSystemName' => 'SNOMED CT'
	));
	$observationParticipantRolePlayingEntity->addChild('name', $allergyMeta['allergyName']);
	
	$allergyIndex++;

}

/*////////////////////////////////////////////////////////////////////////////////////////////////*/
/*//// PROBLEMS //////////////////////////////////////////////////////////////////////////////////*/
/*////////////////////////////////////////////////////////////////////////////////////////////////*/

$problemsSchema = array('PROBSUMMARY' => array(
	'ICD9' => 'PROBICD9',
	'Problem' => 'PROBKIND',
	'Effective Dates' => 'PROBDATE',
	'Problem Status' => 'PROBSTATUS',
));

$problemsData = array();
$inputProblems = $in->problem;
foreach ($inputProblems as $inputProblem) {
	$problemsData[] = array(
		$inputProblem->icd9->code,
		$inputProblem->icd9->desc,
		date('Ymd',strtotime(@$inputProblem->problemStartedAt)),
		($inputProblem->active ? 'active' : 'inactive'),
		'Meta' => array(
			'problemName' => $inputProblem->icd9->desc,
			'problemCode' => $inputProblem->icd9->code,
			'lowValue' => date('Ymd',strtotime(@$inputProblem->problemStartedAt)),
			'typeCode' => 'SUBJ',
			'statusCode' => ($inputProblem->active ? 'active' : 'inactive'),
			'inversionInd' => 'false',
		)
	);
}

$problems = $ccdBody->addChild('component')->addChild('section');
XMLaddManyChildren($problems, array('templateId' => array('root' => '2.16.840.1.113883.3.88.11.83.103', 'assigningAuthorityName' => 'HITSP/C83')));
XMLaddManyChildren($problems, array('templateId' => array('root' => '1.3.6.1.4.1.19376.1.5.3.1.3.6', 'assigningAuthorityName' => 'IHE PCC')));
XMLaddManyChildren($problems, array('templateId' => array('root' => '2.16.840.1.113883.10.20.1.11', 'assigningAuthorityName' => 'HL7 CCD')));
XMLaddManyAttributes($problems->addChild('code'), array(
	'code' => '11450-4',
	'codeSystem' => '2.16.840.1.113883.6.1',
	'codeSystemName' => 'LOINC',
	'displayName' => 'Problem list'
));

$problems->addChild('title', 'Problems');

XMLaddTableSection($problems->addChild('text'), $problemsSchema, $problemsData);

$problemIndex = 1;

foreach ($problemsData as $problemData) {

	$problemDataGroup = array_shift(array_keys($problemsSchema));
	$problemDataReference = '#'.$problemDataGroup.'_'.$problemIndex;
	$problemDataSchema = array_shift(array_values($problemsSchema));
	$problemMeta = $problemsData[$problemIndex-1]['Meta'];
	
	$problem = $problems->addChild('entry');
	$problem->addAttribute('typeCode','DRIV');

	$problemAct = $problem->addChild('act');
	$problemAct->addAttribute('classCode', 'ACT');
	$problemAct->addAttribute('moodCode', 'EVN');

	XMLaddManyChildren($problemAct, array('templateId' => array('root' => '2.16.840.1.113883.3.88.11.83.7', 'assigningAuthorityName' => 'HITSP/C83')));
	XMLaddManyChildren($problemAct, array('templateId' => array('root' => '2.16.840.1.113883.10.20.1.27', 'assigningAuthorityName' => 'CCD')));
	XMLaddManyChildren($problemAct, array('templateId' => array('root' => '1.3.6.1.4.1.19376.1.5.3.1.4.5.1', 'assigningAuthorityName' => 'IHE PCC')));
	XMLaddManyChildren($problemAct, array('templateId' => array('root' => '1.3.6.1.4.1.19376.1.5.3.1.4.5.2', 'assigningAuthorityName' => 'IHE PCC')));

	XMLaddManyChildren($problemAct, array(
		'id' => array(
			'root' => '6a2fa88d-4174-4909-aece-db44b60a3abb'
		),
		'code' => array(
			'nullFlavor' => 'NA'
		),
		'statusCode' => array(
			'code' => 'completed'
		)
	));

	XMLaddManyChildren($problemAct->addChild('effectiveTime'), array(
		'low' => array(
			'value' => $problemMeta['lowValue']
		),
		'high' => array(
			'nullFlavor' => 'UNK'
		)
	));

	$entryRelationship = $problemAct->addChild('entryRelationship');
	$entryRelationship->addAttribute('typeCode', $problemMeta['typeCode']);
	$entryRelationship->addAttribute('inversionInd', $problemMeta['inversionInd']);

	$observation = $entryRelationship->addChild('observation');
	$observation->addAttribute('classCode', 'OBS');
	$observation->addAttribute('moodCode', 'EVN');

	XMLaddManyChildren($observation, array('templateId' => array('root' => '2.16.840.1.113883.10.20.1.28', 'assigningAuthorityName' => 'CCD')));
	XMLaddManyChildren($observation, array('templateId' => array('root' => '1.3.6.1.4.1.19376.1.5.3.1.4.5', 'assigningAuthorityName' => 'IHE PCC')));

	$observation->addChild('id')->addAttribute('root', 'd11275e7-67ae-11db-bd13-0800200c9a66');

	XMLaddManyAttributes($observation->addChild('code'), array(
		'code' => '64572001',
		'codeSystem' => '2.16.840.1.113883.6.96',
		'displayName' => 'Condition',
		'codeSystemName' => 'SNOMED CT'
	));

	$observation->addChild('text')->addChild('reference')->addAttribute('value', $problemDataReference);
	$observation->addChild('statusCode')->addAttribute('code', 'completed');
	$observation->addChild('effectiveTime')->addChild('low')->addAttribute('value', $problemMeta['lowValue']);

	$observationValue = $observation->addChild('value');
	$observationValue->addAttribute('xsi:type', 'CD', $xsi);
	XMLaddManyAttributes($observationValue, array(
		'displayName' => $problemMeta['problemName']
	));
	
	$problemIndex++;

}

/*////////////////////////////////////////////////////////////////////////////////////////////////*/
/*//// MEDICATIONS ///////////////////////////////////////////////////////////////////////////////*/
/*////////////////////////////////////////////////////////////////////////////////////////////////*/

$medicationsSchema = array('MEDSUMMARY' => array(
	'NDCID' => 'NDCID',
	'RxNorm' => 'RXNORM',
	'Generic Name' => 'GENNAME',
	'Brand Name' => 'MEDNAME',
	'Strength' => 'MEDSTRENGTH',
	'Dose' => 'MEDDOSE',
	'Form' => 'MEDFORM',
	'Route' => 'MEDROUTE',
	'Sig Text' => 'SIGTXT',
	'Dates' => 'MEDDATES',
	'Status' => 'MEDSTATUS',
));

$medicationsData = array();
$inputMedications = $in->medication;
foreach ($inputMedications as $inputMedication) {
	foreach ($inputMedication->patientPrescription as $inputPrescription) {
		$inputSig = $inputPrescription->prescribe->sig;
		$medicationsData[] = array(
			@$inputSig->drug->ndcid,
			@$inputSig->drug->rxNormId,
			@$inputSig->drug->genericName,
			@$inputSig->drug->brandName,
			@$inputSig->drug->strength,
			@$inputSig->dose.' '.@$inputSig->doseUnit,
			@$inputSig->drug->form,
			@$inputSig->route,
			@$inputSig->doseTiming,
			date('Ymd',strtotime(@$inputPrescription->createdAt)),
			(@$inputMedication->active == '1' ? 'active' : 'completed'),
			'Meta' => array(
				'medicationBrand' => @$inputSig->drug->brandName,
				'medicationName' => @$inputSig->drug->genericName,
				'medicationCode' => @$inputSig->drug->rxNormId,
				'adminCode' => @$inputSig->route,
				'routeCode' => @$inputSig->route,
				'doseValue' => @$inputSig->dose,
				'doseUnit' => @$inputSig->doseUnit,
				'strength' => @$inputSig->drug->strength,
				'lowValue' => date('Ymd',strtotime(@$inputSig->effectiveDate)),
				'typeCode' => 'SUBJ',
				'statusCode' => (@$inputPrescription->active == '1' ? 'active' : 'completed'),
				'inversionInd' => 'false'
			)
		);
	}
}

$medications = $ccdBody->addChild('component')->addChild('section');
XMLaddManyChildren($medications, array('templateId' => array('root' => '2.16.840.1.113883.3.88.11.83.112', 'assigningAuthorityName' => 'HITSP/C83')));
XMLaddManyChildren($medications, array('templateId' => array('root' => '1.3.6.1.4.1.19376.1.5.3.1.3.19', 'assigningAuthorityName' => 'IHE PCC')));
XMLaddManyChildren($medications, array('templateId' => array('root' => '2.16.840.1.113883.10.20.1.8', 'assigningAuthorityName' => 'HL7 CCD')));
XMLaddManyAttributes($medications->addChild('code'), array(
	'code' => '10160-0',
	'codeSystem' => '2.16.840.1.113883.6.1',
	'codeSystemName' => 'LOINC',
	'displayName' => 'History of medication use'
));

$medications->addChild('title', 'Medications');

XMLaddTableSection($medications->addChild('text'), $medicationsSchema, $medicationsData);

$medicationIndex = 1;

foreach ($medicationsData as $medicationData) {

	$medicationDataGroup = array_shift(array_keys($medicationsSchema));
	$medicationDataReference = '#'.$medicationDataGroup.'_'.$medicationIndex;
	$medicationDataSchema = array_shift(array_values($medicationsSchema));
	$medicationMeta = $medicationsData[$medicationIndex-1]['Meta'];
	
	$medication = $medications->addChild('entry');
	$medication->addAttribute('typeCode','DRIV');

	$substanceAdministration = $medication->addChild('substanceAdministration');
	$substanceAdministration->addAttribute('classCode', 'SBADM');
	$substanceAdministration->addAttribute('moodCode', 'EVN');

	XMLaddManyChildren($substanceAdministration, array('templateId' => array('root' => '2.16.840.1.113883.3.88.11.83.8', 'assigningAuthorityName' => 'HITSP/C83')));
	XMLaddManyChildren($substanceAdministration, array('templateId' => array('root' => '2.16.840.1.113883.10.20.1.24', 'assigningAuthorityName' => 'CCD')));
	XMLaddManyChildren($substanceAdministration, array('templateId' => array('root' => '1.3.6.1.4.1.19376.1.5.3.1.4.7', 'assigningAuthorityName' => 'IHE PCC')));
	XMLaddManyChildren($substanceAdministration, array('templateId' => array('root' => '1.3.6.1.4.1.19376.1.5.3.1.4.7.1', 'assigningAuthorityName' => 'IHE PCC')));

	$substanceAdministration->addChild('id')->addAttribute('root', 'cdbd33f0-6cde-11db-9fe1-0800200c9a66');
	$substanceAdministration->addChild('text')->addChild('reference')->addAttribute('value', '#SIGTEXT_'.$medicationIndex);
	$substanceAdministration->addChild('statusCode')->addAttribute('code', 'completed');

	$substanceAdministrationEffectiveTime = $substanceAdministration->addChild('effectiveTime');
	$substanceAdministrationEffectiveTime->addAttribute('xsi:type', 'IVL_TS', $xsi);
	XMLaddManyChildren($substanceAdministrationEffectiveTime, array(
		'low' => array(
			'value' => $medicationMeta['lowValue']
		),
		'high' => array(
			'nullFlavor' => 'UNK'
		)
	));

	$substanceAdministrationEffectiveTime = $substanceAdministration->addChild('effectiveTime');
	$substanceAdministrationEffectiveTime->addAttribute('xsi:type', 'PIVL_TS', $xsi);
	XMLaddManyChildren($substanceAdministrationEffectiveTime, array(
		'period' => array(
			'value' => '6',
			'unit' => 'h',
		)
	));

	$substanceAdministration->addChild('routeCode')->addChild('originalText', $medicationMeta['routeCode']);

	XMLaddManyAttributes($substanceAdministration->addChild('doseQuantity'), array(
		'value' => $medicationMeta['doseValue'],
		'unit' => $medicationMeta['doseUnit']
	));

	$strengthParts = explode(' ',$medicationMeta['strength']);
	if (sizeof($strengthParts) == 2) {
		XMLaddManyAttributes($substanceAdministration->addChild('rateQuantity'), array(
			'value' => $strengthParts[0],
			'unit' => $strengthParts[1]
		));
	}

	$substanceAdministration->addChild('administrationUnitCode')->addChild('originalText', $medicationMeta['adminCode']);

	$manufacturedProduct = $substanceAdministration->addChild('consumable')->addChild('manufacturedProduct');
	XMLaddManyChildren($manufacturedProduct, array('templateId' => array('root' => '2.16.840.1.113883.3.88.11.83.8.2', 'assigningAuthorityName' => 'HITSP/C83')));
	XMLaddManyChildren($manufacturedProduct, array('templateId' => array('root' => '2.16.840.1.113883.10.20.1.53', 'assigningAuthorityName' => 'CCD')));
	XMLaddManyChildren($manufacturedProduct, array('templateId' => array('root' => '1.3.6.1.4.1.19376.1.5.3.1.4.7.2', 'assigningAuthorityName' => 'IHE PCC')));

	$manufacturedMaterialCode = $manufacturedProduct->addChild('manufacturedMaterial')->addChild('code');
	$manufacturedMaterialCode->addChild('originalText', $medicationMeta['medicationBrand'])->addChild('reference');
	XMLaddManyAttributes($manufacturedMaterialCode, array(
		'code' => $medicationMeta['medicationCode'],
		'codeSystem' => '2.16.840.1.113883.6.88',
		'displayName' => $medicationMeta['medicationName'],
		'codeSystemName' => 'RxNorm'
	));

	$medicationIndex++;

}

/*////////////////////////////////////////////////////////////////////////////////////////////////*/
/*//// LABS //////////////////////////////////////////////////////////////////////////////////////*/
/*////////////////////////////////////////////////////////////////////////////////////////////////*/

$labsData = array();
$inputLabs = $in->lab;
$inputLabsIndex = 0;

foreach ($inputLabs as $inputLab) {
	$inputLabData = $inputLab->labResult;
	$inputLabName = $inputLab->labOrder->summary;
	if (empty($inputLabName)) {
		$nameParts = splitLabDescription($inputLabData->labTestResult[0]->name);
		$inputLabName = $nameParts['resultDescription'];
	}
	$labsData[$inputLabsIndex] = array(
		'labName' => $inputLabName,
		'loincCode' => $inputLabData->loincCode,
		'labDate' => '',
		'labProcedures' => array(),
		'labResults' => array()
	);
	foreach ($inputLabData->labTestResult as $inputLabResult) {
		$nameParts = splitLabDescription($inputLabResult->name);
		$resultDescription = $nameParts['resultDescription'];
		$resultIdealRange = $nameParts['resultIdealRange'];
		$resultDescription = $nameParts['resultDescription'];
		if (!empty($nameParts['resultIdealRange'])) {
			$resultDescription .= ' ('.$nameParts['resultIdealRange'].')';
		}
		$labsData[$inputLabsIndex]['labDate'] = date('Ymd', strtotime(@$inputLabResult->date));
		$labsData[$inputLabsIndex]['labProcedures'][] = array(
			'procedureDescription' => 'Obtain sample for '.$inputLabResult->type,
			'statusCode' => 'completed',
		);
		$labsData[$inputLabsIndex]['labResults'][] = array(
			'resultCode' => $inputLabData->loincCode,
			'resultType' => @$inputLabResult->type,
			'resultDisplayName' => @$resultDescription,
			'resultIdealRange' => @$resultIdealRange,
			'resultMeasurement' => @$inputLabResult->value,
			'resultAbnormal' => @$inputLabResult->abnormal,
			'resultUnit' => @$inputLabResult->unitOfMeasure,
			'source' => @$inputLabResult->source,
			'statusCode' => 'completed'
		);
	}
	$inputLabsIndex++;
}

$labs = $ccdBody->addChild('component')->addChild('section');
XMLaddManyChildren($labs, array('templateId' => array('root' => '2.16.840.1.113883.3.88.11.83.122', 'assigningAuthorityName' => 'HITSP/C83')));
XMLaddManyChildren($labs, array('templateId' => array('root' => '1.3.6.1.4.1.19376.1.5.3.1.3.28', 'assigningAuthorityName' => 'IHE PCC')));
XMLaddManyAttributes($labs->addChild('code'), array(
	'code' => '30954-2',
	'codeSystem' => '2.16.840.1.113883.6.1',
	'codeSystemName' => 'LOINC',
	'displayName' => 'Results'
));

$labs->addChild('title', 'Diagnostic Results');

/*//// LABS TABLE ////////////////////////////////////////////////////////////////////////////////*/

$labResultsDateIndex = array();
$labResultsTableArray = array();

foreach ($labsData as $labBattery) {
	foreach ($labBattery['labResults'] as $labResult) {
		$labResultsDateString = strtotime($labBattery['labDate']);
		$labResultsDateIndex[] = $labResultsDateString;
		$labResultsTableArray[$labResult['resultType']][$labResult['resultDisplayName']]['code'] = $labResult['resultCode'];
		$labResultsTableArray[$labResult['resultType']][$labResult['resultDisplayName']]['results'][$labResultsDateString] = array(
			$labResult['resultMeasurement'].' '.$labResult['resultUnit'],
			$HL7abnormalFlags[strtoupper($labResult['resultAbnormal'])]
		);
	}
}

$labResultsDateIndex = array_unique($labResultsDateIndex);
sort($labResultsDateIndex);

$labResultsTableColumns = count($labResultsDateIndex);

$labsTable = $labs->addChild('text')->addChild('table');
XMLaddManyAttributes($labsTable, array(
	'border' => '1',
	'width' => '100%'
));

$labsTableHeader = $labsTable->addChild('thead')->addChild('tr');
$labsTableHeader->addChild('th', 'LOINC');
$labsTableHeader->addChild('th', 'Description');
foreach ($labResultsDateIndex as $labResultsDate) {
	$labsTableHeader->addChild('th', 'Measure');
	$labsTableHeader->addChild('th', 'Abnormal');
}

$labsTableBody = $labsTable->addChild('tbody');
foreach ($labResultsTableArray as $labResultsType => $labResultsSet) {
	$labsTableRowHeader = $labsTableBody->addChild('tr');
	$labsTableRowHeaderType = $labsTableRowHeader->addChild('td');
	$labsTableRowHeaderType->addAttribute('colspan', 2);
	$labsTableRowHeaderType->addChild('content', $labResultsType)->addAttribute('styleCode', 'BoldItalics');
	foreach ($labResultsDateIndex as $labResultsDate) {
		$labsTableRowHeaderDate = $labsTableRowHeader->addChild('td');
		$labsTableRowHeaderDate->addAttribute('colspan', 2);
		$labsTableRowHeaderDate->addChild('content', date('Y-m-d', $labResultsDate))->addAttribute('styleCode', 'BoldItalics');
	}
	foreach ($labResultsSet as $labResultsSetName => $labResultsSetResults) {
		$labsTableRow = $labsTableBody->addChild('tr');
		$labsTableRow->addChild('td', $labResultsSet[$labResultsSetName]['code']);
		$labsTableRow->addChild('td', $labResultsSetName);
		foreach ($labResultsDateIndex as $labResultsDate) {
			if (isset($labResultsSet[$labResultsSetName]['results'][$labResultsDate])) {
				$labsTableRow->addChild('td', $labResultsSet[$labResultsSetName]['results'][$labResultsDate][0]);
				$labsTableRow->addChild('td', $labResultsSet[$labResultsSetName]['results'][$labResultsDate][1]);
			} else {
				$labsTableRow->addChild('td')->addAttribute('colspan', 2);
			}
		}
	}
}

/*////////////////////////////////////////////////////////////////////////////////////////////////*/

foreach ($labsData as $labData) {

	$lab = $labs->addChild('entry');
	$lab->addAttribute('typeCode','DRIV');

	$organizer = $lab->addChild('organizer');
	$organizer->addAttribute('classCode', 'BATTERY');
	$organizer->addAttribute('moodCode', 'EVN');

	XMLaddManyChildren($organizer, array(
		'id' => array(
			'root' => '7d5a02b0-67a4-11db-bd13-0800200c9a66'
		),
		'code' => array(
			'code' => $labData['loincCode'],
			'codeSystem' => '2.16.840.1.113883.6.96',
			'displayName' => $labData['labName']
		),
		'statusCode' => array(
			'code' => 'completed' 
		),
		'effectiveTime' => array(
			'value' => $labData['labDate'] 
		)
	));

	foreach ($labData['labProcedures'] as $procedure) {

		$procedureComponent = $organizer->addChild('component')->addChild('procedure');	
		$procedureComponent->addAttribute('classCode', 'PROC');
		$procedureComponent->addAttribute('moodCode', 'EVN');
		XMLaddManyChildren($procedureComponent, array('templateId' => array('root' => '2.16.840.1.113883.3.88.11.83.17', 'assigningAuthorityName' => 'HITSP/C83')));
		XMLaddManyChildren($procedureComponent, array('templateId' => array('root' => '2.16.840.1.113883.10.20.1.29', 'assigningAuthorityName' => 'CCD')));
		XMLaddManyChildren($procedureComponent, array('templateId' => array('root' => '1.3.6.1.4.1.19376.1.5.3.1.4.19', 'assigningAuthorityName' => 'IHE PCC')));
		$procedureComponent->addChild('id');

		$procedureComponentCode = $procedureComponent->addChild('code');
		$procedureComponentCode->addChild('originalText', $procedure['procedureDescription'])->addChild('reference')->addAttribute('value', 'Ptr to text in parent Section');

		XMLaddManyAttributes($procedureComponentCode, array(
			'code' => $labData['loincCode'],
			'codeSystem' => '2.16.840.1.113883.6.96',
			'displayName' => $labData['labName']
		));

		$procedureComponent->addChild('text', $procedure['procedureDescription'])->addChild('reference')->addAttribute('value', 'PtrToParentInsectionText');
		$procedureComponent->addChild('statusCode')->addAttribute('code', $procedure['statusCode']);
		$procedureComponent->addChild('effectiveTime')->addAttribute('value', $labData['labDate']);

	}

	foreach ($labData['labResults'] as $observation) {

		$observationComponent = $organizer->addChild('component')->addChild('observation');	
		$observationComponent->addAttribute('classCode', 'OBS');
		$observationComponent->addAttribute('moodCode', 'EVN');
		XMLaddManyChildren($observationComponent, array('templateId' => array('root' => '2.16.840.1.113883.3.88.11.83.15.1', 'assigningAuthorityName' => 'HITSP/C83')));
		XMLaddManyChildren($observationComponent, array('templateId' => array('root' => '2.16.840.1.113883.10.20.1.31', 'assigningAuthorityName' => 'CCD')));
		XMLaddManyChildren($observationComponent, array('templateId' => array('root' => '1.3.6.1.4.1.19376.1.5.3.1.4.13', 'assigningAuthorityName' => 'IHE PCC')));
		$observationComponent->addChild('id')->addAttribute('root', '107c2dc0-67a5-11db-bd13-0800200c9a66');

		$observationComponentCode = $observationComponent->addChild('code');
		XMLaddManyAttributes($observationComponentCode, array(
			'code' => $observation['resultCode'],
			'codeSystem' => '2.16.840.1.113883.6.1',
			'displayName' => $observation['resultDisplayName']
		));

		$observationComponent->addChild('text')->addChild('reference')->addAttribute('value', 'PtrToValueInsectionText');

		XMLaddManyChildren($observationComponent, array(
			'statusCode' => array('code' => 'completed'),
			'effectiveTime' => array('value' => $labData['labDate'])
		));

		$observationComponentValue = $observationComponent->addChild('value');
		$observationComponentValue->addAttribute('xsi:type', 'PQ', $xsi);
		$observationComponentValue->addAttribute('value', $observation['resultMeasurement']);
		$observationComponentValue->addAttribute('unit', $observation['resultUnit']);

		XMLaddManyAttributes($observationComponent->addChild('interpretationCode'), array(
			'code' => $observation['resultAbnormal'],
			'codeSystem' => '2.16.840.1.113883.5.83'
		));

	}

}

/*////////////////////////////////////////////////////////////////////////////////////////////////*/
/*//// OUTPUT ////////////////////////////////////////////////////////////////////////////////////*/
/*////////////////////////////////////////////////////////////////////////////////////////////////*/

header('Content-type: text/xml');
echo $ccdXML->asXML();

?>