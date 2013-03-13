<?php

/*//////////////////////////////////////////////////////////////////////////////////////////////////


stdClass Object
(
    [patient] => stdClass Object
        (
            [identity] => 7d2ed041-fa93-472d-97a8-324b8fde982c
            [firstName] => export
            [lastName] => patient
            [ssn] => 345-34-1120
            [address] => Array
                (
                    [0] => stdClass Object
                        (
                            [name] => Home
                            [address1] => 2645 Mulberry Lane
                            [address2] => 
                            [city] => Toledo
                            [state] => OH
                            [postalCode] => 43605
                            [countryCode] => US
                            [phone] => Array
                                (
                                    [0] => stdClass Object
                                        (
                                            [areaCode] => 234
                                            [prefix] => 837
                                            [suffix] => 2345
                                            [type] => OFFICE
                                        )

                                )

                        )

                )

            [phone] => 
            [email] => 
            [dob] => 1960-04-22
            [gender] => M
            [language] => English
            [patientConsent] => 
            [maritalStatus] => 
            [race] => A
            [ethnicity] => H
            [smoking] => 2
            [paymentProfile] => 
            [emergency] => Array
                (
                    [0] => stdClass Object
                        (
                            [name] => emergency
                            [phone] => stdClass Object
                                (
                                    [areaCode] => 234
                                    [prefix] => 837
                                    [suffix] => 2345
                                    [type] => OFFICE
                                )

                        )

                )

            [subscriberIsPatient] => 
            [insurance] => 
            [externalId] => 5369509
            [middleName] => d
            [suffix] => 
            [preferredContact] => 
            [smokingFrequency] => 1 pack/day
            [ageInYears] => 52
        )

    [medication] => Array
        (
            [0] => stdClass Object
                (
                    [drug] => stdClass Object
                        (
                            [rcopiaId] => 
                            [ndcid] => 00071015640
                            [brandName] => Lipitor
                            [genericName] => 
                            [fullDescription] => 
                            [brandType] => 
                            [form] => Tablet
                            [strength] => 
                            [routeCode] => 
                            [rxNormType] => 
                            [rxNormId] => 
                            [drugGroup] => 
                        )

                    [note] => Array
                        (
                        )

                    [patientPrescription] => Array
                        (
                            [0] => stdClass Object
                                (
                                    [prescribe] => stdClass Object
                                        (
                                            [prescribeIdentity] => 664a66ec-12d0-4530-80b2-1d03e93ba6bd
                                            [patientIdentity] => 7d2ed041-fa93-472d-97a8-324b8fde982c
                                            [patientExternalIdentity] => 
                                            [pharmacyIdentity] => 
                                            [hasScheduledDrug] => 
                                            [stopDate] => 
                                            [addToMedicationList] => 1
                                            [sig] => stdClass Object
                                                (
                                                    [drug] => stdClass Object
                                                        (
                                                            [rcopiaId] => 
                                                            [ndcid] => 00071015640
                                                            [brandName] => Lipitor
                                                            [genericName] => 
                                                            [fullDescription] => 
                                                            [brandType] => 
                                                            [form] => Tablet
                                                            [strength] => 
                                                            [routeCode] => 
                                                            [rxNormType] => 
                                                            [rxNormId] => 
                                                            [drugGroup] => 
                                                        )

                                                    [action] => Apply
                                                    [dose] => 1
                                                    [doseUnit] => tablet
                                                    [route] => as directed
                                                    [doseTiming] => once a day
                                                    [doseOther] => 
                                                    [duration] => 7 days
                                                    [quantity] => 14
                                                    [quantityUnits] => tablets
                                                    [refills] => 2
                                                    [substitutionPermitted] => 1
                                                    [otherNotes] => Other Notes
                                                    [patientNotes] => Patient Notes
                                                    [comments] => Comments
                                                    [schedule] => 
                                                    [writtenDate] => 
                                                    [effectiveDate] => 
                                                    [lastFillDate] => 
                                                    [soldDate] => 
                                                )

                                            [checkId] => 
                                            [signaturePassword] => 1234
                                            [prescriberOrderNumber] => 
                                            [rxReferenceNumber] => 
                                            [formularyNote] => 
                                            [interactionNote] => 
                                            [allergyReaction] => 
                                            [interactionReaction] => 
                                            [drugInteractionCheckPerformed] => 
                                            [icd9] => 
                                            [ePrescribe] => 
                                            [createdBy] => dc30fc2d-5901-481a-bafe-7b44bfe5fe4d
                                            [createdByFirstName] => chuck
                                            [createdByLastName] => norris
                                        )

                                    [createdAt] => 1363130900488
                                    [createdBy] => dc30fc2d-5901-481a-bafe-7b44bfe5fe4d
                                    [active] => 1
                                )

                        )

                    [active] => 1
                    [source] => SOCIAL_CARE
                )

        )

    [problem] => Array
        (
            [0] => stdClass Object
                (
                    [problemNoteIdentity] => 03a00868-0947-4497-bc85-4afb5f3357e8
                    [icd9] => stdClass Object
                        (
                            [code] => 0022
                            [desc] => flu
                        )

                    [note] => 
                    [problemStartedAt] => 
                    [problemStoppedAt] => 
                    [soapNoteIdentity] => 4dc0029b-76bc-412e-b7d3-6398fcfac4e3
                    [significant] => 
                    [active] => 1
                    [updatedAt] => 2013-03-12T23:28:19.633Z
                    [createdBy] => dc30fc2d-5901-481a-bafe-7b44bfe5fe4d
                )

            [1] => stdClass Object
                (
                    [problemNoteIdentity] => 78d5c06f-c1ae-4841-ac88-c52429677fc8
                    [icd9] => stdClass Object
                        (
                            [code] => 250.02
                            [desc] => Diabetes Mellitus, Type 2
                        )

                    [note] => Low blood sugar
                    [problemStartedAt] => 2009-12-24
                    [problemStoppedAt] => 
                    [soapNoteIdentity] => 
                    [significant] => 1
                    [active] => 
                    [updatedAt] => 2013-03-12T23:28:21.208Z
                    [createdBy] => dc30fc2d-5901-481a-bafe-7b44bfe5fe4d
                )

            [2] => stdClass Object
                (
                    [problemNoteIdentity] => 5bf226b3-72c8-480a-b24c-3d07b60f0ee3
                    [icd9] => stdClass Object
                        (
                            [code] => 01116
                            [desc] => bronchitis
                        )

                    [note] => 
                    [problemStartedAt] => 
                    [problemStoppedAt] => 
                    [soapNoteIdentity] => 4dc0029b-76bc-412e-b7d3-6398fcfac4e3
                    [significant] => 
                    [active] => 1
                    [updatedAt] => 2013-03-12T23:28:19.633Z
                    [createdBy] => dc30fc2d-5901-481a-bafe-7b44bfe5fe4d
                )

        )

    [allergy] => Array
        (
            [0] => stdClass Object
                (
                    [identity] => 13e04179-826f-4534-adab-92db2438c44d
                    [name] => Allergy to penicillin
                    [ndcidCode] => 
                    [allergyGroupId] => 
                    [active] => 1
                    [allergicReaction] => Rash
                    [allergicReactionDate] => 2001-01-01
                    [snomed] => 91936005
                    [substance] => 
                    [reaction] => 
                    [createdAt] => 2013-03-12
                    [updatedAt] => 2013-03-12
                )

        )

    [immunization] => Array
        (
            [0] => stdClass Object
                (
                    [createTime] => 2013-03-12T23:28:21.910Z
                    [vaccine] => Influenza
                    [notes] => Administered Flu Shot for patient
                    [userAssertion] => CONFIRMED
                    [activityTime] => 2012-11-02
                    [activityBy] => CVS Pharmacy
                    [administeredAmount] => 3
                    [administeredUnit] => vials
                    [vaccineLotNumber] => 003843
                    [manufacturerName] => Merck
                    [manufacturerCode] => ME-394
                    [cvxCode] => 15
                )

        )

    [soapNote] => Array
        (
            [0] => stdClass Object
                (
                    [identity] => 4dc0029b-76bc-412e-b7d3-6398fcfac4e3
                    [subjective] => stdClass Object
                        (
                            [chiefComplaint] => Knee pain
                            [note] => motorcycle injury
                            [symptoms] => Array
                                (
                                    [0] => grinding
                                    [1] => headache
                                    [2] => ear pain
                                )

                            [historyOfCurrentIllness] => previous surgery
                            [appointmentDate] => 2012-01-19
                        )

                    [objectiveVitals] => stdClass Object
                        (
                            [vitalNotes] => getting basic measurements
                            [temperature] => 99.1
                            [heightFeet] => 5
                            [heightInches] => 9
                            [respiratoryRate] => 10
                            [weight] => 165.3
                            [bpSystolic] => 120
                            [bpDiastolic] => 80
                            [pulse] => 75
                            [headCircumference] => 20.7
                            [oxygenSaturation] => 82
                            [smoking] => 2
                            [painPoints] => Array
                                (
                                    [0] => stdClass Object
                                        (
                                            [painLocation] => UPPER SHOULDER
                                            [painLevel] => 3
                                        )

                                )

                            [smokingFrequency] => 1 pack/day
                            [bmi] => 24.410273
                        )

                    [objectivePhysical] => stdClass Object
                        (
                            [physicalNotes] => patient is complaining of back pain and is unable to sleep
                            [problemAreas] => Array
                                (
                                    [0] => stdClass Object
                                        (
                                            [bodyPart] => stdClass Object
                                                (
                                                    [name] => CHEST
                                                    [category] => Inspection
                                                )

                                            [notes] => Heartbeat regular
                                            [imageUrl] => 
                                        )

                                    [1] => stdClass Object
                                        (
                                            [bodyPart] => stdClass Object
                                                (
                                                    [name] => NEURO II-XII
                                                    [category] => Sensory
                                                )

                                            [notes] => No issues
                                            [imageUrl] => 
                                        )

                                )

                            [patientEducationTopicsDiscussed] => Array
                                (
                                    [0] => Asthma
                                    [1] => Injury Prevention
                                )

                        )

                    [assessment] => stdClass Object
                        (
                            [notes] => minor back strain
                            [problems] => Array
                                (
                                    [0] => stdClass Object
                                        (
                                            [problemNoteIdentity] => 
                                            [icd9] => stdClass Object
                                                (
                                                    [code] => 0022
                                                    [desc] => flu
                                                )

                                            [note] => 
                                            [problemStartedAt] => 
                                            [problemStoppedAt] => 
                                            [soapNoteIdentity] => 4dc0029b-76bc-412e-b7d3-6398fcfac4e3
                                            [significant] => 
                                            [active] => 1
                                            [updatedAt] => 
                                            [createdBy] => 
                                        )

                                    [1] => stdClass Object
                                        (
                                            [problemNoteIdentity] => 
                                            [icd9] => stdClass Object
                                                (
                                                    [code] => 01116
                                                    [desc] => bronchitis
                                                )

                                            [note] => 
                                            [problemStartedAt] => 
                                            [problemStoppedAt] => 
                                            [soapNoteIdentity] => 4dc0029b-76bc-412e-b7d3-6398fcfac4e3
                                            [significant] => 
                                            [active] => 1
                                            [updatedAt] => 
                                            [createdBy] => 
                                        )

                                )

                        )

                    [plan] => stdClass Object
                        (
                            [notes] => prescribing some painkillers, follow up in 2 weeks
                            [comments] => prescribing celebrex 300mg, minor sprain that should clear up in 2 weeks
                        )

                    [updateBy] => dc30fc2d-5901-481a-bafe-7b44bfe5fe4d
                    [updatedAt] => 2013-03-12T23:28:20.133Z
                    [createdBy] => dc30fc2d-5901-481a-bafe-7b44bfe5fe4d
                    [createdAt] => 2013-03-12T23:28:17.485Z
                )

        )

    [lab] => Array
        (
            [0] => stdClass Object
                (
                    [labOrder] => 
                    [labResult] => stdClass Object
                        (
                            [identity] => 95164077-bc6d-4fe8-b098-c47901899816
                            [loincCode] => 14471-0
                            [dateLabPerformed] => 2013-01-01
                            [labType] => Fasting Blood Glucose
                            [labDescription] => Fasting Blood Glucose
                            [idealRange] => 170 mg/dl - 170 mg/dl
                            [labResult] => 178 mg/dl
                            [labIdentity] => c9f347ba-8bf0-47e8-8d96-1e735b449137
                        )

                    [labIdentity] => c9f347ba-8bf0-47e8-8d96-1e735b449137
                )

        )

    [author] => chuck norris
    [organization] => Health Symmetric
)

/*//////////////////////////////////////////////////////////////////////////////////////////////////

$posted_obj = json_decode('{
    "patient": {
        "identity": "7d2ed041-fa93-472d-97a8-324b8fde982c",
        "firstName": "export",
        "lastName": "patient",
        "ssn": "345-34-1120",
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
        "dob": "1960-04-22",
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
        "externalId": "5369509",
        "middleName": "d",
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
                        "prescribeIdentity": "664a66ec-12d0-4530-80b2-1d03e93ba6bd",
                        "patientIdentity": "7d2ed041-fa93-472d-97a8-324b8fde982c",
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
                        "createdBy": "dc30fc2d-5901-481a-bafe-7b44bfe5fe4d",
                        "createdByFirstName": "chuck",
                        "createdByLastName": "norris"
                    },
                    "createdAt": 1363130900488,
                    "createdBy": "dc30fc2d-5901-481a-bafe-7b44bfe5fe4d",
                    "active": true
                }
            ],
            "active": true,
            "source": "SOCIAL_CARE"
        }
    ],
    "problem": [
        {
            "problemNoteIdentity": "03a00868-0947-4497-bc85-4afb5f3357e8",
            "icd9": {
                "code": "0022",
                "desc": "flu"
            },
            "note": null,
            "problemStartedAt": null,
            "problemStoppedAt": null,
            "soapNoteIdentity": "4dc0029b-76bc-412e-b7d3-6398fcfac4e3",
            "significant": false,
            "active": true,
            "updatedAt": "2013-03-12T23:28:19.633Z",
            "createdBy": "dc30fc2d-5901-481a-bafe-7b44bfe5fe4d"
        },
        {
            "problemNoteIdentity": "78d5c06f-c1ae-4841-ac88-c52429677fc8",
            "icd9": {
                "code": "250.02",
                "desc": "Diabetes Mellitus, Type 2"
            },
            "note": "Low blood sugar",
            "problemStartedAt": "2009-12-24",
            "problemStoppedAt": null,
            "soapNoteIdentity": null,
            "significant": true,
            "active": false,
            "updatedAt": "2013-03-12T23:28:21.208Z",
            "createdBy": "dc30fc2d-5901-481a-bafe-7b44bfe5fe4d"
        },
        {
            "problemNoteIdentity": "5bf226b3-72c8-480a-b24c-3d07b60f0ee3",
            "icd9": {
                "code": "01116",
                "desc": "bronchitis"
            },
            "note": null,
            "problemStartedAt": null,
            "problemStoppedAt": null,
            "soapNoteIdentity": "4dc0029b-76bc-412e-b7d3-6398fcfac4e3",
            "significant": false,
            "active": true,
            "updatedAt": "2013-03-12T23:28:19.633Z",
            "createdBy": "dc30fc2d-5901-481a-bafe-7b44bfe5fe4d"
        }
    ],
    "allergy": [
        {
            "identity": "13e04179-826f-4534-adab-92db2438c44d",
            "name": "Allergy to penicillin",
            "ndcidCode": null,
            "allergyGroupId": null,
            "active": true,
            "allergicReaction": "Rash",
            "allergicReactionDate": "2001-01-01",
            "snomed": "91936005",
            "substance": null,
            "reaction": null,
            "createdAt": "2013-03-12",
            "updatedAt": "2013-03-12"
        }
    ],
    "immunization": [
        {
            "createTime": "2013-03-12T23:28:21.910Z",
            "vaccine": "Influenza",
            "notes": "Administered Flu Shot for patient",
            "userAssertion": "CONFIRMED",
            "activityTime": "2012-11-02",
            "activityBy": "CVS Pharmacy",
            "administeredAmount": "3",
            "administeredUnit": "vials",
            "vaccineLotNumber": "003843",
            "manufacturerName": "Merck",
            "manufacturerCode": "ME-394",
            "cvxCode": "15"
        }
    ],
    "soapNote": [
        {
            "identity": "4dc0029b-76bc-412e-b7d3-6398fcfac4e3",
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
                            "code": "0022",
                            "desc": "flu"
                        },
                        "note": null,
                        "problemStartedAt": null,
                        "problemStoppedAt": null,
                        "soapNoteIdentity": "4dc0029b-76bc-412e-b7d3-6398fcfac4e3",
                        "significant": false,
                        "active": true,
                        "updatedAt": null,
                        "createdBy": null
                    },
                    {
                        "problemNoteIdentity": null,
                        "icd9": {
                            "code": "01116",
                            "desc": "bronchitis"
                        },
                        "note": null,
                        "problemStartedAt": null,
                        "problemStoppedAt": null,
                        "soapNoteIdentity": "4dc0029b-76bc-412e-b7d3-6398fcfac4e3",
                        "significant": false,
                        "active": true,
                        "updatedAt": null,
                        "createdBy": null
                    }
                ]
            },
            "plan": {
                "notes": "prescribing some painkillers, follow up in 2 weeks",
                "comments": "prescribing celebrex 300mg, minor sprain that should clear up in 2 weeks"
            },
            "updateBy": "dc30fc2d-5901-481a-bafe-7b44bfe5fe4d",
            "updatedAt": "2013-03-12T23:28:20.133Z",
            "createdBy": "dc30fc2d-5901-481a-bafe-7b44bfe5fe4d",
            "createdAt": "2013-03-12T23:28:17.485Z"
        }
    ],
    "lab": [
        {
            "labOrder": null,
            "labResult": {
                "identity": "95164077-bc6d-4fe8-b098-c47901899816",
                "loincCode": "14471-0",
                "dateLabPerformed": "2013-01-01",
                "labType": "Fasting Blood Glucose",
                "labDescription": "Fasting Blood Glucose",
                "idealRange": "170 mg/dl - 170 mg/dl",
                "labResult": "178 mg/dl",
                "labIdentity": "c9f347ba-8bf0-47e8-8d96-1e735b449137"
            },
            "labIdentity": "c9f347ba-8bf0-47e8-8d96-1e735b449137"
        }
    ],
    "author": "chuck norris",
    "organization": "Health Symmetric"
}');

#print_r($posted_obj);

?>