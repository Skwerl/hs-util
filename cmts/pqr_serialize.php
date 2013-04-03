<?php

$translate_context = 'pqr';
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

$pqriXML = new SimpleXMLElement('<submission xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" type="PQRI-REGISTRY" option="TEST" version="2.0" xsi:noNamespaceSchemaLocation="Registry_Payment.xsd"/>');

/*////////////////////////////////////////////////////////////////////////////////////////////////*/
/*//// SET UP AUDIT HEADER ///////////////////////////////////////////////////////////////////////*/
/*////////////////////////////////////////////////////////////////////////////////////////////////*/

$audit = $pqriXML->addChild('file-audit-data');
$creator = trim($in->cqmUser->title.' '.$in->cqmUser->firstName.' '.$in->cqmUser->lastName); 

$audit->addChild('create-date',date('m-d-Y'));
$audit->addChild('create-time',date('G:i'));
$audit->addChild('create-by',$creator);
$audit->addChild('version',1);
$audit->addChild('file-number',1);
$audit->addChild('number-of-files',1);

/*////////////////////////////////////////////////////////////////////////////////////////////////*/
/*//// SET UP REGISTRY HEADER ////////////////////////////////////////////////////////////////////*/
/*////////////////////////////////////////////////////////////////////////////////////////////////*/

$registry = $pqriXML->addChild('registry');
$registry->addChild('registry-name','Registry');
$registry->addChild('registry-id',0);
$registry->addChild('submission-method','A');

/*////////////////////////////////////////////////////////////////////////////////////////////////*/
/*//// MEASURES //////////////////////////////////////////////////////////////////////////////////*/
/*////////////////////////////////////////////////////////////////////////////////////////////////*/

$patientTotal = $in->cqmUser->groupSize;
$eligibleTotal = 0; foreach ($in->categories as $d) { $eligibleTotal += $d->qualfiedPatients; }

$measures = $pqriXML->addChild('measure-group');
$measures->addAttribute('ID','X');
$provider = $measures->addChild('provider');
$provider->addChild('npi',$in->cqmUser->groupNpi);
$provider->addChild('tin',$in->cqmUser->tin);
$provider->addChild('waiver-signed','Y');
$provider->addChild('encounter-from-date','01-01-2013');
$provider->addChild('encounter-to-date',date('m-d-Y'));

$groupStat = $provider->addChild('measure-group-stat');
$groupStat->addChild('ffs-patient-count',0);
$groupStat->addChild('group-reporting-rate-numerator',0);
$groupStat->addChild('group-eligible-instances',$eligibleTotal);
$groupStat->addChild('group-reporting-rate',100);

foreach ($in->categories as $measureData) {
	$patientReporting = $measureData->qualifiedPatients;
	$patientQualified = $measureData->patientsMeetingRequirement;
	$reportingPercent = ($patientReporting/$patientTotal)*100;
	$qualifiedPercent = ($patientQualified/$patientReporting)*100;
	$measure = $provider->addChild('pqri-measure');
	$measure->addChild('pqri-measure-number',$measureData->pqrs);
	$measure->addChild('eligible-instances',$patientReporting);
	$measure->addChild('meets-performance-instances',$patientQualified);
	$measure->addChild('performance-exclusion-instances',0);
	$measure->addChild('performance-not-met-instances',($patientReporting-$patientQualified));
	$measure->addChild('reporting-rate',100);
	$measure->addChild('performance-rate',round($qualifiedPercent,2));
}

/*////////////////////////////////////////////////////////////////////////////////////////////////*/
/*//// OUTPUT ////////////////////////////////////////////////////////////////////////////////////*/
/*////////////////////////////////////////////////////////////////////////////////////////////////*/

header('Content-type: text/xml');
echo $pqriXML->asXML();

?>