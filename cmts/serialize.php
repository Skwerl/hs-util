<?php

/*//// PREPARE INPUT /////////////////////////////////////////////////////////////////////////////*/

$postdata = file_get_contents("php://input");
$cleaned = preg_replace("!\s+!m",' ',urldecode($postdata));
$posted_obj = json_decode($cleaned); 

// Simulate a post
#require_once('sample_post.php');

$in = $posted_obj;

/*//// MSH SEGMENT ///////////////////////////////////////////////////////////////////////////////*/

$hl7Header->setField(9, $type_string);

$msg =& new Net_HL7_Message(null, $hl7Globals);
$msg->addSegment($hl7Header);

/*//// PID SEGMENT ///////////////////////////////////////////////////////////////////////////////*/

$pid = new Net_HL7_Segment('PID');
$pid->setField(3, $in->patient->externalId);
$pid->setField(4, implode($cs, array($in->patient->lastName,$in->patient->firstName)));
$pid->setField(7, date('Ymd',strtotime($in->patient->dob)));
$pid->setField(16, $in->patient->ssn);
$pid->setField(8, $in->patient->gender);
$pid->setField(10, $in->patient->race);
$pid->setField(22, $in->patient->ethnicity);

$addr_collapsed = array();
$countries = array();
foreach ($in->patient->address as $address) {
	$addr_collapsed[] = implode($cs, array(
		$address->address1,
		$address->address2,
		$address->city,
		$address->state,
		$address->postalCode
	));
	$countries[] = $address->countryCode;
}
$pid->setField(11, implode($rs,$addr_collapsed));
$pid->setField(12, implode($rs,array_unique($countries)));

foreach ($in->patient->phone as $ph) {
	if ($ph->type == 'HOME') { $pid->setField(13, '('.$ph->areaCode.')'.$ph->prefix.'-'.$ph->suffix); }
	if ($ph->type == 'OFFICE') { $pid->setField(14, '('.$ph->areaCode.')'.$ph->prefix.'-'.$ph->suffix); }
}

$msg->addSegment($pid);

/*//// PV1 SEGMENT ///////////////////////////////////////////////////////////////////////////////*/

foreach ($in->soapNote as $soap) {
	$pv1 = new Net_HL7_Segment('PV1');
	$pv1->setField(2, 'O');
	$pv1->setField(26, date('YmdHis',strtotime($soap->subjective->appointmentDate)));
	$msg->addSegment($pv1);
}

/*//// DG1 SEGMENT ///////////////////////////////////////////////////////////////////////////////*/

foreach ($in->problem as $problem) {
	$dg1 = new Net_HL7_Segment('DG1');
	$dg1->setField(4, $problem->icd9->code.$cs.$problem->icd9->desc);
	$dg1->setField(5, date('YmdHis',strtotime($problem->problemStartedAt)));
	$msg->addSegment($dg1);
}

/*//// RXD SEGMENT ///////////////////////////////////////////////////////////////////////////////*/

foreach ($in->medicationProfile->medication as $medication) {
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

/*//// AL1 SEGMENT ///////////////////////////////////////////////////////////////////////////////*/

foreach ($in->allergy as $allergy) {
	$al1 = new Net_HL7_Segment('AL1');
	$al1->setField(3, $allergy->ndcidCode.$cs.$allergy->name.$cs.'NDC');
	$al1->setField(5, $allergy->allergicReaction);
	$al1->setField(6, date('YmdHis',strtotime($allergy->allergicReactionDate)));
	$msg->addSegment($al1);
}

/*//// RXA SEGMENT ///////////////////////////////////////////////////////////////////////////////*/

foreach ($in->immunization as $immunization_group) {
	foreach ($immunization_group as $immunization) {
		$rxa = new Net_HL7_Segment('RXA');
		$rxa->setField(3, date('YmdHis',strtotime($immunization->activityTime)));
		$rxa->setField(4, date('YmdHis',strtotime($immunization->activityTime)));
		$rxa->setField(5, $immunization->cvxCode.$cs.$immunization->vaccine.$cs.'CVX');
		$rxa->setField(6, $immunization->administeredAmount);
		$rxa->setField(9, $immunization->notes);
		$msg->addSegment($rxa);
	}
}

/*//// IN1 SEGMENT ///////////////////////////////////////////////////////////////////////////////*/

foreach ($in->patient->insurance as $insurance) {
	$in1 = new Net_HL7_Segment('IN1');
	$in1->setField(4, $insurance->name);
	$in1->setField(49, $insurance->carrierPayerId);
	$msg->addSegment($in1);
}

/*//// OUTPUT MESSAGE ////////////////////////////////////////////////////////////////////////////*/

$output = $msg->toString(1);

echo $output; ?>