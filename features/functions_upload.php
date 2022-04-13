<?php
function uploadFile($file, $fileID, $fileCategory){
    $_FILES['file'] = $file;

    $fileName = $_FILES['file']['name'];
    $fileTmpName = $_FILES['file']['tmp_name'];
    $fileSize = $_FILES['file']['size'];
    $fileError = $_FILES['file']['error'];
    $fileType = $_FILES['file']['type'];

    $fileExt = explode('.', $fileName);
    $fileActualExt = strtolower(end($fileExt));

    $allowed = array('jpg', 'jpeg', 'png', 'pdf', 'webp', 'docx', 'doc', 'xlsx', 'xls');

    if (in_array($fileActualExt, $allowed)) {
        if ($fileError === 0) {
            if ($fileSize < 100000) {
                $fileNameNew = $fileID . "_" . $fileCategory . "." . $fileActualExt;
                $fileDestination = 'features/uploads/' . $fileNameNew;
                move_uploaded_file($fileTmpName, $fileDestination);
                echo '<div class="alert alert-success" role="alert">File updated with succes!</div>';
            } else {
                echo '<div class="alert alert-danger" role="alert">Your file is too big!</div>';
            }
        } else {
            echo '<div class="alert alert-danger" role="alert">There was an error uploading your file!</div>';
        }
    } else {
        echo '<div class="alert alert-danger" role="alert">You cannot upload files of this type!</div>';
        echo $file;
        echo $_FILES['file']['name'];
    }
}