<?php
require "features/functions_property.php";

if (isset($_GET['submit'])) {
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
    if (getPropertyData($_SESSION["property_code"], 'property_name') != $_GET['propertyName']) {
        setPropertyData($_SESSION["property_code"], 'property_name', $_GET['propertyName']);
    }
    if (getPropertyData($_SESSION["property_code"], 'property_type') != $_GET['propertyType']) {
        setPropertyData($_SESSION["property_code"], 'property_type', $_GET['propertyType']);
    }
    if (getPropertyData($_SESSION["property_code"], 'property_units') != $_GET['units']) {
        setPropertyData($_SESSION["property_code"], 'property_units', $_GET['units']);
    }
    if (getPropertyData($_SESSION["property_code"], 'property_address') != $_GET['propertyAddress']) {
        setPropertyData($_SESSION["property_code"], 'property_address', $_GET['propertyAddress']);
    }

    echo '
        </center></div>
    </div>
</div>
</div>';
}
?>
<div class="container-fluid">
    <h3 class="text-dark mb-4">Manage Properties</h3>
    <div class="col-lg">
        <div class="row">
            <div class="col-xl-12">
                <div class="card shadow mb-3">
                    <div class="card-header py-3">
                        <p class="text-primary m-0 fw-bold">Edit Property</p>
                    </div>
                    <div class="card-body">
                        <form method="GET">
                            <input type="hidden" name="access" value="property">
                            <div class="row">
                                <div class="col">
                                    <div class="mb-3"><label class="form-label"><strong>Property Name</strong></label>
                                        <input class="form-control" type="text" value="<?php echo getPropertyData($_SESSION["property_code"], 'property_name'); ?>" name="propertyName">
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="mb-3"><label class="form-label"><strong>Property Type</strong></label>
                                        <div class="form-group">
                                            <select class="form-control" name="propertyType">
                                                <option value="house" <?php if (getPropertyData($_SESSION["property_code"], 'property_type') === "house") {
                                                                            echo 'selected';
                                                                        } ?>>House</option>
                                                <option value="apartment" <?php if (getPropertyData($_SESSION["property_code"], 'property_type') === "apartment") {
                                                                                echo 'selected';
                                                                            } ?>>Apartment</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="mb-3"><label class="form-label"><strong>Units</strong></label>
                                        <input class="form-control" type="text" value="<?php echo getPropertyData($_SESSION["property_code"], 'property_units'); ?>" name="units">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="mb-3"><label class="form-label"><strong>Property Full Address</strong></label>
                                        <input class="form-control" type="text" value="<?php echo getPropertyData($_SESSION["property_code"], 'property_address'); ?>" name="propertyAddress">
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <button class="btn btn-primary btn-sm" type="submit" name="submit">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>