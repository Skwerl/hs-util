<?php

require_once('functions.php');

date_default_timezone_set('America/Los_Angeles');

$root_id = '2.16.840.1.113883.3.933';

/*////////////////////////////////////////////////////////////////////////////////////////////////*/
/*//// CREATE XML DOC ////////////////////////////////////////////////////////////////////////////*/
/*////////////////////////////////////////////////////////////////////////////////////////////////*/

$ccdXML = new SimpleXMLElement('<levelone></levelone>');
$ccdXML->addAttribute('xmlns', 'urn::hl7-org/cda');
$ccdXML->addAttribute('xmlns:xsi', 'http://www.w3.org/2001/XMLSchema-instance');
$ccdXML->addAttribute('xsi:schemalocation', 'urn::hl7-org/cda levelone_1.0.xsd');

/*////////////////////////////////////////////////////////////////////////////////////////////////*/
/*//// SET UP CCD HEADER /////////////////////////////////////////////////////////////////////////*/
/*////////////////////////////////////////////////////////////////////////////////////////////////*/

$ccdHeader = $ccdXML->addChild('clinical_document_header');
XMLaddManyAttributes($ccdHeader->addChild('id'), array(
	'ex' => '1234',
	'rt' => $root_id
));
XMLaddManyAttributes($ccdHeader->addChild('document_type_cd'), array(
	'v' => '11488-4',
	's' => '12.16.840.1.113883.6.1',
	'dn' => 'CCD Export'
));
$ccdHeader->addChild('origination_dttm')->addAttribute('v',date('Y-m-d'));

/*//// HEADER / PATIENT ENCOUNTER ////////////////////////////////////////////////////////////////*/

$patientEncounter = $ccdHeader->addChild('patient_encounter');
XMLaddManyAttributes($patientEncounter->addChild('id'), array(
	'ex' => 'KPENC1332',
	'rt' => $root_id
));
XMLaddManyAttributes($patientEncounter->addChild('practice_setting_cd'), array(
	'v' => 'GIM',
	's' => '2.16.840.1.113883.5.10588',
	'dn' => 'Dr. Foo Practice'
));
$patientEncounter->addChild('encounter_tmr')->addAttribute('v',date('Y-m-d'));

/*//// LEGAL AUTHENTICATOR ///////////////////////////////////////////////////////////////////////*/

$legalAuthenticator = $ccdHeader->addChild('legal_authenticator');

$legalAuthenticator->addChild('legal_authenticator.type_cd')->addAttribute('v','SPV');
$legalAuthenticator->addChild('participation_tmr')->addAttribute('v',date('Y-m-d'));
$legalAuthenticator->addChild('signature_cd')->addAttribute('v','S');

$legalAuthenticatorPerson = $legalAuthenticator->addChild('person');
XMLaddManyAttributes($legalAuthenticatorPerson->addChild('id'), array(
	'ex' => 'KP00017',
	'rt' => $root_id
));

$legalAuthenticatorPersonNm = $legalAuthenticatorPerson->addChild('person_name');
XMLaddManyChildren($legalAuthenticatorPersonNm->addChild('nm'), array(
	'giv' => array('v' => 'Robert'),
	'fam' => array('v' => 'Dolin'),
	'sfx' => array('v' => 'MD', 'qual' => 'PT')
));
XMLaddManyAttributes($legalAuthenticatorPersonNm->addChild('person_name.type_cd'), array(
	'v' => 'L',
	's' => '2.16.840.1.113883.5.200'
));

/*//// ORIGINATOR ////////////////////////////////////////////////////////////////////////////////*/

$originator = $ccdHeader->addChild('originator');
$originator->addChild('originator.type_cd')->addAttribute('v','AUT');
$originator->addChild('participation_tmr')->addAttribute('v',date('Y-m-d'));

$originatorPerson = $originator->addChild('person');
XMLaddManyAttributes($originatorPerson->addChild('id'), array(
	'ex' => 'KP00017',
	'rt' => $root_id
));

/*//// ORIGINATING ORGANIZATION //////////////////////////////////////////////////////////////////*/

$originatingOrganization = $ccdHeader->addChild('originating_organization');
$originatingOrganization->addChild('originating_organization.type_cd')->addAttribute('v','CST');

$originatingOrganizationOrganization = $originatingOrganization->addChild('organization');
XMLaddManyAttributes($originatingOrganizationOrganization->addChild('id'), array(
	'ex' => 'M345',
	'rt' => $root_id
));
$originatingOrganizationOrganization->addChild('organization.nm')->addAttribute('v','Foo Clinic');

/*//// PROVIDER //////////////////////////////////////////////////////////////////////////////////*/

$provider = $ccdHeader->addChild('provider');
$provider->addChild('provider.type_cd')->addAttribute('v','CON');
$provider->addChild('participation_tmr')->addAttribute('v',date('Y-m-d'));

$providerPerson = $provider->addChild('person');
XMLaddManyAttributes($providerPerson->addChild('id'), array(
	'ex' => 'KP00017',
	'rt' => $root_id
));

/*//// PATIENT ///////////////////////////////////////////////////////////////////////////////////*/

$patient = $ccdHeader->addChild('patient');
$patient->addChild('patient.type_cd')->addAttribute('v','PATSBJ');

$patientPerson = $patient->addChild('person');

XMLaddManyAttributes($patientPerson->addChild('id'), array(
	'ex' => '12345',
	'rt' => $root_id
));

$patientPersonNm = $patientPerson->addChild('person_name');
XMLaddManyChildren($patientPersonNm->addChild('nm'), array(
	'giv' => array('v' => 'Henry'),
	'fam' => array('v' => 'Levin'),
	'sfx' => array('v' => 'III')
));

XMLaddManyAttributes($patientPersonNm->addChild('person_name.type_cd'), array(
	'v' => 'L',
	's' => '2.16.840.1.113883.5.200'
));

$patientBirthdate = $patient->addChild('birth_dttm')->addAttribute('v',date('Y-m-d',strtotime('September 24 1932')));

XMLaddManyAttributes($patient->addChild('administrative_gender_cd'), array(
	'v' => 'M',
	's' => '2.16.840.1.113883.5.1'
));

/*////////////////////////////////////////////////////////////////////////////////////////////////*/
/*//// BODY //////////////////////////////////////////////////////////////////////////////////////*/
/*////////////////////////////////////////////////////////////////////////////////////////////////*/

$ccdBody = $ccdXML->addChild('body');

/*//// MEDICAL HISTORY ///////////////////////////////////////////////////////////////////////////*/

$presentIllness = 'Henry Levin, the 7th is a 67 year old male referred for further asthma management. Onset of asthma in his teens. He was hospitalized twice last year, and already twice this year. He has not been able to be weaned off steroids for the past several months.';
XMLaddParagraphSection($ccdBody, 'History of Present Illness', $presentIllness);

$medicationHistory = array(
	'Asthma',
	'Hypertension',
	'Osteoarthritis, right knee'
);
XMLaddListSection($ccdBody, 'Past Medical History', $medicationHistory);

/*//// MEDICATIONS ///////////////////////////////////////////////////////////////////////////////*/

$medicationList = array(
	'Theodur 200mg BID',
	'Proventil inhaler 2puffs QID PRN',
	'Prednisone 20mg qd',
	'HCTZ 25mg qd'
);
XMLaddListSection($ccdBody, 'Medications', $medicationList);

/*//// ALLERGIES ///////////////////////////////////////////////////////////////////////////////*/

$allergyList = array(
	'Penicillin - Hives',
	'Aspirin - Wheezing'
);
XMLaddListSection($ccdBody, 'Allergies', $allergyList);

/*//// SOCIAL HISTORY ////////////////////////////////////////////////////////////////////////////*/

$socialHistory = array(
	'Smoking: 1 PPD between the ages of 20 and 55, and then he quit',
	'Alcohol: rare'
);
XMLaddListSection($ccdBody, 'Social History', $socialHistory);

/*//// PHYSICAL EXAMINATION //////////////////////////////////////////////////////////////////////*/

$physicalExamination = $ccdBody->addChild('section');
$physicalExamination->addChild('caption','Physical Examination');
$vitalSigns = array(
	'BP: 118/78',
	'Resp: 16 and unlabored',
	'T: 98.6F',
	'HR: 86 and regular',
);
XMLaddListSection($physicalExamination, 'Vital Signs', $vitalSigns);

/*//// LABS //////////////////////////////////////////////////////////////////////////////////////*/

$labResults = array(
	'CXR 02/03/1999: Hyperinflated. Normal cardiac silhouette, clear lungs.',
	'Peak Flow today: 260 l/m'
);
XMLaddListSection($ccdBody, 'Labs', $labResults);

/*//// ASSESSMENT ////////////////////////////////////////////////////////////////////////////////*/

$assessment = array(
	'Asthma, with prior smoking history. Difficulty weaning off steroids. Will try gradual taper.',
	'Hypertension, well-controlled.',
	'Contact dermatitis on finger.',
);
XMLaddListSection($ccdBody, 'Assessment', $assessment);

/*//// PLAN //////////////////////////////////////////////////////////////////////////////////////*/

$plan = array(
	'Complete PFTs with lung volumes.',
	'Chem-7',
	'Provide educational material on inhaler usage and peak flow self-monitoring.',
	'Decrease prednisone to 20qOD alternating with 18qOD.',
	'Hydrocortisone cream to finger BID.',
	'RTC 1 week.'
);
XMLaddListSection($ccdBody, 'Plan', $plan);

/*////////////////////////////////////////////////////////////////////////////////////////////////*/
/*//// OUTPUT ////////////////////////////////////////////////////////////////////////////////////*/
/*////////////////////////////////////////////////////////////////////////////////////////////////*/

header('Content-type: text/xml');
echo $ccdXML->asXML();

?>