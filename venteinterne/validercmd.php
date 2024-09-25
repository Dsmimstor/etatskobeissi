<!DOCTYPE html>
<html lang="en">
<?php
session_start();
require_once "../configs.php";

// Vérifiez si l'utilisateur est connecté
if (!isset($_SESSION["users"])) {
    header("Location: /Login.php");
    exit();
}

// Valider et assainir les entrées
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
$etatcmd = "Terminé";

// Vérifiez si les entrées sont valides
if ($id === false) {
    die("Entrée invalide");
}

try {
    // Préparer la requête SQL avec des paramètres nommés
    $RSqls = "UPDATE `tdocuments` SET
                `etatcmd` = :etatcmd
              WHERE `id` = :id";

    $query = $conn->prepare($RSqls);

    // Lier les paramètres
    $query->bindValue(":etatcmd", $etatcmd, PDO::PARAM_STR);
    $query->bindValue(":id", $id, PDO::PARAM_INT);

    // Exécuter la requête
    $executeIsOk = $query->execute() ? "succès" : "erreur";

    // Rediriger en fonction du résultat de l'exécution
    if ($executeIsOk === "succès") {
        header("Location: listevente.php");
        exit();
    } else {
        echo "Erreur lors de la mise à jour.";
    }
} catch (PDOException $e) {
    // Gérer les erreurs
    echo "Erreur : " . $e->getMessage();
}
?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
</body>
</html>