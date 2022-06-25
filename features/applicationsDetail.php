<?php
//Functions profile
require "features/functions_profile.php";
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
?>


<div class="container-fluid">
    <div class="card shadow">
        <div class="card-header py-3">
            <p class="text-primary m-0 fw-bold">Application Details
            </p>
        </div><br>
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link <?php if(getProfile('profileID', $profileID, 'mainApplicantID') == null) echo 'active'; ?>" aria-current="page" <?php if(getProfile('profileID', $profileID, 'mainApplicantID') != null) echo 'href="?access=applicationsDetail&profileID='.getProfile('profileID', $profileID, 'mainApplicantID').'"'; ?>>Primary Applicant</a>
            </li>
            <?php
            $mainProfileID = getProfile('profileID', $profileID, 'mainApplicantID');
            if($mainProfileID == null)$mainProfileID=$profileID;
            $query = "SELECT * FROM profile WHERE mainApplicantID = '$mainProfileID'";
            $result = mysqli_query($link, $query);
            while ($row = mysqli_fetch_array($result)) {
                echo '<li class="nav-item">
                <a class="nav-link ';
                if(htmlspecialchars($row['profileID']) == $profileID) echo 'active';
                echo '" href="?access=applicationsDetail&profileID='.htmlspecialchars($row['profileID']).'" tabindex="-1">Occupant['.htmlspecialchars($row['firstName']).']</a>
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
                                        <p class="text-secondary mb-1"><?php echo htmlentities(getProfile('profileID', $profileID, 'jobTitle'));
                                                                        ?></p>
                                        <p class="text-muted font-size-sm"><?php echo htmlentities(getProfile('profileID', $profileID, 'employeer'));
                                                                            ?></p>
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
                                <ul class="list-group list-group-flush">
                                    <div class="row g-2">
                                        <div class="mb-3 col-md-9">
                                            <input type="file" id="ID" class="form-control" name="ID[]">
                                        </div>
                                        <div class="mb-3 col-md">
                                            <button type="submit" class="btn btn-primary float-end" name="save" value="upload">Upload</button>
                                        </div>
                                    </div>

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
                                                            <button type="submit" class="btn btn-link btn-lg text-muted" name="save" value="removeProfileAttachments">
                                                                <i class="fa fa-trash"></i>
                                                            </button>
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
                                            </div>

                                        </div>
                                        <div class="row g-2">
                                            <div class="mb-3 col-md-4">
                                                <label class="form-label">Net Income</label>
                                                <input type="text" class="form-control" required data-toggle="input-mask" data-mask-format="000.000.000.000.000,00" data-reverse="true" maxlength="22" name="netIncome" <?php if (getProfile('profileID', $profileID, 'netIncome') != null) echo 'value="' . getProfile('profileID', $profileID, 'netIncome') . '"';  ?>>
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
                                                <div id="<?php if (getProfile('profileID', $profileID, 'HAP') == "Market") echo 'max-height'; ?>">
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
                                                <input type="date" class="form-control" required name="expectedNotice" <?php if (getProfile('profileID', $profileID, 'expectedNotice') != null) echo 'value="' . getProfile('profileID', $profileID, 'expectedNotice') . '"';  ?>>
                                            </div>
                                        </div>

                                        <ul class="list-inline wizard mb-0">
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
            document.getElementById("height").innerHTML = "Niedrigste Höhe in mm";
        } else {
            document.getElementById("max-height").style.display = "none";
            document.getElementById("height").innerHTML = "Höhe";
        }
    }
</script>