<?php
$dir = "img/";
$nameFile = $_FILES['fileImg']['name'];
$tmpFile = $_FILES['fileImg']['tmp_name'];
$typeFile = explode(".",$nameFile)[1];

$correct = array("png","jpg","gif");

if (in_array($typeFile, $correct)){
    if (move_uploaded_file($nameFile, $dir)){
        echo "Uploaded !";
    }
    else{
        echo "error";
    }
}
else{
    echo "type d'image incorrect";
}

?>
