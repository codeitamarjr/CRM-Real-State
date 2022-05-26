<?php
//If the user selects a property from the list will change the session globaly to the selected property $_SESSION["property_code"]
if (isset($_POST['select_property'])) {
    $_SESSION["property_code"] = $_POST['select_property'];
}
?>


<!-- Property Selector Starts -->

<div class="nav-item dropdown no-arrow">
    <a class="dropdown-toggle nav-link" aria-expanded="false" data-bs-toggle="dropdown" href="#">
        <span class="d-none d-lg-inline me-2 text-gray-600 small">
            <form method="POST" name="property_selector">
                <select class="form-select" name="select_property">
                    <optgroup>
                        <option selected><?php echo getPropertyData($_SESSION["property_code"], 'property_name'); ?></option>
                    </optgroup>
                    <optgroup>
                        <option disabled>Manage Another Property</option>

                        <?php
                        //List all the properties from an agent
                        include 'config/config.php';
                        $select = "SELECT * FROM property WHERE property_prs_code = '$agent_prs_code'";
                        $result = mysqli_query($link, $select);
                        while ($row = mysqli_fetch_array($result)) {
                            echo '<option value=' . $row['property_code'] . '>' . $row['property_name'] . '</option>';
                        }
                        mysqli_close($link);
                        ?>
                    </optgroup>
                </select>
            </form>
        </span>
    </a>
</div>

<!-- Property Selector Ends -->

<script>
    //auto send form using Jquery
    $("form").on('change', function() {
        $("form").trigger('submit');
    });
</script>