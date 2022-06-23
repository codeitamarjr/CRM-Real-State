<?php
session_start();

// Load config
require "features/functions_messages.php";
require "features/functions_prospect.php";
require "features/functions_profile.php";
require "features/functions_property.php";
require "config/config.php";

// GET propertyCode for template
$propertyCode = $_GET['propertyCode'];

if ($_POST['save'] == 'start') {
    // Check if the email is already in the database
    if (getProfile('email', $_POST['email'], 'email') != null) {
        echo '<center><div class="alert alert-danger" role="alert">This email is already in the system<br>
            Your application has been restored!</div></center>';
        // Set profileID
        $profileID = getProfile('email', $_POST['email'], 'profileID');
    } else {
        //Create a new profile
        insertProfile($propertyCode, 'M', $_POST['email']);
        //Set the profileID
        $profileID = getProfile('email', $_POST['email'], 'profileID');
    };
};
if ($_POST['save'] == 'reference') {
    //Set profileID
    $profileID = $_POST['profileID'];
    //Set values to the profile
    if($_POST['firstName'] != null) setProfile($profileID, 'firstName', $_POST['firstName']);
    if($_POST['lastName'] != null) setProfile($profileID, 'lastName', $_POST['lastName']);
    if($_POST['address'] != null) setProfile($profileID, 'address', $_POST['address']);
    if($_POST['city'] != null) setProfile($profileID, 'city', $_POST['city']);
    if($_POST['postalCode'] != null) setProfile($profileID, 'postalCode', $_POST['postalCode']);
    if($_POST['DOB'] != null) setProfile($profileID, 'DOB', $_POST['DOB']);
    if($_POST['ppsNumber'] != null) setProfile($profileID, 'ppsNumber', $_POST['ppsNumber']);
    if($_POST['expectedMoveinDate'] != null) setProfile($profileID, 'expectedMoveinDate', $_POST['expectedMoveinDate']);
    if($_POST['carParking'] != null) setProfile($profileID, 'carParking', $_POST['carParking']);
    if($_POST['pet'] != null) setProfile($profileID, 'pet', $_POST['pet']);
    if($_POST['mobilePhone'] != null) setProfile($profileID, 'mobilePhone', $_POST['mobilePhone']);
    if($_POST['contactNumber'] != null) setProfile($profileID, 'contactNumber', $_POST['contactNumber']);
    if($_POST['alternativeEmail'] != null) setProfile($profileID, 'alternativeEmail', $_POST['alternativeEmail']);
    if($_POST['notes'] != null) setProfile($profileID, 'notes', $_POST['notes']);
};
if ($_POST['save'] == 'documents' || $_POST['save'] == 'PAG1') {
    //Set profileID
    $profileID = $_POST['profileID'];
    //Set values to the profile
    if($_POST['employementSector'] != null) setProfile($profileID, 'employementSector', $_POST['employementSector']);
    if($_POST['employementStatus'] != null) setProfile($profileID, 'employementStatus', $_POST['employementStatus']);
    if($_POST['employementSince'] != null) setProfile($profileID, 'employementSince', $_POST['employementSince']);
    if($_POST['employeer'] != null) setProfile($profileID, 'employeer', $_POST['employeer']);
    if($_POST['jobTitle'] != null) setProfile($profileID, 'jobTitle', $_POST['jobTitle']);
    if($_POST['employerPhone'] != null) setProfile($profileID, 'employerPhone', $_POST['employerPhone']);
    if($_POST['netIncome'] != null) setProfile($profileID, 'netIncome', $_POST['netIncome']);
    if($_POST['extraIncome'] != null) setProfile($profileID, 'extraIncome', $_POST['extraIncome']);
    if($_POST['landlordName'] != null) setProfile($profileID, 'landlordName', $_POST['landlordName']);
    if($_POST['landlordPhone'] != null) setProfile($profileID, 'landlordPhone', $_POST['landlordPhone']);
    if($_POST['expectedNotice'] != null) setProfile($profileID, 'expectedNotice', $_POST['expectedNotice']);
};


// Upload the documents
if ($_POST['save'] == 'uploadAttachments' || $_POST['save'] == 'finish' || $_POST['save'] == 'PAG2') {
    //Set profileID
    $profileID = $_POST['profileID'];

    //If user select a file for ID
    if ($_FILES['ID']['name'] != null) {
        require "features/functions_upload.php";

        //Upload the file
        if($_FILES['ID'] != null) uploadProfileAttachments($profileID, 'ID of the Applicant', $_FILES['ID'], 'ID', 'profileID');
        if($_FILES['landlordReference'] != null) uploadProfileAttachments($profileID, 'Landlord Reference Letter', $_FILES['landlordReference'], 'landlordReference', 'landlordReferenceLetter');
        if($_FILES['workReference'] != null) uploadProfileAttachments($profileID, 'Work Reference Letter', $_FILES['workReference'], 'workReference', 'workReferenceLetter');
        if($_FILES['payslip'] != null) uploadProfileAttachments($profileID, 'Payslip', $_FILES['payslip'], 'payslip', 'payslip');
        if($_FILES['bankStatements'] != null) uploadProfileAttachments($profileID, 'Bank Statements', $_FILES['bankStatements'], 'bankStatements', 'bankStatements');
    }
};

// Remove the documents
if ($_POST['save'] == 'removeProfileAttachments') {
    //Set profileID
    $profileID = $_POST['profileID'];

    require "features/functions_upload.php";
    //Delete the file
    $idprofileAttachments = $_POST['idprofileAttachments'];
    $fileNumber = $_POST['fileNumber'];
    $category = $_POST['category'];
    removeProfileAttachments($profileID, $idprofileAttachments, $fileNumber, $category);
};

if ($_POST['save'] == 'finish' || $_POST['save'] == 'addApplicant' || $_POST['save'] == 'PAG2' ) {
    //Set profileID
    $profileID = $_POST['profileID'];
};

if ($_POST['save'] == 'includeOccupant' || $_POST['save'] == 'PAG3') {
    //Set profileID
    $profileID = $_POST['profileID'];
    //Create a new profile for occupant
    if($_POST['occupantFirstName'] != null) insertProfileOccupant($propertyCode, $profileID, 'O', $_POST['occupantEmail'], $_POST['occupantFirstName'], $_POST['occupantPhone']);
};

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Real Enquiries - Tenants Data Registration Form</title>
    <meta content="Customer Relationship Management for Real State Agents - Privacy Policy">
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css?h=093230e10e41709a7a3d6ba7f3b3b116">
    <link type="text/css" rel="stylesheet" href="https://cdn01.jotfor.ms/themes/CSS/5e6b428acc8c4e222d1beb91.css?themeRevisionID=5eb3b4ae85bd2e1e2966db96" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.12.0/css/all.css">
</head>

<body class="bg-gradient-primary">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg">
                <div class="card shadow-lg o-hidden border-0 my-5">
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="col-lg d-none d-lg-flex">
                                <div class="flex-grow-1 bg-login-image" style="background-image: url(assets/img/spacejoy-unsplash.webp);">
                                </div>
                            </div>
                            <div class="col-lg-6">

                                <?php if ($_POST['save'] == null) { ?>

                                    <form method="POST">
                                        <div class="container-fluid">
                                            <div class="col">
                                                <div class="row g-0">
                                                    <div class="card-body text-black">
                                                        <div class="text-center">
                                                            <h2 class="mt-0"><i class="mdi mdi-check-all"></i></h2>
                                                            <h4 class="mt-0">Online Application</h4>
                                                            <div class="text-center">
                                                                <img src="features/uploads/<?php echo getPropertyData($propertyCode, 'property_logo'); ?>" class="rounded" alt="Property Logo">
                                                            </div>
                                                            <p class="w-75 mb-2 mx-auto">Welcome to your application for<br><?php echo getPropertyData($propertyCode, 'property_name'); ?>.<br><br><br>
                                                                Let's start, what's your e-mail address?<br>
                                                            <div class="mb-3 col-md">
                                                                <label class="form-label">Email</label>
                                                                <input type="email" class="form-control" placeholder="Email" name="email" required>
                                                            </div>
                                                            <p>
                                                        </div>
                                                        <ul class="list-inline wizard mb-0">
                                                            <button type="submit" class="btn btn-primary float-end" name="save" value="start">Start</button>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>

                                <?php } elseif ($_POST['save'] == 'start' || $_POST['save'] == 'PAG1') { ?>

                                    <form method="POST">
                                        <input type="hidden" name="profileID" value="<?php echo $profileID; ?>">

                                        <div class="container-fluid">
                                            <div class="row d-flex justify-content-center align-items-center h-100">
                                                <div class="col">
                                                    <div class="row g-0">
                                                        <div class="card-body text-black">
                                                            <h4 class="mb-3">Basic Information</h4>

                                                            <div class="row g-2">
                                                                <div class="mb-3 col-md-6">
                                                                    <label class="form-label">First Name</label>
                                                                    <input type="text" class="form-control" required placeholder="First Name" name="firstName" <?php if (getProfile('profileID', $profileID, 'firstName') != null) echo 'value="' . htmlspecialchars(getProfile('profileID', $profileID, 'firstName')) . '"';  ?>>
                                                                </div>
                                                                <div class="mb-3 col-md-6">
                                                                    <label class="form-label">Last Name</label>
                                                                    <input type="text" class="form-control" required placeholder="Surname" name="lastName" <?php if (getProfile('profileID', $profileID, 'lastName') != null) echo 'value="' . htmlspecialchars(getProfile('profileID', $profileID, 'lastName')) . '"';  ?>>
                                                                </div>
                                                            </div>

                                                            <div class="mb-3">
                                                                <label class="form-label">Address</label>
                                                                <input type="text" class="form-control" required placeholder="1234 Main St" name="address" <?php if (getProfile('profileID', $profileID, 'address') != null) echo 'value="' . htmlspecialchars(getProfile('profileID', $profileID, 'address')) . '"';  ?>>
                                                            </div>

                                                            <div class="row g-2">
                                                                <div class="mb-3 col-md-5">
                                                                    <label class="form-label">City</label>
                                                                    <input type="text" class="form-control" required name="city" <?php if (getProfile('profileID', $profileID, 'city') != null) echo 'value="' . htmlspecialchars(getProfile('profileID', $profileID, 'city')) . '"';  ?>>
                                                                </div>

                                                                <div class="mb-3 col-md-3">
                                                                    <label class="form-label">Postal Code</label>
                                                                    <input type="text" class="form-control" required data-toggle="input-mask" data-mask-format="A00-AAAA" maxlength="7" name="postalCode" <?php if (getProfile('profileID', $profileID, 'postalCode') != null) echo 'value="' . getProfile('profileID', $profileID, 'postalCode') . '"';  ?>>
                                                                    <span class="font-13 text-muted">e.g "xxx-xxxx"</span><br>
                                                                    <span class="font-13 text-muted"><a href="https://finder.eircode.ie/" target="_blank">Find Eircode</a></span>
                                                                </div>
                                                            </div>

                                                            <div class="row g-2">
                                                                <div class="mb-3 col-md-4">
                                                                    <label class="form-label">Date of Birth</label>
                                                                    <input type="date" class="form-control" required name="DOB" <?php if (getProfile('profileID', $profileID, 'DOB') != null) echo 'value="' . getProfile('profileID', $profileID, 'DOB') . '"';  ?>>
                                                                </div>
                                                                <div class="mb-3 col-md-4">
                                                                    <label class="form-label">PPS Number</label>
                                                                    <input type="text" class="form-control" data-toggle="input-mask" data-mask-format="0000000-AA" maxlength="10" name="ppsNumber" <?php if (getProfile('profileID', $profileID, 'ppsNumber') != null) echo 'value="' . getProfile('profileID', $profileID, 'ppsNumber') . '"';  ?>>
                                                                    <span class="font-13 text-muted">e.g "xxxxxx-xx"</span>
                                                                </div>
                                                            </div>

                                                            <h4 class="mb-3">Aditional Information</h4>
                                                            <div class="row g-2">
                                                                <div class="mb-3 col-md-4">
                                                                    <label class="form-label">Expected Move-in Date</label>
                                                                    <input type="date" class="form-control" required name="expectedMoveinDate" <?php if (getProfile('profileID', $profileID, 'expectedMoveinDate') != null) echo 'value="' . getProfile('profileID', $profileID, 'expectedMoveinDate') . '"';  ?>>
                                                                </div>
                                                                <div class="mb-3 col-md-4">
                                                                    <label class="form-label">Car Parking</label>
                                                                    <select id="inputState" class="form-select" required name="carParking">
                                                                        <option disabled>Choose</option>
                                                                        <option value="0">No</option>
                                                                        <option value="1">Yes 1 Car Space</option>
                                                                        <option value="2">Yes 2 Car Space</option>
                                                                    </select>
                                                                </div>
                                                                <div class="mb-3 col-md-4">
                                                                    <label class="form-label">pet</label>
                                                                    <select id="inputState" class="form-select" required name="pet">
                                                                        <option disabled>Choose</option>
                                                                        <option value="0">No</option>
                                                                        <option value="1">Yes 1 pet</option>
                                                                        <option value="2">Yes 2 pets</option>
                                                                    </select>
                                                                </div>
                                                            </div>

                                                            <h4 class="mb-3">Contact Details</h4>

                                                            <div class="row g-2">
                                                                <div class="mb-3 col-md-4">
                                                                    <label class="form-label">Mobile Number</label>
                                                                    <input type="text" class="form-control" required data-toggle="input-mask" data-mask-format="+000-00-00000000" maxlength="17" name="mobilePhone" <?php if (getProfile('profileID', $profileID, 'mobilePhone') != null) echo 'value="' . getProfile('profileID', $profileID, 'mobilePhone') . '"';  ?>>
                                                                    <span class="font-13 text-muted">e.g "+353-xxx-xxxxxxx"</span>
                                                                </div>
                                                                <div class="mb-3 col-md-4">
                                                                    <label class="form-label">Contact Number</label>
                                                                    <input type="text" class="form-control" data-toggle="input-mask" data-mask-format="+000-00-00000000" maxlength="17" name="contactNumber" <?php if (getProfile('profileID', $profileID, 'contactNumber') != null) echo 'value="' . getProfile('profileID', $profileID, 'contactNumber') . '"';  ?>>
                                                                    <span class="font-13 text-muted">e.g "+353-xxx-xxxxxxx"</span>
                                                                </div>
                                                                <div class="mb-3 col-md-4">
                                                                    <label class="form-label">Alternative Email</label>
                                                                    <input type="email" class="form-control" name="alternativeEmail" <?php if (getProfile('profileID', $profileID, 'alternativeEmail') != null) echo 'value="' . htmlspecialchars(getProfile('profileID', $profileID, 'alternativeEmail')) . '"';  ?>>
                                                                </div>
                                                            </div>
                                                            <div class="mb-3 col-md">
                                                                <label class="form-label">Notes</label>
                                                                <textarea class="form-control" id="example-textarea" rows="5" name="notes" maxlength="255"><?php if (getProfile('profileID', $profileID, 'notes') != null) echo htmlspecialchars(getProfile('profileID', $profileID, 'notes'));  ?></textarea>
                                                            </div>
                                                            <ul class="list-inline wizard mb-0">
                                                                <button type="submit" class="btn btn-primary float-end" name="save" value="reference">Next</button>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </form>

                                <?php }; ?>

                                <?php if ($_POST['save'] == 'reference' || $_POST['save'] == 'PAG2') { ?>

                                    <form method="POST">
                                        <input type="hidden" name="profileID" value="<?php echo $profileID; ?>">
                                        <div class="container-fluid">
                                            <div class="row d-flex justify-content-center align-items-center h-100">
                                                <div class="col">
                                                    <div class="row">
                                                        <div class="card-body text-black">

                                                            <h4 class="mb-3">Work Reference</h4>
                                                            <div class="row g-2">
                                                                <div class="mb-3 col-md-4">
                                                                    <label class="form-label">Employement Sector</label>
                                                                    <select id="inputState" class="form-select" name="employementSector" required>
                                                                        <?php if (getProfile('profileID', $profileID, 'employementSector') != null) { ?>
                                                                            <option value="<?php echo getProfile('profileID', $profileID, 'employementSector'); ?>"><?php echo getProfile('profileID', $profileID, 'employementSector'); ?></option>
                                                                        <?php }; ?>
                                                                        <option>Choose</option>
                                                                        <option value="Administration">Administration</option>
                                                                        <option value="Construction">Construction</option>
                                                                        <option value="Civil Service">Civil Service</option>
                                                                        <option value="Domestic Worker">Domestic Worker</option>
                                                                        <option value="Education">Education</option>
                                                                        <option value="Engineering">Engineering</option>
                                                                        <option value="Health Care">Health Care</option>
                                                                        <option value="Hospitality">Hospitality</option>
                                                                        <option value="Information&Technology">Information&Technology</option>
                                                                        <option value="Oil&Gas">Oil&Gas</option>
                                                                        <option value="Pharmaceutical">Pharmaceutical</option>
                                                                        <option value="Professional Advisory">Professional Advisory</option>
                                                                        <option value="Retail">Retail</option>
                                                                        <option value="Self Employed">Self Employed</option>
                                                                        <option value="Social Welfare">Social Welfare</option>
                                                                        <option value="Property">Property</option>
                                                                        <option value="Other">Other</option>
                                                                    </select>
                                                                </div>
                                                                <div class="mb-3 col-md-4">
                                                                    <label class="form-label">Employement Status</label>
                                                                    <select id="inputState" class="form-select" name="employementStatus" required>
                                                                        <?php if (getProfile('profileID', $profileID, 'employementStatus') != null) { ?>
                                                                            <option value="<?php echo getProfile('profileID', $profileID, 'employementStatus'); ?>"><?php echo getProfile('profileID', $profileID, 'employementStatus'); ?></option>
                                                                        <?php }; ?>
                                                                        <option value="Choose">Choose</option>
                                                                        <option value="Employed">Employed</option>
                                                                        <option value="Retired">Retired</option>
                                                                        <option value="Student">Student</option>
                                                                        <option value="Home maker">Home maker</option>
                                                                        <option value="Self Employed">Self Employed</option>
                                                                        <option value="Part time Employment">Part time Employment</option>
                                                                        <option value="Not Employed">Not Employed</option>
                                                                        <option value="Other">Other</option>
                                                                    </select>
                                                                </div>
                                                                <div class="mb-3 col-md-4">
                                                                    <label class="form-label">Employed Since</label>
                                                                    <input type="date" class="form-control" required name="employementSince" <?php if (getProfile('profileID', $profileID, 'employementSince') != null) echo 'value="' . getProfile('profileID', $profileID, 'employementSince') . '"';  ?>>
                                                                </div>
                                                            </div>
                                                            <div class="row g-2">
                                                                <div class="mb-3 col-md-4">
                                                                    <label class="form-label">Name of Employeer</label>
                                                                    <input type="text" class="form-control" required placeholder="Employer Name" name="employeer" <?php if (getProfile('profileID', $profileID, 'employeer') != null) echo 'value="' . getProfile('profileID', $profileID, 'employeer') . '"';  ?>>
                                                                </div>
                                                                <div class="mb-3 col-md-4">
                                                                    <label class="form-label">Job Title</label>
                                                                    <input type="text" class="form-control" required placeholder="Job Title" name="jobTitle" <?php if (getProfile('profileID', $profileID, 'jobTitle') != null) echo 'value="' . getProfile('profileID', $profileID, 'jobTitle') . '"';  ?>>
                                                                </div>
                                                                <div class="mb-3 col-md-4">
                                                                    <label class="form-label">Employeer Phone Number</label>
                                                                    <input type="text" class="form-control" required data-toggle="input-mask" data-mask-format="+000-00-00000000" maxlength="17" name="employerPhone" <?php if (getProfile('profileID', $profileID, 'employerPhone') != null) echo 'value="' . getProfile('profileID', $profileID, 'employerPhone') . '"';  ?>>
                                                                    <span class="font-13 text-muted">e.g "+353-xxx-xxxxxxx"</span>
                                                                </div>

                                                            </div>
                                                            <div class="row g-2">
                                                                <div class="mb-3 col-md-4">
                                                                    <label class="form-label">Net Income</label>
                                                                    <input type="text" class="form-control" required data-toggle="input-mask" data-mask-format="000.000.000.000.000,00" data-reverse="true" maxlength="22" name="netIncome" <?php if (getProfile('profileID', $profileID, 'netIncome') != null) echo 'value="' . getProfile('profileID', $profileID, 'netIncome') . '"';  ?>>
                                                                    <span class="font-13 text-muted">e.g "Your net income after tax(The salary paid into your account)"</span>
                                                                </div>
                                                                <div class="mb-3 col-md-4">
                                                                    <label class="form-label">Extra Income</label>
                                                                    <input type="text" class="form-control" data-toggle="input-mask" data-mask-format="000.000.000.000.000,00" data-reverse="true" maxlength="22" name="extraIncome" <?php if (getProfile('profileID', $profileID, 'extraIncome') != null) echo 'value="' . getProfile('profileID', $profileID, 'extraIncome') . '"';  ?>>
                                                                    <span class="font-13 text-muted">e.g "Your extra income after tax"</span>
                                                                </div>
                                                            </div>

                                                            <h4 class="mb-3">Landlord Reference</h4>
                                                            <div class="row g-2">
                                                                <div class="mb-3 col-md-4">
                                                                    <label class="form-label">Landlord Name</label>
                                                                    <input type="text" class="form-control" placeholder="Landlord Name" name="landlordName" <?php if (getProfile('profileID', $profileID, 'landlordName') != null) echo 'value="' . getProfile('profileID', $profileID, 'landlordName') . '"';  ?>>
                                                                </div>
                                                                <div class="mb-3 col-md-4">
                                                                    <label class="form-label">Contact Number</label>
                                                                    <input type="text" class="form-control" data-toggle="input-mask" data-mask-format="+000-00-00000000" maxlength="17" name="landlordPhone" <?php if (getProfile('profileID', $profileID, 'landlordPhone') != null) echo 'value="' . getProfile('profileID', $profileID, 'landlordPhone') . '"';  ?>>
                                                                    <span class="font-13 text-muted">e.g "+353-xxx-xxxxxxx"</span>
                                                                </div>
                                                                <div class="mb-3 col-md-4">
                                                                    <label for="inputState" class="form-label">Expected Notice</label>
                                                                    <input type="date" class="form-control" required name="expectedNotice" <?php if (getProfile('profileID', $profileID, 'expectedNotice') != null) echo 'value="' . getProfile('profileID', $profileID, 'expectedNotice') . '"';  ?>>
                                                                    <span class="font-13 text-muted">Or expected move-in date"</span>
                                                                </div>
                                                            </div>

                                                            <ul class="list-inline wizard mb-0">
                                                                <button type="submit" class="btn btn-primary" name="save" value="PAG1">Go Back</button>
                                                                <button type="submit" class="btn btn-primary float-end" name="save" value="documents">Next</button>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </form>

                                <?php }; ?>

                                <?php if ($_POST['save'] == 'documents' || $_POST['save'] == 'uploadAttachments' || $_POST['save'] == 'removeProfileAttachments' || $_POST['save'] == 'PAG3') { ?>

                                    <form method="POST" enctype="multipart/form-data">
                                        <input type="hidden" name="profileID" value="<?php echo $profileID; ?>">
                                        <div class="container-fluid">
                                            <div class="row d-flex justify-content-center align-items-center h-100">
                                                <div class="col">
                                                    <div class="row g-0">
                                                        <div class="card-body text-black">
                                                            <h4 class="mb-3">Documents</h4>
                                                            <p>On this section you will be required to upload your documents. Please note that all documents must be in PDF/JPG/JPEG format.</p>
                                                            <div class="row g-2">
                                                                <div class="mb-3 col-md">
                                                                    <label class="form-label">ID</label>
                                                                    <input type="file" id="ID" class="form-control" name="ID[]">
                                                                    <span class="font-13 text-muted">It can be a passport, driving licence, national ID, etc.<br>
                                                                        One single file is allowed!</span>

                                                                    <?php
                                                                    require "config/config.php";

                                                                    $query = "SELECT * FROM profileAttachments WHERE profileID = '$profileID' AND category = 'profileID'";
                                                                    $result = mysqli_query($link, $query);
                                                                    while ($row = mysqli_fetch_array($result)) { ?>

                                                                        <div class="card mb-1 shadow-none border">
                                                                            <div class="p-2">
                                                                                <div class="row align-items-center">
                                                                                    <div class="col-auto">
                                                                                        <div class="avatar-sm">
                                                                                            <span class="avatar-title rounded">
                                                                                                ID:<?php echo htmlspecialchars($row['fileNumber']); ?>
                                                                                            </span>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col ps-0">
                                                                                        <a href="features/uploads/profileAttachments/<?php echo htmlspecialchars($row['fileName']); ?>" class="text-muted fw-bold">View/Download</a>
                                                                                    </div>
                                                                                    <div class="col-auto">
                                                                                        <!-- Button -->
                                                                                        <form method="POST">
                                                                                            <input type="hidden" name="idprofileAttachments" value="<?php echo htmlspecialchars($row['idprofileAttachments']); ?>">
                                                                                            <input type="hidden" name="fileNumber" value="<?php echo htmlspecialchars($row['fileNumber']); ?>">
                                                                                            <input type="hidden" name="category" value="<?php echo htmlspecialchars($row['category']); ?>">
                                                                                            <button type="submit" class="btn btn-link btn-lg text-muted" name="save" value="removeProfileAttachments">
                                                                                                <i class="fa fa-trash"></i>
                                                                                            </button>
                                                                                        </form>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                    <?php } ?>
                                                                </div>
                                                            </div>

                                                            <div class="row g-2">
                                                                <div class="mb-3 col-md">
                                                                    <label class="form-label">Landlord Reference</label>
                                                                    <input type="file" class="form-control" name="landlordReference[]">
                                                                    <?php

                                                                    $query = "SELECT * FROM profileAttachments WHERE profileID = '$profileID' AND category = 'landlordReferenceLetter'";
                                                                    $result = mysqli_query($link, $query);
                                                                    while ($row = mysqli_fetch_array($result)) { ?>

                                                                        <div class="card mb-1 shadow-none border">
                                                                            <div class="p-2">
                                                                                <div class="row align-items-center">
                                                                                    <div class="col-auto">
                                                                                        <div class="avatar-sm">
                                                                                            <span class="avatar-title rounded">
                                                                                                LRL:<?php echo htmlspecialchars($row['fileNumber']); ?>
                                                                                            </span>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col ps-0">
                                                                                        <a href="features/uploads/profileAttachments/<?php echo htmlspecialchars($row['fileName']); ?>" class="text-muted fw-bold">View/Download</a>
                                                                                    </div>
                                                                                    <div class="col-auto">
                                                                                        <!-- Button -->
                                                                                        <form method="POST">
                                                                                            <input type="hidden" name="idprofileAttachments" value="<?php echo htmlspecialchars($row['idprofileAttachments']); ?>">
                                                                                            <input type="hidden" name="fileNumber" value="<?php echo htmlspecialchars($row['fileNumber']); ?>">
                                                                                            <input type="hidden" name="category" value="<?php echo htmlspecialchars($row['category']); ?>">
                                                                                            <button type="submit" class="btn btn-link btn-lg text-muted" name="save" value="removeProfileAttachments">
                                                                                                <i class="fa fa-trash"></i>
                                                                                            </button>
                                                                                            <a href="features/uploads/profileAttachments/<?php echo htmlspecialchars($row['fileName']); ?>" class="btn btn-link btn-lg text-muted">
                                                                                                <i class="dripicons-download"></i>
                                                                                            </a>
                                                                                        </form>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                    <?php } ?>
                                                                </div>
                                                            </div>
                                                            <div class="row g-2">
                                                                <div class="mb-3 col-md">
                                                                    <label class="form-label">Work Reference</label>
                                                                    <input type="file" class="form-control" name="workReference[]">
                                                                    <span class="font-13 text-muted">In a headed paper, stating your name, job title, employer name, annual income,and employer phone number.</span>
                                                                    <?php

                                                                    $query = "SELECT * FROM profileAttachments WHERE profileID = '$profileID' AND category = 'workReferenceLetter'";
                                                                    $result = mysqli_query($link, $query);
                                                                    while ($row = mysqli_fetch_array($result)) { ?>

                                                                        <div class="card mb-1 shadow-none border">
                                                                            <div class="p-2">
                                                                                <div class="row align-items-center">
                                                                                    <div class="col-auto">
                                                                                        <div class="avatar-sm">
                                                                                            <span class="avatar-title rounded">
                                                                                                WRF:<?php echo htmlspecialchars($row['fileNumber']); ?>
                                                                                            </span>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col ps-0">
                                                                                        <a href="features/uploads/profileAttachments/<?php echo htmlspecialchars($row['fileName']); ?>" class="text-muted fw-bold">View/Download</a>
                                                                                    </div>
                                                                                    <div class="col-auto">
                                                                                        <!-- Button -->
                                                                                        <form method="POST">
                                                                                            <input type="hidden" name="idprofileAttachments" value="<?php echo htmlspecialchars($row['idprofileAttachments']); ?>">
                                                                                            <input type="hidden" name="fileNumber" value="<?php echo htmlspecialchars($row['fileNumber']); ?>">
                                                                                            <input type="hidden" name="category" value="<?php echo htmlspecialchars($row['category']); ?>">
                                                                                            <button type="submit" class="btn btn-link btn-lg text-muted" name="save" value="removeProfileAttachments">
                                                                                                <i class="fa fa-trash"></i>
                                                                                            </button>
                                                                                            <a href="features/uploads/profileAttachments/<?php echo htmlspecialchars($row['fileName']); ?>" class="btn btn-link btn-lg text-muted">
                                                                                                <i class="dripicons-download"></i>
                                                                                            </a>
                                                                                        </form>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                    <?php } ?>
                                                                </div>
                                                            </div>
                                                            <div class="row g-2">
                                                                <div class="mb-3 col-md">
                                                                    <label class="form-label">Payslip</label>
                                                                    <input class="form-control" type="file" id="formFileMultiple01" multiple="" name="payslip[]">
                                                                    <span class="font-13 text-muted">The latest payslip(If it's monthly just one, if it's weekly, four, etc.)</span>
                                                                    <?php

                                                                    $query = "SELECT * FROM profileAttachments WHERE profileID = '$profileID' AND category = 'payslip'";
                                                                    $result = mysqli_query($link, $query);
                                                                    while ($row = mysqli_fetch_array($result)) { ?>

                                                                        <div class="card mb-1 shadow-none border">
                                                                            <div class="p-2">
                                                                                <div class="row align-items-center">
                                                                                    <div class="col-auto">
                                                                                        <div class="avatar-sm">
                                                                                            <span class="avatar-title rounded">
                                                                                                WRF:<?php echo htmlspecialchars($row['fileNumber']); ?>
                                                                                            </span>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col ps-0">
                                                                                        <a href="features/uploads/profileAttachments/<?php echo htmlspecialchars($row['fileName']); ?>" class="text-muted fw-bold">View/Download</a>
                                                                                    </div>
                                                                                    <div class="col-auto">
                                                                                        <!-- Button -->
                                                                                        <form method="POST">
                                                                                            <input type="hidden" name="idprofileAttachments" value="<?php echo htmlspecialchars($row['idprofileAttachments']); ?>">
                                                                                            <input type="hidden" name="fileNumber" value="<?php echo htmlspecialchars($row['fileNumber']); ?>">
                                                                                            <input type="hidden" name="category" value="<?php echo htmlspecialchars($row['category']); ?>">
                                                                                            <button type="submit" class="btn btn-link btn-lg text-muted" name="save" value="removeProfileAttachments">
                                                                                                <i class="fa fa-trash"></i>
                                                                                            </button>
                                                                                            <a href="features/uploads/profileAttachments/<?php echo htmlspecialchars($row['fileName']); ?>" class="btn btn-link btn-lg text-muted">
                                                                                                <i class="dripicons-download"></i>
                                                                                            </a>
                                                                                        </form>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                    <?php } ?>
                                                                </div>
                                                            </div>
                                                            <div class="row g-2">
                                                                <div class="mb-3 col-md">
                                                                    <label class="form-label">Bank Statement</label>
                                                                    <input class="form-control" type="file" id="formFileMultiple01" multiple="" name="bankStatements[]">
                                                                    <span class="font-13 text-muted">The latest bank statement, showing the entire last month.</span>
                                                                    <?php

                                                                    $query = "SELECT * FROM profileAttachments WHERE profileID = '$profileID' AND category = 'bankStatements'";
                                                                    $result = mysqli_query($link, $query);
                                                                    while ($row = mysqli_fetch_array($result)) { ?>

                                                                        <div class="card mb-1 shadow-none border">
                                                                            <div class="p-2">
                                                                                <div class="row align-items-center">
                                                                                    <div class="col-auto">
                                                                                        <div class="avatar-sm">
                                                                                            <span class="avatar-title rounded">
                                                                                                BS:<?php echo htmlspecialchars($row['fileNumber']); ?>
                                                                                            </span>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col ps-0">
                                                                                        <a href="features/uploads/profileAttachments/<?php echo htmlspecialchars($row['fileName']); ?>" class="text-muted fw-bold">View/Download</a>
                                                                                    </div>
                                                                                    <div class="col-auto">
                                                                                        <!-- Button -->
                                                                                        <form method="POST">
                                                                                            <input type="hidden" name="idprofileAttachments" value="<?php echo htmlspecialchars($row['idprofileAttachments']); ?>">
                                                                                            <input type="hidden" name="fileNumber" value="<?php echo htmlspecialchars($row['fileNumber']); ?>">
                                                                                            <input type="hidden" name="category" value="<?php echo htmlspecialchars($row['category']); ?>">
                                                                                            <button type="submit" class="btn btn-link btn-lg text-muted" name="save" value="removeProfileAttachments">
                                                                                                <i class="fa fa-trash"></i>
                                                                                            </button>
                                                                                            <a href="features/uploads/profileAttachments/<?php echo htmlspecialchars($row['fileName']); ?>" class="btn btn-link btn-lg text-muted">
                                                                                                <i class="dripicons-download"></i>
                                                                                            </a>
                                                                                        </form>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                    <?php } ?>
                                                                </div>
                                                            </div>

                                                            <ul class="list-inline wizard mb-0">
                                                                <button type="submit" class="btn btn-primary" name="save" value="PAG2">Go Back</button>
                                                                <button type="submit" class="btn btn-primary" name="save" value="uploadAttachments">Upload</button>
                                                                <button type="submit" class="btn btn-primary float-end" name="save" value="finish">Next</button>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>

                                <?php }; ?>

                                <?php if ($_POST['save'] == 'finish' || $_POST['save'] == 'addApplicant' || $_POST['save'] == 'includeOccupant') { ?>

                                    <form method="POST" enctype="multipart/form-data">
                                        <input type="hidden" name="profileID" value="<?php echo $profileID; ?>">
                                        <div class="container-fluid">
                                            <div class="row d-flex justify-content-center align-items-center h-100">
                                                <div class="col">
                                                    <div class="row g-0">
                                                        <div class="card-body text-black">

                                                            <div class="p-5">
                                                                <div class="text-center">
                                                                    <h1 class="text-dark mb-4">On-line Application</h1>
                                                                </div>
                                                                <input type="hidden" name="id" value="<?php echo $hash; ?>">
                                                                <input type="hidden" name="category" value="prospectID">
                                                                <ul class="form-section page-section">
                                                                    <div id="subHeader_1" class="form-subHeader">
                                                                        <p>Thank you for applying with us <?php echo htmlspecialchars(getProfile('profileID', $profileID, 'firstName')); ?>.</p>

                                                                        <?php if(getProfile('profileID', $profileID, 'type') == 'M') { ?>

                                                                        <p>Before you finish your online application, are you applying to live with another occupant?</p>
                                                                        <p>
                                                                            If so we will require that the second applicant also submit his data, to add another applicant click on the buttom bellow.<br>
                                                                            <button type="submit" class="btn btn-primary" name="save" value="addApplicant">Add Occupant</button>
                                                                            <br>
                                                                        <div <?php if ($_POST['save'] != 'addApplicant') echo 'style="display:none;"'; ?>>
                                                                            <div class="row g-2">
                                                                                <div class="mb-3 col-md-4">
                                                                                    <label class="form-label">First Name</label>
                                                                                    <input type="text" name="occupantFirstName" class="form-control" placeholder="First Name" <?php if ($_POST['save'] == 'addApplicant') echo 'required'; ?>>
                                                                                </div>

                                                                                <div class="mb-3 col-md-3">
                                                                                    <label class="form-label">Phone</label>
                                                                                    <input type="text" name="occupantPhone" class="form-control" data-toggle="input-mask" data-mask-format="+000-00-00000000" maxlength="17" <?php if ($_POST['save'] == 'addApplicant') echo 'required'; ?>>
                                                                                    <span class="font-13 text-muted">e.g "+353-xxx-xxxxxxx"</span>
                                                                                </div>
                                                                                <div class="mb-3 col-md-5">
                                                                                    <label class="form-label">Email</label>
                                                                                    <input type="email" name="occupantEmail" class="form-control" placeholder="Email" <?php if ($_POST['save'] == 'addApplicant') echo 'required'; ?>>
                                                                                </div>
                                                                            </div>
                                                                            <button type="submit" class="btn btn-primary" name="save" value="includeOccupant">Save Occupant</button>
                                                                        </div>
                                                                        </p>
                                                                        <p>
                                                                        <table class="table">
                                                                            <thead>
                                                                                <tr>
                                                                                    <th scope="col">Name</th>
                                                                                    <th scope="col">Phone</th>
                                                                                    <th scope="col">Email</th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                                <?php
                                                                                $query = "SELECT * FROM profile WHERE mainApplicantID = '$profileID'";
                                                                                $result = mysqli_query($link, $query);
                                                                                while ($row = mysqli_fetch_array($result)) {
                                                                                    echo "<tr>
                                                                            <td>" . htmlspecialchars($row['firstName']) . "</td>
                                                                            <td>" . htmlspecialchars($row['mobilePhone']) . "</td>
                                                                            <td>" . htmlspecialchars($row['email']) . "</td>
                                                                            <td>" . htmlspecialchars($row['email']) . "</td>

                                                                            </tr>";
                                                                                }
                                                                                ?>
                                                                            </tbody>
                                                                        </table>
                                                                        </p>

                                                                        <?php } ?>
                                                                    </div>
                                                                </ul>
                                                            </div>

                                                            <ul class="list-inline wizard mb-0">
                                                                <button type="submit" class="btn btn-primary" name="save" value="PAG3">Go Back</button>
                                                                <button type="submit" class="btn btn-primary float-end" name="save" value="complete">Finish</button>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>

                                <?php }; ?>

                                <?php if ($_POST['save'] == 'complete') { ?>

                                    <div class="container-fluid">
                                        <div class="row d-flex justify-content-center align-items-center h-100">
                                            <div class="col">
                                                <div class="row g-0">
                                                    <div class="card-body text-black">

                                                        <div class="p-5">
                                                            <div class="text-center">
                                                                <h1 class="text-dark mb-4">On-line Application</h1>
                                                            </div>
                                                            <input type="hidden" name="id" value="<?php echo $hash; ?>">
                                                            <input type="hidden" name="category" value="prospectID">
                                                            <ul class="form-section page-section">
                                                                <div id="subHeader_1" class="form-subHeader">
                                                                    <p>Your online application has been submitted with succes!</p>
                                                                    <p>One of our agents will be in touch shortly on your email address or phone number.</p>
                                                                    <p>Please keep your application data updated and if you need you can come back and edit again using your e-mail address.</p>
                                                                </div>
                                                            </ul>
                                                        </div>

                                                        <ul class="list-inline wizard mb-0">
                                                            <input type="button" value="Go back" class="btn btn-primary" onclick="history.back()">
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                <?php }; ?>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

</body>

</html>
<style type="text/css">
    @media print {
        .form-section {
            display: inline !important
        }

        .form-pagebreak {
            display: none !important
        }

        .form-section-closed {
            height: auto !important
        }

        .page-section {
            position: initial !important
        }
    }

    /* Injected CSS Code */

    .form-label.form-label-auto {
        display: block;
        float: none;
        text-align: left;
        width: 100%;
    }

    /* Injected CSS Code */
</style>