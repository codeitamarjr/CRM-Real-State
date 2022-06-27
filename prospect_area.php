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
    if ($_POST['firstName'] != null) setProfile($profileID, 'firstName', $_POST['firstName']);
    if ($_POST['lastName'] != null) setProfile($profileID, 'lastName', $_POST['lastName']);
    if ($_POST['address'] != null) setProfile($profileID, 'address', $_POST['address']);
    if ($_POST['city'] != null) setProfile($profileID, 'city', $_POST['city']);
    if ($_POST['postalCode'] != null) setProfile($profileID, 'postalCode', $_POST['postalCode']);
    if ($_POST['DOB'] != null) setProfile($profileID, 'DOB', $_POST['DOB']);
    if ($_POST['ppsNumber'] != null) setProfile($profileID, 'ppsNumber', $_POST['ppsNumber']);
    if ($_POST['children'] != null) setProfile($profileID, 'children', $_POST['children']);
    if ($_POST['expectedMoveinDate'] != null) setProfile($profileID, 'expectedMoveinDate', $_POST['expectedMoveinDate']);
    if ($_POST['carParking'] != null) setProfile($profileID, 'carParking', $_POST['carParking']);
    if ($_POST['pet'] != null) setProfile($profileID, 'pet', $_POST['pet']);
    if ($_POST['mobilePhone'] != null) setProfile($profileID, 'mobilePhone', $_POST['mobilePhone']);
    if ($_POST['contactNumber'] != null) setProfile($profileID, 'contactNumber', $_POST['contactNumber']);
    if ($_POST['alternativeEmail'] != null) setProfile($profileID, 'alternativeEmail', $_POST['alternativeEmail']);
    if ($_POST['notes'] != null) setProfile($profileID, 'notes', $_POST['notes']);
};
if ($_POST['save'] == 'documents' || $_POST['save'] == 'PAG1') {
    //Set profileID
    $profileID = $_POST['profileID'];
    //Set values to the profile
    if ($_POST['employementSector'] != null) setProfile($profileID, 'employementSector', $_POST['employementSector']);
    if ($_POST['employementStatus'] != null) setProfile($profileID, 'employementStatus', $_POST['employementStatus']);
    if ($_POST['employementSince'] != null) setProfile($profileID, 'employementSince', $_POST['employementSince']);
    if ($_POST['employeer'] != null) setProfile($profileID, 'employeer', $_POST['employeer']);
    if ($_POST['jobTitle'] != null) setProfile($profileID, 'jobTitle', $_POST['jobTitle']);
    if ($_POST['employerPhone'] != null) setProfile($profileID, 'employerPhone', $_POST['employerPhone']);
    if ($_POST['netIncome'] != null) setProfile($profileID, 'netIncome', $_POST['netIncome']);
    if ($_POST['extraIncome'] != null) setProfile($profileID, 'extraIncome', $_POST['extraIncome']);
    if ($_POST['HAP'] != null) setProfile($profileID, 'HAP', $_POST['HAP']);
    if ($_POST['HAPAllowance'] != null) setProfile($profileID, 'HAPAllowance', $_POST['HAPAllowance']);
    if ($_POST['landlordName'] != null) setProfile($profileID, 'landlordName', $_POST['landlordName']);
    if ($_POST['landlordPhone'] != null) setProfile($profileID, 'landlordPhone', $_POST['landlordPhone']);
    if ($_POST['expectedNotice'] != null) setProfile($profileID, 'expectedNotice', $_POST['expectedNotice']);
};


// Upload the documents
if ($_POST['save'] == 'uploadAttachments' || $_POST['save'] == 'finish' || $_POST['save'] == 'PAG2') {
    //Set profileID
    $profileID = $_POST['profileID'];

    //If user select a file for ID
    if ($_FILES['ID']['name'] != null) {
        require "features/functions_upload.php";

        //Upload the file
        if ($_FILES['ID'] != null) uploadProfileAttachments($profileID, 'ID of the Applicant', $_FILES['ID'], 'ID', 'profileID');
        if ($_FILES['landlordReference'] != null) uploadProfileAttachments($profileID, 'Landlord Reference Letter', $_FILES['landlordReference'], 'landlordReference', 'landlordReferenceLetter');
        if ($_FILES['workReference'] != null) uploadProfileAttachments($profileID, 'Work Reference Letter', $_FILES['workReference'], 'workReference', 'workReferenceLetter');
        if ($_FILES['payslip'] != null) uploadProfileAttachments($profileID, 'Payslip', $_FILES['payslip'], 'payslip', 'payslip');
        if ($_FILES['bankStatements'] != null) uploadProfileAttachments($profileID, 'Bank Statements', $_FILES['bankStatements'], 'bankStatements', 'bankStatements');
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

if ($_POST['save'] == 'finish' || $_POST['save'] == 'addApplicant' || $_POST['save'] == 'PAG2') {
    //Set profileID
    $profileID = $_POST['profileID'];
};

if ($_POST['save'] == 'includeOccupant' || $_POST['save'] == 'PAG3') {
    //Set profileID
    $profileID = $_POST['profileID'];
    //Create a new profile for occupant
    if ($_POST['occupantFirstName'] != null) insertProfileOccupant($propertyCode, $profileID, 'O', $_POST['occupantEmail'], $_POST['occupantFirstName'], $_POST['occupantPhone']);
};

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Real Enquiries - Tenants Data Registration Form</title>
    <meta content="Customer Relationship Management for Real State Agents - Privacy Policy">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css?h=093230e10e41709a7a3d6ba7f3b3b116">
    <link type="text/css" rel="stylesheet" href="https://cdn01.jotfor.ms/themes/CSS/5e6b428acc8c4e222d1beb91.css?themeRevisionID=5eb3b4ae85bd2e1e2966db96" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.12.0/css/all.css">
    <link rel="icon" type="image/x-icon" href="features/uploads/<?php echo getPropertyData($propertyCode, 'property_logo'); ?>">
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
                                                                    <input type="text" class="form-control" data-toggle="input-mask" data-mask-format="A00-AAAA" maxlength="7" name="postalCode" <?php if (getProfile('profileID', $profileID, 'postalCode') != null) echo 'value="' . getProfile('profileID', $profileID, 'postalCode') . '"';  ?>>
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
                                                                <div class="mb-3 col-md-3">
                                                                    <label class="form-label">Childrens</label>
                                                                    <input type="text" class="form-control" data-toggle="input-mask" maxlength="1" name="children" <?php if (getProfile('profileID', $profileID, 'children') != null) echo 'value="' . getProfile('profileID', $profileID, 'children') . '"';  ?>>
                                                                    <span class="font-13 text-muted">Any occupant below 18 years old</span>
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
                                                                    <input type="text" class="form-control" data-toggle="input-mask" data-mask-format="+000-00-00000000" maxlength="17" name="employerPhone" <?php if (getProfile('profileID', $profileID, 'employerPhone') != null) echo 'value="' . getProfile('profileID', $profileID, 'employerPhone') . '"';  ?>>
                                                                    <span class="font-13 text-muted">e.g "+353-xxx-xxxxxxx"</span>
                                                                </div>

                                                            </div>
                                                            <div class="row g-2">
                                                                <div class="mb-3 col-md-4">
                                                                    <label class="form-label">Net Income Monthly</label>
                                                                    <input type="text" class="form-control" required data-toggle="input-mask" data-mask-format="000.000.000.000.000,00" data-reverse="true" maxlength="22" name="netIncome" <?php if (getProfile('profileID', $profileID, 'netIncome') != null) echo 'value="' . getProfile('profileID', $profileID, 'netIncome') . '"';  ?>>
                                                                    <span class="font-13 text-muted">e.g "Your net income after tax(The salary paid into your bank account monthly)"</span>
                                                                </div>
                                                                <div class="mb-3 col-md-4">
                                                                    <label class="form-label">Extra Income</label>
                                                                    <input type="text" class="form-control" data-toggle="input-mask" data-mask-format="000.000.000.000.000,00" data-reverse="true" maxlength="22" name="extraIncome" <?php if (getProfile('profileID', $profileID, 'extraIncome') != null) echo 'value="' . getProfile('profileID', $profileID, 'extraIncome') . '"';  ?>>
                                                                    <span class="font-13 text-muted">e.g "Extra income that came into your bank statement"</span>
                                                                </div>
                                                                <div class="mb-3 col-md-4">
                                                                    <label class="form-label">Social Housing Support</label>
                                                                    <label>No
                                                                        <input type="radio" name="HAP" id="fixHeight" value="Market" <?php if (getProfile('profileID', $profileID, 'HAP') == "Market") echo 'checked'; ?>>
                                                                    </label>
                                                                    <label>HAP
                                                                        <input type="radio" name="HAP" id="adjustableHeight" value="HAP" <?php if (getProfile('profileID', $profileID, 'HAP') == "HAP") echo 'checked'; ?>>
                                                                    </label>
                                                                    <br>
                                                                    <div id="<?php if (getProfile('profileID', $profileID, 'HAP') == "Market" || getProfile('profileID', $profileID, 'HAP') == null) echo 'max-height'; ?>">
                                                                        <label>
                                                                            <p>HAP Allowance<br>
                                                                                <input type="number" name="HAPAllowance" class="form-control" <?php if (getProfile('profileID', $profileID, 'HAPAllowance') != null) echo 'value="' . getProfile('profileID', $profileID, 'HAPAllowance') . '"';  ?>>
                                                                            </p>
                                                                        </label>
                                                                    </div>
                                                                    <span class="font-13 text-muted">e.g "Housing Assistance Payment or Homeless Housing Assistance Payment"</span>
                                                                </div>
                                                            </div>

                                                            <h4 class="mb-3">Landlord Reference</h4>
                                                            <div class="row g-2">
                                                                <div class="mb-3 col-md-4">
                                                                    <label class="form-label">Landlord Name</label>
                                                                    <input type="text" class="form-control" placeholder="Landlord Name" name="landlordName" <?php if (getProfile('profileID', $profileID, 'landlordName') != null) echo 'value="' . getProfile('profileID', $profileID, 'landlordName') . '"';  ?>>
                                                                </div>
                                                                <div class="mb-3 col-md-4">
                                                                    <label class="form-label">Landlord Phone Number</label>
                                                                    <input type="text" class="form-control" data-toggle="input-mask" data-mask-format="+000-00-00000000" maxlength="17" name="landlordPhone" <?php if (getProfile('profileID', $profileID, 'landlordPhone') != null) echo 'value="' . getProfile('profileID', $profileID, 'landlordPhone') . '"';  ?>>
                                                                    <span class="font-13 text-muted">e.g "+353-xxx-xxxxxxx"</span>
                                                                </div>
                                                                <div class="mb-3 col-md-4">
                                                                    <label for="inputState" class="form-label">Expected Notice</label>
                                                                    <input type="date" class="form-control" name="expectedNotice" <?php if (getProfile('profileID', $profileID, 'expectedNotice') != null) echo 'value="' . getProfile('profileID', $profileID, 'expectedNotice') . '"';  ?>>
                                                                    <span class="font-13 text-muted">If you gave a notice to your currently landlord, when you must leave the property?"</span>
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
                                                                                            <input type="hidden" name="profileID" value="<?php echo $profileID; ?>">

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
                                                                                            <input type="hidden" name="profileID" value="<?php echo $profileID; ?>">

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
                                                                                            <input type="hidden" name="profileID" value="<?php echo $profileID; ?>">

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
                                                                                            <input type="hidden" name="profileID" value="<?php echo $profileID; ?>">

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
                                                                    <span class="font-13 text-muted">The latest bank statement, showing the entire last month.<br>
                                                                This is a mandatory document to cross your income and  confirm the affordability.</span>
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
                                                                                            <input type="hidden" name="profileID" value="<?php echo $profileID; ?>">

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
                                                                    <div id="subHeader_1" class="form-subHeader text-center">
                                                                        <p>Thank you for applying with us <?php echo htmlspecialchars(getProfile('profileID', $profileID, 'firstName')); ?>.</p>

                                                                        <?php if (getProfile('profileID', $profileID, 'type') == 'M') { ?>

                                                                            <p>Before you finish your online application, are you applying to live with another occupant?<br>
                                                                                We'll considerer the information of all applicants before the outcome.</p>
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
                                                                                        <span class="font-13 text-muted">Double check this email( This will be the login for your occupant add his data).</span>
                                                                                    </div>
                                                                                </div>
                                                                                <button type="submit" class="btn btn-primary" name="save" value="includeOccupant">Save Occupant</button><br>
                                                                                <span class="font-13 text-muted">Just click once, you'll not be able to delete an occupant.</span>
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
                                                                    <div class="alert alert-warning" role="alert">
                                                                        <p>In case of you'll live with another occupant, you can share the welcome email with him, so he can apply and submit his data( Both incomes will be added into the household income).</p>
                                                                        <a href="whatsapp://send?text=Hi, I'm inviting you to apply with me into the property <?php echo getPropertyData($propertyCode, 'property_name'); ?>, you can visit the website : https://www.realenquiries.com/prospect_area.php?propertyCode=<?php echo $propertyCode; ?>" data-action="share/whatsapp/share" target="_blank">
                                                                        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-whatsapp" viewBox="0 0 16 16">
  <path d="M13.601 2.326A7.854 7.854 0 0 0 7.994 0C3.627 0 .068 3.558.064 7.926c0 1.399.366 2.76 1.057 3.965L0 16l4.204-1.102a7.933 7.933 0 0 0 3.79.965h.004c4.368 0 7.926-3.558 7.93-7.93A7.898 7.898 0 0 0 13.6 2.326zM7.994 14.521a6.573 6.573 0 0 1-3.356-.92l-.24-.144-2.494.654.666-2.433-.156-.251a6.56 6.56 0 0 1-1.007-3.505c0-3.626 2.957-6.584 6.591-6.584a6.56 6.56 0 0 1 4.66 1.931 6.557 6.557 0 0 1 1.928 4.66c-.004 3.639-2.961 6.592-6.592 6.592zm3.615-4.934c-.197-.099-1.17-.578-1.353-.646-.182-.065-.315-.099-.445.099-.133.197-.513.646-.627.775-.114.133-.232.148-.43.05-.197-.1-.836-.308-1.592-.985-.59-.525-.985-1.175-1.103-1.372-.114-.198-.011-.304.088-.403.087-.088.197-.232.296-.346.1-.114.133-.198.198-.33.065-.134.034-.248-.015-.347-.05-.099-.445-1.076-.612-1.47-.16-.389-.323-.335-.445-.34-.114-.007-.247-.007-.38-.007a.729.729 0 0 0-.529.247c-.182.198-.691.677-.691 1.654 0 .977.71 1.916.81 2.049.098.133 1.394 2.132 3.383 2.992.47.205.84.326 1.129.418.475.152.904.129 1.246.08.38-.058 1.171-.48 1.338-.943.164-.464.164-.86.114-.943-.049-.084-.182-.133-.38-.232z"></path>
</svg>
                                                                        </a>
                                                                    </div>
                                                                    <p>Thank you for your interest in our property.</p>
                                                                </div>
                                                            </ul>
                                                        </div>

                                                        <ul class="list-inline wizard mb-0">
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

    /* Injected CSS Code for HAP form */
    #max-height {
        display: none;
    }
</style>

<script>
    // Select HAP form
    const fixHeight = document.querySelector('#fixHeight');
    const adjustableHeight = document.querySelector('#adjustableHeight');

    fixHeight.addEventListener('change', adjustableHeightCheck);
    adjustableHeight.addEventListener('change', adjustableHeightCheck);

    function adjustableHeightCheck() {
        if (document.getElementById("adjustableHeight").checked) {
            document.getElementById("max-height").style.display = "block";
            document.getElementById("height").innerHTML = "Niedrigste Höhe in mm";
        } else {
            document.getElementById("max-height").style.display = "none";
            document.getElementById("height").innerHTML = "Höhe";
        }
    }
</script>