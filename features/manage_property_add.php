<?php

if (isset($_POST['submit'])) {
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
                   insertPropertyDataSafe($_POST['client'],$_POST['propertyType'],$_POST['propertyName'],$_POST['propertyAddress'],'sss',$agent_prs_code);

    echo '
        </center></div>
    </div>
</div>
</div>';
}
?>
<div class="container">
    <div class="col-lg">
        <div class="row">
            <div class="col-xl-12">
                <div class="card shadow mb-3">
                    <div class="card-header py-3">
                        <p class="text-primary m-0 fw-bold">Add a New Property</p>
                    </div>
                    <div class="card-body">
                        <form method="POST">
                            <input type="hidden" name="access" value="property">
                            <div class="row">
                            <div class="col">
                                    <div class="mb-3"><label class="form-label"><strong>Client</strong></label>
                                        <input class="form-control" type="text" name="client" required>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="mb-3"><label class="form-label"><strong>Property Name</strong></label>
                                        <input class="form-control" type="text" name="propertyName" required>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="mb-3"><label class="form-label"><strong>Property Type</strong></label>
                                        <div class="form-group">
                                            <select class="form-control" name="propertyType" required>
                                                <option value="house">House</option>
                                                <option value="apartment">Apartment</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="mb-3"><label class="form-label"><strong>Property Full Address</strong></label>
                                        <input class="form-control" type="text" name="propertyAddress" required>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <button class="btn btn-primary btn-sm" type="submit" name="submit">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>