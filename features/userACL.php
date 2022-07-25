<?php
// Include config file
require "config/config.php";

function switchView($disabled)
{
    if ($disabled) {
        echo '<!-- Switch Enabled -->
        <div class="form-check form-switch">
        <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckChecked" checked>
        <label class="form-check-label" for="flexSwitchCheckChecked">Access</label>
      </div>';
    } else {
        echo '<!-- Switch Disabled -->
    <div class="form-check form-switch">
        <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault">
        <label class="form-check-label" for="flexSwitchCheckDefault">Access</label>
    </div>';
    }
}

function switchEdit($status)
{
    if ($status) {
        echo '<!-- Switch Enabled -->
        <div class="form-check form-switch">
        <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckChecked" checked>
        <label class="form-check-label" for="flexSwitchCheckChecked">Edit</label>
      </div>';
    } else {
        echo '<!-- Switch Disabled -->
    <div class="form-check form-switch">
        <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault">
        <label class="form-check-label" for="flexSwitchCheckDefault">Edit</label>
    </div>';
    }
}

function outputMySQLToHTMLTable(mysqli $link, string $table, string $rows, string $extraQuery)
{
    // Make sure that the table exists in the current database!
    $tableNames = array_column($link->query('SHOW TABLES')->fetch_all(), 0);
    if (!in_array($table, $tableNames, true)) {
        throw new UnexpectedValueException('Unknown table name provided!');
    }
    $res = $link->query('SELECT ' . $rows . ' FROM ' . $table . $extraQuery);
    $data = $res->fetch_all(MYSQLI_ASSOC);

    echo '<table id="dataTable" class="table" style="width:100%">';
    // Display table header
    echo '<thead>';
    echo '<tr>';
    foreach ($res->fetch_fields() as $column) {
        echo '<th>' . htmlspecialchars($column->name) . '</th>';
    }
    echo '</tr>';
    echo '</thead><tbody>';
    // If there is data then display each row
    if ($data) {
        foreach ($data as $row) {
            echo '<tr>';
            foreach ($row as $cell) {
                echo '<td>';
                switch ($cell) {
                    case '0':
                        switchView(false);
                        switchEdit(false);
                        break;
                    case '1':
                        switchView(true);
                        switchEdit(false);
                        break;
                    case '2':
                        switchView(true);
                        switchEdit(true);
                        break;
                    default:
                        echo htmlspecialchars($cell);
                        break;
                }

                echo '</td>';
            }
            echo '</tr>';
        }
    } else {
        echo '</tbody><tr><td colspan="' . $res->field_count . '">No records in the table!</td></tr>';
    }
    echo '</table>';
}


?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs5/jq-3.6.0/jszip-2.5.0/dt-1.12.1/b-2.2.3/b-html5-2.2.3/b-print-2.2.3/cr-1.5.6/r-2.3.0/sb-1.3.4/sr-1.1.1/datatables.min.css" />
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs5/jq-3.6.0/jszip-2.5.0/dt-1.12.1/b-2.2.3/b-html5-2.2.3/b-print-2.2.3/cr-1.5.6/r-2.3.0/sb-1.3.4/sr-1.1.1/datatables.min.js"></script>


<div class="container-fluid">
    <div class="card shadow">
        <div class="card-header py-3">
            <p class="text-primary m-0 fw-bold">Users
            </p>
        </div>
        <div class="card-body">
            <?php
            outputMySQLToHTMLTable(
                $link,
                'userACLGroup',
                '*',
                ''
            );
            ?>


        </div>
    </div>
</div>



<script>
    //Format Tables
    $(document).ready(function() {
        $('#dataTable').DataTable({
            pageLength: 20,
            dom: 'Bfrtip',
            scrollX: true
        });
    });
</script>

<style>
tr th:first-child { display: none; }
table#dataTable tr td:first-child { display: none; }
</style>