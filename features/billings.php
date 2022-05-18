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
                                    echo '<tr data-bs-toggle="modal" data-bs-target="#billingDetails" class="showsRow">';
                                    echo "<td>#" . htmlspecialchars($row['idbillings']) . "</td>
                            <td>" . htmlspecialchars($row['billings_description']) . "</td>
                            <td>" . htmlspecialchars($row['billings_invoice_date']) . "</td>
                            <td>" . htmlspecialchars($row['billings_amount']) . "</td>
                            <td><span class=\"badge bg-secondary\">" . htmlspecialchars($row['billings_status']) . "</span></td>
                            </tr>";
                                }
                                ?>
                            </tbody>

                            <!-- <tbody>
                        <tr data-bs-toggle="modal" data-bs-target="#billingDetails" class="showsRow">
                            <td>#39201</td>
                            <td>Rent</td>
                            <td>06/15/2021</td>
                            <td>$29.99</td>
                            <td><span class="badge bg-secondary">Pending</span></td>
                        </tr>
                        <tr>
                            <td>#38594</td>
                            <td>Rent</td>
                            <td>05/15/2021</td>
                            <td>$29.99</td>
                            <td><span class="badge bg-danger">Arreas</span></td>
                        </tr>
                        <tr>
                            <td>#38223</td>
                            <td>Rent</td>
                            <td>04/15/2021</td>
                            <td>$29.99</td>
                            <td><span class="badge bg-success">Paid</span></td>
                        </tr>
                        <tr>
                            <td>#38125</td>
                            <td>Deposit</td>
                            <td>03/15/2021</td>
                            <td>$29.99</td>
                            <td><span class="badge bg-success">Paid</span></td>
                        </tr>
                    </tbody> -->

                        </table>
                    </div>





                </div>
            </div>
        </div>

        <!-- Modal Billing Details -->
        <div class="modal fade" id="billingDetails" tabindex="-1" aria-labelledby="ModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="ModalLabel">Billing Detail</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Ddasdasdas
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
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