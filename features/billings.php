        <?php
        require "features/functions_billings.php";
        ?>
        <div class="container-xl px-4 mt-4">
            <div class="row">
                <div class="col-lg-4 mb-4">
                    <!-- Billing card 1-->
                    <div class="card h-100 border-start-lg border-start-primary">
                        <div class="card-body">
                            <div class="small text-muted">Balance</div>
                            <div class="h3">€<?php echo getBallanceBill($tenantscod, ''); ?></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 mb-4">
                    <!-- Billing card 2-->
                    <div class="card h-100 border-start-lg border-start-secondary">
                        <div class="card-body">
                            <div class="small text-muted">Next rent due</div>
                            <div class="h3">July 15</div>
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
                                $query = "SELECT * FROM billings WHERE billings_tenantscod = $tenantscod";
                                $result = mysqli_query($link, $query);
                                while ($row = mysqli_fetch_array($result)) {
                                    echo '<tr data-bs-toggle="modal" data-bs-target="#billingDetails'. htmlspecialchars($row['idbillings']) .'" class="showsRow">';
                                    echo "<td>#" . htmlspecialchars($row['idbillings']) . "</td>
                            <td>" . htmlspecialchars($row['billings_description']) . "</td>
                            <td>" . htmlspecialchars($row['billings_invoice_date']) . "</td>
                            <td>" . htmlspecialchars($row['billings_amount']) . "</td>
                            <td><span class=\"badge bg-secondary\">" . htmlspecialchars($row['billings_status']) . "</span></td>
                            </tr>";
                                ?>
                                    <!-- Modal Billing Details -->
                                    <div class="modal fade" id="billingDetails<?php echo htmlspecialchars($row['idbillings']); ?>" tabindex="-1" aria-labelledby="ModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="ModalLabel">Billing Detail</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="container-fluid">
                                                        <!-- Form START -->
                                                        <form>
                                                            <!-- Contact detail -->
                                                            <div class="bg-secondary-soft px-4 py-5 rounded">
                                                                <div class="row g-3">
                                                                    <h4 class="mb-4 mt-0">Billing Details</h4>
                                                                    <div class="col-md-6">
                                                                        <label class="form-label">Transaction ID</label>
                                                                        <input type="text" class="form-control" value="#<?php echo htmlspecialchars($row['idbillings']); ?>" disabled="disabled">
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <label class="form-label">Transaction Date</label>
                                                                        <input type="text" class="form-control" value="<?php echo htmlspecialchars($row['billings_invoice_date']); ?>" disabled="disabled">
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="form-label">Ammount *</label>
                                                                        <input type="text" class="form-control" placeholder="" value="<?php echo htmlspecialchars($row['billings_amount']); ?>">
                                                                    </div>
                                                                    <hr>
                                                                    <div class="col-md-6">
                                                                        <label for="inputEmail4" class="form-label">Charge Date *</label>
                                                                        <input type="date" class="form-control" value="05/05/2000">
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <label class="form-label">Status *</label>
                                                                        <select class="form-control" id="exampleFormControlSelect1">
                                                                            <option>Pending</option>
                                                                            <option>Paid</option>
                                                                            <option>Overdue</option>
                                                                        </select>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="exampleFormControlTextarea1">Notes</label>
                                                                        <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
                                                                    </div>
                                                                </div> <!-- Row END -->
                                                            </div>
                                                        </form> <!-- Form END -->
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                </div>
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