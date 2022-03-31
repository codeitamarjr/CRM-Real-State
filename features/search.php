<?php
require "config/config.php";
?>






<div class="container">
    <div class="row">
        <div class="col-md-12">

            <div class="card">
                <div class="card-body">
                    <h5 class="card-title text-uppercase mb-0">Searching result</h5>
                </div>

                <div class="table-responsive">
                    <table class="table no-wrap user-table mb-0">
                        <thead>
                            <tr>
                                <th scope="col" class="border-0 text-uppercase font-medium">Name</th>
                                <th scope="col" class="border-0 text-uppercase font-medium">Status</th>
                                <th scope="col" class="border-0 text-uppercase font-medium">Email</th>
                                <th scope="col" class="border-0 text-uppercase font-medium">Received</th>
                                <th scope="col" class="border-0 text-uppercase font-medium">Manage</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php
                            if (isset($_GET['submit-search'])) {
                                $search = mysqli_real_escape_string($link, $_GET['search']);
                                $sql = "SELECT * FROM messages WHERE message_sender_name LIKE '%$search%' OR message_title LIKE '%$search%' OR message_phone_number LIKE '%$search%' OR messages_email LIKE '%$search%'";
                                $result = mysqli_query($link, $sql);
                                $query_result = mysqli_num_rows($result);
                                if ($query_result > 0) {
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        $from = $row['messages_email'];
                                        $phone = $row['message_phone_number'];
                                        $date = $row['message_date'];
                                        $message = $row['message_body'];
                                        $status = $row['status'];
                                        $message_id = $row['message_id'];
                                        $name = $row['message_sender_name'];

                                        echo '<tr>
            <td>
                <h5 class="font-medium mb-0"><a href="dashboardv2.php?access=message&message_id=' . $message_id . '">' . $name . '</a></h5>
            </td>
            <td>
                <span class="text-muted">' . $status . '</span><br>
            </td>
            <td>
                <span class="text-muted">' . $from . '</span><br>
                <span class="text-muted">' . $phone . '</span>
            </td>
            <td>
                <span class="text-muted">' . $date . '</span><br>
            </td>
            <td>
            <a class="dropdown-item" href="dashboardv2.php?access=message&message_id=' . $message_id . '&outcome=Delete"><button type="button" class="btn btn-outline-info btn-circle btn-lg btn-circle ml-2"><i class="fa fa-trash"></i> </button></a>
            </td>
        </tr>';
                                    }
                                } else {
                                    echo "There are no results matching your search!";
                                }
                            }
                            ?>



                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>