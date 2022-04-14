<?php
//Load config
require "features/functions_prospect.php";
require "features/functions_messages.php";

//Load variable key into hash
$hash = $_GET['key'];

//Create the profile query in case of he've been created
if (getProspectData($hash, 'hash') === null && getMessage('message_hash', $hash, 'message_sender_name') !== null) {
    insertProspectDataSafe('hash', $hash, 's');
}



if (isset($_POST['save']) | isset($_POST['proceed'])) {
    if ($_POST['prospectName'] != getProspectData($hash, 'prospect_full_name')) {
        setProspectDataSafe($hash, 'prospect_full_name', $_POST['prospectName'], 'ss');
    }
    if ($_POST['country_of_birth'] != getProspectData($hash, 'prospect_cob')) {
        setProspectDataSafe($hash, 'prospect_cob', $_POST['country_of_birth'], 'ss');
    }
    if ($_POST['dateOfBirth'] != getProspectData($hash, 'prospect_dob')) {
        setProspectDataSafe($hash, 'prospect_dob', $_POST['dateOfBirth'], 'ss');
    }
    if ($_POST['phone'] != getProspectData($hash, 'prospect_phone')) {
        setProspectDataSafe($hash, 'prospect_phone', $_POST['phone'], 'ss');
    }
    if ($_POST['expectedMovein'] != getProspectData($hash, 'prospect_expectedMovein')) {
        setProspectDataSafe($hash, 'prospect_expectedMovein', $_POST['expectedMovein'], 'ss');
    }
    if ($_POST['employement_Sector'] != getProspectData($hash, 'prospect_sector')) {
        setProspectDataSafe($hash, 'prospect_sector', $_POST['employement_Sector'], 'ss');
    }
    if ($_POST['employer'] != getProspectData($hash, 'prospect_employer')) {
        setProspectDataSafe($hash, 'prospect_employer', $_POST['employer'], 'ss');
    }
    if ($_POST['job_title'] != getProspectData($hash, 'prospect_job_title')) {
        setProspectDataSafe($hash, 'prospect_job_title', $_POST['job_title'], 'ss');
    }
    if ($_POST['occupants'] != getProspectData($hash, 'prospect_occupants')) {
        setProspectDataSafe($hash, 'prospect_occupants', $_POST['occupants'], 'ss');
    }
    if ($_POST['occupants_over18'] != getProspectData($hash, 'prospect_occupants_over18')) {
        setProspectDataSafe($hash, 'prospect_occupants_over18', $_POST['occupants_over18'], 'ss');
    }
    if ($_POST['extra'] != getProspectData($hash, 'prospect_extra')) {
        setProspectDataSafe($hash, 'prospect_extra', $_POST['extra'], 'ss');
    }
}

if (isset($_POST['upload'])) {
    //require "features/upload.php";
    require "features/functions_upload.php";
    if ($_FILES['ID']['name'] != null) {
        //If the prospect already uploaded a file, delete it, upload a new one and update the database
        if (getProspectData($hash, 'prospect_attach_id') != null) {
            unlink('features/uploads/' . getProspectData($hash, 'prospect_attach_id') . '');
            $fileIDName = uploadFile($_FILES['ID'], $hash, 'ID');
            setProspectDataSafe($hash, 'prospect_attach_id', $fileIDName, 'ss');
        } else {
            $fileIDName = uploadFile($_FILES['ID'], $hash, 'ID');
            setProspectDataSafe($hash, 'prospect_attach_id', $fileIDName, 'ss');
        }
    }
    if ($_FILES['applicantProofOfPayment1']['name'] != null) {
        if (getProspectData($hash, 'prospect_attach_proofpayment1') != null) {
            unlink('features/uploads/' . getProspectData($hash, 'prospect_attach_proofpayment1') . '');
            $fileIDName = uploadFile($_FILES['applicantProofOfPayment1'], $hash, 'ProofOfPayment1');
            setProspectDataSafe($hash, 'prospect_attach_proofpayment1', $fileIDName, 'ss');
        } else {
            $fileIDName = uploadFile($_FILES['applicantProofOfPayment1'], $hash, 'ProofOfPayment1');
            setProspectDataSafe($hash, 'prospect_attach_proofpayment1', $fileIDName, 'ss');
        }
    }
    if ($_FILES['applicantProofOfPayment2']['name'] != null) {
        if (getProspectData($hash, 'prospect_attach_proofpayment2') != null) {
            unlink('features/uploads/' . getProspectData($hash, 'prospect_attach_proofpayment2') . '');
            $fileIDName = uploadFile($_FILES['applicantProofOfPayment2'], $hash, 'ProofOfPayment2');
            setProspectDataSafe($hash, 'prospect_attach_proofpayment2', $fileIDName, 'ss');
        } else {
            $fileIDName = uploadFile($_FILES['applicantProofOfPayment2'], $hash, 'ProofOfPayment2');
            setProspectDataSafe($hash, 'prospect_attach_proofpayment2', $fileIDName, 'ss');
        }
    }
    if ($_FILES['applicantProofOfPayment3']['name'] != null) {
        if (getProspectData($hash, 'prospect_attach_proofpayment3') != null) {
            unlink('features/uploads/' . getProspectData($hash, 'prospect_attach_proofpayment3') . '');
            $fileIDName = uploadFile($_FILES['applicantProofOfPayment3'], $hash, 'ProofOfPayment3');
            setProspectDataSafe($hash, 'prospect_attach_proofpayment3', $fileIDName, 'ss');
        } else {
            $fileIDName = uploadFile($_FILES['applicantProofOfPayment3'], $hash, 'ProofOfPayment3');
            setProspectDataSafe($hash, 'prospect_attach_proofpayment3', $fileIDName, 'ss');
        }
    }
    if ($_FILES['applicantProofOfPayment4']['name'] != null) {
        if (getProspectData($hash, 'prospect_attach_proofpayment4') != null) {
            unlink('features/uploads/' . getProspectData($hash, 'prospect_attach_proofpayment4') . '');
            $fileIDName = uploadFile($_FILES['applicantProofOfPayment4'], $hash, 'ProofOfPayment4');
            setProspectDataSafe($hash, 'prospect_attach_proofpayment4', $fileIDName, 'ss');
        } else {
            $fileIDName = uploadFile($_FILES['applicantProofOfPayment4'], $hash, 'ProofOfPayment4');
            setProspectDataSafe($hash, 'prospect_attach_proofpayment4', $fileIDName, 'ss');
        }
    }
};

if (isset($_POST['removeID'])) {
    unlink('features/uploads/' . getProspectData($hash, 'prospect_attach_id') . '');
    setProspectDataSafe($hash, 'prospect_attach_id', '', 'ss');
};
if (isset($_POST['removeProofOfPayment1'])) {
    unlink('features/uploads/' . getProspectData($hash, 'prospect_attach_proofpayment1') . '');
    setProspectDataSafe($hash, 'prospect_attach_proofpayment1', '', 'ss');
};
if (isset($_POST['removeProofOfPayment2'])) {
    unlink('features/uploads/' . getProspectData($hash, 'prospect_attach_proofpayment2') . '');
    setProspectDataSafe($hash, 'prospect_attach_proofpayment2', '', 'ss');
};
if (isset($_POST['removeProofOfPayment3'])) {
    unlink('features/uploads/' . getProspectData($hash, 'prospect_attach_proofpayment3') . '');
    setProspectDataSafe($hash, 'prospect_attach_proofpayment3', '', 'ss');
};
if (isset($_POST['removeProofOfPayment4'])) {
    unlink('features/uploads/' . getProspectData($hash, 'prospect_attach_proofpayment4') . '');
    setProspectDataSafe($hash, 'prospect_attach_proofpayment4', '', 'ss');
};

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Real Enquiries - Tenants Data Registration Form</title>
    <meta content="Customer Relationship Management for Real State Agents - Privacy Policy">
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css?h=093230e10e41709a7a3d6ba7f3b3b116">
    <link type="text/css" rel="stylesheet" href="https://cdn01.jotfor.ms/themes/CSS/5e6b428acc8c4e222d1beb91.css?themeRevisionID=5eb3b4ae85bd2e1e2966db96" />
</head>

<body class="bg-gradient-primary">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg">
                <div class="card shadow-lg o-hidden border-0 my-5">
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="col-lg d-none d-lg-flex">
                                <div class="flex-grow-1 bg-login-image" style="background-image: url(assets/img/spacejoy-unsplash.webp);">
                                </div>
                            </div>
                            <div class="col-lg-6">

                                <?php //Stop the page if the hash is not valid
                                if (getMessage('message_hash', $hash, 'message_sender_name') === null) {
                                    echo '<div class="p-5"><div class="alert alert-danger" role="alert"><strong>Error!</strong> The link you are trying to access is not valid.</div></div>';
                                    die;
                                } ?>

                                <?php if (!isset($_POST['proceed']) && !isset($_POST['upload']) && !isset($_POST['start'])) { ?>

                                    <div class="p-5">
                                        <form action="<?php echo htmlspecialchars($_SERVER[" PHP_SELF "]); ?>" method="POST">
                                            <div class="text-center">
                                                <h1 class="text-dark mb-4">On-line Application</h1>
                                            </div>
                                            <ul class="form-section page-section">
                                                <div id="subHeader_1" class="form-subHeader">
                                                    <p>Welcome to your online application <?php echo getMessage('message_hash', $hash, 'message_sender_name'); ?>.</p>
                                                    <p>Your application has been started with success.</p>
                                                </div>
                                            </ul>
                                            <li class="form-line" data-type="control_button" id="id_2">
                                                <div id="cid_2" class="form-input-wide" data-layout="full">
                                                    <div data-align="left" class="form-buttons-wrapper form-buttons-left   jsTest-button-wrapperField">
                                                        <button type="submit" class="form-submit-button submit-button jf-form-buttons jsTest-submitField" name="start">
                                                            Start
                                                        </button>
                                                    </div>
                                                </div>
                                            </li>
                                        </form>
                                    </div>

                                <?php } elseif (!isset($_POST['upload']) && isset($_POST['start'])) { ?>

                                    <div class="p-5">
                                        <div class="text-center">
                                            <h1 class="text-dark mb-4">Prospect Application Area</h1>
                                        </div>
                                        <form action="<?php echo htmlspecialchars($_SERVER[" PHP_SELF "]); ?>" method="POST">
                                            <ul class="form-section page-section">
                                                <div id="subHeader_1" class="form-subHeader">
                                                    Welcome to your on-line application
                                                    <?php echo getProspectData($hash, 'prospect_full_name'); ?>, here you can add extra information to support a quick and positive outcome.
                                                </div>
                                                <li class="form-line jf-required" data-type="control_fullname" id="id_3">
                                                    <label class="form-label form-label-top form-label-auto" id="label_3" for="first_3">
                                                        Full Name
                                                        <span class="form-required">
                                                            *
                                                        </span>
                                                    </label>
                                                    <div id="cid_3" class="form-input-wide jf-required" data-layout="full">
                                                        <div data-wrapper-react="true">
                                                            <span class="form-sub-label-container" style="vertical-align:top" data-input-type="first">
                                                                <input type="text" name="prospectName" class="form-textbox validate[required]" autoComplete="section-input_3 given-name" size="10" value="<?php echo getProspectData($hash, 'prospect_full_name') ?>" aria-labelledby="label_3 sublabel_3_first" required="" />
                                                            </span>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li class="form-line form-line-column form-col-1 jf-required" data-type="control_dropdown" id="id_15">
                                                    <label class="form-label form-label-top" id="label_15" for="input_15">
                                                        Country of Birth
                                                        <span class="form-required">
                                                            *
                                                        </span>
                                                    </label>
                                                    <div id="cid_15" class="form-input-wide jf-required" data-layout="half">
                                                        <select class="form-dropdown validate[required]" name="country_of_birth" style="width:310px" data-component="dropdown" required="">
                                                            <option value="<?php echo getProspectData($hash, 'prospect_cob'); ?>">
                                                                <?php if (getProspectData($hash, 'prospect_cob') != null) {
                                                                    echo getProspectData($hash, 'prospect_cob');
                                                                } else echo 'Select a Country'; ?></option>
                                                            <option value="China">China</option>
                                                            <option value="India">India</option>
                                                            <option value="United States">United States</option>
                                                            <option value="Indonesia">Indonesia</option>
                                                            <option value="Brazil">Brazil</option>
                                                            <option value="Pakistan">Pakistan</option>
                                                            <option value="Nigeria">Nigeria</option>
                                                            <option value="Bangladesh">Bangladesh</option>
                                                            <option value="Russia">Russia</option>
                                                            <option value="Japan">Japan</option>
                                                            <option value="Mexico">Mexico</option>
                                                            <option value="Philippines">Philippines</option>
                                                            <option value="Vietnam">Vietnam</option>
                                                            <option value="Ethiopia">Ethiopia</option>
                                                            <option value="Egypt">Egypt</option>
                                                            <option value="Germany">Germany</option>
                                                            <option value="Iran">Iran</option>
                                                            <option value="Turkey">Turkey</option>
                                                            <option value="Democratic Republic of the Congo">Democratic
                                                                Republic of the Congo</option>
                                                            <option value="Thailand">Thailand</option>
                                                            <option value="France">France</option>
                                                            <option value="United Kingdom">United Kingdom</option>
                                                            <option value="Italy">Italy</option>
                                                            <option value="Burma">Burma</option>
                                                            <option value="South Africa">South Africa</option>
                                                            <option value="South Korea">South Korea</option>
                                                            <option value="Colombia">Colombia</option>
                                                            <option value="Spain">Spain</option>
                                                            <option value="Ukraine">Ukraine</option>
                                                            <option value="Tanzania">Tanzania</option>
                                                            <option value="Kenya">Kenya</option>
                                                            <option value="Argentina">Argentina</option>
                                                            <option value="Algeria">Algeria</option>
                                                            <option value="Poland">Poland</option>
                                                            <option value="Sudan">Sudan</option>
                                                            <option value="Uganda">Uganda</option>
                                                            <option value="Canada">Canada</option>
                                                            <option value="Iraq">Iraq</option>
                                                            <option value="Morocco">Morocco</option>
                                                            <option value="Peru">Peru</option>
                                                            <option value="Uzbekistan">Uzbekistan</option>
                                                            <option value="Saudi Arabia">Saudi Arabia</option>
                                                            <option value="Malaysia">Malaysia</option>
                                                            <option value="Venezuela">Venezuela</option>
                                                            <option value="Nepal">Nepal</option>
                                                            <option value="Afghanistan">Afghanistan</option>
                                                            <option value="Yemen">Yemen</option>
                                                            <option value="North Korea">North Korea</option>
                                                            <option value="Ghana">Ghana</option>
                                                            <option value="Mozambique">Mozambique</option>
                                                            <option value="Taiwan">Taiwan</option>
                                                            <option value="Australia">Australia</option>
                                                            <option value="Ivory Coast">Ivory Coast</option>
                                                            <option value="Syria">Syria</option>
                                                            <option value="Madagascar">Madagascar</option>
                                                            <option value="Angola">Angola</option>
                                                            <option value="Cameroon">Cameroon</option>
                                                            <option value="Sri Lanka">Sri Lanka</option>
                                                            <option value="Romania">Romania</option>
                                                            <option value="Burkina Faso">Burkina Faso</option>
                                                            <option value="Niger">Niger</option>
                                                            <option value="Kazakhstan">Kazakhstan</option>
                                                            <option value="Netherlands">Netherlands</option>
                                                            <option value="Chile">Chile</option>
                                                            <option value="Malawi">Malawi</option>
                                                            <option value="Ecuador">Ecuador</option>
                                                            <option value="Guatemala">Guatemala</option>
                                                            <option value="Mali">Mali</option>
                                                            <option value="Cambodia">Cambodia</option>
                                                            <option value="Senegal">Senegal</option>
                                                            <option value="Zambia">Zambia</option>
                                                            <option value="Zimbabwe">Zimbabwe</option>
                                                            <option value="Chad">Chad</option>
                                                            <option value="South Sudan">South Sudan</option>
                                                            <option value="Belgium">Belgium</option>
                                                            <option value="Cuba">Cuba</option>
                                                            <option value="Tunisia">Tunisia</option>
                                                            <option value="Guinea">Guinea</option>
                                                            <option value="Greece">Greece</option>
                                                            <option value="Portugal">Portugal</option>
                                                            <option value="Rwanda">Rwanda</option>
                                                            <option value="Czech Republic">Czech Republic</option>
                                                            <option value="Somalia">Somalia</option>
                                                            <option value="Haiti">Haiti</option>
                                                            <option value="Benin">Benin</option>
                                                            <option value="Burundi">Burundi</option>
                                                            <option value="Bolivia">Bolivia</option>
                                                            <option value="Hungary">Hungary</option>
                                                            <option value="Sweden">Sweden</option>
                                                            <option value="Belarus">Belarus</option>
                                                            <option value="Dominican Republic">Dominican Republic
                                                            </option>
                                                            <option value="Azerbaijan">Azerbaijan</option>
                                                            <option value="Honduras">Honduras</option>
                                                            <option value="Austria">Austria</option>
                                                            <option value="United Arab Emirates">United Arab Emirates
                                                            </option>
                                                            <option value="Israel">Israel</option>
                                                            <option value="Switzerland">Switzerland</option>
                                                            <option value="Tajikistan">Tajikistan</option>
                                                            <option value="Bulgaria">Bulgaria</option>
                                                            <option value="Hong Kong (China)">Hong Kong (China)</option>
                                                            <option value="Serbia">Serbia</option>
                                                            <option value="Papua New Guinea">Papua New Guinea</option>
                                                            <option value="Paraguay">Paraguay</option>
                                                            <option value="Laos">Laos</option>
                                                            <option value="Jordan">Jordan</option>
                                                            <option value="El Salvador">El Salvador</option>
                                                            <option value="Eritrea">Eritrea</option>
                                                            <option value="Libya">Libya</option>
                                                            <option value="Togo">Togo</option>
                                                            <option value="Sierra Leone">Sierra Leone</option>
                                                            <option value="Nicaragua">Nicaragua</option>
                                                            <option value="Kyrgyzstan">Kyrgyzstan</option>
                                                            <option value="Denmark">Denmark</option>
                                                            <option value="Finland">Finland</option>
                                                            <option value="Slovakia">Slovakia</option>
                                                            <option value="Singapore">Singapore</option>
                                                            <option value="Turkmenistan">Turkmenistan</option>
                                                            <option value="Norway">Norway</option>
                                                            <option value="Lebanon">Lebanon</option>
                                                            <option value="Costa Rica">Costa Rica</option>
                                                            <option value="Central African Republic">Central African
                                                                Republic</option>
                                                            <option value="Ireland">Ireland</option>
                                                            <option value="Georgia">Georgia</option>
                                                            <option value="New Zealand">New Zealand</option>
                                                            <option value="Republic of the Congo">Republic of the Congo
                                                            </option>
                                                            <option value="Palestine">Palestine</option>
                                                            <option value="Liberia">Liberia</option>
                                                            <option value="Croatia">Croatia</option>
                                                            <option value="Oman">Oman</option>
                                                            <option value="Bosnia and Herzegovina">Bosnia and
                                                                Herzegovina</option>
                                                            <option value="Puerto Rico">Puerto Rico</option>
                                                            <option value="Kuwait">Kuwait</option>
                                                            <option value="Moldov">Moldov</option>
                                                            <option value="Mauritania">Mauritania</option>
                                                            <option value="Panama">Panama</option>
                                                            <option value="Uruguay">Uruguay</option>
                                                            <option value="Armenia">Armenia</option>
                                                            <option value="Lithuania">Lithuania</option>
                                                            <option value="Albania">Albania</option>
                                                            <option value="Mongolia">Mongolia</option>
                                                            <option value="Jamaica">Jamaica</option>
                                                            <option value="Namibia">Namibia</option>
                                                            <option value="Lesotho">Lesotho</option>
                                                            <option value="Qatar">Qatar</option>
                                                            <option value="Macedonia">Macedonia</option>
                                                            <option value="Slovenia">Slovenia</option>
                                                            <option value="Botswana">Botswana</option>
                                                            <option value="Latvia">Latvia</option>
                                                            <option value="Gambia">Gambia</option>
                                                            <option value="Kosovo">Kosovo</option>
                                                            <option value="Guinea-Bissau">Guinea-Bissau</option>
                                                            <option value="Gabon">Gabon</option>
                                                            <option value="Equatorial Guinea">Equatorial Guinea</option>
                                                            <option value="Trinidad and Tobago">Trinidad and Tobago
                                                            </option>
                                                            <option value="Estonia">Estonia</option>
                                                            <option value="Mauritius">Mauritius</option>
                                                            <option value="Swaziland">Swaziland</option>
                                                            <option value="Bahrain">Bahrain</option>
                                                            <option value="Timor-Leste">Timor-Leste</option>
                                                            <option value="Djibouti">Djibouti</option>
                                                            <option value="Cyprus">Cyprus</option>
                                                            <option value="Fiji">Fiji</option>
                                                            <option value="Reunion (France)">Reunion (France)</option>
                                                            <option value="Guyana">Guyana</option>
                                                            <option value="Comoros">Comoros</option>
                                                            <option value="Bhutan">Bhutan</option>
                                                            <option value="Montenegro">Montenegro</option>
                                                            <option value="Macau (China)">Macau (China)</option>
                                                            <option value="Solomon Islands">Solomon Islands</option>
                                                            <option value="Western Sahara">Western Sahara</option>
                                                            <option value="Luxembourg">Luxembourg</option>
                                                            <option value="Suriname">Suriname</option>
                                                            <option value="Cape Verde">Cape Verde</option>
                                                            <option value="Malta">Malta</option>
                                                            <option value="Guadeloupe (France)">Guadeloupe (France)
                                                            </option>
                                                            <option value="Martinique (France)">Martinique (France)
                                                            </option>
                                                            <option value="Brunei">Brunei</option>
                                                            <option value="Bahamas">Bahamas</option>
                                                            <option value="Iceland">Iceland</option>
                                                            <option value="Maldives">Maldives</option>
                                                            <option value="Belize">Belize</option>
                                                            <option value="Barbados">Barbados</option>
                                                            <option value="French Polynesia (France)">French Polynesia
                                                                (France)</option>
                                                            <option value="Vanuatu">Vanuatu</option>
                                                            <option value="New Caledonia (France)">New Caledonia
                                                                (France)</option>
                                                            <option value="French Guiana (France)">French Guiana
                                                                (France)</option>
                                                            <option value="Mayotte (France)">Mayotte (France)</option>
                                                            <option value="Samoa">Samoa</option>
                                                            <option value="Sao Tom and Principe">Sao Tom and Principe
                                                            </option>
                                                            <option value="Saint Lucia">Saint Lucia</option>
                                                            <option value="Guam (USA)">Guam (USA)</option>
                                                            <option value="Curacao (Netherlands)">Curacao (Netherlands)
                                                            </option>
                                                            <option value="Saint Vincent and the Grenadines">Saint
                                                                Vincent and the Grenadines</option>
                                                            <option value="Kiribati">Kiribati</option>
                                                            <option value="United States Virgin Islands (USA)">United
                                                                States Virgin Islands (USA)</option>
                                                            <option value="Grenada">Grenada</option>
                                                            <option value="Tonga">Tonga</option>
                                                            <option value="Aruba (Netherlands)">Aruba (Netherlands)
                                                            </option>
                                                            <option value="Federated States of Micronesia">Federated
                                                                States of Micronesia</option>
                                                            <option value="Jersey (UK)">Jersey (UK)</option>
                                                            <option value="Seychelles">Seychelles</option>
                                                            <option value="Antigua and Barbuda">Antigua and Barbuda
                                                            </option>
                                                            <option value="Isle of Man (UK)">Isle of Man (UK)</option>
                                                            <option value="Andorra">Andorra</option>
                                                            <option value="Dominica">Dominica</option>
                                                            <option value="Bermuda (UK)">Bermuda (UK)</option>
                                                            <option value="Guernsey (UK)">Guernsey (UK)</option>
                                                            <option value="Greenland (Denmark)">Greenland (Denmark)
                                                            </option>
                                                            <option value="Marshall Islands">Marshall Islands</option>
                                                            <option value="American Samoa (USA)">American Samoa (USA)
                                                            </option>
                                                            <option value="Cayman Islands (UK)">Cayman Islands (UK)
                                                            </option>
                                                            <option value="Saint Kitts and Nevis">Saint Kitts and Nevis
                                                            </option>
                                                            <option value="Northern Mariana Islands (USA)">Northern
                                                                Mariana Islands (USA)</option>
                                                            <option value="Faroe Islands (Denmark)">Faroe Islands
                                                                (Denmark)</option>
                                                            <option value="Sint Maarten (Netherlands)">Sint Maarten
                                                                (Netherlands)</option>
                                                            <option value="Saint Martin (France)">Saint Martin (France)
                                                            </option>
                                                            <option value="Liechtenstein">Liechtenstein</option>
                                                            <option value="Monaco">Monaco</option>
                                                            <option value="San Marino">San Marino</option>
                                                            <option value="Turks and Caicos Islands (UK)">Turks and
                                                                Caicos Islands (UK)</option>
                                                            <option value="Gibraltar (UK)">Gibraltar (UK)</option>
                                                            <option value="British Virgin Islands (UK)">British Virgin
                                                                Islands (UK)</option>
                                                            <option value="Aland Islands (Finland)">Aland Islands
                                                                (Finland)</option>
                                                            <option value="Caribbean Netherlands (Netherlands)">
                                                                Caribbean Netherlands (Netherlands)</option>
                                                            <option value="Palau">Palau</option>
                                                            <option value="Cook Islands (NZ)">Cook Islands (NZ)</option>
                                                            <option value="Anguilla (UK)">Anguilla (UK)</option>
                                                            <option value="Wallis and Futuna (France)">Wallis and Futuna
                                                                (France)</option>
                                                            <option value="Tuvalu">Tuvalu</option>
                                                            <option value="Nauru">Nauru</option>
                                                            <option value="Saint Barthelemy (France)">Saint Barthelemy
                                                                (France)</option>
                                                            <option value="Saint Pierre and Miquelon (France)">Saint
                                                                Pierre and Miquelon (France)</option>
                                                            <option value="Montserrat (UK)">Montserrat (UK)</option>
                                                            <option value="Saint Helena, Ascension and Tristan da Cunha (UK)">
                                                                Saint Helena, Ascension and Tristan da Cunha (UK)
                                                            </option>
                                                            <option value="Svalbard and Jan Mayen (Norway)">Svalbard and
                                                                Jan Mayen (Norway)</option>
                                                            <option value="Falkland Islands (UK)">Falkland Islands (UK)
                                                            </option>
                                                            <option value="Norfolk Island (Australia)">Norfolk Island
                                                                (Australia)</option>
                                                            <option value="Christmas Island (Australia)">Christmas
                                                                Island (Australia)</option>
                                                            <option value="Niue (NZ)">Niue (NZ)</option>
                                                            <option value="Tokelau (NZ)">Tokelau (NZ)</option>
                                                            <option value="Vatican City">Vatican City</option>
                                                            <option value="Cocos (Keeling) Islands (Australia)">Cocos
                                                                (Keeling) Islands (Australia)</option>
                                                            <option value="Pitcairn Islands (UK)">Pitcairn Islands (UK)
                                                            </option>
                                                        </select>
                                                    </div>
                                                </li>
                                                <li class="form-line form-line-column form-col-2 jf-required" data-type="control_datetime" id="id_16">
                                                    <label class="form-label form-label-top" id="label_16" for="lite_mode_16">
                                                        Date of Birth
                                                        <span class="form-required">
                                                            *
                                                        </span>
                                                    </label>
                                                    <div id="cid_16" class="form-input-wide jf-required" data-layout="half">
                                                        <div data-wrapper-react="true">
                                                            <span class="form-sub-label-container" style="vertical-align:top">
                                                                <input name="dateOfBirth" type="date" class="form-textbox validate[required, limitDate, validateLiteDate]" id="lite_mode_16" size="12" data-maxlength="12" maxLength="12" data-age="" value="<?php echo getProspectData($hash, 'prospect_dob') ?>" required="" data-format="mmddyyyy" data-seperator="-" placeholder="MM-DD-YYYY" autoComplete="section-input_16 off" aria-labelledby="label_16 sublabel_16_litemode" />
                                                            </span>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li class="form-line form-line-column form-col-3 jf-required" data-type="control_phone" id="id_5">
                                                    <label class="form-label form-label-top" id="label_5" for="input_5_full">
                                                        Phone Number
                                                        <span class="form-required">
                                                            *
                                                        </span>
                                                    </label>
                                                    <div id="cid_5" class="form-input-wide jf-required" data-layout="half">
                                                        <span class="form-sub-label-container" style="vertical-align:top">
                                                            <input name="phone" type="tel" data-type="mask-number" class="mask-phone-number form-textbox validate[required, Fill Mask]" data-defaultvalue="" autoComplete="section-input_5 tel-national" style="width:310px" data-masked="true" value="<?php echo getProspectData($hash, 'prospect_phone'); ?>" placeholder="(000) 000-0000" data-component="phone" aria-labelledby="label_5" required="" />
                                                            <label class="form-sub-label is-empty" for="input_5_full" id="sublabel_5_masked" style="min-height:13px" aria-hidden="false"> </label>
                                                        </span>
                                                    </div>
                                                </li>
                                                <li class="form-line form-line-column form-col-2 jf-required" data-type="control_datetime" id="id_16">
                                                    <label class="form-label form-label-top" id="label_16" for="lite_mode_16">
                                                        Expected Move-in
                                                        <span class="form-required">
                                                            *
                                                        </span>
                                                    </label>
                                                    <div id="cid_16" class="form-input-wide jf-required" data-layout="half">
                                                        <div data-wrapper-react="true">
                                                            <span class="form-sub-label-container" style="vertical-align:top">
                                                                <input name="expectedMovein" type="date" class="form-textbox validate[required, limitDate, validateLiteDate]" id="lite_mode_16" size="12" data-maxlength="12" maxLength="12" data-age="" value="<?php echo getProspectData($hash, 'prospect_expectedMovein'); ?>" required="" data-format="mmddyyyy" data-seperator="-" placeholder="MM-DD-YYYY" autoComplete="section-input_16 off" aria-labelledby="label_16 sublabel_16_litemode" />
                                                            </span>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li id="cid_18" class="form-input-wide" data-type="control_head">
                                                    <div class="form-header-group  header-default">
                                                        <div class="header-text httal htvam">
                                                            <h2 id="header_18" class="form-header" data-component="header">
                                                                Employment Status
                                                            </h2>
                                                            <div id="subHeader_18" class="form-subHeader">
                                                                Give us extra information about your financial status
                                                            </div>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li class="form-line jf-required" data-type="control_dropdown" id="id_21">
                                                    <label class="form-label form-label-top form-label-auto" id="label_21" for="input_21">
                                                        Sector
                                                        <span class="form-required">
                                                            *
                                                        </span>
                                                    </label>
                                                    <div id="cid_21" class="form-input-wide jf-required" data-layout="half">
                                                        <select class="form-dropdown validate[required]" name="employement_Sector" style="width:310px" data-component="dropdown" required="">
                                                            <option value="<?php echo getProspectData($hash, 'prospect_sector'); ?>">
                                                                <?php if (getProspectData($hash, 'prospect_sector') != null) {
                                                                    echo getProspectData($hash, 'prospect_sector');
                                                                } else echo 'Select a Sector'; ?></option>
                                                            <option value="Accounting">Accounting</option>
                                                            <option value="Airlines/Aviation">Airlines/Aviation</option>
                                                            <option value="Alternative Dispute Resolution">Alternative
                                                                Dispute Resolution</option>
                                                            <option value="Alternative Medicine">Alternative Medicine
                                                            </option>
                                                            <option value="Animation">Animation</option>
                                                            <option value="Apparel & Fashion">Apparel & Fashion</option>
                                                            <option value="Architecture & Planning">Architecture &
                                                                Planning</option>
                                                            <option value="Arts and Crafts">Arts and Crafts</option>
                                                            <option value="Automotive">Automotive</option>
                                                            <option value="Aviation & Aerospace">Aviation & Aerospace
                                                            </option>
                                                            <option value="Banking">Banking</option>
                                                            <option value="Biotechnology">Biotechnology</option>
                                                            <option value="Broadcast Media">Broadcast Media</option>
                                                            <option value="Building Materials">Building Materials
                                                            </option>
                                                            <option value="Business Supplies and Equipment">Business
                                                                Supplies and Equipment</option>
                                                            <option value="Capital Markets">Capital Markets</option>
                                                            <option value="Chemicals">Chemicals</option>
                                                            <option value="Civic & Social Organization">Civic & Social
                                                                Organization</option>
                                                            <option value="Civil Engineering">Civil Engineering</option>
                                                            <option value="Commercial Real Estate">Commercial Real
                                                                Estate</option>
                                                            <option value="Computer & Network Security">Computer &
                                                                Network Security</option>
                                                            <option value="Computer Games">Computer Games</option>
                                                            <option value="Computer Hardware">Computer Hardware</option>
                                                            <option value="Computer Networking">Computer Networking
                                                            </option>
                                                            <option value="Computer Software">Computer Software</option>
                                                            <option value="Construction">Construction</option>
                                                            <option value="Consumer Electronics">Consumer Electronics
                                                            </option>
                                                            <option value="Consumer Goods">Consumer Goods</option>
                                                            <option value="Consumer Services">Consumer Services</option>
                                                            <option value="Cosmetics">Cosmetics</option>
                                                            <option value="Dairy">Dairy</option>
                                                            <option value="Defense & Space">Defense & Space</option>
                                                            <option value="Design">Design</option>
                                                            <option value="Education Management">Education Management
                                                            </option>
                                                            <option value="E-Learning">E-Learning</option>
                                                            <option value="Electrical/Electronic Manufacturing">
                                                                Electrical/Electronic Manufacturing</option>
                                                            <option value="Entertainment">Entertainment</option>
                                                            <option value="Environmental Services">Environmental
                                                                Services</option>
                                                            <option value="Events Services">Events Services</option>
                                                            <option value="Executive Office">Executive Office</option>
                                                            <option value="Facilities Services">Facilities Services
                                                            </option>
                                                            <option value="Farming">Farming</option>
                                                            <option value="Financial Services">Financial Services
                                                            </option>
                                                            <option value="Fine Art">Fine Art</option>
                                                            <option value="Fishery">Fishery</option>
                                                            <option value="Food & Beverages">Food & Beverages</option>
                                                            <option value="Food Production">Food Production</option>
                                                            <option value="Fund-Raising">Fund-Raising</option>
                                                            <option value="Furniture">Furniture</option>
                                                            <option value="Gambling & Casinos">Gambling & Casinos
                                                            </option>
                                                            <option value="Glass, Ceramics & Concrete">Glass, Ceramics &
                                                                Concrete</option>
                                                            <option value="Government Administration">Government
                                                                Administration</option>
                                                            <option value="Government Relations">Government Relations
                                                            </option>
                                                            <option value="Graphic Design">Graphic Design</option>
                                                            <option value="Health, Wellness and Fitness">Health,
                                                                Wellness and Fitness</option>
                                                            <option value="Higher Education">Higher Education</option>
                                                            <option value="Hospital & Health Care">Hospital & Health
                                                                Care</option>
                                                            <option value="Hospitality">Hospitality</option>
                                                            <option value="Human Resources">Human Resources</option>
                                                            <option value="Import and Export">Import and Export</option>
                                                            <option value="Individual & Family Services">Individual &
                                                                Family Services</option>
                                                            <option value="Industrial Automation">Industrial Automation
                                                            </option>
                                                            <option value="Information Services">Information Services
                                                            </option>
                                                            <option value="Information Technology and Services">
                                                                Information Technology and Services</option>
                                                            <option value="Insurance">Insurance</option>
                                                            <option value="International Affairs">International Affairs
                                                            </option>
                                                            <option value="International Trade and Development">
                                                                International Trade and Development</option>
                                                            <option value="Internet">Internet</option>
                                                            <option value="Investment Banking">Investment Banking
                                                            </option>
                                                            <option value="Investment Management">Investment Management
                                                            </option>
                                                            <option value="Judiciary">Judiciary</option>
                                                            <option value="Law Enforcement">Law Enforcement</option>
                                                            <option value="Law Practice">Law Practice</option>
                                                            <option value="Legal Services">Legal Services</option>
                                                            <option value="Legislative Office">Legislative Office
                                                            </option>
                                                            <option value="Leisure, Travel & Tourism">Leisure, Travel &
                                                                Tourism</option>
                                                            <option value="Libraries">Libraries</option>
                                                            <option value="Logistics and Supply Chain">Logistics and
                                                                Supply Chain</option>
                                                            <option value="Luxury Goods & Jewelry">Luxury Goods &
                                                                Jewelry</option>
                                                            <option value="Machinery">Machinery</option>
                                                            <option value="Management Consulting">Management Consulting
                                                            </option>
                                                            <option value="Maritime">Maritime</option>
                                                            <option value="Marketing and Advertising">Marketing and
                                                                Advertising</option>
                                                            <option value="Market Research">Market Research</option>
                                                            <option value="Mechanical or Industrial Engineering">
                                                                Mechanical or Industrial Engineering</option>
                                                            <option value="Media Production">Media Production</option>
                                                            <option value="Medical Devices">Medical Devices</option>
                                                            <option value="Medical Practice">Medical Practice</option>
                                                            <option value="Mental Health Care">Mental Health Care
                                                            </option>
                                                            <option value="Military">Military</option>
                                                            <option value="Mining & Metals">Mining & Metals</option>
                                                            <option value="Motion Pictures and Film">Motion Pictures and
                                                                Film</option>
                                                            <option value="Museums and Institutions">Museums and
                                                                Institutions</option>
                                                            <option value="Music">Music</option>
                                                            <option value="Nanotechnology">Nanotechnology</option>
                                                            <option value="Newspapers">Newspapers</option>
                                                            <option value="Nonprofit Organization Management">Nonprofit
                                                                Organization Management</option>
                                                            <option value="Oil & Energy">Oil & Energy</option>
                                                            <option value="Online Media">Online Media</option>
                                                            <option value="Outsourcing/Offshoring">
                                                                Outsourcing/Offshoring</option>
                                                            <option value="Package/Freight Delivery">Package/Freight
                                                                Delivery</option>
                                                            <option value="Packaging and Containers">Packaging and
                                                                Containers</option>
                                                            <option value="Paper & Forest Products">Paper & Forest
                                                                Products</option>
                                                            <option value="Performing Arts">Performing Arts</option>
                                                            <option value="Pharmaceuticals">Pharmaceuticals</option>
                                                            <option value="Philanthropy">Philanthropy</option>
                                                            <option value="Photography">Photography</option>
                                                            <option value="Plastics">Plastics</option>
                                                            <option value="Political Organization">Political
                                                                Organization</option>
                                                            <option value="Primary/Secondary Education">
                                                                Primary/Secondary Education</option>
                                                            <option value="Printing">Printing</option>
                                                            <option value="Professional Training & Coaching">
                                                                Professional Training & Coaching</option>
                                                            <option value="Program Development">Program Development
                                                            </option>
                                                            <option value="Public Policy">Public Policy</option>
                                                            <option value="Public Relations and Communications">Public
                                                                Relations and Communications</option>
                                                            <option value="Public Safety">Public Safety</option>
                                                            <option value="Publishing">Publishing</option>
                                                            <option value="Railroad Manufacture">Railroad Manufacture
                                                            </option>
                                                            <option value="Ranching">Ranching</option>
                                                            <option value="Real Estate">Real Estate</option>
                                                            <option value="Recreational Facilities and Services">
                                                                Recreational Facilities and Services</option>
                                                            <option value="Religious Institutions">Religious
                                                                Institutions</option>
                                                            <option value="Renewables & Environment">Renewables &
                                                                Environment</option>
                                                            <option value="Research">Research</option>
                                                            <option value="Restaurants">Restaurants</option>
                                                            <option value="Retail">Retail</option>
                                                            <option value="Security and Investigations">Security and
                                                                Investigations</option>
                                                            <option value="Semiconductors">Semiconductors</option>
                                                            <option value="Shipbuilding">Shipbuilding</option>
                                                            <option value="Sporting Goods">Sporting Goods</option>
                                                            <option value="Sports">Sports</option>
                                                            <option value="Staffing and Recruiting">Staffing and
                                                                Recruiting</option>
                                                            <option value="Supermarkets">Supermarkets</option>
                                                            <option value="Telecommunications">Telecommunications
                                                            </option>
                                                            <option value="Textiles">Textiles</option>
                                                            <option value="Think Tanks">Think Tanks</option>
                                                            <option value="Tobacco">Tobacco</option>
                                                            <option value="Translation and Localization">Translation and
                                                                Localization</option>
                                                            <option value="Transportation/Trucking/Railroad">
                                                                Transportation/Trucking/Railroad </option>
                                                            <option value="Utilities">Utilities</option>
                                                            <option value="Venture Capital & Private Equity">Venture
                                                                Capital & Private Equity </option>
                                                            <option value="Veterinary">Veterinary</option>
                                                            <option value="Warehousing">Warehousing</option>
                                                            <option value="Wholesale">Wholesale</option>
                                                            <option value="Wine and Spirits">Wine and Spirits</option>
                                                            <option value="Wireless">Wireless</option>
                                                            <option value="Writing and Editing">Writing and Editing
                                                            </option>
                                                            <option value="NA">NA</option>
                                                            <option value="Empty">Empty</option>
                                                            <option value="Unknown">Unknown</option>
                                                        </select>
                                                    </div>
                                                </li>
                                                <li class="form-line form-line-column form-col-1 jf-required" data-type="control_textbox" id="id_20">
                                                    <label class="form-label form-label-top" id="label_20" for="input_20">
                                                        Employer
                                                        <span class="form-required">
                                                            *
                                                        </span>
                                                    </label>
                                                    <div id="cid_20" class="form-input-wide jf-required" data-layout="half">
                                                        <input type="text" name="employer" data-type="input-textbox" class="form-textbox validate[required]" data-defaultvalue="" style="width:310px" size="310" value="<?php echo getProspectData($hash, 'prospect_employer'); ?>" data-component="textbox" aria-labelledby="label_20" required="" />
                                                    </div>
                                                </li>
                                                <li class="form-line form-line-column form-col-2 jf-required" data-type="control_textbox" id="id_22">
                                                    <label class="form-label form-label-top" id="label_22" for="input_22">
                                                        Job Title
                                                        <span class="form-required">
                                                            *
                                                        </span>
                                                    </label>
                                                    <div id="cid_22" class="form-input-wide jf-required" data-layout="half">
                                                        <input type="text" name="job_title" data-type="input-textbox" class="form-textbox validate[required]" data-defaultvalue="" style="width:310px" size="310" value="<?php echo getProspectData($hash, 'prospect_job_title'); ?>" data-component="textbox" aria-labelledby="label_22" required="" />
                                                    </div>
                                                </li>
                                                <li id="cid_24" class="form-input-wide" data-type="control_head">
                                                    <div class="form-header-group  header-default">
                                                        <div class="header-text httal htvam">
                                                            <h2 id="header_24" class="form-header" data-component="header">
                                                                Occupants
                                                            </h2>
                                                            <div id="subHeader_18" class="form-subHeader">
                                                                How many occupants will live in this property?
                                                            </div>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li class="form-line form-line-column form-col-1 jf-required" data-type="control_number" id="id_25">
                                                    <label class="form-label form-label-top" id="label_25" for="input_25">
                                                        Total of Occupants
                                                        <span class="form-required">
                                                            *
                                                        </span>
                                                    </label>
                                                    <div id="cid_25" class="form-input-wide jf-required" data-layout="half">
                                                        <input type="number" name="occupants" data-type="input-number" class=" form-number-input form-textbox validate[required]" data-defaultvalue="" style="width:310px" size="310" value="<?php echo getProspectData($hash, 'prospect_occupants'); ?>" placeholder="ex: 2" data-component="number" aria-labelledby="label_25" required="" step="any" />
                                                    </div>
                                                </li>
                                                <li class="form-line form-line-column form-col-2" data-type="control_number" id="id_26">
                                                    <label class="form-label form-label-top" id="label_26" for="input_26">
                                                        Occupants over 18 years </label>
                                                    <div id="cid_26" class="form-input-wide" data-layout="half">
                                                        <input type="number" name="occupants_over18" data-type="input-number" class=" form-number-input form-textbox" data-defaultvalue="" style="width:310px" size="310" value="<?php echo getProspectData($hash, 'prospect_occupants_over18'); ?>" placeholder="ex: 1" data-component="number" aria-labelledby="label_26" step="any" />
                                                    </div>
                                                </li>
                                                <li class="form-line" data-type="control_textarea" id="id_11">
                                                    <label class="form-label form-label-top form-label-auto" id="label_11" for="input_11"> Extra info: </label>
                                                    <div id="cid_11" class="form-input-wide" data-layout="full">
                                                        <textarea id="input_11" name="extra" style="width:100%;height:150px" data-component="textarea" aria-labelledby="label_11"><?php echo getProspectData($hash, 'prospect_extra'); ?></textarea>
                                                    </div>
                                                </li>
                                                <li class="form-line" data-type="control_button" id="id_2">
                                                    <div id="cid_2" class="form-input-wide" data-layout="full">
                                                        <div data-align="left" class="form-buttons-wrapper form-buttons-left   jsTest-button-wrapperField">
                                                            <button type="submit" class="form-submit-button submit-button jf-form-buttons jsTest-submitField" name="save">
                                                                Save
                                                            </button>
                                                            <button type="submit" class="form-submit-button submit-button jf-form-buttons jsTest-submitField" name="proceed">
                                                                Continue
                                                            </button>
                                                        </div>
                                                    </div>
                                                </li>
                                            </ul>
                                        </form>
                                    </div>

                                <?php }; ?>

                                <?php if (isset($_POST['proceed'])) { ?>

                                    <div class="p-5">
                                        <div class="text-center">
                                            <h1 class="text-dark mb-4">Prospect Application Area</h1>
                                        </div>
                                        <form method="POST" enctype="multipart/form-data">
                                            <input type="hidden" name="id" value="<?php echo $hash; ?>">
                                            <input type="hidden" name="category" value="prospectID">
                                            <ul class="form-section page-section">
                                                <div id="subHeader_1" class="form-subHeader">
                                                    <p>In order to be considered for an apartment, you need to upload the following documents:</p>
                                                </div>
                                                <li id="cid_18" class="form-input-wide" data-type="control_head">
                                                    <div class="form-header-group  header-default">
                                                        <div class="header-text httal htvam">
                                                            <h2 id="header_18" class="form-header" data-component="header">
                                                                Upload ID
                                                            </h2>
                                                            <div id="subHeader_18" class="form-subHeader">
                                                                <p>Please upload an image of your ID (Passport, driver licence, national ID)</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li class="form-line jf-required">
                                                    <label class="form-label form-label-top form-label-auto">
                                                        ID
                                                        <span class="form-required">
                                                            *
                                                        </span>
                                                    </label>
                                                    <div id="cid_3" class="form-input-wide jf-required">
                                                        <div data-wrapper-react="true">
                                                            <span class="form-sub-label-container" style="vertical-align:top">

                                                                <div class="card">
                                                                    <div class="card-body">
                                                                        <div>
                                                                            <a href="features/uploads/<?php echo getProspectData($hash, 'prospect_attach_id'); ?>" download><?php echo getProspectData($hash, 'prospect_attach_id'); ?></a>
                                                                            <button type="submit" class="btn btn-danger btn-sm" name="removeID">X</button>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <input class="form-control" type="file" name="ID">
                                                                <label class="form-sub-label" style="min-height:13px" aria-hidden="false">The following files are accepted: 'jpg', 'jpeg', 'png', 'pdf', 'webp', 'docx', 'doc', 'xlsx', 'xls'.</label>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </li>


                                                <li id="cid_18" class="form-input-wide" data-type="control_head">
                                                    <div class="form-header-group  header-default">
                                                        <div class="header-text httal htvam">
                                                            <h2 id="header_18" class="form-header" data-component="header">
                                                                Upload proof of income
                                                            </h2>
                                                            <div id="subHeader_18" class="form-subHeader">
                                                                <p>Upload three months of recent bank statements (preferred), or three months of recent payslips as a proof of income</p>
                                                                <p>Applications without proof of sufficient income will not be approved.</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li class="form-line jf-required" data-type="control_fullname" id="id_3">
                                                    <label class="form-label form-label-top form-label-auto" id="label_3" for="first_3">
                                                        Proof of income
                                                        <span class="form-required">
                                                            *
                                                        </span>
                                                    </label>
                                                    <div id="cid_3" class="form-input-wide jf-required" data-layout="full">
                                                        <div data-wrapper-react="true">
                                                            <span class="form-sub-label-container" style="vertical-align:top" data-input-type="first">

                                                                <p>
                                                                <div class="card">
                                                                    <div class="card-body">
                                                                        <div>
                                                                            <a href="features/uploads/<?php echo getProspectData($hash, 'prospect_attach_proofpayment1'); ?>" download><?php echo getProspectData($hash, 'prospect_attach_proofpayment1'); ?></a>
                                                                            <button type="submit" class="btn btn-danger btn-sm" name="removeProofOfPayment1">X</button>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <input class="form-control" type="file" name="applicantProofOfPayment1">
                                                                </p>

                                                                <p>
                                                                <div class="card">
                                                                    <div class="card-body">
                                                                        <div>
                                                                            <a href="features/uploads/<?php echo getProspectData($hash, 'prospect_attach_proofpayment2'); ?>" download><?php echo getProspectData($hash, 'prospect_attach_proofpayment2'); ?></a>
                                                                            <button type="submit" class="btn btn-danger btn-sm" name="removeProofOfPayment2">X</button>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <input class="form-control" type="file" name="applicantProofOfPayment2">
                                                                </p>

                                                                <p>
                                                                <div class="card">
                                                                    <div class="card-body">
                                                                        <div>
                                                                            <a href="features/uploads/<?php echo getProspectData($hash, 'prospect_attach_proofpayment3'); ?>" download><?php echo getProspectData($hash, 'prospect_attach_proofpayment3'); ?></a>
                                                                            <button type="submit" class="btn btn-danger btn-sm" name="removeProofOfPayment3">X</button>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <input class="form-control" type="file" name="applicantProofOfPayment3">
                                                                </p>

                                                                <p>
                                                                <div class="card">
                                                                    <div class="card-body">
                                                                        <div>
                                                                            <a href="features/uploads/<?php echo getProspectData($hash, 'prospect_attach_proofpayment4'); ?>" download><?php echo getProspectData($hash, 'prospect_attach_proofpayment4'); ?></a>
                                                                            <button type="submit" class="btn btn-danger btn-sm" name="removeProofOfPayment4">X</button>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <input class="form-control" type="file" name="applicantProofOfPayment4">
                                                                </p>

                                                                <label class="form-sub-label" for="first_3" id="sublabel_3_first" style="min-height:13px" aria-hidden="false">The following files are accepted: 'jpg', 'jpeg', 'png', 'pdf', 'webp', 'docx', 'doc', 'xlsx', 'xls'.</label>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li class="form-line" data-type="control_button" id="id_2">
                                                    <div id="cid_2" class="form-input-wide" data-layout="full">
                                                        <div data-align="left" class="form-buttons-wrapper form-buttons-left   jsTest-button-wrapperField">
                                                            <button type="submit" class="form-submit-button submit-button jf-form-buttons jsTest-submitField" name="upload">
                                                                Upload files and Finish
                                                            </button>
                                                        </div>
                                                    </div>
                                                </li>
                                            </ul>
                                        </form>
                                    </div>

                                <?php }; ?>

                                <?php if (isset($_POST['upload'])) { ?>

                                    <div class="p-5">
                                        <div class="text-center">
                                            <h1 class="text-dark mb-4">On-line Application</h1>
                                        </div>
                                        <input type="hidden" name="id" value="<?php echo $hash; ?>">
                                        <input type="hidden" name="category" value="prospectID">
                                        <ul class="form-section page-section">
                                            <div id="subHeader_1" class="form-subHeader">
                                                <p>Thank you <?php echo getProspectData($hash, 'prospect_full_name'); ?>.</p>
                                                <p>Your online application has been submitted with succes!</p>
                                                <p>One of our agents will be in touch shortly on your email address or phone number.</p>
                                                <p>Please keep your application data updated and if you need you can come back using your personal link and edit or add more information.</p>
                                            </div>
                                        </ul>
                                    </div>

                                <?php }; ?>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

</body>

</html>
<style type="text/css">
    @media print {
        .form-section {
            display: inline !important
        }

        .form-pagebreak {
            display: none !important
        }

        .form-section-closed {
            height: auto !important
        }

        .page-section {
            position: initial !important
        }
    }

    /* Injected CSS Code */

    .form-label.form-label-auto {
        display: block;
        float: none;
        text-align: left;
        width: 100%;
    }

    /* Injected CSS Code */
</style>