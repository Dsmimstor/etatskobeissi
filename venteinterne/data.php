<?php

//require_once "../configs.php";
include "../configs.php";

$id = $_POST["id"];
var_dump($id);
$RSqlsz = "SELECT * FROM `tclients` WHERE `id`  = '$id' ";
$queryz = $conn->prepare($RSqlsz);
$queryz->execute();
$resultclient = $queryz->fetch(PDO::FETCH_ASSOC);
echo  json_encode($resultclient);

