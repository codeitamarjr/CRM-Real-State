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
            if ($fileSize < 1000000) {
                $fileNameNew = $fileID . "_" . $fileCategory . "." . $fileActualExt;
                $fileDestination = 'features/uploads/' . $fileNameNew;
                move_uploaded_file($fileTmpName, $fileDestination);
                return $fileNameNew;
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

function uploadProfileAttachments($profileID,$description,$file, $fileType, $fileCategory){
    $_FILES['file'] = $file;
    $countfiles = count($_FILES['file']['name']);
    $countfiles = count($_FILES['file']['name']);
    for($i=0;$i<$countfiles;$i++){

        $fileName = $_FILES['file']['name'][$i];
        $fileSize = $_FILES['file']['size'][$i];
        $fileError = $_FILES['file']['error'][$i];
        $fileExt = explode('.', $fileName);
        $fileActualExt = strtolower(end($fileExt));
        $allowed = array('jpg', 'jpeg', 'png', 'pdf', 'webp', 'docx', 'doc', 'xlsx', 'xls');
        if (in_array($fileActualExt, $allowed)) {
            if ($fileError === 0) {
                if ($fileSize < 1000000) {
                    $fileNameNew = $profileID."_".$fileType."_".$fileCategory."_".uniqid('', true) ."." . $fileExt[1];
                    $fileDestination = 'features/uploads/profileAttachments/' . $fileNameNew;
                    move_uploaded_file($_FILES['file']['tmp_name'][$i], $fileDestination);
                    require 'config/config.php';

                    //autoincrement the fileNumber for the profileAttachments table
                    $fileNumber = -1;
                    do {
                        $fileNumber++;
                    } while (getProfileAttachments('profileID', $profileID, $fileNumber,$fileCategory, 'category') != null);

                    $sql = "INSERT INTO profileAttachments (profileID, fileNumber , fileName, description, category) VALUES ('$profileID','$fileNumber', '$fileNameNew',' $description', '$fileCategory')";
                    $link->query($sql);

                } else {
                    echo "Your file is too big";
                }
            } else {
                echo "There was an error uploading your file";
            }
        } else {
            return "You cannot upload files of this type";
        }
    }
}

function getProfileAttachments($row,$conditional,$fileNumber,$category, $return){
    require "config/config.php";
    $query = "SELECT $return FROM profileAttachments WHERE ($row = '$conditional') AND (fileNumber = '$fileNumber') AND (category = '$category')";
    $result = mysqli_query($link, $query);
    if ($result) {
        while ($row = mysqli_fetch_array($result)) {
            return $row[$return];
        }
    } else {
        echo '<center><div class="alert alert-danger" role="alert">Error: ' . mysqli_error($link) . '</div></center>';
    }
    mysqli_close($link);
}

function removeProfileAttachments($profileID,$idprofileAttachments,$fileNumber,$category){
    require 'config/config.php';

    //Get the name of the file and delete the real file
    $fileName = getProfileAttachments('profileID', $profileID, $fileNumber,$category, 'fileName');
    unlink("features/uploads/profileAttachments/" . $fileName . "");
    //Delete the row from the database
    $sql = "DELETE FROM profileAttachments WHERE profileID = '$profileID' AND idprofileAttachments = '$idprofileAttachments'";
    $link->query($sql);
}