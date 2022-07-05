<?php
//Functions profile
// test if the page is required inside tenantsDetail.php
if(!isset($tenantsCod)){
require "features/functions_profile.php";
require "features/functions_tenant.php";
};
require "config/config.php";

//Define profile ID
$profileID = $_GET['profileID'];


//Get property code definied at the start of the login SESSION
$property_code = $_SESSION["property_code"];

//Update applicant data
if ($_POST['save'] == 'update') {
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
if ($_POST['save'] == 'uploadAttachments') {
    //Set profileID
    $profileID = $_POST['profileID'];
    //If user select a file for ID
    if ($_FILES['CRM']['name'] != null) {
        require "features/functions_upload.php";
        //Upload the file
        if ($_FILES['CRM'] != null) uploadProfileAttachments($profileID, 'Upload from CRM', $_FILES['CRM'], 'CRM', 'manualUpload');
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

// Change applicant status
if ($_POST['approve'] != null) modal(setProfile($_POST['approve'], 'status', 'Approved'));
if ($_POST['deny'] != null) modal(setProfile($_POST['deny'], 'status', 'Denied'));

function modal($messageModal)
{
    echo "<script>
        $(document).ready(function(){
            $(\"#alertModal\").modal('show');
        });
        </script>";
    echo '<!-- Modal Alert -->
        <div class="modal" id="alertModal" tabindex="-1" aria-labelledby="alertModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                    <center>
                       ';
    echo $messageModal;
    echo '
                    </center></div>
                </div>
            </div>
        </div>';
}

// Delete the applicant
if ($_POST['delete'] != null) {
    //Delete the profile
    deleteProfile($_POST['delete']);
}

// Change Property of the applicant
if ($_POST['changeApplicationID'] != null) {
    // Change the property of the applicant and shows in the modal
    changeProfileProperty($_POST['changeApplicationID'], $_POST['newPropertyCode']);
}

// Count occupants into each application
$occupantsTotal = 0;

// Set the applicant as a tenant if approved
if ($_POST['setTenant'] != null) {
    modal(newTenant($property_code,$_POST["unitCodeTenant"],$_POST['setTenant']));
    echo $_POST['setTenant'];
    echo $property_code;
    echo $_POST["unitCodeTenant"];
}

?>


<div class="container-fluid">
    <div class="card shadow">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h6 class="text-primary fw-bold m-0">Enquirie Details</h6>
            <div class="dropdown no-arrow">
                <button class="btn btn-link btn-sm dropdown-toggle" aria-expanded="false" data-bs-toggle="dropdown" type="button">
                    <i class="fas fa-ellipsis-v text-gray-400"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-end shadow animated--fade-in">
                    <h6 class="dropdown-header text-center">Change Status</h6>

                    <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#approveModal">&nbsp;Approve</a>
                    <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#denyModal">&nbsp;Deny</a>
                    <!-- Shows the modal to change property just for 'M'ainly applicants -->
                    <?php if (getProfile('profileID', $profileID, 'type') == 'M') { ?>
                        <div class="dropdown-divider"></div>
                        <h6 class="dropdown-header text-center">Change Property</h6>
                        <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#changeProperty">&nbsp;Change Property</a>

                        <!-- If is the main tenant profile and if it's approved show the modal to set as tenant -->
                        <?php if (getProfile('profileID', $profileID, 'status') == 'Approved') { ?>
                            <div class="dropdown-divider"></div>
                            <h6 class="dropdown-header text-center">Set as Tenant</h6>
                            <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#setTenant">&nbsp;Set as Tenant</a>
                    <?php }
                    } ?>
                </div>
            </div>
        </div><br>
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link <?php if (getProfile('profileID', $profileID, 'mainApplicantID') == null) echo 'active'; ?>" aria-current="page" <?php if (getProfile('profileID', $profileID, 'mainApplicantID') != null) echo 'href="?access=applicationsDetail&profileID=' . getProfile('profileID', $profileID, 'mainApplicantID') . '"'; ?>>Primary Applicant</a>
            </li>
            <?php
            $mainProfileID = getProfile('profileID', $profileID, 'mainApplicantID');
            if ($mainProfileID == null) $mainProfileID = $profileID;
            else $isOccupant = true;
            $query = "SELECT * FROM profile WHERE mainApplicantID = '$mainProfileID'";
            $result = mysqli_query($link, $query);
            while ($row = mysqli_fetch_array($result)) {
                $occupantsTotal++;
                echo '<li class="nav-item">
                <a class="nav-link ';
                if (htmlspecialchars($row['profileID']) == $profileID) echo 'active';
                echo '" href="?access=applicationsDetail&profileID=' . htmlspecialchars($row['profileID']) . '" tabindex="-1">Occupant[' . htmlspecialchars($row['firstName']) . ']</a>
            </li>';
            }
            ?>
            <li class="nav-item">
                <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Notes</a>
            </li>
        </ul>
        <div class="card-body">
            <div class="row">
                <div class="row gutters-sm">
                    <div class="col-md-4 mb-0">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex flex-column align-items-center text-center">
                                    <img src="assets/img/avatars/user_blank.png" alt="User Default Profile" class="rounded-circle" width="150">
                                    <div class="mt-3">
                                        <h4><?php echo htmlspecialchars(getProfile('profileID', $profileID, 'firstName'));
                                            ?></h4>
                                        <p class="text-secondary mb-1"><?php echo htmlentities(getProfile('profileID', $profileID, 'jobTitle')); ?></p>
                                        <p class="text-muted font-size-sm"><?php echo htmlentities(getProfile('profileID', $profileID, 'employeer')); ?></p>
                                    </div>
                                </div>
                                <hr>
                                <div class="d-flex flex-column align-items-center text-center">
                                    <div class="mt-3">
                                        <p class="text-secondary mb-1">
                                            <a href="prospect_area.php?propertyCode=<?php echo htmlspecialchars(getProfile('profileID', $profileID, 'propertyCode')); ?>" target="_blank">View Application Area</a>
                                        </p>
                                    </div>
                                </div>
                                <hr>
                                <ul class="list-group">
                                    <form method="POST" enctype="multipart/form-data">
                                        <input type="hidden" name="profileID" value="<?php echo $profileID; ?>">

                                        <div class="row">

                                            <div class="mb-3 col-md-8">
                                                <input type="file" id="CRM" class="form-control" name="CRM[]">
                                            </div>
                                            <div class="mb-3 col-sm-1">
                                                <button type="submit" class="btn btn-primary" name="save" value="uploadAttachments">Upload</button>
                                            </div>

                                        </div>
                                    </form>

                                    <?php
                                    require "config/config.php";
                                    $query = "SELECT * FROM profileAttachments WHERE profileID = '$profileID'";
                                    $result = mysqli_query($link, $query);
                                    while ($row = mysqli_fetch_array($result)) { ?>
                                        <div class="card mb-1 shadow-none border">
                                            <div class="p-2">
                                                <div class="row align-items-center">
                                                    <div class="col-auto">
                                                        <div class="avatar-sm">
                                                            <span class="avatar-title rounded">
                                                                <?php echo htmlspecialchars($row['description']); ?>
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <div class="col ps-0">
                                                        <a href="features/uploads/profileAttachments/<?php echo htmlspecialchars($row['fileName']); ?>" class="text-muted fw-bold" target="_blank"><i class="fa fa-cloud-download"></i></a>
                                                    </div>
                                                    <div class="col-auto">
                                                        <!-- Button -->
                                                        <form method="POST">
                                                            <input type="hidden" name="idprofileAttachments" value="<?php echo htmlspecialchars($row['idprofileAttachments']); ?>">
                                                            <input type="hidden" name="fileNumber" value="<?php echo htmlspecialchars($row['fileNumber']); ?>">
                                                            <input type="hidden" name="category" value="<?php echo htmlspecialchars($row['category']); ?>">
                                                            <input type="hidden" name="profileID" value="<?php echo $profileID; ?>">
                                                            <a class="btn btn-link btn-lg text-muted" data-bs-toggle="modal" data-bs-target="#deleteAttachment<?php echo htmlspecialchars($row['fileNumber']); ?>"><i class="fa fa-trash"></i></a>

                                                            <!-- Modal Delete Document -->
                                                            <div class="modal fade" id="deleteAttachment<?php echo htmlspecialchars($row['fileNumber']); ?>" tabindex="-1" aria-hidden="true">
                                                                <div class="modal-dialog modal-dialog-centered">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title" id="exampleModalLabel">Delet Document</h5>
                                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            Are you sure you want to delete this document?<br>
                                                                            This action cannot be undone!<br>
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <button type="submit" class="btn btn-link btn-lg text-muted" name="save" value="removeProfileAttachments">
                                                                                <i class="fa fa-trash"></i>
                                                                            </button>
                                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel and Close</button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </ul>

                            </div>
                        </div>

                    </div>
                    <div class="col-md-8">
                        <div class="card mb-0">
                            <div class="card-body">
                                <form method="POST">
                                    <div class="card-body text-black">

                                        <h4 class="mb-3">Basic Info</h4>

                                        <div class="row g-2">
                                            <div class="mb-3 col-md-6">
                                                <label class="form-label">First Name</label>
                                                <input type="text" class="form-control" placeholder="First Name" name="firstName" <?php if (getProfile('profileID', $profileID, 'firstName') != null) echo 'value="' . htmlspecialchars(getProfile('profileID', $profileID, 'firstName')) . '"';  ?>>
                                            </div>
                                            <div class="mb-3 col-md-6">
                                                <label class="form-label">Last Name</label>
                                                <input type="text" class="form-control" placeholder="Surname" name="lastName" <?php if (getProfile('profileID', $profileID, 'lastName') != null) echo 'value="' . htmlspecialchars(getProfile('profileID', $profileID, 'lastName')) . '"';  ?>>
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Address</label>
                                            <input type="text" class="form-control" placeholder="1234 Main St" name="address" <?php if (getProfile('profileID', $profileID, 'address') != null) echo 'value="' . htmlspecialchars(getProfile('profileID', $profileID, 'address')) . '"';  ?>>
                                        </div>

                                        <div class="row g-2">
                                            <div class="mb-3 col-md-5">
                                                <label class="form-label">City</label>
                                                <input type="text" class="form-control" name="city" <?php if (getProfile('profileID', $profileID, 'city') != null) echo 'value="' . htmlspecialchars(getProfile('profileID', $profileID, 'city')) . '"';  ?>>
                                            </div>

                                            <div class="mb-3 col-md-3">
                                                <label class="form-label">Postal Code</label>
                                                <input type="text" class="form-control" data-toggle="input-mask" data-mask-format="A00-AAAA" maxlength="7" name="postalCode" <?php if (getProfile('profileID', $profileID, 'postalCode') != null) echo 'value="' . getProfile('profileID', $profileID, 'postalCode') . '"';  ?>>
                                                <span class="font-13 text-muted"><a href="https://finder.eircode.ie/" target="_blank">Find Eircode</a></span>
                                            </div>
                                        </div>

                                        <div class="row g-2">
                                            <div class="mb-3 col-md-4">
                                                <label class="form-label">Date of Birth</label>
                                                <input type="date" class="form-control" name="DOB" <?php if (getProfile('profileID', $profileID, 'DOB') != null) echo 'value="' . getProfile('profileID', $profileID, 'DOB') . '"';  ?>>
                                            </div>
                                            <div class="mb-3 col-md-4">
                                                <label class="form-label">PPS Number</label>
                                                <input type="text" class="form-control" data-toggle="input-mask" data-mask-format="0000000-AA" maxlength="10" name="ppsNumber" <?php if (getProfile('profileID', $profileID, 'ppsNumber') != null) echo 'value="' . getProfile('profileID', $profileID, 'ppsNumber') . '"';  ?>>
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
                                                <input type="date" class="form-control" name="expectedMoveinDate" <?php if (getProfile('profileID', $profileID, 'expectedMoveinDate') != null) echo 'value="' . getProfile('profileID', $profileID, 'expectedMoveinDate') . '"';  ?>>
                                            </div>
                                            <div class="mb-3 col-md-4">
                                                <label class="form-label">Car Parking</label>
                                                <select id="inputState" class="form-select" name="carParking">
                                                    <option disabled>Choose</option>
                                                    <option value="0">No</option>
                                                    <option value="1">Yes 1 Car Space</option>
                                                    <option value="2">Yes 2 Car Space</option>
                                                </select>
                                            </div>
                                            <div class="mb-3 col-md-4">
                                                <label class="form-label">pet</label>
                                                <select id="inputState" class="form-select" name="pet">
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
                                                <input type="text" class="form-control" data-toggle="input-mask" data-mask-format="+000-00-00000000" maxlength="17" name="mobilePhone" <?php if (getProfile('profileID', $profileID, 'mobilePhone') != null) echo 'value="' . getProfile('profileID', $profileID, 'mobilePhone') . '"';  ?>>
                                            </div>
                                            <div class="mb-3 col-md-4">
                                                <label class="form-label">Contact Number</label>
                                                <input type="text" class="form-control" data-toggle="input-mask" data-mask-format="+000-00-00000000" maxlength="17" name="contactNumber" <?php if (getProfile('profileID', $profileID, 'contactNumber') != null) echo 'value="' . getProfile('profileID', $profileID, 'contactNumber') . '"';  ?>>
                                            </div>
                                            <div class="mb-3 col-md-4">
                                                <label class="form-label"> Email</label>
                                                <input type="email" class="form-control" name="email" <?php if (getProfile('profileID', $profileID, 'email') != null) echo 'value="' . htmlspecialchars(getProfile('profileID', $profileID, 'email')) . '"';  ?>>
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


                                        <hr>
                                        <h4 class="mb-3">Work Reference</h4>
                                        <div class="row g-2">
                                            <div class="mb-3 col-md-4">
                                                <label class="form-label">Employement Sector</label>
                                                <select id="inputState" class="form-select" name="employementSector">
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
                                                <select id="inputState" class="form-select" name="employementStatus">
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
                                            </div>

                                        </div>
                                        <div class="row g-2">
                                            <div class="mb-3 col-md-4">
                                                <label class="form-label">Net Income</label>
                                                <input type="text" class="form-control" data-toggle="input-mask" data-mask-format="000.000.000.000.000,00" data-reverse="true" maxlength="22" name="netIncome" <?php if (getProfile('profileID', $profileID, 'netIncome') != null) echo 'value="' . getProfile('profileID', $profileID, 'netIncome') . '"';  ?>>
                                            </div>
                                            <div class="mb-3 col-md-4">
                                                <label class="form-label">Extra Income</label>
                                                <input type="text" class="form-control" data-toggle="input-mask" data-mask-format="000.000.000.000.000,00" data-reverse="true" maxlength="22" name="extraIncome" <?php if (getProfile('profileID', $profileID, 'extraIncome') != null) echo 'value="' . getProfile('profileID', $profileID, 'extraIncome') . '"';  ?>>
                                            </div>
                                            <div class="mb-3 col-md-4">
                                                <label class="form-label">Social Housing Support</label>
                                                <br>
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
                                            </div>
                                        </div>

                                        <hr>
                                        <h4 class="mb-3">Landlord Reference</h4>
                                        <div class="row g-2">
                                            <div class="mb-3 col-md-4">
                                                <label class="form-label">Landlord Name</label>
                                                <input type="text" class="form-control" placeholder="Landlord Name" name="landlordName" <?php if (getProfile('profileID', $profileID, 'landlordName') != null) echo 'value="' . getProfile('profileID', $profileID, 'landlordName') . '"';  ?>>
                                            </div>
                                            <div class="mb-3 col-md-4">
                                                <label class="form-label">Contact Number</label>
                                                <input type="text" class="form-control" data-toggle="input-mask" data-mask-format="+000-00-00000000" maxlength="17" name="landlordPhone" <?php if (getProfile('profileID', $profileID, 'landlordPhone') != null) echo 'value="' . getProfile('profileID', $profileID, 'landlordPhone') . '"';  ?>>
                                            </div>
                                            <div class="mb-3 col-md-4">
                                                <label for="inputState" class="form-label">Expected Notice</label>
                                                <input type="date" class="form-control" name="expectedNotice" <?php if (getProfile('profileID', $profileID, 'expectedNotice') != null) echo 'value="' . getProfile('profileID', $profileID, 'expectedNotice') . '"';  ?>>
                                            </div>
                                        </div>

                                        <ul class="list-inline wizard mb-0">
                                            <?php if ($occupantsTotal == 0 || $isOccupant) { ?>
                                                <a class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteProfile">&nbsp;Delete</a>
                                            <?php } ?>
                                            <button type="submit" class="btn btn-primary float-end" name="save" value="update">Update</button>
                                        </ul>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Change Property -->
<div class="modal fade" id="changeProperty" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form method="POST">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Change the Property of an Application</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure do you want to change the property from <?php echo htmlspecialchars(getProfile('profileID', $profileID, 'firstName')); ?>?<br>
                    This action cannot be undone.<br>
                    Select a property to change to:<br>
                    <select class="form-select" name="newPropertyCode">
                        <optgroup>
                            <option selected><?php echo getPropertyData($_SESSION["property_code"], 'property_name'); ?></option>
                        </optgroup>
                        <optgroup>
                            <option disabled>Manage Another Property</option>
                            <?php
                            //List all the properties from an agent
                            include 'config/config.php';
                            $select = "SELECT * FROM property WHERE property_prs_code = '$agent_prs_code'";
                            $result = mysqli_query($link, $select);
                            while ($row = mysqli_fetch_array($result)) {
                                echo '<option value=' . $row['property_code'] . '>' . $row['property_name'] . '</option>';
                            }
                            ?>
                        </optgroup>
                    </select>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" name="changeApplicationID" value="<?php echo $profileID; ?>">Change</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel and Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Approve -->
<div class="modal fade" id="approveModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Confirm Status to Approve</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Approve the application from <?php echo htmlspecialchars(getProfile('profileID', $profileID, 'firstName')); ?>?
            </div>
            <div class="modal-footer">
                <form method="POST">
                    <button type="submit" class="btn btn-primary" name="approve" value="<?php echo $profileID; ?>">Approve</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel and Close</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Deny -->
<div class="modal fade" id="denyModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Confirm Status to Approve</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Deny the application from <?php echo htmlspecialchars(getProfile('profileID', $profileID, 'firstName')); ?>?
            </div>
            <div class="modal-footer">
                <form method="POST">
                    <button type="submit" class="btn btn-danger" name="deny" value="<?php echo $profileID; ?>">Deny</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel and Close</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Delete -->
<div class="modal fade" id="deleteProfile" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Confirm Status to Delete Profile</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Delete the application of <?php echo htmlspecialchars(getProfile('profileID', $profileID, 'firstName')); ?>?<br>
                This action cannot be undone.
            </div>
            <div class="modal-footer">
                <form method="POST">
                    <button type="submit" class="btn btn-danger" name="delete" value="<?php echo $profileID; ?>">Confirm</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel and Close</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Set as Tenant -->
<div class="modal fade" id="setTenant" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form method="POST">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">New Tenant</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    For which unit this tenant will move in?<br>
                    <select class="form-select" name="unitCodeTenant">
                        <optgroup>
                            <?php
                            //List all the units that is available for the tenant
                            include 'config/config.php';
                            $select = "SELECT * FROM unit WHERE property_code = '$property_code'";
                            $result = mysqli_query($link, $select);
                            while ($row = mysqli_fetch_array($result)) {
                                if (getTenantData($row['idunit'], 'idunit','status') != null) {
                                    echo '<option disabled>' . $row['unit_number'] . '</option>';
                                } else {
                                    echo '<option value=' . $row['idunit'] . '>' . $row['unit_number'] . ' | ' . $row['unit_customCode'] . '</option>';
                                }
                            }
                            ?>
                        </optgroup>
                    </select>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" name="setTenant" value="<?php echo $profileID; ?>">Confirm</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel and Close</button>
                </div>
            </form>
        </div>
    </div>
</div>



<style>
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
        } else {
            document.getElementById("max-height").style.display = "none";
        }
    }
</script>