<?php
// Include config file
require "config/config.php";
require "features/functions_profile.php";
//Get property code definied at the start of the login SESSION
$property_code = $_SESSION["property_code"];
$prs_code_enquiry = $_SESSION["agent_prs_code"];

//Insert new enquiry
if ($_POST['insert'] == true) {

    //Define variables
    $message_hash = hash('md5', $_POST['email']);
    $email_adress = $_POST['email'];
    $mail_subject = "Manual Insert";
    $email = $_POST['email'];
    $message_phone_number = $_POST['phone'];
    $first_name =   $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $message_sender_name = "$first_name $last_name";
    $property_code_enquiry = $_POST['property_code_enquiry'];

    if (getMessage('messages_email', $_POST['email'], 'message_date') != 0) {
        echo '<center><div class="alert alert-danger" role="alert">Error: This email is already in the database!</div></center>';
    } else {
        //Insert new enquiry
        echo insertMessage($prs_code_enquiry, $email, $property_code_enquiry);
        echo setMessage(getMessage('messages_email', $email, 'message_id'), 'message_sender_name', $message_sender_name);
        setMessage(getMessage('messages_email', $email, 'message_id'), 'message_phone_number', $message_phone_number);
        setMessage(getMessage('messages_email', $email, 'message_id'), 'message_title', $mail_subject);
        setMessage(getMessage('messages_email', $email, 'message_id'), 'message_body', $_POST['message_text']);
        setMessage(getMessage('messages_email', $email, 'message_id'), 'messages_prs_code', $_SESSION["agent_prs_code"]);
        setMessage(getMessage('messages_email', $email, 'message_id'), 'property_address', getPropertyData($_SESSION["property_code"], 'property_name'));
    }
};


$query = "SELECT * FROM messages WHERE property_code = $property_code OR property_code is null ORDER BY message_date DESC ";
$result = mysqli_query($link, $query);
?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs5/jq-3.6.0/jszip-2.5.0/dt-1.12.1/b-2.2.3/b-html5-2.2.3/b-print-2.2.3/cr-1.5.6/r-2.3.0/sb-1.3.4/sr-1.1.1/datatables.min.css" />
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs5/jq-3.6.0/jszip-2.5.0/dt-1.12.1/b-2.2.3/b-html5-2.2.3/b-print-2.2.3/cr-1.5.6/r-2.3.0/sb-1.3.4/sr-1.1.1/datatables.min.js"></script>



<div class="container-fluid">
    <div class="card shadow">
        <div class="card-header py-3">
            <p class="text-primary m-0 fw-bold">Inbox of Enquiries
                <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#newEnquiry"> + Add New Enquiry</button>
            </p>
        </div>
        <div class="card-body">
                <table id="dataTable" class="table table-striped dt-responsive nowrap w-100" style="width:100%">
                    <thead>
                        <tr>
                            <th>Property</th>
                            <th>Name</th>
                            <th>E-mail</th>
                            <th>App</th>
                            <th>E-mail</th>
                            <th>Date Received</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                        <?php while ($row = mysqli_fetch_array($result)) {
                            $message_id = htmlspecialchars($row['message_id']);

                            echo "<tr ";
                            if ($row['status'] == "Approved") {
                                echo "class='table-success'";
                            }
                            if ($row['status'] == "Denied") {
                                echo "class='table-danger'";
                            }
                            if ($row['status'] == "Invited") {
                                echo "class='table-warning'";
                            }
                            echo " onclick=\"window.open('?access=enquiryDetails&message_id=$message_id','_blank')\" >
    <td>" . htmlspecialchars(getPropertyData($row['property_code'], 'property_name'))  . "</td>
    <td>" . htmlspecialchars($row['message_sender_name']) . "</td>
    <td>" . htmlspecialchars($row['messages_email']) . "</td>
    <td>";  if(getProfile('email',$row['messages_email'],'propertyCode') == $_SESSION["property_code"])echo '<span class="d-inline-block" tabindex="0" data-bs-toggle="tooltip" title="This prospect already submitted his application, click to view.">
    <a href="?access=applicationsDetail&profileID='.getProfile('email',$row['messages_email'],'profileID').'" target="_blank">
    <button type="button" class="btn btn-secondary" control-id="ControlID-4">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-file-earmark-person" viewBox="0 0 16 16">
  <path d="M11 8a3 3 0 1 1-6 0 3 3 0 0 1 6 0z"></path>
  <path d="M14 14V4.5L9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2zM9.5 3A1.5 1.5 0 0 0 11 4.5h2v9.255S12 12 8 12s-5 1.755-5 1.755V2a1 1 0 0 1 1-1h5.5v2z"></path>
</svg>
              </button></a></span>';
                            echo "</td>
    <td>";
    if(($row['emailWelcome']) != null ) echo '<span class="d-inline-block" tabindex="0" data-bs-toggle="tooltip" title="This prospect already received a welcome email, click to view.">
    <button type="button" class="btn btn-outline-success" control-id="ControlID-4">
    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-envelope-check" viewBox="0 0 16 16">
<path d="M2 2a2 2 0 0 0-2 2v8.01A2 2 0 0 0 2 14h5.5a.5.5 0 0 0 0-1H2a1 1 0 0 1-.966-.741l5.64-3.471L8 9.583l7-4.2V8.5a.5.5 0 0 0 1 0V4a2 2 0 0 0-2-2H2Zm3.708 6.208L1 11.105V5.383l4.708 2.825ZM1 4.217V4a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v.217l-7 4.2-7-4.2Z"></path>
<path d="M16 12.5a3.5 3.5 0 1 1-7 0 3.5 3.5 0 0 1 7 0Zm-1.993-1.679a.5.5 0 0 0-.686.172l-1.17 1.95-.547-.547a.5.5 0 0 0-.708.708l.774.773a.75.75 0 0 0 1.174-.144l1.335-2.226a.5.5 0 0 0-.172-.686Z"></path>
</svg>
  </button></span>';
    echo "</td>
    <td>" . htmlspecialchars($row['message_date']) . "</td>
    <td>" . htmlspecialchars($row['status']) . "</td>
    </tr>";  //$row['index'] the index here is a field name
                        }
                        ?>

                    </tbody>
                    <tfoot>
                        <tr>
                            <th>Property</th>
                            <th>Name</th>
                            <th>E-mail</th>
                            <th></th>
                            <th></th>
                            <th>Date Received</th>
                            <th>Status</th>
                        </tr>
                    </tfoot>
                </table>

            <div class="row">
            </div>
        </div>
    </div>
</div>

<!-- New Enquiry Modal -->
<div class="modal fade" id="newEnquiry" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST">
                <input type="hidden" name="access" value="enquiries">
                <input type="hidden" name="insert" value="true">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add New Enquiry</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <div class="row">
                        <div class="col">
                            <div class="col-lg">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row mb-3">
                                            <p>
                                            <div class="col-sm-3">
                                                <h6 class="mb-0">Property</h6>
                                            </div>
                                            <div class="col-sm-9 text-secondary">
                                                <select class="form-select" name="property_code_enquiry">
                                                    <?php
                                                    //List all the properties from an agent
                                                    require 'config/config.php';
                                                    $select = "SELECT * FROM property WHERE property_prs_code = '$agent_prs_code'";
                                                    $result = mysqli_query($link, $select);
                                                    while ($row = mysqli_fetch_array($result)) {
                                                        echo '<option value="' . $row['property_code'] . '">' . $row['property_name'] . '</option>';
                                                    }
                                                    mysqli_close($link);
                                                    ?>
                                                </select>
                                            </div>
                                            </p>

                                            <div class="col-sm-3">
                                                <h6 class="mb-0">First Name</h6>
                                            </div>
                                            <div class="col-sm-9 text-secondary">
                                                <input type="text" class="form-control" name="first_name" required>
                                            </div>
                                            <p>
                                            <div class="col-sm-3">
                                                <h6 class="mb-0">Last Name</h6>
                                            </div>
                                            <div class="col-sm-9 text-secondary">
                                                <input type="text" class="form-control" name="last_name" required>
                                            </div>
                                            </p>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-sm-3">
                                                <h6 class="mb-0">Email</h6>
                                            </div>
                                            <div class="col-sm-9 text-secondary">
                                                <input type="email" class="form-control" name="email" required>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-sm-3">
                                                <h6 class="mb-0">Phone</h6>
                                            </div>
                                            <div class="col-sm-9 text-secondary">
                                                <input type="phone" class="form-control" name="phone" required>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-sm-3">
                                                <h6 class="mb-0">Message</h6>
                                            </div>
                                            <div class="col-sm-9 text-secondary">
                                                <textarea class="form-control" name="message_text"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <input type="submit" class="btn btn-primary" value="Insert">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel and Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    //Function to handle the select box
    $(function() {
        $('[data-toggle="tooltip"]').tooltip()
    })
</script>

<style>
    tr:hover {
        cursor: pointer;
    }
</style>

<script>
    //Format Tables
    $(document).ready(function() {
        $('#dataTable').DataTable({
            pageLength: 15,
            dom: 'Bfrtip',
            buttons: [
                'copy', 'excel', 'pdf', 'print'
            ]
        });
    });
</script>