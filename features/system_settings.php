<?php
require "features/functions_automail.php";


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

                </div>
            </form>
        </div>
    </div>

</div>

<script>
    $('input[type="checkbox"]').on('click', function(event) {
        var flag = $('input').length > 2 ? true : false;
        if (flag) $('form').submit();
    });

    $("form").on('change', function() {
        $("form").trigger('submit');
    });
</script>