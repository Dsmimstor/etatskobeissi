<?php

session_start();
require_once "../configs.php";
if (!isset($_SESSION["users"])) {
    header("Location: /Login.php");
} else {
    $id = $_GET["id"];
    $RSqls = "DELETE FROM `tdocuments` WHERE `id` = '$id' ";
  //  $RSql = "SELECT a.* , p.code codeprod , p.designations produit , u.abreviation unite FROM `tventeinterne` a INNER JOIN `tproduits`p ON a.id_produit = p.id  INNER JOIN `tunite` u ON a.id_unite = u.id ";
 
    $query = $conn->prepare($RSqls);
    $resultat = $query->execute();
    if ($resultat) {
        header("Location: listevente.php");
    }
} ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script>
        alert("Une erreur est survenue");
        location.href = "listevente.php";
    </script>
    <title>Document</title>
</head>

<body>

</body>
</html>