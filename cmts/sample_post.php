<?php

/*//////////////////////////////////////////////////////////////////////////////////////////////////

stdClass Object
(
    [patient] => stdClass Object
        (
            [firstName] => Jeremy1
            [lastName] => ODay2
            [ssn] => ssn
            [preferredContact] => 
            [phone] => Array
                (
                    [0] => stdClass Object
                        (
                            [areaCode] => 123
                            [prefix] => 456
                            [suffix] => 7890
                            [type] => OFFICE
                        )

                    [1] => stdClass Object
                        (
                            [areaCode] => 123
                            [prefix] => 456
                            [suffix] => 7890
                            [type] => FAX
                        )

                )

            [address] => Array
                (
                    [0] => stdClass Object
                        (
                            [name] => address name
                            [address1] => address1
                            [address2] => address2
                            [city] => city
                            [state] => state
                            [postalCode] => 90403
                            [countryCode] => US
                        )

                    [1] => stdClass Object
                        (
                            [name] => address name
                            [address1] => address1
                            [address2] => address2
                            [city] => city
                            [state] => state
                            [postalCode] => 90403
                            [countryCode] => US
                        )

                )

            [email] => Array
                (
                    [0] => stdClass Object
                        (
                            [emailAddress] => jeremy@chaoslabs.com
                            [primary] => 1
                        )

                )

            [dob] => 2012-11-30T21:07:49.005Z
            [gender] => M
            [language] => language
            [patientConsent] => 
            [maritalStatus] => D
            [race] => R
            [ethnicity] => E
            [smoking] => 1
            [paymentProfile] => A
            [emergency] => Array
                (
                    [0] => stdClass Object
                        (
                            [name] => Name
                            [phone] => stdClass Object
                                (
                                    [areaCode] => 123
                                    [prefix] => 456
                                    [suffix] => 7890
                                    [type] => OFFICE
                                )

                        )

                    [1] => stdClass Object
                        (
                            [name] => Name
                            [phone] => stdClass Object
                                (
                                    [areaCode] => 123
                                    [prefix] => 456
                                    [suffix] => 7890
                                    [type] => OFFICE
                                )

                        )

                )

            [subscriberIsPatient] => 1
            [insurance] => Array
                (
                    [0] => stdClass Object
                        (
                            [name] => Insurance Name
                            [copayPennies] => 500
                            [primary] => 
                            [idNumber] => 123456
                            [carrierPayerId] => 987654
                        )

                    [1] => stdClass Object
                        (
                            [name] => Insurance Name
                            [copayPennies] => 500
                            [primary] => 
                            [idNumber] => 123456
                            [carrierPayerId] => 987654
                        )

                )

            [externalId] => 99927557
            [middleName] => 
            [suffix] => 
            [smokingFrequency] => 1-9 cigarettes/day
        )

    [author] => Author
    [organization] => Organization
    [problem] => Array
        (
            [0] => stdClass Object
                (
                    [problemNoteIdentity] => 
                    [icd9] => stdClass Object
                        (
                            [code] => 290.0.2
                            [desc] => Senile dementia, uncomplicated
                        )

                    [note] => hallucinations
                    [problemStartedAt] => 2012-12-24T08:58:52.186-08:00
                    [problemStoppedAt] => 
                    [createdAt] => 1356368332328
                    [createdBy] => 
                    [soapNoteIdentity] => 
                    [status] => new
                    [significant] => 1
                )

        )

    [medicationProfile] => stdClass Object
        (
            [medication] => stdClass Object
                (
                    [00069421030] => stdClass Object
                        (
                            [drug] => stdClass Object
                                (
                                    [rcopiaId] => 
                                    [ndcid] => 00069421030
                                    [brandName] => Viagra
                                    [genericName] => 
                                    [fullDescription] => 
                                    [brandType] => 
                                    [form] => Tablet
                                    [strength] => 
                                    [routeCode] => 
                                    [rxNormType] => 
                                    [rxNormId] => 
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
                                                    [prescribeIdentity] => aa1cc96a-6333-4d84-8eb6-50f295d9e8ee
                                                    [patientIdentity] => 2f6154dc-f7a2-42e9-8c79-d18001d94d69
                                                    [patientExternalIdentity] => 5288541
                                                    [pharmacyIdentity] => 9900004
                                                    [hasScheduledDrug] => 
                                                    [stopDate] => 
                                                    [addToMedicationList] => 1
                                                    [sig] => stdClass Object
                                                        (
                                                            [drug] => stdClass Object
                                                                (
                                                                    [rcopiaId] => 
                                                                    [ndcid] => 00069421030
                                                                    [brandName] => Viagra
                                                                    [genericName] => 
                                                                    [fullDescription] => 
                                                                    [brandType] => 
                                                                    [form] => Tablet
                                                                    [strength] => 
                                                                    [routeCode] => 
                                                                    [rxNormType] => 
                                                                    [rxNormId] => 
                                                                )

                                                            [action] => 
                                                            [dose] => 
                                                            [doseUnit] => 
                                                            [route] => 
                                                            [doseTiming] => 
                                                            [doseOther] => 
                                                            [duration] => 
                                                            [quantity] => 14
                                                            [quantityUnits] => tablets
                                                            [refills] => 
                                                            [substitutionPermitted] => 1
                                                            [otherNotes] => Other notes
                                                            [patientNotes] => Patient notes
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
                                                )

                                            [createdAt] => 1360125449195
                                            [createdBy] => c8ccd370-322f-43db-9165-8fc21812448a
                                        )

                                    [1] => stdClass Object
                                        (
                                            [prescribe] => stdClass Object
                                                (
                                                    [prescribeIdentity] => d31f2a56-b3d7-4a07-9519-d641a55d3c07
                                                    [patientIdentity] => 2f6154dc-f7a2-42e9-8c79-d18001d94d69
                                                    [patientExternalIdentity] => 5288541
                                                    [pharmacyIdentity] => 9900004
                                                    [hasScheduledDrug] => 
                                                    [stopDate] => 
                                                    [addToMedicationList] => 1
                                                    [sig] => stdClass Object
                                                        (
                                                            [drug] => stdClass Object
                                                                (
                                                                    [rcopiaId] => 
                                                                    [ndcid] => 00069421030
                                                                    [brandName] => Viagra
                                                                    [genericName] => 
                                                                    [fullDescription] => 
                                                                    [brandType] => 
                                                                    [form] => Tablet
                                                                    [strength] => 
                                                                    [routeCode] => 
                                                                    [rxNormType] => 
                                                                    [rxNormId] => 
                                                                )

                                                            [action] => 
                                                            [dose] => 
                                                            [doseUnit] => 
                                                            [route] => 
                                                            [doseTiming] => 
                                                            [doseOther] => 
                                                            [duration] => 
                                                            [quantity] => 14
                                                            [quantityUnits] => tablets
                                                            [refills] => 
                                                            [substitutionPermitted] => 1
                                                            [otherNotes] => Other notes
                                                            [patientNotes] => Patient notes
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
                                                )

                                            [createdAt] => 1360125458877
                                            [createdBy] => c8ccd370-322f-43db-9165-8fc21812448a
                                        )

                                )

                            [prescribeActive] => Array
                                (
                                    [0] => d31f2a56-b3d7-4a07-9519-d641a55d3c07
                                    [1] => aa1cc96a-6333-4d84-8eb6-50f295d9e8ee
                                )

                        )

                )

            [activeMedication] => Array
                (
                )

        )

    [allergy] => Array
        (
            [0] => stdClass Object
                (
                    [identity] => 
                    [name] => peanut
                    [ndcidCode] => Arachis hypogaea
                    [allergyGroupId] => Arachis Ara h 1
                    [allergicReaction] => Anaphylaxis
                    [allergicReactionDate] => 2013-01-15T10:39:20.546-08:00
                    [active] => 1
                )

        )

    [soapNote] => Array
        (
            [0] => stdClass Object
                (
                    [identity] => 27598610-397c-456b-a8a0-f394bd704414
                    [subjective] => stdClass Object
                        (
                            [chiefComplaint] => Knee pain
                            [note] => motorcycle injury
                            [symptoms] => Array
                                (
                                    [0] => sensative
                                    [1] => swelling
                                    [2] => discoloration
                                )

                            [historyOfCurrentIllness] => previous surgery
                            [appointmentDate] => 2013-01-16T05:45:08.459-08:00
                        )

                    [objectiveVitals] => stdClass Object
                        (
                            [vitalNotes] => sample vitals notes
                            [temperature] => 98.6
                            [heightFeet] => 5
                            [heightInches] => 8
                            [respiratoryRate] => 16
                            [weight] => 175
                            [bpSystolic] => 120
                            [bpDiastolic] => 80
                            [pulse] => 75
                            [headCircumference] => 22.5
                            [oxygenSaturation] => 82
                            [smoking] => 1
                            [painPoints] => Array
                                (
                                    [0] => stdClass Object
                                        (
                                            [painLocation] => Knee
                                            [painLevel] => 3
                                        )

                                )

                            [bmi] => 26.61
                        )

                    [objectivePhysical] => stdClass Object
                        (
                            [physicalNotes] => patient is complaining of knee pain
                            [problemAreas] => Array
                                (
                                    [0] => stdClass Object
                                        (
                                            [bodyPart] => stdClass Object
                                                (
                                                    [name] => KNEE
                                                    [category] => leg
                                                )

                                            [notes] => throbbing pain
                                            [imageUrl] => http://xxx/yyy
                                        )

                                    [1] => stdClass Object
                                        (
                                            [bodyPart] => stdClass Object
                                                (
                                                    [name] => HEENT
                                                    [category] => Mouth
                                                )

                                            [notes] => Redness in Throat
                                            [imageUrl] => 
                                        )

                                )

                            [patientEducationTopicsDiscussed] => 
                        )

                    [assessment] => stdClass Object
                        (
                            [notes] => Update to Serious problems here
                            [problems] => Array
                                (
                                    [0] => stdClass Object
                                        (
                                            [problemNoteIdentity] => 
                                            [icd9] => stdClass Object
                                                (
                                                    [code] => 321
                                                    [desc] => Cough
                                                )

                                            [note] => some notes
                                            [problemStartedAt] => 
                                            [problemStoppedAt] => 
                                            [soapNoteIdentity] => 
                                            [significant] => 
                                            [status] => 
                                            [updatedAt] => 
                                            [createdBy] => 
                                        )

                                    [1] => stdClass Object
                                        (
                                            [problemNoteIdentity] => 
                                            [icd9] => stdClass Object
                                                (
                                                    [code] => 543.2
                                                    [desc] => id Pulvinar
                                                )

                                            [note] => some more notes
                                            [problemStartedAt] => 
                                            [problemStoppedAt] => 
                                            [soapNoteIdentity] => 
                                            [significant] => 
                                            [status] => open
                                            [updatedAt] => 
                                            [createdBy] => 
                                        )

                                )

                        )

                    [plan] => stdClass Object
                        (
                            [notes] => Physical Therapy 2x a week
                            [comments] => Follow up visit
                        )

                    [updateBy] => Mieke Mocke
                    [updatedAt] => 2013-01-03T15:49:35.346-08:00
                )

        )

    [immunization] => Array
        (
            [0] => Array
                (
                    [0] => stdClass Object
                        (
                            [createTime] => timestamp
                            [vaccine] => vaccine
                            [notes] => notes
                            [userAssertion] => CONFIRMED
                            [activityTime] => activityTime
                            [activityBy] => activityBy
                            [administeredAmount] => administeredAmount
                            [administeredUnit] => administertedUnit
                            [vaccineLotNumber] => vaccineLotNumber
                            [manufacturerName] => manufacturerName
                            [manufacturerCode] => manufacturerCode
                            [cvxCode] => cvxCode
                        )

                    [1] => stdClass Object
                        (
                            [createTime] => timestamp
                            [vaccine] => vaccine
                            [notes] => notes
                            [userAssertion] => CONFIRMED
                            [activityTime] => activityTime
                            [activityBy] => activityBy
                            [administeredAmount] => administeredAmount
                            [administeredUnit] => administertedUnit
                            [vaccineLotNumber] => vaccineLotNumber
                            [manufacturerName] => manufacturerName
                            [manufacturerCode] => manufacturerCode
                            [cvxCode] => cvxCode
                        )

                )

            [1] => Array
                (
                    [0] => stdClass Object
                        (
                            [createTime] => timestamp
                            [vaccine] => vaccine
                            [notes] => notes
                            [userAssertion] => CONFIRMED
                            [activityTime] => activityTime
                            [activityBy] => activityBy
                            [administeredAmount] => administeredAmount
                            [administeredUnit] => administertedUnit
                            [vaccineLotNumber] => vaccineLotNumber
                            [manufacturerName] => manufacturerName
                            [manufacturerCode] => manufacturerCode
                            [cvxCode] => cvxCode
                        )

                    [1] => stdClass Object
                        (
                            [createTime] => timestamp
                            [vaccine] => vaccine
                            [notes] => notes
                            [userAssertion] => CONFIRMED
                            [activityTime] => activityTime
                            [activityBy] => activityBy
                            [administeredAmount] => administeredAmount
                            [administeredUnit] => administertedUnit
                            [vaccineLotNumber] => vaccineLotNumber
                            [manufacturerName] => manufacturerName
                            [manufacturerCode] => manufacturerCode
                            [cvxCode] => cvxCode
                        )

                )

        )

)

/*//////////////////////////////////////////////////////////////////////////////////////////////////

$posted_obj = json_decode('{
    "patient":{
        "firstName":"Jeremy1",
        "lastName":"ODay2",
        "ssn":"ssn",
        "preferredContact":null,
        "phone":[
            {
                "areaCode":"123",
                "prefix":"456",
                "suffix":"7890",
                "type":"OFFICE"
            },
            {
                "areaCode":"123",
                "prefix":"456",
                "suffix":"7890",
                "type":"FAX"
            }
        ],
        "address":[
            {
                "name":"address name",
                "address1":"address1",
                "address2":"address2",
                "city":"city",
                "state":"state",
                "postalCode":"90403",
                "countryCode":"US"
            },
            {
                "name":"address name",
                "address1":"address1",
                "address2":"address2",
                "city":"city",
                "state":"state",
                "postalCode":"90403",
                "countryCode":"US"
            }
        ],
        "email":[
            {
                "emailAddress":"jeremy@chaoslabs.com",
                "primary":true
            }
        ],
        "dob":"2012-11-30T21:07:49.005Z",
        "gender":"M",
        "language":"language",
        "patientConsent":false,
        "maritalStatus":"D",
        "race":"R",
        "ethnicity":"E",
        "smoking":"1",
        "paymentProfile":"A",
        "emergency":[
            {
                "name":"Name",
                "phone":{
                    "areaCode":"123",
                    "prefix":"456",
                    "suffix":"7890",
                    "type":"OFFICE"
                }
            },
            {
                "name":"Name",
                "phone":{
                    "areaCode":"123",
                    "prefix":"456",
                    "suffix":"7890",
                    "type":"OFFICE"
                }
            }
        ],
        "subscriberIsPatient":true,
        "insurance":[
            {
                "name":"Insurance Name",
                "copayPennies":500,
                "primary":false,
                "idNumber":"123456",
                "carrierPayerId":"987654"
            },
            {
                "name":"Insurance Name",
                "copayPennies":500,
                "primary":false,
                "idNumber":"123456",
                "carrierPayerId":"987654"
            }
        ],
        "externalId":"99927557",
        "middleName":null,
        "suffix":null,
        "smokingFrequency":"1-9 cigarettes/day"
    },
    "author":"Author",
    "organization":"Organization",
    "problem":[
        {
            "problemNoteIdentity":null,
            "icd9":{
                "code":"290.0.2",
                "desc":"Senile dementia, uncomplicated"
            },
            "note":"hallucinations",
            "problemStartedAt":"2012-12-24T08:58:52.186-08:00",
            "problemStoppedAt":null,
            "createdAt":1356368332328,
            "createdBy":null,
            "soapNoteIdentity":null,
            "status":"new",
            "significant":true
        }
    ],
    "medicationProfile":{
        "medication":{
            "00069421030":{
                "drug":{
                    "rcopiaId":null,
                    "ndcid":"00069421030",
                    "brandName":"Viagra",
                    "genericName":null,
                    "fullDescription":null,
                    "brandType":null,
                    "form":"Tablet",
                    "strength":null,
                    "routeCode":null,
                    "rxNormType":null,
                    "rxNormId":null
                },
                "note":[],
                "patientPrescription":[
                    {
                        "prescribe":{
                            "prescribeIdentity":"aa1cc96a-6333-4d84-8eb6-50f295d9e8ee",
                            "patientIdentity":"2f6154dc-f7a2-42e9-8c79-d18001d94d69",
                            "patientExternalIdentity":"5288541",
                            "pharmacyIdentity":"9900004",
                            "hasScheduledDrug":false,
                            "stopDate":null,
                            "addToMedicationList":true,
                            "sig":{
                                "drug":{
                                    "rcopiaId":null,
                                    "ndcid":"00069421030",
                                    "brandName":"Viagra",
                                    "genericName":null,
                                    "fullDescription":null,
                                    "brandType":null,
                                    "form":"Tablet",
                                    "strength":null,
                                    "routeCode":null,
                                    "rxNormType":null,
                                    "rxNormId":null
                                },
                                "action":null,
                                "dose":null,
                                "doseUnit":null,
                                "route":null,
                                "doseTiming":null,
                                "doseOther":null,
                                "duration":null,
                                "quantity":"14",
                                "quantityUnits":"tablets",
                                "refills":null,
                                "substitutionPermitted":true,
                                "otherNotes":"Other notes",
                                "patientNotes":"Patient notes",
                                "comments":"Comments",
                                "schedule":null,
                                "writtenDate":null,
                                "effectiveDate":null,
                                "lastFillDate":null,
                                "soldDate":null
                            },
                            "checkId":null,
                            "signaturePassword":"1234",
                            "prescriberOrderNumber":null,
                            "rxReferenceNumber":null,
                            "formularyNote":null,
                            "interactionNote":null,
                            "allergyReaction":null,
                            "interactionReaction":null,
                            "drugInteractionCheckPerformed":false
                        },
                        "createdAt":1360125449195,
                        "createdBy":"c8ccd370-322f-43db-9165-8fc21812448a"
                    },
                    {
                        "prescribe":{
                            "prescribeIdentity":"d31f2a56-b3d7-4a07-9519-d641a55d3c07",
                            "patientIdentity":"2f6154dc-f7a2-42e9-8c79-d18001d94d69",
                            "patientExternalIdentity":"5288541",
                            "pharmacyIdentity":"9900004",
                            "hasScheduledDrug":false,
                            "stopDate":null,
                            "addToMedicationList":true,
                            "sig":{
                                "drug":{
                                    "rcopiaId":null,
                                    "ndcid":"00069421030",
                                    "brandName":"Viagra",
                                    "genericName":null,
                                    "fullDescription":null,
                                    "brandType":null,
                                    "form":"Tablet",
                                    "strength":null,
                                    "routeCode":null,
                                    "rxNormType":null,
                                    "rxNormId":null
                                },
                                "action":null,
                                "dose":null,
                                "doseUnit":null,
                                "route":null,
                                "doseTiming":null,
                                "doseOther":null,
                                "duration":null,
                                "quantity":"14",
                                "quantityUnits":"tablets",
                                "refills":null,
                                "substitutionPermitted":true,
                                "otherNotes":"Other notes",
                                "patientNotes":"Patient notes",
                                "comments":"Comments",
                                "schedule":null,
                                "writtenDate":null,
                                "effectiveDate":null,
                                "lastFillDate":null,
                                "soldDate":null
                            },
                            "checkId":null,
                            "signaturePassword":"1234",
                            "prescriberOrderNumber":null,
                            "rxReferenceNumber":null,
                            "formularyNote":null,
                            "interactionNote":null,
                            "allergyReaction":null,
                            "interactionReaction":null,
                            "drugInteractionCheckPerformed":false
                        },
                        "createdAt":1360125458877,
                        "createdBy":"c8ccd370-322f-43db-9165-8fc21812448a"
                    }
                ],
                "prescribeActive":[
                    "d31f2a56-b3d7-4a07-9519-d641a55d3c07",
                    "aa1cc96a-6333-4d84-8eb6-50f295d9e8ee"
                ]
            }
        },
        "activeMedication":[]
    },
    "allergy":[
        {
            "identity":null,
            "name":"peanut",
            "ndcidCode":"Arachis hypogaea",
            "allergyGroupId":"Arachis Ara h 1",
            "allergicReaction":"Anaphylaxis",
            "allergicReactionDate":"2013-01-15T10:39:20.546-08:00",
            "active":true
        }
    ],
    "soapNote":[
        {
            "identity":"27598610-397c-456b-a8a0-f394bd704414",
            "subjective":{
                "chiefComplaint":"Knee pain",
                "note":"motorcycle injury",
                "symptoms":[
                    "sensative",
                    "swelling",
                    "discoloration"
                ],
                "historyOfCurrentIllness":"previous surgery",
                "appointmentDate":"2013-01-16T05:45:08.459-08:00"
            },
            "objectiveVitals":{
                "vitalNotes":"sample vitals notes",
                "temperature":98.6,
                "heightFeet":5,
                "heightInches":8,
                "respiratoryRate":16,
                "weight":175,
                "bpSystolic":120,
                "bpDiastolic":80,
                "pulse":75,
                "headCircumference":22.5,
                "oxygenSaturation":82,
                "smoking":1,
                "painPoints":[
                    {
                        "painLocation":"Knee",
                        "painLevel":3
                    }
                ],
                "bmi":26.61
            },
            "objectivePhysical":{
                "physicalNotes":"patient is complaining of knee pain",
                "problemAreas":[
                    {
                        "bodyPart":{
                            "name":"KNEE",
                            "category":"leg"
                        },
                        "notes":"throbbing pain",
                        "imageUrl":"http://xxx/yyy"
                    },
                    {
                        "bodyPart":{
                            "name":"HEENT",
                            "category":"Mouth"
                        },
                        "notes":"Redness in Throat",
                        "imageUrl":null
                    }
                ],
                "patientEducationTopicsDiscussed":null
            },
            "assessment":{
                "notes":"Update to Serious problems here",
                "problems":[
                    {
                        "problemNoteIdentity":null,
                        "icd9":{
                            "code":"321",
                            "desc":"Cough"
                        },
                        "note":"some notes",
                        "problemStartedAt":null,
                        "problemStoppedAt":null,
                        "soapNoteIdentity":null,
                        "significant":false,
                        "status":null,
                        "updatedAt":null,
                        "createdBy":null
                    },
                    {
                        "problemNoteIdentity":null,
                        "icd9":{
                            "code":"543.2",
                            "desc":"id Pulvinar"
                        },
                        "note":"some more notes",
                        "problemStartedAt":null,
                        "problemStoppedAt":null,
                        "soapNoteIdentity":null,
                        "significant":false,
                        "status":"open",
                        "updatedAt":null,
                        "createdBy":null
                    }
                ]
            },
            "plan":{
                "notes":"Physical Therapy 2x a week",
                "comments":"Follow up visit"
            },
            "updateBy":"Mieke Mocke",
            "updatedAt":"2013-01-03T15:49:35.346-08:00"
        }
    ],
    "immunization":[
        [
            {
                "createTime":"timestamp",
                "vaccine":"vaccine",
                "notes":"notes",
                "userAssertion":"CONFIRMED",
                "activityTime":"activityTime",
                "activityBy":"activityBy",
                "administeredAmount":"administeredAmount",
                "administeredUnit":"administertedUnit",
                "vaccineLotNumber":"vaccineLotNumber",
                "manufacturerName":"manufacturerName",
                "manufacturerCode":"manufacturerCode",
                "cvxCode":"cvxCode"
            },
            {
                "createTime":"timestamp",
                "vaccine":"vaccine",
                "notes":"notes",
                "userAssertion":"CONFIRMED",
                "activityTime":"activityTime",
                "activityBy":"activityBy",
                "administeredAmount":"administeredAmount",
                "administeredUnit":"administertedUnit",
                "vaccineLotNumber":"vaccineLotNumber",
                "manufacturerName":"manufacturerName",
                "manufacturerCode":"manufacturerCode",
                "cvxCode":"cvxCode"
            }
        ],
        [
            {
                "createTime":"timestamp",
                "vaccine":"vaccine",
                "notes":"notes",
                "userAssertion":"CONFIRMED",
                "activityTime":"activityTime",
                "activityBy":"activityBy",
                "administeredAmount":"administeredAmount",
                "administeredUnit":"administertedUnit",
                "vaccineLotNumber":"vaccineLotNumber",
                "manufacturerName":"manufacturerName",
                "manufacturerCode":"manufacturerCode",
                "cvxCode":"cvxCode"
            },
            {
                "createTime":"timestamp",
                "vaccine":"vaccine",
                "notes":"notes",
                "userAssertion":"CONFIRMED",
                "activityTime":"activityTime",
                "activityBy":"activityBy",
                "administeredAmount":"administeredAmount",
                "administeredUnit":"administertedUnit",
                "vaccineLotNumber":"vaccineLotNumber",
                "manufacturerName":"manufacturerName",
                "manufacturerCode":"manufacturerCode",
                "cvxCode":"cvxCode"
            }
        ]
    ]
}');

?>