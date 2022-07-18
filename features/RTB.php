<?php
$eircode = $_POST['eircode'];
if (isset($_POST['eircode'])) {
    $addressLine1 = $_POST['addressLine1'];
    $eircode = $_POST['eircode']; //'D11AEP9'example
    $countyId = $_POST['RTBCountry'];
    $APIKey = '60285EE9-92E7-4F0A-9D4C-EA486FD79990';
}

$url = 'https://portal.rtb.ie/webapi/RegisterSearch/GetRegisteredDwellingDetails?addressLine1=' . $addressLine1 . '&eircode=' . $eircode . '&countyId=' . $countyId . '&APIKey=' . $APIKey;
$json = file_get_contents($url);
// Decode the JSON
$data = json_decode($json);
// Clean up the [ and ] from the JSON
$data = str_replace('[', '', $data);
$data = str_replace(']', '', $data);
// Convert the JSON to an array
$data = json_decode($data, true);
//print_r($data);
?>
<div class="container-fluid">
    <div class="main-body">
        <div class="row">
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex flex-column align-items-center text-center">
                            <img src="https://www.rtb.ie/img/RTBlogo.png" alt="RTB" class="p-1" width="100%">
                            <div class="mt-3">
                                <h4>Residential Tenancies Board</h4>
                                <p class="text-secondary mb-1">Check The Register</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="card">
                    <form method="POST">
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-sm-4">
                                    <h6 class="mb-0">Country</h6>
                                </div>
                                <div class="col-sm-8 text-secondary">
                                    <select class="form-select" aria-label="Select one country" name="RTBCountry">
                                        <option value="" selected="selected"> Please select </option>
                                        <option value="3b4cd92b-c49b-e811-a870-000d3a274eca">Carlow</option>
                                        <option value="1b4cd92b-c49b-e811-a870-000d3a274eca">Cavan</option>
                                        <option value="2d4cd92b-c49b-e811-a870-000d3a274eca">Clare</option>
                                        <option value="2b4cd92b-c49b-e811-a870-000d3a274eca">Cork</option>
                                        <option value="274cd92b-c49b-e811-a870-000d3a274eca">Donegal</option>
                                        <option value="1d4cd92b-c49b-e811-a870-000d3a274eca">Dublin</option>
                                        <option value="154cd92b-c49b-e811-a870-000d3a274eca">Galway</option>
                                        <option value="454cd92b-c49b-e811-a870-000d3a274eca">Kerry</option>
                                        <option value="394cd92b-c49b-e811-a870-000d3a274eca">Kildare</option>
                                        <option value="1f4cd92b-c49b-e811-a870-000d3a274eca">Kilkenny</option>
                                        <option value="214cd92b-c49b-e811-a870-000d3a274eca">Laois</option>
                                        <option value="354cd92b-c49b-e811-a870-000d3a274eca">Leitrim</option>
                                        <option value="174cd92b-c49b-e811-a870-000d3a274eca">Limerick</option>
                                        <option value="474cd92b-c49b-e811-a870-000d3a274eca">Longford</option>
                                        <option value="434cd92b-c49b-e811-a870-000d3a274eca">Louth</option>
                                        <option value="334cd92b-c49b-e811-a870-000d3a274eca">Mayo</option>
                                        <option value="3d4cd92b-c49b-e811-a870-000d3a274eca">Meath</option>
                                        <option value="414cd92b-c49b-e811-a870-000d3a274eca">Monaghan</option>
                                        <option value="374cd92b-c49b-e811-a870-000d3a274eca">Offaly</option>
                                        <option value="254cd92b-c49b-e811-a870-000d3a274eca">Roscommon</option>
                                        <option value="2f4cd92b-c49b-e811-a870-000d3a274eca">Sligo</option>
                                        <option value="3f4cd92b-c49b-e811-a870-000d3a274eca">Tipperary</option>
                                        <option value="314cd92b-c49b-e811-a870-000d3a274eca">Waterford</option>
                                        <option value="234cd92b-c49b-e811-a870-000d3a274eca">Westmeath</option>
                                        <option value="294cd92b-c49b-e811-a870-000d3a274eca">Wexford</option>
                                        <option value="194cd92b-c49b-e811-a870-000d3a274eca">Wicklow</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-4">
                                    <h6 class="mb-0">Eircode</h6>
                                </div>
                                <div class="col-sm-8 text-secondary">
                                    <input type="text" class="form-control" name="eircode">
                                </div>
                            </div>
                            <!-- <div class="row mb-3">
                                <div class="col-sm-4">
                                    <h6 class="mb-0">Full Address</h6>
                                </div>
                                <div class="col-sm-8 text-secondary">
                                    <input type="text" class="form-control" name="addressLine1">
                                </div>
                            </div> -->
                            <div class="row">
                                <div class="col-sm-4"></div>
                                <div class="col-sm-8 text-secondary">
                                    <input type="submit" class="btn btn-primary px-4" value="Search" name="RTB">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php if (isset($data['Eircode'])) { ?>

    <div class="p-4 container">
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        <div class="row mb-3">

                            <div class="container">
                                <div class="main-body">

                                    <div class="row gutters-sm">
                                        <div class="col-md-4 mb-3">
                                            <div class="card">
                                                <div class="card-body">
                                                    <div class="d-flex flex-column align-items-center text-center">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="150" height="150" fill="currentColor" class="bi bi-house" viewBox="0 0 16 16">
                                                            <path fill-rule="evenodd" d="M2 13.5V7h1v6.5a.5.5 0 0 0 .5.5h9a.5.5 0 0 0 .5-.5V7h1v6.5a1.5 1.5 0 0 1-1.5 1.5h-9A1.5 1.5 0 0 1 2 13.5zm11-11V6l-2-2V2.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5z" />
                                                            <path fill-rule="evenodd" d="M7.293 1.5a1 1 0 0 1 1.414 0l6.647 6.646a.5.5 0 0 1-.708.708L8 2.207 1.354 8.854a.5.5 0 1 1-.708-.708L7.293 1.5z" />
                                                        </svg>
                                                        <div class="mt-3">
                                                            <h4>RTB Result</h4>
                                                            <p class="text-secondary mb-1">This Eircode/Address<br>is registered on RTB</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="card mb-3">
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-sm-4">
                                                            <h6 class="mb-0">Address/Apartment</h6>
                                                        </div>
                                                        <div class="col-sm-8 text-secondary">
                                                            <?php echo $data['AddressLine1'] . ', ' . $data['AddressLine2'] . ', ' . $data['AddressLine3'] . ', ' . $data['AddressLine4']; ?>
                                                        </div>
                                                    </div>
                                                    <hr>
                                                    <div class="row">
                                                        <div class="col-sm-4">
                                                            <h6 class="mb-0">Dublin</h6>
                                                        </div>
                                                        <div class="col-sm-8 text-secondary">
                                                            <?php echo $data['AddressLine5']; ?>
                                                        </div>
                                                    </div>
                                                    <hr>
                                                    <div class="row">
                                                        <div class="col-sm-4">
                                                            <h6 class="mb-0">Eircode</h6>
                                                        </div>
                                                        <div class="col-sm-8 text-secondary">
                                                            <?php echo $data['Eircode']; ?>
                                                        </div>
                                                    </div>
                                                    <hr>
                                                    <div class="row">
                                                        <div class="col-sm-4">
                                                            <h6 class="mb-0">County</h6>
                                                        </div>
                                                        <div class="col-sm-8 text-secondary">
                                                            <?php echo $data['County']; ?>
                                                        </div>
                                                    </div>
                                                    <hr>
                                                    <div class="row">
                                                        <div class="col-sm-4">
                                                            <h6 class="mb-0">Number of Bedrooms Registered</h6>
                                                        </div>
                                                        <div class="col-sm-8 text-secondary">
                                                            <?php echo $data['NoOfBedrooms']; ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php } ?>