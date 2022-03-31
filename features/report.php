<?php
// Include config file
require "config/config.php";

//select all data from the mail_income sql
$query = "SELECT * FROM messages limit 5";
$result = mysqli_query($link, $query);
?>


<div class="container-fluid">
    <h3 class="text-dark mb-1">Report</h3>
    <div class="card shadow mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h6 class="text-primary fw-bold m-0">Report Sample</h6>
            <div class="dropdown no-arrow"><button class="btn btn-link btn-sm dropdown-toggle" aria-expanded="false" data-bs-toggle="dropdown" type="button"><i class="fas fa-ellipsis-v text-gray-400"></i></button>
                <div class="dropdown-menu dropdown-menu-end shadow animated--fade-in">
                    <h6 class="dropdown-header text-center"><strong>Action:</strong></h6>
                    <a class="dropdown-item" href="features/export.php">&nbsp;Download as XLS</a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <p class="m-0">This is just a sample of the final report!</p><br>
            <table class="table my-0" >
                <thead>
                    <tr>
                        <th>Date Received</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Message</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
<?php
while ($row = mysqli_fetch_array($result)) {   //Creates a loop to loop through results
    echo "<tr><td>" . htmlspecialchars($row['message_date']) . "</td>
            <td>" . htmlspecialchars($row['message_sender_name']) . "</td>
            <td>" . htmlspecialchars($row['messages_email']) . "</td>
            <td>" . htmlspecialchars($row['message_phone_number']) . "</td>
            <td>" . htmlspecialchars($row['message_body']) . "</td>
            <td>" . htmlspecialchars($row['status']) . "</td></tr>";
}

mysqli_close($link);
?>
                </tbody>
            </table>

        </div>
    </div>
</div>