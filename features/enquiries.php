<?php
// Include config file
require "config/config.php";
//Get property code definied at the start of the login SESSION
$property_code = $_SESSION["property_code"];

//Define max of results per page 
if (!isset($_GET['show'])) {
    $results_per_page = 15;
} else {
    $results_per_page = $_GET['show'];
}

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
        insertMessage($prs_code_enquiry, $email, $property_code_enquiry);
        setMessage(getMessage('messages_email', $email, 'message_id'), 'message_sender_name', $message_sender_name);
        setMessage(getMessage('messages_email', $email, 'message_id'), 'message_phone_number', $message_phone_number);
        setMessage(getMessage('messages_email', $email, 'message_id'), 'message_title', $mail_subject);
        setMessage(getMessage('messages_email', $email, 'message_id'), 'message_body', $_POST['message_text']);
        setMessage(getMessage('messages_email', $email, 'message_id'), 'messages_prs_code', $_SESSION["agent_prs_code"]);
    }
};


//select all data from the mail_income sql
$query = "SELECT * FROM messages WHERE property_code = $property_code ";
$result = mysqli_query($link, $query);

//find the total number of results
$number_of_result = mysqli_num_rows($result);

//total number of pages in total
$number_of_page = ceil($number_of_result / $results_per_page);

//which page number visitor is currently on  
if (!isset($_GET['page'])) {
    $page = 1;
} else {
    $page = $_GET['page'];
}

//determine the sql LIMIT starting number for the results on the displaying page  
$page_first_result = ($page - 1) * $results_per_page;

$query = "SELECT * FROM messages WHERE property_code = $property_code ORDER BY message_date DESC LIMIT " . $page_first_result . ',' . $results_per_page;
$result = mysqli_query($link, $query);
?>


<div class="container">
    <h3 class="text-dark mb-4">Enquiries</h3>
    <div class="card shadow">
        <div class="card-header py-3">
            <p class="text-primary m-0 fw-bold">Inbox of Enquiries
                <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#newEnquiry"> + Add New Enquiry</button>
            </p>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6 text-nowrap">
                    <div id="dataTable_length" class="dataTables_length" aria-controls="dataTable"><label class="form-label">Show&nbsp;
                            <select class="d-inline-block form-select form-select-sm" onchange="javascript:handleSelect(this)">
                                <option value="&show=10" selected=""><?php echo $results_per_page; ?> </option>
                                <option value="&show=25">25</option>
                                <option value="&show=50">50</option>
                                <option value="&show=100">100</option>
                            </select>&nbsp;</label></div>
                </div>
                <div class="col-md-6">
                </div>
            </div>
            <div class="table-responsive table mt-2" id="dataTable" role="grid" aria-describedby="dataTable_info">
                <table class="table my-0" id="dataTable">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Status</th>
                            <th>Date Received</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php while ($row = mysqli_fetch_array($result)) {
                            $message_id = htmlspecialchars($row['message_id']);

                            echo "<tr ";
                            if ($row['status'] == "Approved") {
                                echo "class='table-success'";
                            }
                            if ($row['status'] == "Denied") {
                                echo "class='table-danger'";
                            }
                            echo " onclick=\"location.href='?access=enquiryDetails&message_id=$message_id'\" >
    <td>" . htmlspecialchars($row['message_sender_name']) . "</td>
    <td>" . htmlspecialchars($row['messages_email']) . "</td>
    <td>";
                            //Check if the prospect fillout his data on prospect table, if so shows an clickable link to show his profile
                            $message_hash = $row['message_hash'];
                            $query_prospect = "SELECT * FROM prospect WHERE hash = '$message_hash'";
                            $result_prospect = mysqli_query($link, $query_prospect);
                            while ($row_prospect = mysqli_fetch_array($result_prospect)) {
                                $hash = $row_prospect['hash'];
                                if (!empty($hash)) {
                                    echo '<a data-toggle="tooltip" title="This application has been received"><i class="fa fa-address-card"></i></a>';
                                }
                            };
                            echo "</td>
    <td>" . htmlspecialchars($row['message_date']) . "</td>
    <td>" . htmlspecialchars($row['status']) . "</td>
    </tr>";  //$row['index'] the index here is a field name
                        }
                        ?>

                    </tbody>
                    <tfoot>
                        <tr>
                            <td><strong>Name</strong></td>
                            <td><strong>Email</strong></td>
                            <td><strong>Status</strong></td>
                            <td><strong>Date Received</strong></td>
                            <td><strong>Status</strong></td>
                        </tr>
                    </tfoot>
                </table>
            </div>




            <div class="row">

                <div class="col-md-6 align-self-center">
                    <p id="dataTable_info" class="dataTables_info" role="status" aria-live="polite">Showing <?php echo $page_first_result + 1; ?> to <?php echo ($page_first_result + $results_per_page); ?> of <?php echo totalMesssages($_SESSION["property_code"], ''); ?></p>
                </div>

                <div class="col-md-6">
                    <nav class="d-lg-flex justify-content-lg-end dataTables_paginate paging_simple_numbers">
                        <ul class="pagination">
                            <?php
                            //display the link of the pages in URL  
                            for ($page = 1; $page <= $number_of_page;) {
                                echo '<li class="page-item"><a class="page-link" href="dashboard.php?access=enquiries&show=' . $results_per_page . '&page=' . $page . '">' . $page . ' </a></li>';
                                $page++;
                            }
                            //Close SQL connection
                            mysqli_close($link);
                            ?>
                        </ul>
                    </nav>
                </div>

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



<script type="text/javascript">
    function handleSelect(elm) {
        window.location = "dashboard.php?access=enquiries&" + elm.value;
    }
</script>

<style>
    tr:hover {
        background-color: #4e73df;
        color: white;
        cursor: pointer;
    }
</style>