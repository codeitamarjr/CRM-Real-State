<?php
//Load config
require "features/functions_messages.php";

require "features/functions_prospect.php";
require "features/functions_profile.php";

$hash = $_GET['key'];

if ($_POST['save'] == 'start') {
    // Check if the email is already in the database
    if (getProfile('email', $_POST['email'], 'email') != null) {
        echo '<center><div class="alert alert-danger" role="alert">This email is already in the system<br>
            Your application has been restored!</div></center>';
        // Set profileID
        $profileID = getProfile('email', $_POST['email'], 'profileID');
        $_SESSION['profileID'] = $profileID;
    } else {
        //Create a new profile
        insertProfile('M', $_POST['email']);
        //Set the profileID
        $profileID = getProfile('email', $_POST['email'], 'profileID');
        $_SESSION['profileID'] = $profileID;
    };
};
if ($_POST['save'] == 'reference') {
    //Set profileID
    $profileID = $_POST['profileID'];
    //Set values to the profile
    setProfile($profileID, 'firstName', $_POST['firstName']);
    setProfile($profileID, 'lastName', $_POST['lastName']);
    setProfile($profileID, 'address', $_POST['address']);
    setProfile($profileID, 'city', $_POST['city']);
    setProfile($profileID, 'postalCode', $_POST['postalCode']);
    setProfile($profileID, 'DOB', $_POST['DOB']);
    setProfile($profileID, 'ppsNumber', $_POST['ppsNumber']);
    setProfile($profileID, 'expectedMoveinDate', $_POST['expectedMoveinDate']);
    setProfile($profileID, 'carParking', $_POST['carParking']);
    setProfile($profileID, 'pet', $_POST['pet']);
    setProfile($profileID, 'mobilePhone', $_POST['mobilePhone']);
    setProfile($profileID, 'contactNumber', $_POST['contactNumber']);
    setProfile($profileID, 'alternativeEmail', $_POST['alternativeEmail']);
    setProfile($profileID, 'notes', $_POST['notes']);
};
if ($_POST['save'] == 'documents') {
    //Set profileID
    $profileID = $_POST['profileID'];
    //Set values to the profile
    setProfile($profileID, 'employementSector', $_POST['employementSector']);
    setProfile($profileID, 'employementStatus', $_POST['employementStatus']);
    setProfile($profileID, 'employementSince', $_POST['employementSince']);
    setProfile($profileID, 'employeer', $_POST['employeer']);
    setProfile($profileID, 'jobTitle', $_POST['jobTitle']);
    setProfile($profileID, 'employerPhone', $_POST['employerPhone']);
    setProfile($profileID, 'netIncome', $_POST['netIncome']);
    setProfile($profileID, 'extraIncome', $_POST['extraIncome']);
    setProfile($profileID, 'landlordName', $_POST['landlordName']);
    setProfile($profileID, 'landlordPhone', $_POST['landlordPhone']);
    setProfile($profileID, 'expectedNotice', $_POST['expectedNotice']);
};


// Upload the documents
if ($_POST['save'] == 'uploadAttachments' || $_POST['save'] == 'finish') {
    //Set profileID
    $profileID = $_POST['profileID'];

    //If user select a file for ID
    if ($_FILES['ID']['name'] != null) {
        require "features/functions_upload.php";

        //Upload the file
        uploadProfileAttachments($profileID, 'ID of the Applicant', $_FILES['ID'], 'ID', 'profileID');
        uploadProfileAttachments($profileID, 'Landlord Reference Letter', $_FILES['landlordReference'], 'landlordReference', 'landlordReferenceLetter');
        uploadProfileAttachments($profileID, 'Work Reference Letter', $_FILES['workReference'], 'workReference', 'workReferenceLetter');
        uploadProfileAttachments($profileID, 'Payslip', $_FILES['payslip'], 'payslip', 'payslip');
        uploadProfileAttachments($profileID, 'Bank Statements', $_FILES['bankStatements'], 'bankStatements', 'bankStatements');
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

                                <?php //Stop the page if the hash is not valid as one of the hashes from the enquiries table
                                if (getMessage('message_hash', $hash, 'message_sender_name') === null) {
                                    echo '<div class="p-5"><div class="alert alert-danger" role="alert"><strong>Error!</strong> The link you are trying to access is not valid.</div></div>';
                                    die;
                                } ?>

                                <?php if ($_POST['save'] == null) { ?>

                                    <form method="POST">
                                        <div class="container-fluid">
                                            <div class="col">
                                                <div class="row g-0">
                                                    <div class="card-body text-black">
                                                        <div class="text-center">
                                                            <h2 class="mt-0"><i class="mdi mdi-check-all"></i></h2>
                                                            <h4 class="mt-0">Welcome to your Online Application</h4>
                                                            <p class="w-75 mb-2 mx-auto">Thank you for applying for a %Apartment%.<br><br><br>
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

                                <?php } elseif ($_POST['save'] == 'start') { ?>

                                    <form method="POST">
                                        <input type="hidden" name="profileID" value="<?php echo $profileID; ?>">

                                        <div class="container-fluid">
                                            <div class="row d-flex justify-content-center align-items-center h-100">
                                                <div class="col">
                                                    <div class="row g-0">
                                                        <div class="card-body text-black">
                                                            <h4 class="mb-3">Primary Applicant</h4>

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
                                                                    <input type="text" class="form-control" required data-toggle="input-mask" data-mask-format="0000000-AA" maxlength="10" name="ppsNumber" <?php if (getProfile('profileID', $profileID, 'ppsNumber') != null) echo 'value="' . getProfile('profileID', $profileID, 'ppsNumber') . '"';  ?>>
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

                                <?php if ($_POST['save'] == 'reference') { ?>

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
                                                                    <input type="date" class="form-control" name="employementSince" <?php if (getProfile('profileID', $profileID, 'employementSince') != null) echo 'value="' . getProfile('profileID', $profileID, 'employementSince') . '"';  ?>>
                                                                </div>
                                                            </div>
                                                            <div class="row g-2">
                                                                <div class="mb-3 col-md-4">
                                                                    <label class="form-label">Name of Employeer</label>
                                                                    <input type="text" class="form-control" placeholder="Employer Name" name="employeer" <?php if (getProfile('profileID', $profileID, 'employeer') != null) echo 'value="' . getProfile('profileID', $profileID, 'employeer') . '"';  ?>>
                                                                </div>
                                                                <div class="mb-3 col-md-4">
                                                                    <label class="form-label">Job Title</label>
                                                                    <input type="text" class="form-control" placeholder="Job Title" name="jobTitle" <?php if (getProfile('profileID', $profileID, 'jobTitle') != null) echo 'value="' . getProfile('profileID', $profileID, 'jobTitle') . '"';  ?>>
                                                                </div>
                                                                <div class="mb-3 col-md-4">
                                                                    <label class="form-label">Employeer Phone Number</label>
                                                                    <input type="text" class="form-control" data-toggle="input-mask" data-mask-format="+000-00-00000000" maxlength="17" name="employerPhone" <?php if (getProfile('profileID', $profileID, 'employerPhone') != null) echo 'value="' . getProfile('profileID', $profileID, 'employerPhone') . '"';  ?>>
                                                                    <span class="font-13 text-muted">e.g "+353-xxx-xxxxxxx"</span>
                                                                </div>

                                                            </div>
                                                            <div class="row g-2">
                                                                <div class="mb-3 col-md-4">
                                                                    <label class="form-label">Net Income</label>
                                                                    <input type="text" class="form-control" data-toggle="input-mask" data-mask-format="000.000.000.000.000,00" data-reverse="true" maxlength="22" name="netIncome" <?php if (getProfile('profileID', $profileID, 'netIncome') != null) echo 'value="' . getProfile('profileID', $profileID, 'netIncome') . '"';  ?>>
                                                                    <span class="font-13 text-muted">e.g "Your net income after tax"</span>
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
                                                                    <input type="date" class="form-control" name="expectedNotice" <?php if (getProfile('profileID', $profileID, 'expectedNotice') != null) echo 'value="' . getProfile('profileID', $profileID, 'expectedNotice') . '"';  ?>>
                                                                </div>
                                                            </div>

                                                            <ul class="list-inline wizard mb-0">
                                                                <button type="submit" class="btn btn-primary float-end" name="save" value="documents">Next</button>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </form>

                                <?php }; ?>

                                <?php if ($_POST['save'] == 'documents' || $_POST['save'] == 'uploadAttachments' || $_POST['save'] == 'removeProfileAttachments') { ?>

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
                                                                <button type="submit" class="btn btn-primary float-start" name="save" value="uploadAttachments">Upload</button>
                                                            </ul>
                                                            <ul class="list-inline wizard mb-0">
                                                                <button type="submit" class="btn btn-primary float-end" name="save" value="finish">Next</button>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </form>

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