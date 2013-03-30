<?php

$HL7abnormalFlags = array(
	'<' => 'Below Absolute Low-Off Instrument Scale',
	'>' => 'Above Absolute High-Off Instrument Scale',
	'A' => 'Abnormal (Applies to Non-Numeric Results)',
	'AA' => 'Very Abnormal (Applies to Non-Numerics Units, Analogous to Panic Limits for Numerical Limits',
	'B' => 'Better; Use When Direction Not Relevant',
	'D' => 'Significant Change Down',
	'H' => 'Above High Normal',
	'HH' => 'Above Upper Panic Limits',
	'I' => 'Intermediate',
	'L' => 'Below Low Normal',
	'LL' => 'Below Lower Panic Limits',
	'MS' => 'Moderately Sensitive',
	'N' => 'Normal (Applies to Non-Numeric Results)',
	'NULL' => 'No Range Defined, or Normal Ranges Don\'t Apply',
	'R' => 'Resistant',
	'S' => 'Sensitive',
	'U' => 'Significant Change Up',	
	'VS' => 'Very Sensitive',	
	'W' => 'Worse; Use When Direction Not Relevant'
);

$HL7martialCodes = array(
	'N' => 'Annulled',
	'C' => 'Common law',
	'D' => 'Divorced',
	'P' => 'Domestic partner',
	'I' => 'Interlocutory',
	'E' => 'Legally Separated',
	'G' => 'Living together',
	'M' => 'Married',
	'O' => 'Other',
	'R' => 'Registered domestic partner',
	'A' => 'Separated',
	'S' => 'Single',
	'U' => 'Unknown',
	'B' => 'Unmarried',
	'T' => 'Unreported',
	'W' => 'Widowed'	
);

$HL7raceCodes = array(
	'A' => 'Asian or Pacific Islander',
	'B' => 'Black or African-American',
	'H' => 'Hispanic',
	'I' => 'American Indian or Alaska Native',
	'O' => 'Other',
	'U' => 'Unknown',
	'W' => 'White'
);

$HL7ethnicityCodes = array(
	'H' => 'Hispanic or Latino',
	'N' => 'not Hispanic or Latino',
	'NH' => 'not Hispanic or Latino',
	'U' => 'Unknown'
);

?>