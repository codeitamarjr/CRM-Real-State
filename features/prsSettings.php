<?php
include "functions_prs.php";
if (isset($_GET['submit'])) {
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
    if (isset($_GET['namePRS'])) {
        setPRSData($_SESSION["agent_prs_code"], 'prs_name', $_GET['namePRS']);
    }
    if (isset($_GET['emailPRS'])) {
        setPRSData($_SESSION["agent_prs_code"], 'prs_email', $_GET['emailPRS']);
    }
    if (isset($_GET['addressPRS'])) {
        setPRSData($_SESSION["agent_prs_code"], 'prs_full_address', $_GET['addressPRS']);
    }
    if (isset($_GET['phonePRS'])) {
        setPRSData($_SESSION["agent_prs_code"], 'prs_phone', $_GET['phonePRS']);
    }
    echo '
                </center></div>
            </div>
        </div>
    </div>';
}

?>


<div class="container">
    <div class="col-lg">
        <div class="row">
            <div class="col-xl-12">
                <div class="card shadow mb-3">
                    <div class="card-header py-3">
                        <p class="text-primary m-0 fw-bold">Estate Agency Info</p>
                    </div>
                    <div class="card-body">
                        <form method="GET">
                            <input type="hidden" name="access" value="<?php echo pathinfo(__FILE__, PATHINFO_FILENAME); ?>">
                            <div class="row">
                                <div class="col">
                                    <div class="mb-3"><label class="form-label"><strong>PRS Name</strong></label>
                                        <input class="form-control" type="text" value="<?php echo getPRSData($_SESSION["agent_prs_code"], 'prs_name'); ?>" name="namePRS">
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="mb-3"><label class="form-label"><strong>PRS Email</strong></label>
                                        <input class="form-control" type="text" value="<?php echo getPRSData($_SESSION["agent_prs_code"], 'prs_email'); ?>" name="emailPRS">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="mb-3"><label class="form-label"><strong>PRS Address</strong></label>
                                        <input class="form-control" type="text" value="<?php echo getPRSData($_SESSION["agent_prs_code"], 'prs_full_address'); ?>" name="addressPRS">
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="mb-3"><label class="form-label"><strong>PRS Phone</strong></label>
                                        <input class="form-control" type="text" value="<?php echo getPRSData($_SESSION["agent_prs_code"], 'prs_phone'); ?>" name="phonePRS">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="mb-3">
                                    <button class="btn btn-primary btn-sm" type="submit" name="submit">Update Details</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>