<?php
// Include config file
require "features/functions_unit.php";
require "features/functions_profile.php";

// Define idunit
$idunit = $_GET['idunit'];

// Edit option
if (isset($_POST['edit'])) {
    $edit = '';
} else {
    $edit = '-plaintext';
}

// Modal
function modal($messageModal)
{
    echo "<script>
        $(document).ready(function(){
            $(\"#alertModal\").modal('show');
        });
        </script>";
    echo '<!-- Modal Alert -->
        <div class="modal" id="alertModal" tabindex="-1" aria-labelledby="alertModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                    <center>
                       ';
    echo $messageModal;
    echo '
                    </center></div>
                </div>
            </div>
        </div>';
}

// Update unit
if (isset($_POST['save'])) {
    if ($_POST['unit_customCode'] != null) echo modal(setUnit($idunit, 'unit_customCode', $_POST['unit_customCode']));
    if ($_POST['XeroCode'] != null) echo modal(setUnit($idunit, 'XeroCode', $_POST['XeroCode']));
    if ($_POST['tenancyType'] != null) echo modal(setUnit($idunit, 'tenancyType', $_POST['tenancyType']));

    if ($_POST['rental_price'] != null) echo modal(setUnit($idunit, 'rental_price', $_POST['rental_price']));
    if ($_POST['floor'] != null) echo modal(setUnit($idunit, 'floor', $_POST['floor']));
    if ($_POST['unit_block'] != null) echo modal(setUnit($idunit, 'unit_block', $_POST['unit_block']));
    if ($_POST['unit_number'] != null) echo modal(setUnit($idunit, 'unit_number', $_POST['unit_number']));
    if ($_POST['type'] != null) echo modal(setUnit($idunit, 'type', $_POST['type']));

    if ($_POST['postal_code'] != null) echo modal(setUnit($idunit, 'postal_code', $_POST['postal_code']));
    if ($_POST['bedrooms'] != null) echo modal(setUnit($idunit, 'bedrooms', $_POST['bedrooms']));
    if ($_POST['carpark'] != null) echo modal(setUnit($idunit, 'carpark', $_POST['carpark']));
    if ($_POST['date_available'] != null) echo modal(setUnit($idunit, 'date_available', $_POST['date_available']));
    if ($_POST['status'] != null) echo modal(setUnit($idunit, 'status', $_POST['status']));

    if ($_POST['description'] != null) echo modal(setUnit($idunit, 'description', $_POST['description']));


}

?>
<div class="container-fluid">
    <div class="main-body">
        <div class="row">
            <div class="col-lg-4 ">
                <div class="card shadow">
                    <div class="card-body">
                        <div class="d-flex flex-column align-items-center text-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="p-1" width="150" height="150" fill="currentColor" class="bi bi-building" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M14.763.075A.5.5 0 0 1 15 .5v15a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1-.5-.5V14h-1v1.5a.5.5 0 0 1-.5.5h-9a.5.5 0 0 1-.5-.5V10a.5.5 0 0 1 .342-.474L6 7.64V4.5a.5.5 0 0 1 .276-.447l8-4a.5.5 0 0 1 .487.022zM6 8.694 1 10.36V15h5V8.694zM7 15h2v-1.5a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 .5.5V15h2V1.309l-7 3.5V15z" />
                                <path d="M2 11h1v1H2v-1zm2 0h1v1H4v-1zm-2 2h1v1H2v-1zm2 0h1v1H4v-1zm4-4h1v1H8V9zm2 0h1v1h-1V9zm-2 2h1v1H8v-1zm2 0h1v1h-1v-1zm2-2h1v1h-1V9zm0 2h1v1h-1v-1zM8 7h1v1H8V7zm2 0h1v1h-1V7zm2 0h1v1h-1V7zM8 5h1v1H8V5zm2 0h1v1h-1V5zm2 0h1v1h-1V5zm0-2h1v1h-1V3z" />
                            </svg>
                            <div class="mt-3">
                                <h4>Unit Details</h4>
                                <p class="text-secondary mb-1"><?php echo htmlspecialchars(getPropertyData(getUnit($idunit, 'idunit', 'property_code'), 'property_name')); ?> | <?php echo getUnit($idunit, 'idunit', 'unit_number') ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-8">
                <form method="POST">
                    <div class="card card-body shadow">
                        <div class="row">
                            <div class="col">
                                <div class="mb-3"><label class="form-label">Property</label>
                                    <input class="form-control-plaintext" value="<?php echo htmlspecialchars(getPropertyData(getUnit($idunit, 'idunit', 'property_code'), 'property_name')); ?>">
                                </div>
                            </div>
                            <div class="col">
                                <div class="mb-3"><label class="form-label">CRM Code</label>
                                    <input class="form-control-plaintext" value="<?php echo getUnit($idunit, 'idunit', 'idunit') ?>">
                                </div>
                            </div>
                            <div class="col">
                                <div class="mb-3"><label class="form-label">Custom Code</label>
                                    <input class="form-control<?php echo $edit; ?>" type="text" name="unit_customCode" value="<?php echo getUnit($idunit, 'idunit', 'unit_customCode') ?>">
                                </div>
                            </div>
                            <div class="col">
                                <div class="mb-3"><label class="form-label">Xero Code</label>
                                    <input class="form-control<?php echo $edit; ?>" type="text" name="XeroCode" value="<?php echo getUnit($idunit, 'idunit', 'XeroCode') ?>">
                                </div>
                            </div>
                            <div class="col">
                                <div class="mb-3"><label class="form-label">Tenancy Type</label>
                                    <select class="form-control<?php echo $edit; ?>" name="tenancyType">
                                        <option selected value="<?php echo getUnit($idunit, 'idunit', 'tenancyType') ?>"><?php echo getUnit($idunit, 'idunit', 'tenancyType') ?></option>
                                        <option value="Lease">Lease</option>
                                        <option value="Contract">Contract</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <hr>

                        <div class="row">
                            <div class="col">
                                <div class="mb-3"><label class="form-label">Rental Price</label>
                                    <input class="form-control<?php echo $edit; ?>" type="text" name="rental_price" value="<?php echo getUnit($idunit, 'idunit', 'rental_price') ?>">
                                </div>
                            </div>
                            <div class="col">
                                <div class="mb-3"><label class="form-label">Unit Floor</label>
                                    <select class="form-control<?php echo $edit; ?>" name="floor">
                                        <option selected value="<?php echo getUnit($idunit, 'idunit', 'floor') ?>"><?php echo getUnit($idunit, 'idunit', 'floor') ?></option>
                                        <option value="Basement">Basement</option>
                                        <option value="Ground Floor">Ground Floor</option>
                                        <option value="First Floor">First Floor</option>
                                        <option value="First Floor Return">First Floor Return</option>
                                        <option value="Second Floor">Second Floor</option>
                                        <option value="Second Floor Return">Second Floor Return</option>
                                        <option value="Third Floor">Third Floor</option>
                                        <option value="Third Floor Return">Third Floor Return</option>
                                        <option value="Fourth Floor">Fourth Floor</option>
                                        <option value="Fourth Floor Return">Fourth Floor Return</option>
                                        <option value="Fifth Floor">Fifth Floor</option>
                                        <option value="Fifth Floor Return">Fifth Floor Return</option>
                                        <option value="Sixth Floor">Sixth Floor</option>
                                        <option value="Sixth Floor Return">Sixth Floor Return</option>
                                        <option value="Seventh Floor">Seventh Floor</option>
                                        <option value="Seventh Floor Return">Seventh Floor Return</option>
                                        <option value="Eighth Floor">Eighth Floor</option>
                                        <option value="Eighth Floor Return">Eighth Floor Return</option>
                                        <option value="Ninth Floor">Ninth Floor</option>
                                        <option value="Ninth Floor Return">Ninth Floor Return</option>
                                        <option value="Tenth Floor">Tenth Floor</option>
                                        <option value="Tenth Floor Return">Tenth Floor Return</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col">
                                <div class="mb-3"><label class="form-label">Unit Block</label>
                                    <input class="form-control<?php echo $edit; ?>" type="text" name="unit_block" value="<?php echo getUnit($idunit, 'idunit', 'unit_block') ?>">
                                </div>
                            </div>
                            <div class="col">
                                <div class="mb-3"><label class="form-label">Unit Number</label>
                                    <input class="form-control<?php echo $edit; ?>" type="number" name="unit_number" value="<?php echo getUnit($idunit, 'idunit', 'unit_number') ?>">
                                </div>
                            </div>
                            <div class="col">
                                <div class="mb-3"><label class="form-label">Unit Type</label>
                                    <select class="form-control<?php echo $edit; ?>" name="type">
                                        <option selected value="<?php echo getUnit($idunit, 'idunit', 'type') ?>"><?php echo getUnit($idunit, 'idunit', 'type') ?></option>
                                        <option value="1 Bedroom">1 Bedroom</option>
                                        <option value="2 Bedroom">2 Bedroom</option>
                                        <option value="3 Bedroom">3 Bedroom</option>
                                        <option value="1 Double bedroom">1 Double bedroom</option>
                                        <option value="2 Double bedroom">2 Double bedroom</option>
                                        <option value="3 Double bedroom">3 Double bedroom</option>
                                        <option value="Studio">Studio</option>
                                        <option value="Double Studio">Double Studio</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <hr>

                        <div class="row">
                            <div class="col">
                                <div class="mb-3"><label class="form-label">Postal Code</label>
                                    <input class="form-control<?php echo $edit; ?>" type="text" name="postal_code" value="<?php echo getUnit($idunit, 'idunit', 'postal_code') ?>">
                                </div>
                            </div>
                            <div class="col">
                                <div class="mb-3"><label class="form-label">Bedrooms</label>
                                    <input class="form-control<?php echo $edit; ?>" type="number" name="bedrooms" value="<?php echo getUnit($idunit, 'idunit', 'bedrooms') ?>">
                                </div>
                            </div>
                            <div class="col">
                                <div class="mb-3"><label class="form-label">Car Parking</label>
                                    <select class="form-control<?php echo $edit; ?>" name="carpark">
                                        <option selected value="<?php echo getUnit($idunit, 'idunit', 'carpark') ?>"><?php echo getUnit($idunit, 'idunit', 'carpark') ?></option>
                                        <option value="Yes">Yes</option>
                                        <option value="No">No</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col">
                                <div class="mb-3"><label class="form-label">Date Available</label>
                                    <input class="form-control<?php echo $edit; ?>" type="date" name="date_available" value="<?php echo getUnit($idunit, 'idunit', 'date_available') ?>">
                                </div>
                            </div>
                            <div class="col">
                                <div class="mb-3"><label class="form-label">Status</label>
                                    <select class="form-control<?php echo $edit; ?>" name="status">
                                        <option selected value="<?php echo getUnit($idunit, 'idunit', 'status') ?>"><?php echo getUnit($idunit, 'idunit', 'status') ?></option>
                                        <option value="Available">Available</option>
                                        <option value="Maintenance">Maintenance</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col">
                            <div class="mb-3"><label class="form-label">Description</label>
                                <input class="form-control<?php echo $edit; ?>" type="text" name="description" value="<?php echo getUnit($idunit, 'idunit', 'description') ?>">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-8 text-secondary">
                                <?php if (!$_POST['edit'] ?? null) echo '<button type="submit" class="btn btn-primary" name="edit" value="edit">Edit</button>'; ?>
                                <?php if ($_POST['edit'] ?? null) echo '<button type="submit" class="btn btn-primary" name="save" value="update">Update</button>'; ?>
                            </div>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</div>