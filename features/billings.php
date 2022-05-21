        <?php
        require "features/functions_billings.php";

        if ($_POST['action'] == 'updateBill') {
        ?>
            <script>
                $(document).ready(function() {
                    $("#alertModal").modal('show');
                });
            </script>
            <!-- Modal Alert -->
            <div class="modal" id="alertModal" tabindex="-1" aria-labelledby="alertModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-body">
                            <center>
                                <?php
                                 setBill($_POST['transactionID'],'billings_amount',$_POST['billings_amount']);
                                 setBill($_POST['transactionID'],'billings_charge_date',$_POST['billings_charge_date']);
                                 setBill($_POST['transactionID'],'billings_status',$_POST['billings_status']);
                                 setBill($_POST['transactionID'],'billings_note',$_POST['billings_note']);
                                 setBill($_POST['transactionID'],'billings_user',$_SESSION["agent_id"]);
                                 setBill($_POST['transactionID'],'billings_user_date',date("Y-m-d H:i:s"));
                                ?>
                                <p> Redirect in <span id="countdowntimer">3 </span> seconds</p>
                                <meta http-equiv="refresh" content="3;#" />
                                <script type="text/javascript">
                                    var timeleft = 5;
                                    var downloadTimer = setInterval(function() {
                                        timeleft--;
                                        document.getElementById("countdowntimer").textContent = timeleft;
                                        if (timeleft <= 0)
                                            clearInterval(downloadTimer);
                                    }, 1000);
                                </script>
                            </center>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Modal Alert -->
        <?php
        }
        ?>
        <div class="container-xl px-4 mt-4">
            <div class="row">
                <div class="col-lg-4 mb-4">
                    <!-- Billing card 1-->
                    <div class="card h-100 border-start-lg border-start-primary">
                        <div class="card-body">
                            <div class="small text-muted">Balance</div>
                            <div class="h3">€<?php echo getBallanceBill($tenantscod, ' AND billings_invoice_date <= NOW() AND billings_status != "Paid"'); ?></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 mb-4">
                    <!-- Billing card 2-->
                    <div class="card h-100 border-start-lg border-start-secondary">
                        <div class="card-body">
                            <div class="small text-muted">Next rent due</div>
                            <div class="h3"><?php echo date('d M', strtotime(htmlspecialchars( geNextBill($tenantscod, 'billings_invoice_date' ,' AND billings_status != "Paid" ORDER BY billings_invoice_date ASC LIMIT 1') )));?></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 mb-4">
                    <!-- Billing card 3-->
                    <div class="card h-100 border-start-lg border-start-success">
                        <div class="card-body">
                            <div class="small text-muted">Status</div>
                            <div class="h3 d-flex align-items-center">Current Tenant</div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Billing history -->
            <div class="card mb-4">
                <div class="card-header">Rent History</div>
                <div class="card-body p-0">
                    <!-- Billing history table-->
                    <div class="table-responsive table-billing-history">
                        <table class="table mb-0">
                            <thead>
                                <tr>
                                    <th class="border-gray-200" scope="col">Transaction ID</th>
                                    <th class="border-gray-200" scope="col">Description</th>
                                    <th class="border-gray-200" scope="col">Date</th>
                                    <th class="border-gray-200" scope="col">Amount</th>
                                    <th class="border-gray-200" scope="col">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                require "config/config.php";
                                $query = "SELECT * FROM billings WHERE billings_tenantscod = $tenantscod ORDER BY billings_invoice_date DESC";
                                $result = mysqli_query($link, $query);
                                while ($row = mysqli_fetch_array($result)) {
                                    $mysqDateTime = htmlspecialchars($row['billings_invoice_date']);
                                    $dateFormated = date('Y-m-d', strtotime($mysqDateTime));

                                    echo '<tr data-bs-toggle="modal" data-bs-target="#billingDetails' . htmlspecialchars($row['idbillings']) . '" class="showsRow">';
                                    echo "<td>#" . htmlspecialchars($row['idbillings']) . "</td>
                            <td>" . htmlspecialchars($row['billings_description']) . "</td>
                            <td>" . $dateFormated . "</td>
                            <td>" . htmlspecialchars($row['billings_amount']) . "</td>
                            <td><span class=\"badge 
                            ";
                                    if (htmlspecialchars($row['billings_status']) == 'Paid') {
                                        echo "bg-success";
                                    } else if (htmlspecialchars($row['billings_status']) == 'Overdue') {
                                        echo "bg-danger";
                                    } else {
                                        echo "bg-secondary";
                                    }
                                    echo "\">" . htmlspecialchars($row['billings_status']) . "</span></td>
                            </tr>";
                                ?>
                                    <!-- Modal Billing Details -->
                                    <div class="modal fade" id="billingDetails<?php echo htmlspecialchars($row['idbillings']); ?>" tabindex="-1" aria-labelledby="ModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <!-- Form START -->
                                                <form action="?access=tenantView&content=billings&tenantscod=<?php echo $tenantscod; ?>&hash=<?php echo $hash; ?>" method="POST">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="ModalLabel">Billing Detail</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="container-fluid">
                                                            <!-- Contact detail -->
                                                            <div class="bg-secondary-soft px-4 py-5 rounded">
                                                                <div class="row g-3">
                                                                    <h4 class="mb-4 mt-0">Billing Details</h4>
                                                                    <div class="col-md-6">
                                                                        <label class="form-label">Transaction ID</label>
                                                                        <input type="hidden" class="form-control" name="transactionID" value="<?php echo htmlspecialchars($row['idbillings']); ?>">
                                                                        <input type="text" class="form-control" name="transactionID" value="<?php echo htmlspecialchars($row['idbillings']); ?>" disabled="disabled">
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <label class="form-label">Transaction Date</label>
                                                                        <input type="text" class="form-control" value="<?php echo htmlspecialchars($row['billings_invoice_date']); ?>" disabled="disabled">
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="form-label">Ammount *</label>
                                                                        <input type="text" class="form-control" name="billings_amount" value="<?php echo htmlspecialchars($row['billings_amount']); ?>" required>
                                                                    </div>
                                                                    <hr>
                                                                    <div class="col-md-6">
                                                                        <label for="inputEmail4" class="form-label">Charge Date *</label>
                                                                        <input type="date" class="form-control" name="billings_charge_date" value="<?php echo date('Y-m-d', strtotime(htmlspecialchars($row['billings_charge_date']))); ?>" required>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <label class="form-label">Status *</label>
                                                                        <select class="form-control" name="billings_status" required>
                                                                            <option value="<?php echo htmlspecialchars($row['billings_status']); ?>" selected><?php echo htmlspecialchars($row['billings_status']); ?></option>
                                                                            <option value="Pending">Pending</option>
                                                                            <option value="Paid">Paid</option>
                                                                            <option value="Overdue">Overdue</option>
                                                                        </select>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label>Notes</label>
                                                                        <textarea class="form-control" name="billings_note" rows="3"><?php echo htmlspecialchars($row['billings_note']); ?></textarea>
                                                                    </div>
                                                                    <label class="small mb-1">Edited by <?php echo userGetData2('agent_id',($row['billings_user']),'agent_name'); ?> on <?php echo htmlspecialchars($row['billings_user_date']); ?> </label>
                                                                </div> <!-- Row END -->
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="submit" class="btn btn-primary" name="action" value="updateBill">&nbsp;Update</button>
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                    </div>
                                                </form>
                                                <!-- Form END -->
                                            </div>
                                        </div>
                                    </div>

                                <?php
                                }
                                ?>
                            </tbody>

                            <!-- <tbody>
                            <td><span class="badge bg-secondary">Pending</span></td>
                            <td><span class="badge bg-danger">Arreas</span></td>
                            <td><span class="badge bg-success">Paid</span></td>
                            <td><span class="badge bg-success">Paid</span></td>
                    </tbody> -->

                        </table>
                    </div>





                </div>
            </div>
        </div>



        <style>
            tr.showsRow:hover {
                background-color: #4e73df;
                color: white;
                cursor: pointer;
            }
        </style>