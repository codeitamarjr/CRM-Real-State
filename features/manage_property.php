<?php
require "features/functions_unit.php";

if (isset($_POST['submit'])) {
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
    if (getPropertyData($_SESSION["property_code"], 'property_name') != $_POST['propertyName']) {
        setPropertyDataSafe($_SESSION["property_code"], 'property_name', $_POST['propertyName'], 'ss');
    }
    if (getPropertyData($_SESSION["property_code"], 'property_type') != $_POST['propertyType']) {
        setPropertyDataSafe($_SESSION["property_code"], 'property_type', $_POST['propertyType'], 'ss');
    }
    if (getPropertyData($_SESSION["property_code"], 'property_address') != $_POST['propertyAddress']) {
        setPropertyDataSafe($_SESSION["property_code"], 'property_address', $_POST['propertyAddress'], 'ss');
    }
    if (getPropertyData($_SESSION["property_code"], 'property_bank_deposit_BANK') != $_POST['depositBank']) {
        setPropertyDataSafe($_SESSION["property_code"], 'property_bank_deposit_BANK', $_POST['depositBank'], 'ss');
    }
    if (getPropertyData($_SESSION["property_code"], 'property_bank_deposit_IBAN') != $_POST['depositIBAN']) {
        setPropertyDataSafe($_SESSION["property_code"], 'property_bank_deposit_IBAN', $_POST['depositIBAN'], 'ss');
    }
    if (getPropertyData($_SESSION["property_code"], 'property_bank_rent_BANK') != $_POST['rentBank']) {
        setPropertyDataSafe($_SESSION["property_code"], 'property_bank_rent_BANK', $_POST['rentBank'], 'ss');
    }
    if (getPropertyData($_SESSION["property_code"], 'property_bank_rent_IBAN') != $_POST['property_bank_rent_IBAN']) {
        setPropertyDataSafe($_SESSION["property_code"], 'property_bank_rent_IBAN', $_POST['property_bank_rent_IBAN'], 'ss');
    }
    if (getPropertyData($_SESSION["property_code"], 'getting_email_time') != $_POST['getting_email_time']) {
        setPropertyDataSafe($_SESSION["property_code"], 'getting_email_time', $_POST['getting_email_time'], 'ss');
    }
    if (getPropertyData($_SESSION["property_code"], 'property_email_hostname') != $_POST['property_email_hostname']) {
        setPropertyDataSafe($_SESSION["property_code"], 'property_email_hostname', $_POST['property_email_hostname'], 'ss');
    }
    if (getPropertyData($_SESSION["property_code"], 'property_email_port') != $_POST['property_email_port']) {
        setPropertyDataSafe($_SESSION["property_code"], 'property_email_port', $_POST['property_email_port'], 'ss');
    }
    if (getPropertyData($_SESSION["property_code"], 'property_email_username') != $_POST['property_email_username']) {
        setPropertyDataSafe($_SESSION["property_code"], 'property_email_username', $_POST['property_email_username'], 'ss');
    }
    if (getPropertyData($_SESSION["property_code"], 'property_email_password') != $_POST['property_email_password']) {
        setPropertyDataSafe($_SESSION["property_code"], 'property_email_password', $_POST['property_email_password'], 'ss');
    }
    if (getPropertyData($_SESSION["property_code"], 'property_calendly') != $_POST['calendly']) {
        setPropertyDataSafe($_SESSION["property_code"], 'property_calendly', $_POST['calendly'], 'ss');
    }
    
    echo '
        </center></div>
    </div>
</div>
</div>';
}

if (isset($_POST['officeUpdate'])) {
    if (getPropertyData($_SESSION["property_code"], 'office_name') != $_POST['officeName']) {
        echo setPropertyDataSafe($_SESSION["property_code"], 'office_name', $_POST['officeName'], 'ss');
    }
    if (getPropertyData($_SESSION["property_code"], 'office_email') != $_POST['officeEmail']) {
        echo setPropertyDataSafe($_SESSION["property_code"], 'office_email', $_POST['officeEmail'], 'ss');
    }
    if (getPropertyData($_SESSION["property_code"], 'office_phone') != $_POST['officePhone']) {
        echo setPropertyDataSafe($_SESSION["property_code"], 'office_phone', $_POST['officePhone'], 'ss');
    }
    if (getPropertyData($_SESSION["property_code"], 'office_address') != $_POST['officeAddress']) {
        echo setPropertyDataSafe($_SESSION["property_code"], 'office_address', $_POST['officeAddress'], 'ss');
    }
};

//Upload Property Logo
if ($_FILES['picture']['name'] != null) {
    require "features/functions_upload.php";
    if (getPropertyData($_SESSION["property_code"], 'property_logo') != null) {
        unlink('features/uploads/' . getPropertyData($_SESSION["property_code"], 'property_logo') . '');
        $fileIDName = uploadFile($_FILES['picture'], getPropertyData($_SESSION["property_code"], 'property_code'), 'propertyLogo');
        setPropertyDataSafe($_SESSION["property_code"], 'property_logo', $fileIDName, 'ss');
        header("Refresh:0");
    } else {
        $fileIDName = uploadFile($_FILES['picture'], getPropertyData($_SESSION["property_code"], 'property_code'), 'propertyLogo');
        setPropertyDataSafe($_SESSION["property_code"], 'property_logo', $fileIDName, 'ss');
        header("Refresh:0");
    }
}
?>
<div class="container-fluid">
    <div class="d-sm-flex justify-content-between align-items-center mb-4">
        <h3 class="text-dark mb-0">Property Editor</h3>
    </div>




    <div class="row">
        <div class="col-xl-4">
            <div class="card mb-4 mb-xl-0">
                <div class="card-header">Property Logo</div>
                <div class="card-body text-center">
                    <div class="text-center" style="padding: 11px;"><img class="rounded-circle mb-3 mt-4" src="features/uploads/<?php echo htmlentities(getPropertyData($_SESSION["property_code"], 'property_logo')); ?>" width="160" height="160">
                        <br>
                        <label class="form-label" style="margin: 0;">Property Logo</label>
                        <br>
                        <form method="POST" enctype="multipart/form-data">
                            <input class="form-control" type="file" name="picture">
                            <div class="mb-3"></div>
                            <button class="btn btn-primary btn-sm" type="submit" name="upload">Upload</button>
                        </form>
                    </div>

                </div>
            </div>
        </div>
        <div class="col-xl-8">
            <div class="card mb-4">
                <div class="card-header">Property Office Details</div>
                <div class="card-body">
                    <form method="POST">
                        <div class="row gx-3 mb-3">
                            <div class="col-md-5">
                                <label class="small mb-1">Office Name</label>
                                <input class="form-control" type="text" name="officeName" value="<?php echo getPropertyData($_SESSION["property_code"], 'office_name') ?>">
                            </div>
                            <div class="col-md-4">
                                <label class="small mb-1">Office e-mail</label>
                                <input class="form-control" type="email" name="officeEmail" value="<?php echo getPropertyData($_SESSION["property_code"], 'office_email') ?>">
                            </div>
                            <div class="col-md-3">
                                <label class="small mb-1">Office Phone Number</label>
                                <input class="form-control" name="officePhone" type="tel" value="<?php echo getPropertyData($_SESSION["property_code"], 'office_phone') ?>">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="small mb-1">Office Full Address</label>
                            <input class="form-control" name="officeAddress" type="text" value="<?php echo getPropertyData($_SESSION["property_code"], 'office_address') ?>">
                        </div>
                        <button class="btn btn-primary" type="submit" name="officeUpdate">Save changes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <br>


    <div class="col-lg">
        <div class="row">
            <div class="col-xl-12">
                <div class="card mb-3">
                    <div class="card-header py-3">
                        <p class="text-primary m-0">Edit Property</p>
                    </div>
                    <div class="card-body">
                        <form method="POST">
                            <input type="hidden" name="access" value="manage_property">
                            <div class="row">
                                <div class="col">
                                    <div class="mb-3"><label class="form-label">Property Name</label>
                                        <input class="form-control" type="text" value="<?php echo getPropertyData($_SESSION["property_code"], 'property_name'); ?>" name="propertyName">
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="mb-3"><label class="form-label">Property Type</label>
                                        <div class="form-group">
                                            <select class="form-control" name="propertyType">
                                                <option value="house" <?php if (getPropertyData($_SESSION["property_code"], 'property_type') === "house") {
                                                                            echo 'selected';
                                                                        } ?>>House</option>
                                                <option value="apartment" <?php if (getPropertyData($_SESSION["property_code"], 'property_type') === "apartment") {
                                                                                echo 'selected';
                                                                            } ?>>Apartment</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="mb-3"><label class="form-label">Units</label>
                                        <input class="form-control" value="<?php echo totalUnits($_SESSION["property_code"], '');    ?>" name="units" disabled>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="mb-3"><label class="form-label">Property Full Address</label>
                                        <input class="form-control" type="text" value="<?php echo getPropertyData($_SESSION["property_code"], 'property_address'); ?>" name="propertyAddress">
                                    </div>
                                </div>
                            </div>

                            <div class="card-header py-3">
                                <p class="text-primary m-0">Bank Details</p>
                            </div>
                            <p>Bank Details for the Deposit Account
                            </p>
                            <div class="row">
                                <div class="col">
                                    <div class="mb-3"><label class="form-label">Deposit Bank</label>
                                        <input class="form-control" type="text" value="<?php echo getPropertyData($_SESSION["property_code"], 'property_bank_deposit_BANK'); ?>" name="depositBank">
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="mb-3"><label class="form-label">Deposit IBAN</label>
                                        <input class="form-control" type="text" value="<?php echo getPropertyData($_SESSION["property_code"], 'property_bank_deposit_IBAN'); ?>" name="depositIBAN">
                                    </div>
                                </div>
                            </div>
                            <p>Bank Details for the Rent Account
                            </p>
                            <div class="row">
                                <div class="col">
                                    <div class="mb-3"><label class="form-label">Rent Bank</label>
                                        <input class="form-control" type="text" value="<?php echo getPropertyData($_SESSION["property_code"], 'property_bank_rent_BANK'); ?>" name="rentBank">
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="mb-3"><label class="form-label">Rent IBAN</label>
                                        <input class="form-control" type="text" value="<?php echo getPropertyData($_SESSION["property_code"], 'property_bank_rent_IBAN'); ?>" name="property_bank_rent_IBAN">
                                    </div>
                                </div>
                            </div>

                            <!-- Start Getting Email Section -->
                            <div class="card-header py-3">
                                <p class="text-primary m-0">Emails Settings</p>
                            </div>
                            <p>This settings will change the Getting E-mails Function, this feature will check the property mailbox for new e-mails, if you recude the time the connection to the mailbox will increase and slow the server-response in general.</p>
                            <div class="row align-items-center">
                                <div class="col">
                                    Getting E-mail Time
                                    <p class="text-muted mb-0">Select the interval in minutes to getting new e-mails from the property e-mail mailbox, this function will works as soon as an user is using the CRM System.</p>
                                </div>
                                <div class="col-auto">
                                    <div class="custom-control custom-switch">
                                        <select class="m_form-control" name="getting_email_time">
                                            <option selected value="<?php echo getPropertyData($_SESSION["property_code"], 'getting_email_time'); ?>"><?php echo getPropertyData($_SESSION["property_code"], 'getting_email_time'); ?></option>
                                            <option value="3">3</option>
                                            <option value="5">5</option>
                                            <option value="10">10</option>
                                            <option value="15">15</option>
                                            <option value="20">20</option>
                                            <option value="30">30</option>
                                            <option value="40">40</option>
                                            <option value="50">50</option>
                                            <option value="60">60</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <hr class="my-4" />
                            <div class="row">
                                <div class="col">
                                    <div class="mb-3"><label class="form-label">Host Name</label>
                                        <input class="form-control" type="text" value="<?php echo getPropertyData($_SESSION["property_code"], 'property_email_hostname'); ?>" name="property_email_hostname">
                                    </div>
                                </div>
                                <div class="col">
                                    <label class="form-label">Email Port</label>
                                    <input class="form-control" type="text" value="<?php echo getPropertyData($_SESSION["property_code"], 'property_email_port'); ?>" name="property_email_port">
                                </div>
                                <div class="col">
                                    <div class="mb-3"><label class="form-label">User/Email</label>
                                        <input class="form-control" type="text" value="<?php echo getPropertyData($_SESSION["property_code"], 'property_email_username'); ?>" name="property_email_username">
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="mb-3"><label class="form-label">Password</label>
                                        <input class="form-control" type="password" value="<?php echo getPropertyData($_SESSION["property_code"], 'property_email_password'); ?>" name="property_email_password">
                                    </div>
                                </div>
                            </div>

                            <!-- End Getting Email Section -->

                            <!-- Start Calendly Section -->
                            <div class="card-header py-3">
                                <p class="text-primary m-0">Calendly</p>
                            </div>
                            <p>Set the Calendly option to send the link for the applicants.</p>
                            <div class="list-group mb-5">
                                <div class="list-group-item">
                                    <div class="row align-items-center">
                                        <div class="col">
                                            <strong class="mb-0">Calendly link</strong>
                                            <p class="text-muted mb-0">Set the link for the Calendly:</p>
                                        </div>
                                    </div>
                                    <div class="row align-items-center">
                                        <div class="col">
                                            <div class="input-group mb-3">
                                                <span class="input-group-text" id="basic-addon3">https://calendly.com/</span>
                                                <input type="text" class="form-control" aria-describedby="basic-addon3" name=calendly value="<?php echo getPropertyData($_SESSION["property_code"], 'property_calendly'); ?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- End Calendly Section -->

                            <div class="mb-3">
                                <button class="btn btn-primary btn-sm" type="submit" name="submit">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>