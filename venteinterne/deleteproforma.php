

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

// Valider et assainir l'entrée
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

// Vérifiez si l'entrée est valide
if ($id === false) {
    die("Entrée invalide");
}

try {
    // Préparer la requête SQL pour sélectionner l'entrée
    $RSql = "SELECT * FROM `tdetail_document` WHERE `id` = :id";
    $stmt = $conn->prepare($RSql);
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $servers = $stmt->fetch(PDO::FETCH_ASSOC);

    // Vérifiez si l'entrée existe
    if ($servers === false) {
        die("Document non trouvé");
    }

    $iddocument = $servers['id_document'];

    // Préparer la requête SQL pour supprimer l'entrée
    $RSqls = "DELETE FROM `tdetail_document` WHERE `id` = :id";
    $query = $conn->prepare($RSqls);
    $query->bindValue(':id', $id, PDO::PARAM_INT);
    $resultat = $query->execute();

    // Rediriger en fonction du résultat de l'exécution
    if ($resultat) {
        header("Location: detailventeproforma.php?id=" . $iddocument);
        exit();
    } else {
        echo "Erreur lors de la suppression.";
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
<?php if (isset($error_message)): ?>
    <script>
        alert("<?php echo $error_message; ?>");
        location.href = "detailventeproforma.php?id=" . $iddocument;
    </script>
<?php else: ?>

<?php endif; ?>
</body>
</html>