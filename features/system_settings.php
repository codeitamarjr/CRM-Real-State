<?php
require "features/functions_automail.php";
require "features/functions_property.php";


$property_code = $_SESSION["property_code"];

//Set the checked box from the DB
if (getPropertyData($property_code, 'automail_new') == 1) {
    $automailNew = 'checked=""';
}
if (getPropertyData($property_code, 'automail_approved') == 1) {
    $automailApproved = 'checked=""';
}
if (getPropertyData($property_code, 'automail_denied') == 1) {
    $automailDenied = 'checked=""';
}
//Loading time and calendly from the DB
$getting_email_time = getPropertyData($property_code, 'getting_email_time');
$getting_calendly = getPropertyData($property_code, 'property_calendly');

//Check if the users clicked on any option by checking the hidden form if get by POST
if (isset($_POST['save'])) {
    //If so check the status of each checkbox
    if (isset($_POST['automailNew'])) {
        setPropertyData($property_code, 'automail_new', 1);
        $automailNew = 'checked=""';
    }
    if (!isset($_POST['automailNew'])) {
        setPropertyData($property_code, 'automail_new', 0);
        $automailNew = '';
    }
    if ($_POST['automailApproved']) {
        $automailApproved = 'checked=""';
        setPropertyData($property_code, 'automail_approved', 1);
    }
    if (!isset($_POST['automailApproved'])) {
        $automailApproved = '';
        setPropertyData($property_code, 'automail_approved', 0);
    }
    if (isset($_POST['automailDenied'])) {
        $automailDenied = 'checked=""';
        setPropertyData($property_code, 'automail_denied', 1);
    }
    if (!isset($_POST['automailDenied'])) {
        $automailDenied = '';
        setPropertyData($property_code, 'automail_denied', 0);
    }
    if (isset($_POST['gettin_email_time'])) {
        $getting_email_time = $_POST['gettin_email_time'];
        setPropertyData($property_code, 'getting_email_time', $getting_email_time);
    }
    if (isset($_POST['calendly'])) {
        if ($_POST['calendly'] != getPropertyData($property_code, 'property_calendly')) {
            setPropertyData($property_code, 'property_calendly', $_POST['calendly']);
        }
    }
    if (isset($_POST['PropertyHostName'])) {
        if ($_POST['PropertyHostName'] != getPropertyData($property_code, 'property_email_hostname')) {
            setPropertyData($property_code, 'property_email_hostname', $_POST['PropertyHostName']);
        }
    }
    if (isset($_POST['PropertyEmail'])) {
        if ($_POST['PropertyEmail'] != getPropertyData($property_code, 'property_email_username')) {
            setPropertyData($property_code, 'property_email_username', $_POST['PropertyEmail']);
        }
    }
    if (isset($_POST['PropertyEmailPassword'])) {
        if ($_POST['PropertyEmailPassword'] != getPropertyData($property_code, 'property_email_password')) {
            setPropertyData($property_code, 'property_email_password', $_POST['PropertyEmailPassword']);
        }
    }
}

?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-12 col-lg-10 col-xl-8 mx-auto">
            <h2 class="h3 mb-4 page-title">Settings</h2>
            <form name="settings" method="POST">
                <input type="hidden" name="save" value="save">
                <div class="my-4">
                    <div class="alert alert-warning" role="alert">
                        <p>Do not change any settings withouth contacting your IT Departament or checking the documentation / developer.</p>
                    </div>
                    <hr class="my-4" />
                    <!-- Start of Section -->
                    <strong class="mb-0">Automail</strong>
                    <p>This settings will change the Autmail function, this feature send automatic e-mails based on the user actions.</p>
                    <div class="list-group mb-5 shadow">
                        <div class="list-group-item">
                            <div class="row align-items-center">
                                <div class="col">
                                    <strong class="mb-0">Automail for New Enquiries</strong>
                                    <p class="text-muted mb-0">Send an automatic email for each new enquiries received on the property email.</p>
                                </div>
                                <div class="col-auto">
                                    <div class="custom-control custom-switch">
                                        <input name="automailNew" type="checkbox" class="custom-control-input" <?php echo $automailNew ?> />

                                        <span class="custom-control-label"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="list-group-item">
                            <div class="row align-items-center">
                                <div class="col">
                                    <strong class="mb-0">Automail for Approved Enquiries</strong>
                                    <p class="text-muted mb-0">Send an automatic email for each approved enquiries.</p>
                                </div>
                                <div class="col-auto">
                                    <div class="custom-control custom-switch">
                                        <input name="automailApproved" type="checkbox" class="custom-control-input" <?php echo $automailApproved ?> />
                                        <span class="custom-control-label"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="list-group-item">
                            <div class="row align-items-center">
                                <div class="col">
                                    <strong class="mb-0">Automail for Denied Enquiries</strong>
                                    <p class="text-muted mb-0">Send an automatic email for each denied enquiries.</p>
                                </div>
                                <div class="col-auto">
                                    <div class="custom-control custom-switch">
                                        <input name="automailDenied" type="checkbox" class="custom-control-input" <?php echo $automailDenied ?> />
                                        <span class="custom-control-label"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End of Section -->
                    <hr class="my-4" />
                    <!-- Start Getting Email Section -->
                    <strong class="mb-0">Getting E-mails</strong>
                    <p>This settings will change the Getting E-mails Function, this feature will check the property mailbox for new e-mails, if you recude the time the connection to the mailbox will increase and slow the server-response in general.</p>
                    <div class="list-group mb-5 shadow">
                        <div class="list-group-item">
                            <div class="row align-items-center">
                                <div class="col">
                                    <strong class="mb-0">Getting E-mail Time</strong>
                                    <p class="text-muted mb-0">Select the interval in minutes to getting new e-mails from the property e-mail mailbox, this function will works as soon as an user is using the CRM System.</p>
                                </div>
                                <div class="col-auto">
                                    <div class="custom-control custom-switch">
                                        <select class="m_form-control" name="gettin_email_time">
                                            <option selected="" disabled="" value=""><?php echo $getting_email_time; ?></option>
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
                                    <div class="mb-3"><label class="form-label"><strong>Property Host Name</strong></label>
                                        <input class="form-control" type="text" value="<?php echo getPropertyData($property_code, 'property_email_hostname');
                                                                                        ?>" name="PropertyHostName">
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="mb-3"><label class="form-label"><strong>Property Email</strong></label>
                                        <input class="form-control" type="text" value="<?php echo getPropertyData($property_code, 'property_email_username');
                                                                                        ?>" name="PropertyEmail">
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="mb-3"><label class="form-label"><strong>Property Email Password</strong></label>
                                        <input class="form-control" type="password" value="<?php echo getPropertyData($property_code, 'property_email_password');
                                                                                        ?>" name="PropertyEmailPassword">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                            </div>
                        </div>
                    </div>

                    <!-- End Getting Email Section -->
                    <hr class="my-4" />
                    <!-- Start Calendly Section -->
                    <strong class="mb-0">Calendly</strong>
                    <p>Set the Calendly option to send the link for the applicants.</p>
                    <div class="list-group mb-5 shadow">
                        <div class="list-group-item">
                            <div class="row align-items-center">
                                <div class="col">
                                    <strong class="mb-0">Calendly link</strong>
                                    <p class="text-muted mb-0">Set the link for the Calendly:</p>
                                </div>
                            </div>
                            <div class="row align-items-center">
                                <div class="col">
                                    <input class="form-control" type="text" name=calendly value="<?php echo getPropertyData($property_code, 'property_calendly'); ?>">
                                </div>
                            </div>

                        </div>
                    </div>
                    <!-- End Calendly Section -->





                </div>
            </form>
        </div>
    </div>

</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    $('input[type="checkbox"]').on('click', function(event) {
        var flag = $('input').length > 2 ? true : false;
        if (flag) $('form').submit();
    });

    $("form").on('change', function() {
        $("form").trigger('submit');
    });
</script>