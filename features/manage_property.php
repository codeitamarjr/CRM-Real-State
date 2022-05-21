<?php

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
    if (getPropertyData($_SESSION["property_code"], 'property_units') != $_POST['units']) {
        setPropertyDataSafe($_SESSION["property_code"], 'property_units', $_POST['units'], 'ss');
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
    
    echo '
        </center></div>
    </div>
</div>
</div>';
}
?>
<div class="container">
    <div class="d-sm-flex justify-content-between align-items-center mb-4">
        <h3 class="text-dark mb-0">Property Editor</h3>
        <?php require "nav_bar_selector_property.php"; ?>
    </div>

    <div class="col-lg">
        <div class="row">
            <div class="col-xl-12">
                <div class="card shadow mb-3">
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
                                        <input class="form-control" type="text" value="<?php echo getPropertyData($_SESSION["property_code"], 'property_units'); ?>" name="units">
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