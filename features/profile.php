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
    if (isset($_GET['name']) && $_GET['name'] != userGetData($_SESSION["username"], 'agent_name')) {
        userSetData($_SESSION["username"], 'agent_name', $_GET['name']);
        echo '<h1><span style="color: #339966;"><center>Your name was updated with success!</center></span></h1>';
    }
    echo '
                </center></div>
            </div>
        </div>
    </div>';
}

if ($_FILES['picture']['name'] != null) {
    require "features/functions_upload.php";
    if (userGetData($_SESSION["username"],'agent_pic') != null) {
        unlink('features/uploads/' . userGetData($_SESSION["username"],'agent_pic') . '');
        $fileIDName = uploadFile($_FILES['picture'], userGetData($_SESSION["username"],'agent_id'), 'agentPic');
        userSetData($_SESSION["username"], 'agent_pic', $fileIDName);
        header("Refresh:0");
    } else {
        $fileIDName = uploadFile($_FILES['picture'], userGetData($_SESSION["username"],'agent_id'), 'agentPic');
        userSetData($_SESSION["username"], 'agent_pic', $fileIDName);
        header("Refresh:0");
    }
}

?>

<div class="container">
    <h3 class="text-dark mb-4"></h3>
    <div class="row mb-3">
        <div class="col-lg-4 col-xl-4">
            <div class="card mb-3">
                <div class="card-body text-center shadow" style="padding: 11px;"><img class="rounded-circle mb-3 mt-4" src="features/uploads/<?php echo htmlentities(userGetData($_SESSION["username"], 'agent_pic')); ?>" width="160" height="160">
                    <br>
                    <label class="form-label" style="margin: 0;">Your profile picture</label>
                    <br>
                    <form method="POST" enctype="multipart/form-data">
                        <input class="form-control" type="file" name="picture">
                        <div class="mb-3"></div>
                        <button class="btn btn-primary btn-sm" type="submit" name="upload">Upload</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-lg-8">
            <div class="row">
                <div class="col-xl-12">
                    <div class="card shadow mb-3">
                        <div class="card-header py-3">
                            <p class="text-primary m-0 fw-bold">Agent Data</p>
                        </div>
                        <div class="card-body">
                            <form method="GET">
                                <input type="hidden" name="access" value="profile">
                                <div class="row">
                                    <div class="col">
                                        <div class="mb-3"><label class="form-label" for="first_name"><strong>Full
                                                    Name</strong></label>
                                            <input class="form-control" type="text" value="<?php echo userGetData($_SESSION["username"], 'agent_name'); ?>" name="name">
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <button class="btn btn-primary btn-sm" type="submit" name="submit">Update Details</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    
</div>