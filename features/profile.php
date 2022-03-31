<?php
//session_start();
if (isset($_GET['pic_address'])) {
    userSetData($_SESSION["username"],'agent_pic',$_GET['pic_address']);
    echo '<h1><span style="color: #339966;"><center>Your picture was updated with success!</center></span></h1>';
} if (isset($_GET['name'])) {
    userSetData($_SESSION["username"],'agent_name',$_GET['name']);
    echo '<h1><span style="color: #339966;"><center>Your name was updated with success!</center></span></h1>';
} 

?>
<div class="container-fluid">
    <h3 class="text-dark mb-4">Profile</h3>
    <div class="row mb-3">
        <div class="col-lg-4 col-xl-4">
            <div class="card mb-3">
                <div class="card-body text-center shadow" style="padding: 11px;"><img class="rounded-circle mb-3 mt-4" src="<?php echo htmlentities(userGetData($_SESSION["username"],'agent_pic')); ?>" width="160" height="160">
                    <br>
                    <label class="form-label" style="margin: 0;">Web address of your picture:</label>
                    <br>
                    <form method="GET">
                        <input type="hidden" name="access" value="profile">
                        <input type="text" name="pic_address" placeholder="<?php echo htmlentities(userGetData($_SESSION["username"],'agent_pic')); ?>">
                        <br>
                        <div class="mb-3"></div>
                        <button class="btn btn-primary btn-sm" type="submit">Update Picute</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-lg-8">
            <div class="row">
                <div class="col-xl-12">
                    <div class="card shadow mb-3">
                        <div class="card-header py-3">
                            <p class="text-primary m-0 fw-bold">Personal user data</p>
                        </div>
                        <div class="card-body">
                            <form method="GET">
                            <input type="hidden" name="access" value="profile">
                                <div class="row">
                                    <div class="col">
                                        <div class="mb-3"><label class="form-label" for="first_name"><strong>Full
                                                    Name</strong></label>
                                            <input class="form-control" type="text" placeholder="<?php echo userGetData($_SESSION["username"],'agent_name'); ?>" name="name">
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <button class="btn btn-primary btn-sm" type="submit">Update Details</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>