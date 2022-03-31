<?php
//Load config
require "config/config.php";

//Load variable key into hash
if (!isset($_GET['key'])) {
    //do nothing
} else
    //carryon the key to hash
    $hash =   $_GET['key'];


//select all data from the mail_income sql
$query = "SELECT * FROM messages WHERE message_hash = '$hash'";
$result = mysqli_query($link, $query);

while ($row = mysqli_fetch_array($result)) {
    //Creates a loop to loop through results
    $messages_email = $row['messages_email'];
    $name = $row['message_sender_name'];
    $phone = $row['message_phone_number'];
    $property_code = $row['property_code'];
}


if (!empty(trim($_POST["action"]))) {
    //Prepare to inject the form:

    if (!empty(trim($_POST["full_name"]))) {
        $name = $link->real_escape_string(trim($_POST["full_name"]));
    }
    if (!empty(trim($_POST["country_of_birth"]))) {
        $country_of_birth = $link->real_escape_string(trim($_POST["country_of_birth"]));
    }
    $dateOfBirth = $link->real_escape_string(trim($_POST["dateOfBirth"]));
    $employement_Sector = $link->real_escape_string(trim($_POST["employement_Sector"]));
    $employer = $link->real_escape_string(trim($_POST["employer"]));
    $job_title = $link->real_escape_string(trim($_POST["job_title"]));
    if (!empty(trim($_POST["phone"]))) {
        $phone = $link->real_escape_string(trim($_POST["phone"]));
    }
    $occupants = $link->real_escape_string(trim($_POST["occupants"]));
    $occupants_over18 = $link->real_escape_string(trim($_POST["occupants_over18"]));
    $extra = $link->real_escape_string($_POST['extra']);

    $query = "INSERT INTO prospect (prospect_property_code, prospect_full_name, prospect_cob , prospect_dob, prospect_sector , prospect_employer, 
        prospect_job_title, prospect_phone, prospect_occupants, prospect_email, hash,prospect_occupants_over18 , prospect_extra)
        VALUES
        ('$property_code', '$name','$country_of_birth','$dateOfBirth', '$employement_Sector', '$employer',
        '$job_title', '$phone', '$occupants',  '$messages_email', '$hash','$occupants_over18','$extra');
        ";

    if ($link->query($query) === TRUE) {
        echo '<h1><span style="color: #ff0000;"><center>Profile updated with succes!</center></span></h1>';
        die;
    } else {
        echo "Error: " . $sql . "<br>" . $link->error;
    }
}
mysqli_close($link); //Make sure to close out the database connection
?>
<!DOCTYPE html>
<html>

<head>
<link type="text/css" rel="stylesheet" href="https://cdn01.jotfor.ms/themes/CSS/5e6b428acc8c4e222d1beb91.css?themeRevisionID=5eb3b4ae85bd2e1e2966db96" />

    <title>Real Enquiries - Tenants Data Registration Form</title>
</head>

<body>





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
    </style>
    <style type="text/css" id="form-designer-style">
        /* Injected CSS Code */
        .form-label.form-label-auto {

            display: block;
            float: none;
            text-align: left;
            width: 100%;

        }

        /* Injected CSS Code */
    </style>

    <form action="<?php echo htmlspecialchars($_SERVER[" PHP_SELF "]); ?>" method="post">
        <div role="main" class="form-all">
            <style>
                .form-all:before {
                    background: none;
                }
            </style>
            <ul class="form-section page-section">
                <li id="cid_1" class="form-input-wide" data-type="control_head">
                    <div class="form-header-group  header-large">
                        <div class="header-text httal htvam">
                            <h1 id="header_1" class="form-header" data-component="header">
                                Prospect Application Area
                            </h1>
                            <div id="subHeader_1" class="form-subHeader">
                                Welcome to your area <?php echo $name; ?>, here you can add extra information to support a quick and positive outcome.
                                Bear in mind that you can just submit your data once, after you click on the submit button you can not change your application.
                            </div>
                        </div>
                    </div>
                </li>
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
                                <input type="text" name="full_name" class="form-textbox validate[required]" autoComplete="section-input_3 given-name" size="10" value="<?php echo $name ?>" aria-labelledby="label_3 sublabel_3_first" required="" />
                                <label class="form-sub-label" for="first_3" id="sublabel_3_first" style="min-height:13px" aria-hidden="false"> Full Name </label>
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
                            <option selected disabled value="">Select</option>
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
                            <option value="Democratic Republic of the Congo">Democratic Republic of the Congo</option>
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
                            <option value="Dominican Republic">Dominican Republic</option>
                            <option value="Azerbaijan">Azerbaijan</option>
                            <option value="Honduras">Honduras</option>
                            <option value="Austria">Austria</option>
                            <option value="United Arab Emirates">United Arab Emirates</option>
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
                            <option value="Central African Republic">Central African Republic</option>
                            <option value="Ireland">Ireland</option>
                            <option value="Georgia">Georgia</option>
                            <option value="New Zealand">New Zealand</option>
                            <option value="Republic of the Congo">Republic of the Congo</option>
                            <option value="Palestine">Palestine</option>
                            <option value="Liberia">Liberia</option>
                            <option value="Croatia">Croatia</option>
                            <option value="Oman">Oman</option>
                            <option value="Bosnia and Herzegovina">Bosnia and Herzegovina</option>
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
                            <option value="Trinidad and Tobago">Trinidad and Tobago</option>
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
                            <option value="Guadeloupe (France)">Guadeloupe (France)</option>
                            <option value="Martinique (France)">Martinique (France)</option>
                            <option value="Brunei">Brunei</option>
                            <option value="Bahamas">Bahamas</option>
                            <option value="Iceland">Iceland</option>
                            <option value="Maldives">Maldives</option>
                            <option value="Belize">Belize</option>
                            <option value="Barbados">Barbados</option>
                            <option value="French Polynesia (France)">French Polynesia (France)</option>
                            <option value="Vanuatu">Vanuatu</option>
                            <option value="New Caledonia (France)">New Caledonia (France)</option>
                            <option value="French Guiana (France)">French Guiana (France)</option>
                            <option value="Mayotte (France)">Mayotte (France)</option>
                            <option value="Samoa">Samoa</option>
                            <option value="Sao Tom and Principe">Sao Tom and Principe</option>
                            <option value="Saint Lucia">Saint Lucia</option>
                            <option value="Guam (USA)">Guam (USA)</option>
                            <option value="Curacao (Netherlands)">Curacao (Netherlands)</option>
                            <option value="Saint Vincent and the Grenadines">Saint Vincent and the Grenadines</option>
                            <option value="Kiribati">Kiribati</option>
                            <option value="United States Virgin Islands (USA)">United States Virgin Islands (USA)</option>
                            <option value="Grenada">Grenada</option>
                            <option value="Tonga">Tonga</option>
                            <option value="Aruba (Netherlands)">Aruba (Netherlands)</option>
                            <option value="Federated States of Micronesia">Federated States of Micronesia</option>
                            <option value="Jersey (UK)">Jersey (UK)</option>
                            <option value="Seychelles">Seychelles</option>
                            <option value="Antigua and Barbuda">Antigua and Barbuda</option>
                            <option value="Isle of Man (UK)">Isle of Man (UK)</option>
                            <option value="Andorra">Andorra</option>
                            <option value="Dominica">Dominica</option>
                            <option value="Bermuda (UK)">Bermuda (UK)</option>
                            <option value="Guernsey (UK)">Guernsey (UK)</option>
                            <option value="Greenland (Denmark)">Greenland (Denmark)</option>
                            <option value="Marshall Islands">Marshall Islands</option>
                            <option value="American Samoa (USA)">American Samoa (USA)</option>
                            <option value="Cayman Islands (UK)">Cayman Islands (UK)</option>
                            <option value="Saint Kitts and Nevis">Saint Kitts and Nevis</option>
                            <option value="Northern Mariana Islands (USA)">Northern Mariana Islands (USA)</option>
                            <option value="Faroe Islands (Denmark)">Faroe Islands (Denmark)</option>
                            <option value="Sint Maarten (Netherlands)">Sint Maarten (Netherlands)</option>
                            <option value="Saint Martin (France)">Saint Martin (France)</option>
                            <option value="Liechtenstein">Liechtenstein</option>
                            <option value="Monaco">Monaco</option>
                            <option value="San Marino">San Marino</option>
                            <option value="Turks and Caicos Islands (UK)">Turks and Caicos Islands (UK)</option>
                            <option value="Gibraltar (UK)">Gibraltar (UK)</option>
                            <option value="British Virgin Islands (UK)">British Virgin Islands (UK)</option>
                            <option value="Aland Islands (Finland)">Aland Islands (Finland)</option>
                            <option value="Caribbean Netherlands (Netherlands)">Caribbean Netherlands (Netherlands)</option>
                            <option value="Palau">Palau</option>
                            <option value="Cook Islands (NZ)">Cook Islands (NZ)</option>
                            <option value="Anguilla (UK)">Anguilla (UK)</option>
                            <option value="Wallis and Futuna (France)">Wallis and Futuna (France)</option>
                            <option value="Tuvalu">Tuvalu</option>
                            <option value="Nauru">Nauru</option>
                            <option value="Saint Barthelemy (France)">Saint Barthelemy (France)</option>
                            <option value="Saint Pierre and Miquelon (France)">Saint Pierre and Miquelon (France)</option>
                            <option value="Montserrat (UK)">Montserrat (UK)</option>
                            <option value="Saint Helena, Ascension and Tristan da Cunha (UK)">Saint Helena, Ascension and Tristan da Cunha (UK)</option>
                            <option value="Svalbard and Jan Mayen (Norway)">Svalbard and Jan Mayen (Norway)</option>
                            <option value="Falkland Islands (UK)">Falkland Islands (UK)</option>
                            <option value="Norfolk Island (Australia)">Norfolk Island (Australia)</option>
                            <option value="Christmas Island (Australia)">Christmas Island (Australia)</option>
                            <option value="Niue (NZ)">Niue (NZ)</option>
                            <option value="Tokelau (NZ)">Tokelau (NZ)</option>
                            <option value="Vatican City">Vatican City</option>
                            <option value="Cocos (Keeling) Islands (Australia)">Cocos (Keeling) Islands (Australia)</option>
                            <option value="Pitcairn Islands (UK)">Pitcairn Islands (UK)</option>
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
                                <input name="dateOfBirth" type="date" class="form-textbox validate[required, limitDate, validateLiteDate]" id="lite_mode_16" size="12" data-maxlength="12" maxLength="12" data-age="" value="" required="" data-format="mmddyyyy" data-seperator="-" placeholder="MM-DD-YYYY" autoComplete="section-input_16 off" aria-labelledby="label_16 sublabel_16_litemode" />
                                <label class="form-sub-label" for="lite_mode_16" id="sublabel_16_litemode" style="min-height:13px" aria-hidden="false"> Date </label>
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
                            <input name="phone" type="tel" data-type="mask-number" class="mask-phone-number form-textbox validate[required, Fill Mask]" data-defaultvalue="" autoComplete="section-input_5 tel-national" style="width:310px" data-masked="true" value="" placeholder="(000) 000-0000" data-component="phone" aria-labelledby="label_5" required="" />
                            <label class="form-sub-label is-empty" for="input_5_full" id="sublabel_5_masked" style="min-height:13px" aria-hidden="false"> </label>
                        </span>
                    </div>
                </li>
                <li class="form-line" data-type="control_divider" id="id_17">
                    <div id="cid_17" class="form-input-wide" data-layout="full">
                        <div class="divider" aria-label="Divider" data-component="divider" style="border-bottom-width:1px;border-bottom-style:solid;border-color:#ecedf3;height:1px;margin-left:0px;margin-right:0px;margin-top:5px;margin-bottom:5px">
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
                            <option selected disabled value="">Employement Sector</option>
                            <option value="Accounting">Accounting</option>
                            <option value="Airlines/Aviation">Airlines/Aviation</option>
                            <option value="Alternative Dispute Resolution">Alternative Dispute Resolution</option>
                            <option value="Alternative Medicine">Alternative Medicine</option>
                            <option value="Animation">Animation</option>
                            <option value="Apparel & Fashion">Apparel & Fashion</option>
                            <option value="Architecture & Planning">Architecture & Planning</option>
                            <option value="Arts and Crafts">Arts and Crafts</option>
                            <option value="Automotive">Automotive</option>
                            <option value="Aviation & Aerospace">Aviation & Aerospace</option>
                            <option value="Banking">Banking</option>
                            <option value="Biotechnology">Biotechnology</option>
                            <option value="Broadcast Media">Broadcast Media</option>
                            <option value="Building Materials">Building Materials</option>
                            <option value="Business Supplies and Equipment">Business Supplies and Equipment</option>
                            <option value="Capital Markets">Capital Markets</option>
                            <option value="Chemicals">Chemicals</option>
                            <option value="Civic & Social Organization">Civic & Social Organization</option>
                            <option value="Civil Engineering">Civil Engineering</option>
                            <option value="Commercial Real Estate">Commercial Real Estate</option>
                            <option value="Computer & Network Security">Computer & Network Security</option>
                            <option value="Computer Games">Computer Games</option>
                            <option value="Computer Hardware">Computer Hardware</option>
                            <option value="Computer Networking">Computer Networking</option>
                            <option value="Computer Software">Computer Software</option>
                            <option value="Construction">Construction</option>
                            <option value="Consumer Electronics">Consumer Electronics</option>
                            <option value="Consumer Goods">Consumer Goods</option>
                            <option value="Consumer Services">Consumer Services</option>
                            <option value="Cosmetics">Cosmetics</option>
                            <option value="Dairy">Dairy</option>
                            <option value="Defense & Space">Defense & Space</option>
                            <option value="Design">Design</option>
                            <option value="Education Management">Education Management</option>
                            <option value="E-Learning">E-Learning</option>
                            <option value="Electrical/Electronic Manufacturing">Electrical/Electronic Manufacturing</option>
                            <option value="Entertainment">Entertainment</option>
                            <option value="Environmental Services">Environmental Services</option>
                            <option value="Events Services">Events Services</option>
                            <option value="Executive Office">Executive Office</option>
                            <option value="Facilities Services">Facilities Services</option>
                            <option value="Farming">Farming</option>
                            <option value="Financial Services">Financial Services</option>
                            <option value="Fine Art">Fine Art</option>
                            <option value="Fishery">Fishery</option>
                            <option value="Food & Beverages">Food & Beverages</option>
                            <option value="Food Production">Food Production</option>
                            <option value="Fund-Raising">Fund-Raising</option>
                            <option value="Furniture">Furniture</option>
                            <option value="Gambling & Casinos">Gambling & Casinos</option>
                            <option value="Glass, Ceramics & Concrete">Glass, Ceramics & Concrete</option>
                            <option value="Government Administration">Government Administration</option>
                            <option value="Government Relations">Government Relations</option>
                            <option value="Graphic Design">Graphic Design</option>
                            <option value="Health, Wellness and Fitness">Health, Wellness and Fitness</option>
                            <option value="Higher Education">Higher Education</option>
                            <option value="Hospital & Health Care">Hospital & Health Care</option>
                            <option value="Hospitality">Hospitality</option>
                            <option value="Human Resources">Human Resources</option>
                            <option value="Import and Export">Import and Export</option>
                            <option value="Individual & Family Services">Individual & Family Services</option>
                            <option value="Industrial Automation">Industrial Automation</option>
                            <option value="Information Services">Information Services</option>
                            <option value="Information Technology and Services">Information Technology and Services</option>
                            <option value="Insurance">Insurance</option>
                            <option value="International Affairs">International Affairs</option>
                            <option value="International Trade and Development">International Trade and Development</option>
                            <option value="Internet">Internet</option>
                            <option value="Investment Banking">Investment Banking</option>
                            <option value="Investment Management">Investment Management</option>
                            <option value="Judiciary">Judiciary</option>
                            <option value="Law Enforcement">Law Enforcement</option>
                            <option value="Law Practice">Law Practice</option>
                            <option value="Legal Services">Legal Services</option>
                            <option value="Legislative Office">Legislative Office</option>
                            <option value="Leisure, Travel & Tourism">Leisure, Travel & Tourism</option>
                            <option value="Libraries">Libraries</option>
                            <option value="Logistics and Supply Chain">Logistics and Supply Chain</option>
                            <option value="Luxury Goods & Jewelry">Luxury Goods & Jewelry</option>
                            <option value="Machinery">Machinery</option>
                            <option value="Management Consulting">Management Consulting</option>
                            <option value="Maritime">Maritime</option>
                            <option value="Marketing and Advertising">Marketing and Advertising</option>
                            <option value="Market Research">Market Research</option>
                            <option value="Mechanical or Industrial Engineering">Mechanical or Industrial Engineering</option>
                            <option value="Media Production">Media Production</option>
                            <option value="Medical Devices">Medical Devices</option>
                            <option value="Medical Practice">Medical Practice</option>
                            <option value="Mental Health Care">Mental Health Care</option>
                            <option value="Military">Military</option>
                            <option value="Mining & Metals">Mining & Metals</option>
                            <option value="Motion Pictures and Film">Motion Pictures and Film</option>
                            <option value="Museums and Institutions">Museums and Institutions</option>
                            <option value="Music">Music</option>
                            <option value="Nanotechnology">Nanotechnology</option>
                            <option value="Newspapers">Newspapers</option>
                            <option value="Nonprofit Organization Management">Nonprofit Organization Management</option>
                            <option value="Oil & Energy">Oil & Energy</option>
                            <option value="Online Media">Online Media</option>
                            <option value="Outsourcing/Offshoring">Outsourcing/Offshoring</option>
                            <option value="Package/Freight Delivery">Package/Freight Delivery</option>
                            <option value="Packaging and Containers">Packaging and Containers</option>
                            <option value="Paper & Forest Products">Paper & Forest Products</option>
                            <option value="Performing Arts">Performing Arts</option>
                            <option value="Pharmaceuticals">Pharmaceuticals</option>
                            <option value="Philanthropy">Philanthropy</option>
                            <option value="Photography">Photography</option>
                            <option value="Plastics">Plastics</option>
                            <option value="Political Organization">Political Organization</option>
                            <option value="Primary/Secondary Education">Primary/Secondary Education</option>
                            <option value="Printing">Printing</option>
                            <option value="Professional Training & Coaching">Professional Training & Coaching</option>
                            <option value="Program Development">Program Development</option>
                            <option value="Public Policy">Public Policy</option>
                            <option value="Public Relations and Communications">Public Relations and Communications</option>
                            <option value="Public Safety">Public Safety</option>
                            <option value="Publishing">Publishing</option>
                            <option value="Railroad Manufacture">Railroad Manufacture</option>
                            <option value="Ranching">Ranching</option>
                            <option value="Real Estate">Real Estate</option>
                            <option value="Recreational Facilities and Services">Recreational Facilities and Services</option>
                            <option value="Religious Institutions">Religious Institutions</option>
                            <option value="Renewables & Environment">Renewables & Environment</option>
                            <option value="Research">Research</option>
                            <option value="Restaurants">Restaurants</option>
                            <option value="Retail">Retail</option>
                            <option value="Security and Investigations">Security and Investigations</option>
                            <option value="Semiconductors">Semiconductors</option>
                            <option value="Shipbuilding">Shipbuilding</option>
                            <option value="Sporting Goods">Sporting Goods</option>
                            <option value="Sports">Sports</option>
                            <option value="Staffing and Recruiting">Staffing and Recruiting</option>
                            <option value="Supermarkets">Supermarkets</option>
                            <option value="Telecommunications">Telecommunications</option>
                            <option value="Textiles">Textiles</option>
                            <option value="Think Tanks">Think Tanks</option>
                            <option value="Tobacco">Tobacco</option>
                            <option value="Translation and Localization">Translation and Localization</option>
                            <option value="Transportation/Trucking/Railroad">Transportation/Trucking/Railroad </option>
                            <option value="Utilities">Utilities</option>
                            <option value="Venture Capital & Private Equity">Venture Capital & Private Equity </option>
                            <option value="Veterinary">Veterinary</option>
                            <option value="Warehousing">Warehousing</option>
                            <option value="Wholesale">Wholesale</option>
                            <option value="Wine and Spirits">Wine and Spirits</option>
                            <option value="Wireless">Wireless</option>
                            <option value="Writing and Editing">Writing and Editing</option>
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
                        <input type="text" name="employer" data-type="input-textbox" class="form-textbox validate[required]" data-defaultvalue="" style="width:310px" size="310" value="" data-component="textbox" aria-labelledby="label_20" required="" />
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
                        <input type="text" name="job_title" data-type="input-textbox" class="form-textbox validate[required]" data-defaultvalue="" style="width:310px" size="310" value="" data-component="textbox" aria-labelledby="label_22" required="" />
                    </div>
                </li>
                <li class="form-line" data-type="control_divider" id="id_23">
                    <div id="cid_23" class="form-input-wide" data-layout="full">
                        <div class="divider" aria-label="Divider" data-component="divider" style="border-bottom-width:1px;border-bottom-style:solid;border-color:#ecedf3;height:1px;margin-left:0px;margin-right:0px;margin-top:5px;margin-bottom:5px">
                        </div>
                    </div>
                </li>
                <li id="cid_24" class="form-input-wide" data-type="control_head">
                    <div class="form-header-group  header-default">
                        <div class="header-text httal htvam">
                            <h2 id="header_24" class="form-header" data-component="header">
                                Occupants
                            </h2>
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
                        <input type="number" name="occupants" data-type="input-number" class=" form-number-input form-textbox validate[required]" data-defaultvalue="" style="width:310px" size="310" value="" placeholder="ex: 2" data-component="number" aria-labelledby="label_25" required="" step="any" />
                    </div>
                </li>
                <li class="form-line form-line-column form-col-2" data-type="control_number" id="id_26">
                    <label class="form-label form-label-top" id="label_26" for="input_26"> Occupants over 18 years </label>
                    <div id="cid_26" class="form-input-wide" data-layout="half">
                        <input type="number" name="occupants_over18" data-type="input-number" class=" form-number-input form-textbox" data-defaultvalue="" style="width:310px" size="310" value="" placeholder="ex: 1" data-component="number" aria-labelledby="label_26" step="any" />
                    </div>
                </li>
                <li class="form-line" data-type="control_textarea" id="id_11">
                    <label class="form-label form-label-top form-label-auto" id="label_11" for="input_11"> Extra info: </label>
                    <div id="cid_11" class="form-input-wide" data-layout="full">
                        <textarea id="input_11" name="extra" style="width:648px;height:163px" data-component="textarea" aria-labelledby="label_11"></textarea>
                    </div>
                </li>
                <li class="form-line" data-type="control_button" id="id_2">
                    <div id="cid_2" class="form-input-wide" data-layout="full">
                        <div data-align="left" class="form-buttons-wrapper form-buttons-left   jsTest-button-wrapperField">
                            <input type="hidden" name="action" value="submit">
                            <button id="input_2" type="submit" class="form-submit-button submit-button jf-form-buttons jsTest-submitField" data-component="button" data-content="">
                                Submit
                            </button>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
        <div class="formFooter-heightMask">
        </div>
        <div class="formFooter f6 branding21">
            <div class="formFooter-wrapper formFooter-leftSide">
            </div>
            <div class="formFooter-wrapper formFooter-rightSide">
                <span class="formFooter-text">
                    Real Enquiries v1.0
                </span>
            </div>
        </div>
    </form>

</body>

</html>