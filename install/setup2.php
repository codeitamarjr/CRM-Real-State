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
                                <form method="POST" action="setup3.php">
                                    <div class="p-5">
                                        <div class="text-center">
                                            <h4 class="text-dark mb-4">Installation Page</h4>
                                        </div>
                                        <p style="text-align: center;"><strong>MySQL Settings Page</strong></p>
                                        <p>Please provide the MySQL settings:</p>
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h4 class="panel-title">MySQL Settings</h4>
                                            </div>
                                            <div class="panel-body">
                                                <div class="form-group">
                                                    <label class="col control-label">Server</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" class="form-control" name="server">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col control-label">Username</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" class="form-control" name="username">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col control-label">Password</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" class="form-control" name="password">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-center">
                                        <input type="submit" value="Proceed" class="btn btn-primary my-4">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

</html>