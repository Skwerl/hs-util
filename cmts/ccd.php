<?php

require_once('functions.php');

date_default_timezone_set('America/Los_Angeles');

/*////////////////////////////////////////////////////////////////////////////////////////////////*/
/*//// CREATE XML DOC ////////////////////////////////////////////////////////////////////////////*/
/*////////////////////////////////////////////////////////////////////////////////////////////////*/

$ccdXML = new SimpleXMLElement('<ClinicalDocument></ClinicalDocument>');
$ccdXML->addAttribute('xmlns', 'urn:hl7-org:v3');
$ccdXML->addAttribute('xmlns:xsi', 'http://www.w3.org/2001/XMLSchema-instance');
$ccdXML->addAttribute('xsi:schemalocation', 'urn:hl7-org:v3 http://xreg2.nist.gov:8080/hitspValidation/schema/cdar2c32/infrastructure/cda/C32_CDA.xsd');

/*////////////////////////////////////////////////////////////////////////////////////////////////*/
/*//// SET UP CCD HEADER /////////////////////////////////////////////////////////////////////////*/
/*////////////////////////////////////////////////////////////////////////////////////////////////*/

$ccdXML->addChild('realmCode')->addAttribute('code','US');

XMLaddManyChildren($ccdXML, array('templateId' => array('root' => '2.16.840.1.113883.3.27.1776', 'assigningAuthorityName' => 'CDA/R2')));
XMLaddManyChildren($ccdXML, array('templateId' => array('root' => '2.16.840.1.113883.10.20.3', 'assigningAuthorityName' => 'HL7/CDT Header')));
XMLaddManyChildren($ccdXML, array('templateId' => array('root' => '1.3.6.1.4.1.19376.1.5.3.1.1.1', 'assigningAuthorityName' => 'IHE/PCC')));
XMLaddManyChildren($ccdXML, array('templateId' => array('root' => '2.16.840.1.113883.3.88.11.32.1', 'assigningAuthorityName' => 'HITSP/C32')));

XMLaddManyChildren($ccdXML, array(
	'id' => array(
		'root' => '2.16.840.1.113883.3.72',
		'extension' => 'MU_Rev2_HITSP_C32C83_4Sections_MeaningfulEntryContent_NoErrors',
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
		'value' => date('YmdHis')
	),
	'confidentialityCode' => array(
		// null
	),
	'languageCode' => array(
		'code' => 'en-US'
	)
));

/*////////////////////////////////////////////////////////////////////////////////////////////////*/
/*//// PATIENT ROLE //////////////////////////////////////////////////////////////////////////////*/
/*////////////////////////////////////////////////////////////////////////////////////////////////*/

$patientRole = $ccdXML->addChild('recordTarget')->addChild('patientRole');

XMLaddManyAttributes($patientRole->addChild('id'), array(
	'root' => 'ProviderID',
	'extension' => 'PatientID',
	'assigningAuthorityName' => 'Provider Name'
));

$address = $patientRole->addChild('addr');
$address->addAttribute('use', 'HP');
$address->addChild('streetAddressLine', 'Address Line 1');
$address->addChild('streetAddressLine', 'Address Line 2');
$address->addChild('city', 'City');
$address->addChild('state', 'State');
$address->addChild('postalCode', '10101');
$address->addChild('country', 'USA');

$patientRole->addChild('telecom');

$patient = $patientRole->addChild('patient');
$patientName = $patient->addChild('name');
$patientName->addChild('given', 'FirstName');
$patientName->addChild('given', 'M');
$patientName->addChild('family', 'LastName');

XMLaddManyAttributes($patient->addChild('administrativeGenderCode'), array(
	'code' => 'F',
	'displayName' => 'Female',
	'codeSystem' => '2.16.840.1.113883.5.1',
	'codeSystemName' => 'HL7 AdministrativeGender'
));

$patient->addChild('birthTime')->addAttribute('value', date('Ymd'));

XMLaddManyAttributes($patient->addChild('maritalStatusCode'), array(
	'code' => 'S',
	'displayName' => 'Single',
	'codeSystem' => '2.16.840.1.113883.5.2',
	'codeSystemName' => 'HL7 Marital status'
));

$languageCommunication = $patient->addChild('languageCommunication');
XMLaddManyAttributes($languageCommunication->addChild('templateId'), array(
	'root' => '2.16.840.1.113883.3.88.11.83.2',
	'assigningAuthorityName' => 'HITSP/C83'
));
XMLaddManyAttributes($languageCommunication->addChild('templateId'), array(
	'root' => '1.3.6.1.4.1.19376.1.5.3.1.2.1',
	'assigningAuthorityName' => 'IHE/PCC'
));

$languageCommunication->addChild('languageCode')->addAttribute('code', 'en-US');

/*////////////////////////////////////////////////////////////////////////////////////////////////*/
/*//// AUTHOR ////////////////////////////////////////////////////////////////////////////////////*/
/*////////////////////////////////////////////////////////////////////////////////////////////////*/

$author = $ccdXML->addChild('author');
$author->addChild('time')->addAttribute('code', date('YmdHis'));
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
	'Type' => 'ALGTYPE',
	'Substance' => 'ALGSUB',
	'Reaction' => 'ALGREACT',
	'Status' => 'ALGSTATUS',
));
$allergiesData = array(
	array(
		'Drug Allergy',
		'Penicillin',
		'Hives',
		'Active',
		'Meta' => array(
			'typeCode' => 'SUBJ',
			'statusCode' => 'completed',
			'inversionInd' => 'false',
			'allergyCode' => '416098002',
			'allergyName' => 'Penicillin'
		)
	),
	array(
		'Drug Intolerance',
		'Aspirin',
		'Wheezing',
		'Active',
		'Meta' => array(
			'typeCode' => 'SUBJ',
			'statusCode' => 'completed',
			'inversionInd' => 'false',
			'allergyCode' => '416098002',
			'allergyName' => 'Aspirin'
		)
	),
	array(
		'Drug Intolerance',
		'Codeine',
		'Nausea',
		'Active',
		'Meta' => array(
			'typeCode' => 'SUBJ',
			'statusCode' => 'completed',
			'inversionInd' => 'false',
			'allergyCode' => '416098002',
			'allergyName' => 'Codeine'
		)
	)
);

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
			'code' => $allergyMeta['statusCode']
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
	$observation->addChild('statusCode')->addAttribute('code', $allergyMeta['statusCode']);
	$observation->addChild('effectiveTime')->addChild('low')->addAttribute('nullFlavor', 'UNK');

	$observationValue = $observation->addChild('value');
	XMLaddManyAttributes($observationValue, array(
		'xsi:type' => 'CD',
		'code' => $allergyMeta['allergyCode'],
		'codeSystem' => '2.16.840.1.113883.6.88',
		'displayName' => $allergyMeta['allergyName'],
		'codeSystemName' => 'RxNorm'
	));
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
		'xsi:type' => 'CD',
		'code' => $allergyMeta['allergyCode'],
		'codeSystem' => '2.16.840.1.113883.6.88',
		'displayName' => $allergyMeta['allergyName'],
		'codeSystemName' => 'RxNorm'
	));
	$observationParticipantRolePlayingEntity->addChild('name', $allergyMeta['allergyName']);
	
	$allergyIndex++;

}

/*////////////////////////////////////////////////////////////////////////////////////////////////*/
/*//// PROBLEMS //////////////////////////////////////////////////////////////////////////////////*/
/*////////////////////////////////////////////////////////////////////////////////////////////////*/

$problemsSchema = array('PROBSUMMARY' => array(
	'Problem' => 'PROBKIND',
	'Effective Dates' => 'PROBDATE',
	'Problem Status' => 'PROBSTATUS',
));
$problemsData = array(
	array(
		'Asthma',
		'1950',
		'Active',
		'Meta' => array(
			'problemName' => 'Asthma',
			'problemCode' => '195967001',
			'lowValue' => '1950',
			'typeCode' => 'SUBJ',
			'statusCode' => 'completed',
			'inversionInd' => 'false',
		)
	),
	array(
		'Pneumonia',
		'Mar 1999',
		'Resolved',
		'Meta' => array(
			'problemName' => 'Pneumonia',
			'problemCode' => '195967001',
			'lowValue' => 'Mar 1999',
			'typeCode' => 'SUBJ',
			'statusCode' => 'completed',
			'inversionInd' => 'false',
		)
	),
	array(
		'Myocardial Infarction',
		'Jan 1997',
		'Resolved',
		'Meta' => array(
			'problemName' => 'Myocardial Infarction',
			'problemCode' => '195967001',			
			'lowValue' => 'Jan 1997',
			'typeCode' => 'SUBJ',
			'statusCode' => 'completed',
			'inversionInd' => 'false',
		)
	),
	array(
		'Pregnancy',
		'Oct 26, 2010',
		'NOT currently pregnant',
		'Meta' => array(
			'problemName' => 'Pregnancy',
			'problemCode' => '195967001',			
			'lowValue' => 'Oct 26, 2010',
			'typeCode' => 'SUBJ',
			'statusCode' => 'completed',
			'inversionInd' => 'false',
		)
	)
);

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
			'code' => $problemMeta['statusCode']
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
	$observation->addChild('statusCode')->addAttribute('code', $problemMeta['statusCode']);
	$observation->addChild('effectiveTime')->addChild('low')->addAttribute('value', $problemMeta['lowValue']);

	$observationValue = $observation->addChild('value');
	XMLaddManyAttributes($observationValue, array(
		'xsi:type' => 'CD',
		'code' => $problemMeta['problemCode'],
		'codeSystem' => '2.16.840.1.113883.6.96',
		'displayName' => $problemMeta['problemName'],
		'codeSystemName' => 'SNOMED CT'
	));
	
	$problemIndex++;

}

/*////////////////////////////////////////////////////////////////////////////////////////////////*/
/*//// MEDICATIONS ///////////////////////////////////////////////////////////////////////////////*/
/*////////////////////////////////////////////////////////////////////////////////////////////////*/

$medicationsSchema = array('MEDSUMMARY' => array(
	'Medication' => 'MEDNAME',
	'Dose' => 'MEDDOSE',
	'Form' => 'MEDFORM',
	'Route' => 'MEDROUTE',
	'Sig Text' => 'SIGTXT',
	'Dates' => 'MEDDATES',
	'Status' => 'MEDSTATUS',
));
$medicationsData = array(
	array(
		'Albuterol inhalant',
		'2 puffs',
		'inhaler',
		'inhale',
		'2 puffs QID PRN (as needed for wheezing)',
		'July 2005+',
		'Active',
		'Meta' => array(
			'medicationName' => 'Albuterol inhalant',
			'medicationCode' => '195967001',
			'adminCode' => 'inhaler',
			'routeCode' => 'inhallation',
			'doseValue' => '2',
			'doseUnit' => 'puffs',
			'lowValue' => '1950',
			'typeCode' => 'SUBJ',
			'statusCode' => 'completed',
			'inversionInd' => 'false'
		)
	),
	array(
		'clopidogrel (Plavix)',
		'75 mg',
		'tablet',
		'oral',
		'75mg PO daily',
		'unknown',
		'Active',
		'Meta' => array(
			'medicationName' => 'clopidogrel (Plavix)',
			'medicationCode' => '195967001',
			'adminCode' => 'tablet',
			'routeCode' => 'taken orally',
			'doseValue' => '75',
			'doseUnit' => 'mg',
			'lowValue' => '1950',
			'typeCode' => 'SUBJ',
			'statusCode' => 'active',
			'inversionInd' => 'false'
		)
	)
);

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
	$substanceAdministration->addChild('statusCode')->addAttribute('code', $medicationMeta['statusCode']);

	$substanceAdministrationEffectiveTime = $substanceAdministration->addChild('effectiveTime');
	$substanceAdministrationEffectiveTime->addAttribute('xsi:type', 'IVL_TS');
	XMLaddManyChildren($substanceAdministrationEffectiveTime, array(
		'low' => array(
			'value' => $medicationMeta['lowValue']
		),
		'high' => array(
			'nullFlavor' => 'UNK'
		)
	));

	$substanceAdministrationEffectiveTime = $substanceAdministration->addChild('effectiveTime');
	$substanceAdministrationEffectiveTime->addAttribute('xsi:type', 'PIVL_TS');
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

	$substanceAdministration->addChild('administrationUnitCode')->addChild('originalText', $medicationMeta['adminCode']);

	$manufacturedProduct = $medication->addChild('consumable')->addChild('manufacturedProduct');
	XMLaddManyChildren($manufacturedProduct, array('templateId' => array('root' => '2.16.840.1.113883.3.88.11.83.8.2', 'assigningAuthorityName' => 'HITSP/C83')));
	XMLaddManyChildren($manufacturedProduct, array('templateId' => array('root' => '2.16.840.1.113883.10.20.1.53', 'assigningAuthorityName' => 'CCD')));
	XMLaddManyChildren($manufacturedProduct, array('templateId' => array('root' => '1.3.6.1.4.1.19376.1.5.3.1.4.7.2', 'assigningAuthorityName' => 'IHE PCC')));

	$manufacturedMaterialCode = $manufacturedProduct->addChild('manufacturedMaterial')->addChild('code');
	$manufacturedMaterialCode->addChild('originalText', $medicationMeta['medicationName'])->addChild('reference');
	XMLaddManyAttributes($manufacturedMaterialCode, array(
		'code' => $medicationMeta['medicationCode'],
		'codeSystem' => '2.16.840.1.113883.6.88',
		'displayName' => $medicationMeta['medicationName'],
		'codeSystemName' => 'RxNorm'
	));

	$medicationIndex++;

}

/*////////////////////////////////////////////////////////////////////////////////////////////////*/
/*//// OUTPUT ////////////////////////////////////////////////////////////////////////////////////*/
/*////////////////////////////////////////////////////////////////////////////////////////////////*/

header('Content-type: text/xml');
echo $ccdXML->asXML();

?>