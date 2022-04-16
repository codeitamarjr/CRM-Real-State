<?php
session_start();

/* Attempt to connect to MySQL database */
$link = mysqli_connect($_POST['server'], $_POST['username'], $_POST['password'], $_POST['dbname']);

// Check connection
if ($link === false) {
    die("ERROR: Could not connect. " . mysqli_connect_error());
} else echo '<center><div class="alert alert-success" role="alert">
The conection was successful!
</div></center>';

// Check connection 2
if ($link->connect_error) {
    die("Connection failed: " . $link->connect_error);
}

function tableExists($table, $link)
{
    $sql = "SELECT * FROM $table";
    $test = mysqli_query($link, $sql);
    if ($test !== FALSE) {
        return true;
    } else {
        return false;
    }
}

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
                                <form method="POST" name="createDBTables">
                                    <div class="p-5">
                                        <div class="text-center">
                                            <h4 class="text-dark mb-4">Installation Page</h4>
                                        </div>


                                        <p style="text-align: center;"><strong>Creating the Database</strong></p>
                                        <p>This step will create the required tables at the database for the CRM work.</p>


                                        <div class="portlet light bordered">
                                            <div class="portlet-title tabbable-line">
                                                <div class="caption caption-md">
                                                    <i class="icon-globe theme-font hide"></i>
                                                    <span class="caption-subject font-blue-madison bold uppercase">Required Tables</span>
                                                </div>
                                            </div>
                                            <div class="portlet-body">

                                                <table class="table">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Table</th>
                                                            <th>Status</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $i = 1;
                                                        foreach (glob("*.sql") as $file) {
                                                            $file_info = pathinfo(getcwd() . './' . $file);
                                                            //echo $file_info['dirname'], "<br>";
                                                            //echo $file_info['basename'], "<br>";
                                                            echo '<tr ';
                                                            if (tableExists($file_info['filename'], $link))
                                                                echo 'style="background-color: #dff0d8"';
                                                            echo '><th>' . $i . '</th>';
                                                            echo '<td>' . $file_info['filename'] . '</td>';
                                                            echo '<td>';
                                                            if (tableExists($file_info['filename'], $link))
                                                                echo 'This table already exists';
                                                            else {
                                                                //Load the sql file from each table
                                                                $query = (file_get_contents($file));

                                                                //Execute the sql file
                                                                $result = mysqli_query($link, $query);
                                                                if ($result) {
                                                                    echo 'Table created successfully';
                                                                } else {
                                                                    echo '<div class="alert alert-danger" role="alert">Error: ' . mysqli_error($link) . '</div>';
                                                                }
                                                            }
                                                            echo '</td>';
                                                            echo '</tr>';
                                                            $i++;
                                                        }
                                                        ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-center">
                                        <input type="submit" value="Proceed and Create Tables" class="btn btn-primary my-4">
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
<style>
    .alert {
        width: fit-content;
    }
</style>