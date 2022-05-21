<?php
// Include config file
require "config/config.php";
require "features/functions_automail.php";

//Set the automail_id from the GET data if it's not empty
$automail_id = $_GET['automail_id'];
if (!empty($automail_id)) {
    $automail_message = getAutomail($automail_id,'automail_message');
}

// Checking if the "tinyTextArea" field is set
if (!empty($_POST['tinyTextArea'])) {
    // Getting the variables from the form
    //$content = $link->real_escape_string($_POST['tinyTextArea']);
    $content =  $_POST['tinyTextArea'];
    $content = $link->real_escape_string($content);
    $automail_id = $_POST['automail_id'];
    $automail_title = $link->real_escape_string($_POST['title']);
    // Executing the query to update the message
    echo setAutomail($automail_id, 'automail_title', $automail_title);
    echo setAutomail($automail_id, 'automail_message', $content);
    die();
}

?>
<script src='features/tinymce/tinymce.min.js'></script>

<div class="container">
    <div class="card shadow mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h6 class="text-primary fw-bold m-0">Edit the Automail Response</h6>
        </div>
        <div class="card-body">
            <form method="GET">
                <input type="hidden" name="access" value="automail">
                <label for="automail_id">Choose a message:</label>
                <select class="form-select" id="automail_id" name="automail_id">
                    <option selected><?php echo getAutomail($_GET['automail_id'], 'automail_title'); ?></option>
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

<div class="container">
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
                        <input type="text" class="form-control" name="title" value="<?php echo getAutomail($_GET['automail_id'], 'automail_title'); ?>">
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
        plugins: 'print preview paste code fullscreen image link media table hr pagebreak nonbreaking anchor toc advlist lists wordcount imagetools textpattern noneditable help charmap quickbars emoticons',
        menubar: true,
        height: 500,
        toolbar: 'prospectLink propertyName prospectName prospectEmail prsName prsPhone prsEmail prsAddress',
        setup: function(editor) {
            editor.ui.registry.addButton('prospectLink', {
                text: '#ProspectProfileLink',
                onAction: function(_) {
                    editor.insertContent('%link%');
                }
            });
            editor.ui.registry.addButton('propertyName', {
                text: '#PropertyName',
                onAction: function(_) {
                    editor.insertContent('%propertyName%');
                }
            });
            editor.ui.registry.addButton('prospectName', {
                text: '#PropspectName',
                onAction: function(_) {
                    editor.insertContent('%prospectName%');
                }
            });
            editor.ui.registry.addButton('prospectEmail', {
                text: '#PropspectE-mail',
                onAction: function(_) {
                    editor.insertContent('%prospectEmail%');
                }
            });
            editor.ui.registry.addButton('prsName', {
                text: '#prsName',
                onAction: function(_) {
                    editor.insertContent('%prsName%');
                }
            });
            editor.ui.registry.addButton('prsPhone', {
                text: '#prsPhone',
                onAction: function(_) {
                    editor.insertContent('%prsPhone%');
                }
            });
            editor.ui.registry.addButton('prsEmail', {
                text: '#prsE-mail',
                onAction: function(_) {
                    editor.insertContent('%prsEmail%');
                }
            });
            editor.ui.registry.addButton('prsAddress', {
                text: '#prsAddress',
                onAction: function(_) {
                    editor.insertContent('%prsAddress%');
                }
            });
        }
    });
</script>