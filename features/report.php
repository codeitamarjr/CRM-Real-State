<?php
// Include config file
require "config/config.php";

$link->set_charset('utf8mb4'); // set the charset
//Function to get the table name and column name to be used in the query
function outputMySQLToHTMLTable(mysqli $link, string $table, string $rows)
{
    // Make sure that the table exists in the current database!
    $tableNames = array_column($link->query('SHOW TABLES')->fetch_all(), 0);
    if (!in_array($table, $tableNames, true)) {
        throw new UnexpectedValueException('Unknown table name provided!');
    }
    $res = $link->query('SELECT ' . $rows . ' FROM ' . $table);
    $data = $res->fetch_all(MYSQLI_ASSOC);

    echo '<table id="export" class="table my-0">';
    // Display table header
    echo '<thead>';
    echo '<tr>';
    foreach ($res->fetch_fields() as $column) {
        echo '<th>' . htmlspecialchars($column->name) . '</th>';
    }
    echo '</tr>';
    echo '</thead>';
    // If there is data then display each row
    if ($data) {
        foreach ($data as $row) {
            echo '<tbody><tr>';
            foreach ($row as $cell) {
                echo '<td>' . htmlspecialchars($cell) . '</td>';
            }
            echo '</tr></tbody>';
        }
    } else {
        echo '<tr><td colspan="' . $res->field_count . '">No records in the table!</td></tr>';
    }
    echo '</table>';
}

//Check if the button has been clicked to open modal
if ($_POST['report'] == 'messages' || $_POST['report'] == 'demographic') {
    // if the outcome has a variable Approved will update the status to Approved
    echo "<script>
    $(document).ready(function(){
        $(\"#alertModal\").modal('show');
    });
    </script>";
    echo '<div class="modal" id="alertModal" tabindex="-1" aria-labelledby="alertModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                <center>
                   ';
    if ($_POST['report'] == 'messages') {
        outputMySQLToHTMLTable($link, 'messages', '*');
    }
    if ($_POST['report'] == 'demographic') {
        outputMySQLToHTMLTable($link, 'prospect', 'prospect_id,prospect_property_code,prospect_status,prospect_email,prospect_full_name,prospect_cob,prospect_dob,prospect_phone,prospect_address	,prospect_occupants	,prospect_occupants_over18,	prospect_sector	,prospect_employer,	prospect_job_title,	prospect_income	,prospect_extra,	prospect_expectedMovein,	prospect_submission_date');
    }
    echo '
                </center></div>
                <div class="modal-footer">
                <button class="btn btn-primary">
                    <download>Download</download>
                </button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel and Close</button>
            </div>
            </div>
        </div>
    </div>';
}

?>

<script src="https://www.jqueryscript.net/demo/Export-Html-Table-To-Excel-Spreadsheet-using-jQuery-table2excel/src/jquery.table2excel.js"></script>



<div class="container-fluid">
    <h3 class="text-dark mb-1">Report</h3>
    <div class="card shadow">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h6 class="text-primary fw-bold m-0">Report Sample</h6>
        </div>
        <div class="card-body">
            <p class="m-0">Select the option to view and download the report</p><br>
            <div class="scroll">
                <form method="POST">
                    <button class="btn btn-primary" name="report" value="messages">View Messages Report</button>
                    <button class="btn btn-primary" name="report" value="demographic">View Demographic Report</button>
                </form>
            </div>
        </div>
    </div>
</div>




<script>
    $(function() {
        $("download").click(function() {
            $("#export").table2excel({
                exclude: ".xls",
                name: "CRM Report",
                filename: "CRM"
            });
        });
    });
</script>