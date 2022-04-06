<?php
session_start();


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css?h=093230e10e41709a7a3d6ba7f3b3b116">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <title>CRM Installer</title>
</head>

<body class="bg-gradient-primary">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-9 col-lg-12 col-xl-10">
                <div class="card shadow-lg o-hidden border-0 my-5">
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-flex">
                                <div class="flex-grow-1 bg-login-image" style="background-image: url(../assets/img/spacejoy-unsplash.webp);">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h4 class="text-dark mb-4">Installation Page</h4>
                                    </div>
                                    <p style="text-align: center;"><strong>Welcome to the Instalattion Page</strong></p>
                                    <p>Let's start with the minimum requirements, do not proceed if some of the modeulos below is not installed</p>
                                    <ul>
                                        <li>PHP <?php $module = get_loaded_extensions();
                                        if (in_array('Core', $module)) {
                                            echo '<span class="text-success">Installed</span>';
                                        } else {
                                            echo '<span class="text-danger">Not Installed</span>';
                                        } ?>
                                        </li>
                                        <li>PHP-MySQLi <?php if (in_array('mysqli', $module)) {
                                            echo '<span class="text-success">Installed</span>';
                                        } else {
                                            echo '<span class="text-danger">Not Installed</span>';
                                        } ?>
                                        </li>
                                        <li>IMAP <?php if (in_array('imap', $module)) {
                                            echo '<span class="text-success">Installed</span>';
                                        } else {
                                            echo '<span class="text-danger">Not Installed</span>';
                                        } ?>
                                        </li>
                                        <li>Start Session <?php if (session_status() == PHP_SESSION_ACTIVE) {
                                            echo '<span class="text-success">Working</span>';
                                        } else {
                                            echo '<span class="text-danger">Failled</span>';
                                        } ?>
                                    </div>
                                    <div class="text-center">
                                        <button type="button" class="btn btn-primary my-4" onclick="window.location.href='setup2.php'">Proceed</button>
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