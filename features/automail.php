<?php
// Include config file
require "config/config.php";
require "features/functions_automail.php";

//Set the automail_id from the GET data if it's not empty
$automail_id = $_GET['automail_id'];
if (!empty($automail_id)) {
    $query = "SELECT * FROM automail WHERE automail_id = $automail_id";
    $result = mysqli_query($link, $query);
    while ($row = mysqli_fetch_array($result)) {
        $automail_message =  str_replace("http://ec2-63-34-20-196.eu-west-1.compute.amazonaws.com/propertymanagement/prospect_area.php?key=' . \$key . '", "#PROSPECTLINK", $row['automail_message']);
        //$automail_message = $row['automail_message'];
    }
}

// Checking if the "tinyTextArea" field is set
if (!empty($_POST['tinyTextArea'])) {
    // Getting the variables from the form
    //$content = $link->real_escape_string($_POST['tinyTextArea']);
    $content =  str_replace("#PROSPECTLINK", "http://ec2-63-34-20-196.eu-west-1.compute.amazonaws.com/propertymanagement/prospect_area.php?key=' . \$key . '",  $_POST['tinyTextArea']);
    $content = $link->real_escape_string($content);
    $automail_id = $_POST['automail_id'];
    $automail_title = $link->real_escape_string($_POST['title']);
    // Executing the query to update the message

    $query = ("UPDATE automail SET automail_title = '$automail_title', automail_message = '$content' WHERE (automail_id = '$automail_id')");
    createAutomailTemplate($automail_id);
    if ($link->query($query) === TRUE) {
       
        echo '<h1><span style="color: #339966;"><center>This message has been updated with succes!</center></span></h1>';
        die;
    } else {
        echo "Error: " . $sql . "<br>" . $link->error;
    }
}

?>
<script src='features/tinymce/tinymce.min.js'></script>

<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h6 class="text-primary fw-bold m-0">Edit the Automail Response</h6>
        </div>
        <div class="card-body">
            <form method="GET">
                <input type="hidden" name="access" value="automail">
                <label for="automail_id">Choose a message:</label>
                <select class="form-select" id="automail_id" name="automail_id">
                    <option selected><?php echo getAutomailTitle($_GET['automail_id']); ?></option>
                    <?php
                    //List all the messages from this property_code
                    $property_code = $_SESSION["property_code"];
                    $query = "SELECT * FROM automail WHERE prs_code = $property_code";
                    $result = mysqli_query($link, $query);
                    while ($row = mysqli_fetch_array($result)) {
                        //Creates a loop to loop through results
                        $automail_title = $row['automail_title'];
                        $automail_id = $row['automail_id'];
                        echo '<option value="' . $automail_id . '">' . $automail_title . '</option>';
                    } ?>
                </select>
                <input type="submit" value="Select" class="btn btn-default">
            </form>
        </div>
    </div>
</div>

<div class="container-fluid">
    <div class="card shadow mb-4">
        <form method="POST">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h6 class="text-primary fw-bold m-0">Edit the Automail Response</h6>
                <div class="dropdown no-arrow"><button class="btn btn-link btn-sm dropdown-toggle" aria-expanded="false" data-bs-toggle="dropdown" type="button"><i class="fas fa-ellipsis-v text-gray-400"></i></button>
                    <div class="dropdown-menu dropdown-menu-end shadow animated--fade-in">
                        <h6 class="dropdown-header text-center"><strong>Action:</strong></h6>
                        <button type="submit" value="Save" class="btn btn-default">Save</button>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#">&nbsp;Get Empty Template</a>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-sm-1">
                        <h6 class="mb-0">Title</h6>
                    </div>
                    <div class="col-lg text-secondary">
                        <input type="text" class="form-control" name="title" value="<?php echo getAutomailTitle($_GET['automail_id']); ?>">
                    </div>
                </div>
            </div>

            <div class="card-body">
                <textarea name="tinyTextArea" id="tinyTextArea"><?php echo $automail_message; ?></textarea>
                <input type="hidden" name="automail_id" value="<?php echo $_GET['automail_id']; ?>">
            </div>
        </form>
    </div>
</div>

<?php
mysqli_close($link)
?>

<script>
    tinymce.init({
        selector: '#tinyTextArea',
        plugins: 'print preview paste directionality code visualblocks visualchars fullscreen image link media table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists wordcount imagetools textpattern noneditable help charmap quickbars emoticons',
        menubar: true,
        height: 500,
        toolbar: 'prospectLink propertyName prospectName',
        setup: function(editor) {
            editor.ui.registry.addButton('prospectLink', {
                text: '#ProspectProfileLink',
                onAction: function(_) {
                    editor.insertContent('<a href="#PROSPECTLINK">Personal Link</a>');
                }
            });
            editor.ui.registry.addButton('propertyName', {
                text: '#PropertyName',
                onAction: function(_) {
                    editor.insertContent('\'.$property_name.\'');
                }
            });
            editor.ui.registry.addButton('prospectName', {
                text: '#PropspectName',
                onAction: function(_) {
                    editor.insertContent('\'.$prospect_name.\'');
                }
            });
        }
    });
</script>