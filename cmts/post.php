<?php require_once('globals.php'); ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Test Console</title>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>

<style type="text/css">
	#output {
		font-family: "Courier New", Courier, monospace;
		font-size: 12px;
		width: 100%;
		word-wrap: break-word;
	}
</style>

</head>

<body>
<div id="everything">
	<form id="form1" name="form1" method="post">
		<textarea name="data1" id="data1" cols="100" rows="10">{
    "patient": {
        "identity": "5876360a-9ca7-469c-a586-03f706be038f",
        "firstName": "exporting",
        "lastName": "patient",
        "ssn": "345-34-1130",
        "address": [
            {
                "name": "Home",
                "address1": "2645 Mulberry Lane",
                "address2": "",
                "city": "Toledo",
                "state": "OH",
                "postalCode": "43605",
                "countryCode": "US",
                "phone": [
                    {
                        "areaCode": "234",
                        "prefix": "837",
                        "suffix": "2345",
                        "type": "OFFICE"
                    }
                ]
            }
        ],
        "phone": null,
        "email": null,
        "dob": "1960-05-24",
        "gender": "M",
        "language": "English",
        "patientConsent": null,
        "maritalStatus": null,
        "race": "A",
        "ethnicity": "H",
        "smoking": 2,
        "paymentProfile": null,
        "emergency": [
            {
                "name": "emergency",
                "phone": {
                    "areaCode": "234",
                    "prefix": "837",
                    "suffix": "2345",
                    "type": "OFFICE"
                }
            }
        ],
        "subscriberIsPatient": null,
        "insurance": null,
        "externalId": "5371483",
        "middleName": "a",
        "suffix": null,
        "preferredContact": null,
        "smokingFrequency": "1 pack/day",
        "ageInYears": 52
    },
    "medication": [
        {
            "drug": {
                "rcopiaId": null,
                "ndcid": "00071015640",
                "brandName": "Lipitor",
                "genericName": null,
                "fullDescription": null,
                "brandType": null,
                "form": "Tablet",
                "strength": null,
                "routeCode": null,
                "rxNormType": null,
                "rxNormId": null,
                "drugGroup": null
            },
            "note": [],
            "patientPrescription": [
                {
                    "prescribe": {
                        "prescribeIdentity": "bb8a8331-af3e-4d14-ab0f-8d0e8d24fc97",
                        "patientIdentity": "5876360a-9ca7-469c-a586-03f706be038f",
                        "patientExternalIdentity": "",
                        "pharmacyIdentity": "",
                        "hasScheduledDrug": false,
                        "stopDate": null,
                        "addToMedicationList": true,
                        "sig": {
                            "drug": {
                                "rcopiaId": null,
                                "ndcid": "00071015640",
                                "brandName": "Lipitor",
                                "genericName": null,
                                "fullDescription": null,
                                "brandType": null,
                                "form": "Tablet",
                                "strength": null,
                                "routeCode": null,
                                "rxNormType": null,
                                "rxNormId": null,
                                "drugGroup": null
                            },
                            "action": "Apply",
                            "dose": "1",
                            "doseUnit": "tablet",
                            "route": "as directed",
                            "doseTiming": "once a day",
                            "doseOther": null,
                            "duration": "7 days",
                            "quantity": "14",
                            "quantityUnits": "tablets",
                            "refills": "2",
                            "substitutionPermitted": true,
                            "otherNotes": "Other Notes",
                            "patientNotes": "Patient Notes",
                            "comments": "Comments",
                            "schedule": null,
                            "writtenDate": null,
                            "effectiveDate": null,
                            "lastFillDate": null,
                            "soldDate": null
                        },
                        "checkId": null,
                        "signaturePassword": "1234",
                        "prescriberOrderNumber": null,
                        "rxReferenceNumber": null,
                        "formularyNote": null,
                        "interactionNote": null,
                        "allergyReaction": null,
                        "interactionReaction": null,
                        "drugInteractionCheckPerformed": false,
                        "icd9": null,
                        "ePrescribe": false,
                        "createdBy": "e61b13d5-dac2-4384-b81f-90049813b635",
                        "createdByFirstName": "chuck",
                        "createdByLastName": "norris"
                    },
                    "createdAt": 1363309359303,
                    "createdBy": "e61b13d5-dac2-4384-b81f-90049813b635",
                    "active": true
                }
            ],
            "active": true,
            "source": "SOCIAL_CARE"
        }
    ],
    "problem": [
        {
            "problemNoteIdentity": "b7c0375e-75e5-4072-9fe7-ad2a2a95b15d",
            "icd9": {
                "code": "246.9",
                "desc": "Unspecified disorder of thyroid"
            },
            "note": "Low blood sugar",
            "problemStartedAt": "2009-12-24",
            "problemStoppedAt": null,
            "soapNoteIdentity": null,
            "significant": true,
            "active": false,
            "updatedAt": "2013-03-15T01:02:39.459Z",
            "createdBy": "e61b13d5-dac2-4384-b81f-90049813b635"
        },
        {
            "problemNoteIdentity": "986ebd3d-2209-4cbf-9407-8bdceccbc81a",
            "icd9": {
                "code": "004.3",
                "desc": "Shigella sonnei"
            },
            "note": null,
            "problemStartedAt": null,
            "problemStoppedAt": null,
            "soapNoteIdentity": "d03fc4aa-dbb9-4c76-bcf2-137d50593606",
            "significant": false,
            "active": true,
            "updatedAt": "2013-03-15T01:02:38.796Z",
            "createdBy": "e61b13d5-dac2-4384-b81f-90049813b635"
        },
        {
            "problemNoteIdentity": "803232e6-01e1-4293-b644-6cd4c591d82b",
            "icd9": {
                "code": "001.0",
                "desc": "Cholera due to vibrio cholarae"
            },
            "note": null,
            "problemStartedAt": null,
            "problemStoppedAt": null,
            "soapNoteIdentity": "d03fc4aa-dbb9-4c76-bcf2-137d50593606",
            "significant": false,
            "active": true,
            "updatedAt": "2013-03-15T01:02:38.796Z",
            "createdBy": "e61b13d5-dac2-4384-b81f-90049813b635"
        }
    ],
    "allergy": [
        {
            "identity": "6f230362-9bac-4bc5-a5c6-426bbd5e1495",
            "name": "Allergy to penicillin",
            "ndcidCode": null,
            "allergyGroupId": null,
            "active": true,
            "allergicReaction": "Rash",
            "allergicReactionDate": "2001-01-01",
            "snomed": "91936005",
            "substance": null,
            "reaction": null,
            "createdAt": "2013-03-15",
            "updatedAt": "2013-03-15"
        }
    ],
    "immunization": [
        {
            "createTime": "2013-03-15T01:02:39.678Z",
            "vaccine": "Pneumococcal Polysaccharide Vaccine",
            "notes": "Administered Flu Shot for patient",
            "userAssertion": "CONFIRMED",
            "activityTime": "2012-11-02",
            "activityBy": "CVS Pharmacy",
            "administeredAmount": "3",
            "administeredUnit": "vl",
            "vaccineLotNumber": "003843",
            "manufacturerName": "Merck",
            "manufacturerCode": "ME-394",
            "cvxCode": "33"
        }
    ],
    "soapNote": [
        {
            "identity": "d03fc4aa-dbb9-4c76-bcf2-137d50593606",
            "subjective": {
                "chiefComplaint": "Knee pain",
                "note": "motorcycle injury",
                "symptoms": [
                    "grinding",
                    "headache",
                    "ear pain"
                ],
                "historyOfCurrentIllness": "previous surgery",
                "appointmentDate": "2012-01-19"
            },
            "objectiveVitals": {
                "vitalNotes": "getting basic measurements",
                "temperature": 99.1,
                "heightFeet": 5,
                "heightInches": 9,
                "respiratoryRate": 10,
                "weight": 165.3,
                "bpSystolic": 120,
                "bpDiastolic": 80,
                "pulse": 75,
                "headCircumference": 20.7,
                "oxygenSaturation": 82,
                "smoking": 2,
                "painPoints": [
                    {
                        "painLocation": "UPPER SHOULDER",
                        "painLevel": 3
                    }
                ],
                "smokingFrequency": "1 pack/day",
                "bmi": 24.410273
            },
            "objectivePhysical": {
                "physicalNotes": "patient is complaining of back pain and is unable to sleep",
                "problemAreas": [
                    {
                        "bodyPart": {
                            "name": "CHEST",
                            "category": "Inspection"
                        },
                        "notes": "Heartbeat regular",
                        "imageUrl": ""
                    },
                    {
                        "bodyPart": {
                            "name": "NEURO II-XII",
                            "category": "Sensory"
                        },
                        "notes": "No issues",
                        "imageUrl": ""
                    }
                ],
                "patientEducationTopicsDiscussed": [
                    "Asthma",
                    "Injury Prevention"
                ]
            },
            "assessment": {
                "notes": "minor back strain",
                "problems": [
                    {
                        "problemNoteIdentity": null,
                        "icd9": {
                            "code": "001.0",
                            "desc": "Cholera due to vibrio cholarae"
                        },
                        "note": null,
                        "problemStartedAt": null,
                        "problemStoppedAt": null,
                        "soapNoteIdentity": "d03fc4aa-dbb9-4c76-bcf2-137d50593606",
                        "significant": false,
                        "active": true,
                        "updatedAt": null,
                        "createdBy": null
                    },
                    {
                        "problemNoteIdentity": null,
                        "icd9": {
                            "code": "004.3",
                            "desc": "Shigella sonnei"
                        },
                        "note": null,
                        "problemStartedAt": null,
                        "problemStoppedAt": null,
                        "soapNoteIdentity": "d03fc4aa-dbb9-4c76-bcf2-137d50593606",
                        "significant": false,
                        "active": true,
                        "updatedAt": null,
                        "createdBy": null
                    }
                ]
            },
            "plan": {
                "notes": "prescribing some painkillers, follow up in 2 weeks",
                "comments": "prescribing celebrex 300mg, minor sprain that should clear up in 2 weeks",
                "patientRequestedRecords": false
            },
            "updateBy": "e61b13d5-dac2-4384-b81f-90049813b635",
            "updatedAt": "2013-03-15T01:02:38.984-07:00",
            "createdBy": "e61b13d5-dac2-4384-b81f-90049813b635",
            "createdAt": "2013-03-15T01:02:36.877-07:00"
        }
    ],
    "lab": [
        {
            "labOrder": {
                "identity": "95306e3c-d07e-4289-b277-3da61008978a",
                "summary": "Hermatology",
                "labStatus": "Active",
                "labIdentity": "b4702a1e-8967-45a9-89f8-e67ac2b540c9",
                "labInstructions": "Run Eosinophil Count and Hemoglobin"
            },
            "labResult": {
                "identity": "d08e97a4-d310-407e-9002-1584309fd36f",
                "loincCode": "718-7",
                "labIdentity": "b4702a1e-8967-45a9-89f8-e67ac2b540c9",
                "facilityName": "XYZ MRI Lab",
                "facilityStreetAddress": "101 Main Street",
                "facilityCity": "Los Angeles",
                "facilityState": "CA",
                "facilityPostalCode": "92617",
                "labTestResult": [
                    {
                        "date": "2013-01-01",
                        "type": "Hermatology",
                        "name": "Eosinophil Count (1-3%)",
                        "value": "2",
                        "unitOfMeasure": "%",
                        "source": "Not Applicable",
                        "condition": "Not Applicable",
                        "abnormal": false
                    },
                    {
                        "date": "2013-01-01",
                        "type": "Hermatology",
                        "name": "Hemoglobin (male: 14-18 g/dl female: 12-16 g/dl)",
                        "value": "16",
                        "unitOfMeasure": "g/dl",
                        "source": "Not Applicable",
                        "condition": "Not Applicable",
                        "abnormal": true
                    }
                ]
            },
            "labIdentity": "b4702a1e-8967-45a9-89f8-e67ac2b540c9"
        }
    ],
    "author": "chuck norris",
    "organization": "Health Symmetric",
    "practice": {
        "identity": "15184dc3-d09f-4ac9-9b2f-807d6ea03524",
        "name": "472900@rspec.com",
        "settings": null,
        "phone": null,
        "address": [
            {
                "name": "Home",
                "address1": "101 Main",
                "address2": "Suite 250",
                "city": "New York",
                "state": "NY",
                "postalCode": "23455",
                "countryCode": "US",
                "phone": [
                    {
                        "areaCode": "234",
                        "prefix": "837",
                        "suffix": "2345",
                        "type": "OFFICE"
                    }
                ]
            }
        ],
        "rolesAndPermissions": {
            "STAFF": [
                "CREATE_PATIENT",
                "LOG_PHONE_CALL",
                "CREATE_CONTACT"
            ],
            "NURSE": [
                "CREATE_PATIENT",
                "UPDATE_PATIENT",
                "PROGRESS_NOTES",
                "LOG_PHONE_CALL",
                "UPLOAD_DOCUMENTS",
                "REQUEST_XRAYS_LABS",
                "CREATE_CONTACT"
            ],
            "PHYSICIAN": [
                "CREATE_PATIENT",
                "UPDATE_PATIENT",
                "SHARE_PATIENT",
                "PRESCRIBE_MEDICATION",
                "PROGRESS_NOTES",
                "LOG_PHONE_CALL",
                "UPLOAD_DOCUMENTS",
                "RUN_REPORTS",
                "REQUEST_XRAYS_LABS",
                "CREATE_CONTACT",
                "DIAGNOSE_PATIENTS",
                "SIGN_SOAP_NOTE"
            ],
            "ADMINISTRATOR": [
                "ADMINISTRATOR"
            ]
        },
        "symptoms": null,
        "practiceType": null,
        "emergencyPassword": null
    }
}</textarea><br/>
		<select name="format1" id="format1">
			<option value="ccd" selected>CCD</option>
			<option value="adt">ADT</option>
			<option value="oru">ORU</option>
			<option value="vxu">VXU</option>
			<option value="pqr">PQRI</option>
		</select>
		<input type="submit" name="button" id="button1" value="JSON to Clinical" />
	</form>
	<br/>
	<form id="form2" name="form2" method="post">
		<textarea name="data2" id="data2" cols="100" rows="10"></textarea><br/>
		<select name="format2" id="format2">
			<option value="ccd" selected>CCD</option>
			<option value="ccr">CCR</option>
			<option value="hl7">HL7</option>
		</select>
		<input type="submit" name="button" id="button2" value="Clinical to JSON" />
	</form>
<br><b>Output:</b> <span id="endpoint"></span><br><pre id="output"></pre>
</div>
</div>

<script type="text/javascript">

$(document).ready(function() {
	$("#form1").submit(function() {
		var endpoint = "<?php echo $allGlobals['API_ROOT']; ?>serialize/"+$("#format1").val();
		$.post(endpoint, $("#data1").val(), function(data) {
			$("#output").html(safe_tags(data));
			$("#endpoint").html(endpoint);			
		}, "text");
		return false;
	});
	$("#form2").submit(function() {
		var endpoint = "<?php echo $allGlobals['API_ROOT']; ?>deserialize/"+$("#format2").val();
		$.post(endpoint, $("#data2").val(), function(data) {
			$("#output").html(safe_tags(data));
			$("#endpoint").html(endpoint);			
		}, "text");
		return false;
	});
});

function safe_tags(str) {
    return str.replace(/&/g,"&amp;").replace(/</g,"&lt;").replace(/>/g,"&gt;");
}

</script>

</body>
</html>