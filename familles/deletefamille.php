<?php

session_start();
require_once "../configs.php";
if (!isset($_SESSION["users"])) {
    header("Location: /Login.php");
} else {
    $id = $_GET["id"];
    $RSqls = "DELETE FROM `tfamilles` WHERE `id` = '$id' ";
    $query = $conn->prepare($RSqls);
    $resultat = $query->execute();
    if ($resultat) {
        header("Location: listefamille.php");
    }
} ?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script>
        alert("Une erreur est survenue");
        location.href = "listefamille.php";
    </script>
    <title>Document</title>
</head>

<body>

</body>
</html>