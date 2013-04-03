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
        "identity": "7b641cd3-129b-4714-807e-a6f09bcb8ea5",
        "firstName": "data set 4",
        "lastName": "304f",
        "ssn": "347-34-1132",
        "address": [{
                "name": "Home",
                "address1": "2645 Mulberry Lane",
                "address2": "",
                "city": "Toledo",
                "state": "OH",
                "postalCode": "43605",
                "countryCode": "US",
                "phone": [{
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
        "dob": "1965-05-26",
        "gender": "M",
        "language": "English",
        "patientConsent": null,
        "maritalStatus": null,
        "race": "A",
        "ethnicity": "H",
        "smoking": 2,
        "paymentProfile": null,
        "emergency": [{
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
        "externalId": "5377643",
        "middleName": "a",
        "suffix": null,
        "preferredContact": null,
        "smokingFrequency": "1 pack/day",
        "ageInYears": 47
    },
    "medication": [{
            "drug": {
                "rcopiaId": null,
                "ndcid": "00071015540",
                "brandName": "Lipitor",
                "genericName": "atorvastatin calcium",
                "fullDescription": null,
                "brandType": null,
                "form": "Tablet",
                "strength": "10 mg",
                "routeCode": "PO",
                "rxNormType": null,
                "rxNormId": "617314",
                "drugGroup": null
            },
            "note": [],
            "patientPrescription": [{
                    "prescribe": {
                        "prescribeIdentity": "df9b6412-806e-403c-9e3b-f7ea6edbe348",
                        "patientIdentity": "7b641cd3-129b-4714-807e-a6f09bcb8ea5",
                        "patientExternalIdentity": "replace me",
                        "pharmacyIdentity": "",
                        "hasScheduledDrug": false,
                        "stopDate": null,
                        "addToMedicationList": true,
                        "sig": {
                            "drug": { 
                                "rcopiaId": null,
                                 "ndcid": "00071015540",
                                 "brandName": "Lipitor",
                                 "genericName": "atorvastatin calcium",
                                 "fullDescription": null,
                                 "brandType": null,
                                 "form": "Tablet",
                                 "strength": "10 mg",
                                 "routeCode": "PO",
                                 "rxNormType": null,
                                 "rxNormId": "617314",
                                 "drugGroup": null
                            },
                            "action": "Apply",
                            "dose": "1",
                            "doseUnit": "tablet",
                            "route": "PO",
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
                        "createdBy": "8bcd70a1-b388-4c15-b4bb-62eb11c27482",
                        "createdByFirstName": "chuck",
                        "createdByLastName": "norris"
                    },
                    "createdAt": "2013-04-03T11:28:33.834-07:00",
                    "createdBy": "8bcd70a1-b388-4c15-b4bb-62eb11c27482",
                    "active": true,
                    "source": "SOCIAL_CARE"
                }
            ],
            "active": true,
            "source": "SOCIAL_CARE",
            "education": ["http://www.rxlist.com/lipitor-drug.htm"]
        }, {
            "drug": {
                "rcopiaId": null,
                "ndcid": "00039006710",
                "brandName": "Lasix",
                "genericName": "furosemide",
                "fullDescription": null,
                "brandType": null,
                "form": "Tablet",
                "strength": "20 mg",
                "routeCode": "PO",
                "rxNormType": null,
                "rxNormId": "200801",
                "drugGroup": null
            },
            "note": [],
            "patientPrescription": [{
                    "prescribe": {
                        "prescribeIdentity": "94dea51e-d1cc-4bbf-86c5-d76bbdfdf7c8",
                        "patientIdentity": "7b641cd3-129b-4714-807e-a6f09bcb8ea5",
                        "patientExternalIdentity": "replace me",
                        "pharmacyIdentity": "",
                        "hasScheduledDrug": false,
                        "stopDate": null,
                        "addToMedicationList": true,
                        "sig": {
                            "drug": { 
                                "rcopiaId": null,
                                 "ndcid": "00039006710",
                                 "brandName": "Lasix",
                                 "genericName": "furosemide",
                                 "fullDescription": null,
                                 "brandType": null,
                                 "form": "Tablet",
                                 "strength": "20 mg",
                                 "routeCode": "PO",
                                 "rxNormType": null,
                                 "rxNormId": "200801",
                                 "drugGroup": null
                            },
                            "action": "Apply",
                            "dose": "1",
                            "doseUnit": "tablet",
                            "route": "PO",
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
                        "createdBy": "8bcd70a1-b388-4c15-b4bb-62eb11c27482",
                        "createdByFirstName": "chuck",
                        "createdByLastName": "norris"
                    },
                    "createdAt": "2013-04-03T11:28:33.891-07:00",
                    "createdBy": "8bcd70a1-b388-4c15-b4bb-62eb11c27482",
                    "active": true,
                    "source": "SOCIAL_CARE"
                }
            ],
            "active": true,
            "source": "SOCIAL_CARE",
            "education": ["http://www.rxlist.com/lasix-drug.htm"]
        }, {
            "drug": {
                "rcopiaId": null,
                "ndcid": "00245004115",
                "brandName": "Klor-Con 10",
                "genericName": "potassium chloride",
                "fullDescription": null,
                "brandType": null,
                "form": "tablet extended release",
                "strength": "10 mEq",
                "routeCode": "PO",
                "rxNormType": null,
                "rxNormId": "628958",
                "drugGroup": null
            },
            "note": [],
            "patientPrescription": [{
                    "prescribe": {
                        "prescribeIdentity": "aecec1ae-de1b-4522-9d3f-077d3fbe6811",
                        "patientIdentity": "7b641cd3-129b-4714-807e-a6f09bcb8ea5",
                        "patientExternalIdentity": "replace me",
                        "pharmacyIdentity": "",
                        "hasScheduledDrug": false,
                        "stopDate": null,
                        "addToMedicationList": true,
                        "sig": {
                            "drug": { 
                                "rcopiaId": null,
                                 "ndcid": "00245004115",
                                 "brandName": "Klor-Con 10",
                                 "genericName": "potassium chloride",
                                 "fullDescription": null,
                                 "brandType": null,
                                 "form": "tablet extended release",
                                 "strength": "10 mEq",
                                 "routeCode": "PO",
                                 "rxNormType": null,
                                 "rxNormId": "628958",
                                 "drugGroup": null
                            },
                            "action": "Apply",
                            "dose": "1",
                            "doseUnit": "tablet",
                            "route": "PO",
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
                        "createdBy": "8bcd70a1-b388-4c15-b4bb-62eb11c27482",
                        "createdByFirstName": "chuck",
                        "createdByLastName": "norris"
                    },
                    "createdAt": "2013-04-03T11:28:33.939-07:00",
                    "createdBy": "8bcd70a1-b388-4c15-b4bb-62eb11c27482",
                    "active": true,
                    "source": "SOCIAL_CARE"
                }
            ],
            "active": true,
            "source": "SOCIAL_CARE",
            "education": ["http://www.rxlist.com/klor-con-drug/patient-images-side-effects.htm"]
        }
    ],
    "problem": [{
            "problemNoteIdentity": "b9a940a2-b19f-4279-8be1-c67df316bf23",
            "icd9": {
                "code": "401.9",
                "desc": "Hypertension, Essential"
            },
            "note": "Stress",
            "problemStartedAt": "2009-12-24",
            "problemStoppedAt": null,
            "soapNoteIdentity": null,
            "significant": true,
            "active": false,
            "updatedAt": "2013-04-03T18:28:34.054Z",
            "createdBy": "8bcd70a1-b388-4c15-b4bb-62eb11c27482"
        }, {
            "problemNoteIdentity": "5264c359-f81c-40e9-8df9-116b6323533a",
            "icd9": {
                "code": "272.4",
                "desc": "Hyperlipidemia"
            },
            "note": "reported",
            "problemStartedAt": "2009-12-24",
            "problemStoppedAt": null,
            "soapNoteIdentity": null,
            "significant": true,
            "active": true,
            "updatedAt": "2013-04-03T18:28:34.013Z",
            "createdBy": "8bcd70a1-b388-4c15-b4bb-62eb11c27482"
        }
    ],
    "allergy": [{
            "identity": "b92b772c-1a33-4b18-95fb-a083cb82214b",
            "name": "Drug Allergy",
            "ndcidCode": null,
            "allergyGroupId": null,
            "active": true,
            "allergicReaction": "Rash",
            "allergicReactionDate": "2001-01-01",
            "snomed": "4160980002",
            "substance": null,
            "reaction": null,
            "createdAt": "2013-04-03T18:28:33.974Z",
            "updatedAt": "2013-04-03T18:28:33.974Z",
            "rxnormId": "2870"
        }
    ],
    "immunization": [],
    "soapNote": [{
            "identity": "1d8f610d-12c6-4dc5-b271-a31e21214bda",
            "subjective": {
                "chiefComplaint": "Knee pain",
                "note": "motorcycle injury",
                "symptoms": ["grinding", "headache", "ear pain"],
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
                "painPoints": [{
                        "painLocation": "UPPER SHOULDER",
                        "painLevel": 3
                    }
                ],
                "smokingFrequency": "1 pack/day",
                "bmi": 24.410273
            },
            "objectivePhysical": {
                "physicalNotes": "patient is complaining of back pain and is unable to sleep",
                "problemAreas": [{
                        "bodyPart": {
                            "name": "CHEST",
                            "category": "Inspection"
                        },
                        "notes": "Heartbeat regular",
                        "imageUrl": ""
                    }, {
                        "bodyPart": {
                            "name": "NEURO II-XII",
                            "category": "Sensory"
                        },
                        "notes": "No issues",
                        "imageUrl": ""
                    }
                ],
                "patientEducationTopicsDiscussed": ["Asthma", "Injury Prevention"]
            },
            "assessment": {
                "notes": "minor back strain",
                "problems": null
            },
            "plan": {
                "notes": "prescribing some painkillers, follow up in 2 weeks",
                "comments": "prescribing celebrex 300mg, minor sprain that should clear up in 2 weeks",
                "patientRequestedRecords": false
            },
            "updateBy": "8bcd70a1-b388-4c15-b4bb-62eb11c27482",
            "updatedAt": "2013-04-03T18:28:33.800Z",
            "createdBy": "8bcd70a1-b388-4c15-b4bb-62eb11c27482",
            "createdAt": "2013-04-03T18:28:31.829Z"
        }
    ],
    "lab": [{
            "labOrder": {
                "identity": "8f09abc8-2534-484c-88ea-42ba9a8a7f79",
                "summary": "LDL Cholesterol",
                "labStatus": "Active",
                "labIdentity": "0bbbf007-a6d7-4bc5-88a3-f20449c902cd",
                "labInstructions": "LDL Cholesterol"
            },
            "labResult": {
                "identity": "7d2f4ec6-4581-4b4d-a212-d015a01f97ea",
                "loincCode": "2089-1",
                "labIdentity": "0bbbf007-a6d7-4bc5-88a3-f20449c902cd",
                "facilityName": "Milton Street Laboratory",
                "facilityStreetAddress": "40025 Milton Street",
                "facilityCity": "Aurora",
                "facilityState": "CO",
                "facilityPostalCode": "80011",
                "labTestResult": [{
                        "date": "2013-03-15",
                        "type": "Chemistry",
                        "name": "LDL Cholesterol (<100 mg/dl)",
                        "value": "120",
                        "unitOfMeasure": "mg/dl",
                        "source": "Not Applicable",
                        "condition": "Not Applicable",
                        "abnormal": "true"
                    }
                ],
                "education": ["http://labtestsonline.org/understanding/analytes/cholesterol/tab/glance"]
            },
            "labIdentity": "0bbbf007-a6d7-4bc5-88a3-f20449c902cd"
        }, {
            "labOrder": {
                "identity": "fc3287ca-c96c-4de2-8ac3-30c47b892b60",
                "summary": "HDL Cholesterol",
                "labStatus": "Active",
                "labIdentity": "8ebcac5e-c74a-40e3-9372-d435938b1c21",
                "labInstructions": "HDL Cholesterol"
            },
            "labResult": {
                "identity": "cbcde341-6e39-45c5-bfd8-fb682f9f9ffc",
                "loincCode": "14646-4",
                "labIdentity": "8ebcac5e-c74a-40e3-9372-d435938b1c21",
                "facilityName": "Milton Street Laboratory",
                "facilityStreetAddress": "40025 Milton Street",
                "facilityCity": "Aurora",
                "facilityState": "CO",
                "facilityPostalCode": "80011",
                "labTestResult": [{
                        "date": "2013-03-15",
                        "type": "HDL Cholesterol",
                        "name": "HDL Cholesterol (>= 40 mg/dl)",
                        "value": "41",
                        "unitOfMeasure": "mg/dl",
                        "source": "Not Applicable",
                        "condition": "Not Applicable",
                        "abnormal": "false"
                    }
                ],
                "education": ["http://labtestsonline.org/understanding/analytes/cholesterol/tab/glance"]
            },
            "labIdentity": "8ebcac5e-c74a-40e3-9372-d435938b1c21"
        }, {
            "labOrder": {
                "identity": "b8736fba-5c2a-401b-8399-53333fec709a",
                "summary": "Total Cholesterol",
                "labStatus": "Active",
                "labIdentity": "53e43a14-21c4-4576-9122-28fdccd84ec4",
                "labInstructions": "Total Cholesterol"
            },
            "labResult": {
                "identity": "5ddb8778-b0ab-4ce7-af80-83f68010d514",
                "loincCode": "14647-2",
                "labIdentity": "53e43a14-21c4-4576-9122-28fdccd84ec4",
                "facilityName": "Milton Street Laboratory",
                "facilityStreetAddress": "40025 Milton Street",
                "facilityCity": "Aurora",
                "facilityState": "CO",
                "facilityPostalCode": "80011",
                "labTestResult": [{
                        "date": "2013-03-15",
                        "type": "Total Cholesterol",
                        "name": "Total Cholesterol",
                        "value": "180",
                        "unitOfMeasure": "mg/dl",
                        "source": "Not Applicable",
                        "condition": "Not Applicable",
                        "abnormal": "false"
                    }
                ],
                "education": ["http://labtestsonline.org/understanding/analytes/cholesterol/tab/glance"]
            },
            "labIdentity": "53e43a14-21c4-4576-9122-28fdccd84ec4"
        }, {
            "labOrder": {
                "identity": "ef188abe-87e5-4851-939c-5accf0da522c",
                "summary": "Potassium",
                "labStatus": "Active",
                "labIdentity": "840f7b2d-6a1f-4a98-a7f3-3fd63e59ceb8",
                "labInstructions": "Potassium"
            },
            "labResult": {
                "identity": "068d9dea-e766-431a-8f10-2b5d3c7d3a8d",
                "loincCode": "2823-3",
                "labIdentity": "840f7b2d-6a1f-4a98-a7f3-3fd63e59ceb8",
                "facilityName": "Milton Street Laboratory",
                "facilityStreetAddress": "40025 Milton Street",
                "facilityCity": "Aurora",
                "facilityState": "CO",
                "facilityPostalCode": "80011",
                "labTestResult": [{
                        "date": "2013-03-15",
                        "type": "Potassium",
                        "name": "Potassium",
                        "value": "4.5",
                        "unitOfMeasure": "mEq/L",
                        "source": "Not Applicable",
                        "condition": "Not Applicable",
                        "abnormal": "false"
                    }
                ],
                "education": ["http://labtestsonline.org/understanding/analytes/potassium/tab/glance"]
            },
            "labIdentity": "840f7b2d-6a1f-4a98-a7f3-3fd63e59ceb8"
        }, {
            "labOrder": {
                "identity": "407f3e30-74c7-4c33-a6e7-0f2e6f73da77",
                "summary": "Triglycerides",
                "labStatus": "Active",
                "labIdentity": "51408f2c-bd69-4743-bcf1-e084a943e094",
                "labInstructions": "Triglycerides"
            },
            "labResult": {
                "identity": "59b66c45-787f-46ad-9c11-6ca3f165e598",
                "loincCode": "14927-8",
                "labIdentity": "51408f2c-bd69-4743-bcf1-e084a943e094",
                "facilityName": "Milton Street Laboratory",
                "facilityStreetAddress": "40025 Milton Street",
                "facilityCity": "Aurora",
                "facilityState": "CO",
                "facilityPostalCode": "80011",
                "labTestResult": [{
                        "date": "2013-03-15",
                        "type": "Triglycerides",
                        "name": "Triglycerides (<150 mg/dl)",
                        "value": "187",
                        "unitOfMeasure": "mg/dl",
                        "source": "Not Applicable",
                        "condition": "Not Applicable",
                        "abnormal": "true"
                    }
                ],
                "education": ["http://labtestsonline.org/understanding/analytes/cholesterol/tab/glance"]
            },
            "labIdentity": "51408f2c-bd69-4743-bcf1-e084a943e094"
        }
    ],
    "author": "chuck norris",
    "organization": "Health Symmetric",
    "practice": {
        "identity": "c81a23b3-5609-40dd-96e9-06a28ed3e2d9",
        "name": "173303@rspec.com",
        "settings": null,
        "phone": null,
        "address": [{
                "name": "Home",
                "address1": "101 Main",
                "address2": "Suite 250",
                "city": "New York",
                "state": "NY",
                "postalCode": "23455",
                "countryCode": "US",
                "phone": [{
                        "areaCode": "234",
                        "prefix": "837",
                        "suffix": "2345",
                        "type": "OFFICE"
                    }
                ]
            }
        ],
        "rolesAndPermissions": {
            "STAFF": ["CREATE_PATIENT", "LOG_PHONE_CALL", "CREATE_CONTACT"],
            "NURSE": ["CREATE_PATIENT", "UPDATE_PATIENT", "PROGRESS_NOTES", "LOG_PHONE_CALL", "UPLOAD_DOCUMENTS", "REQUEST_XRAYS_LABS", "CREATE_CONTACT"],
            "PHYSICIAN": ["CREATE_PATIENT", "UPDATE_PATIENT", "SHARE_PATIENT", "PRESCRIBE_MEDICATION", "PROGRESS_NOTES", "LOG_PHONE_CALL", "UPLOAD_DOCUMENTS", "RUN_REPORTS", "REQUEST_XRAYS_LABS", "CREATE_CONTACT", "DIAGNOSE_PATIENTS", "SIGN_SOAP_NOTE"],
            "ADMINISTRATOR": ["ADMINISTRATOR"]
        },
        "symptoms": null,
        "practiceType": null,
        "emergencyPassword": null
    },
    "user": {
        "identity": "8bcd70a1-b388-4c15-b4bb-62eb11c27482",
        "firstName": "chuck",
        "lastName": "norris",
        "phone": [{
                "areaCode": "234",
                "prefix": "837",
                "suffix": "2345",
                "type": "OFFICE"
            }
        ],
        "defaultRole": "Physician",
        "specialty": "Student",
        "settings": null,
        "renderingNpi": "999",
        "groupNpi": "444",
        "dea": "222",
        "licenseNumber": "0990",
        "username": "987492@rspec.com",
        "password": null,
        "pin": null,
        "title": "Mr.",
        "email": [{
                "emailAddress": "user@rspec.com",
                "primary": true
            }
        ],
        "prescriptionProfile": null,
        "tin": "234"
    },
    "patientCount": 2
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