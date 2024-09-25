<?php
// Initialiser la session
session_start();
require_once "../configs.php";
// Vérifiez si l'utilisateur est connecté, sinon redirigez-le vers la page de connexion
if (!isset($_SESSION["users"])) {
    header("Location: Login.php");
    exit();
}
$RSqlste = "SELECT * FROM `tsociete` WHERE `id`  = '1' ";
$queryste = $conn->prepare($RSqlste);
$queryste->execute();
$resultste = $queryste->fetch(PDO::FETCH_ASSOC);

// Vérifiez si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les données du formulaire
    $product_name = htmlspecialchars($_POST['product_name']);
    $quantity = intval($_POST['quantity']);
    $entry_date = $_POST['entry_date'];

    // Préparer la requête SQL pour insérer les données dans la table des stocks
    $sql = "INSERT INTO stock_entries (product_name, quantity, entry_date) VALUES (:product_name, :quantity, :entry_date)";
    $stmt = $conn->prepare($sql);

    // Lier les paramètres
    $stmt->bindParam(':product_name', $product_name);
    $stmt->bindParam(':quantity', $quantity);
    $stmt->bindParam(':entry_date', $entry_date);

    // Exécuter la requête
    if ($stmt->execute()) {
        echo "Entrée de stock ajoutée avec succès.";
    } else {
        echo "Erreur lors de l'ajout de l'entrée de stock.";
    }
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="/img/Iconadc.jpg" />
    <title>SALS EXPRESS</title>

    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
    <!--<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">-->


    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@500&family=Montserrat:wght@100&family=Yellowtail&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700" rel="stylesheet">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">


    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap5.min.css">

    <link rel="stylesheet" href="/css/Stylelisteventes.css" />
    <script>
        function confirmer(id) {
            if (confirm("Voulez-vous supprimer cet article ?")) {
                location.href = "delete.php?id=" + id;
            }
        }
    </script>
</head>

<body>
    <header class="nav1">
        <!-- Logo-->
        <p class="slogan" href="#">
            <img src="/img/SALS1L.png" alt="logoAtelier" />
            <a><?php echo htmlspecialchars($resultste["designation"], ENT_QUOTES, 'UTF-8'); ?> </a>
        </p>
    </header>
    <div class="container">
        <div style="height:50px;"></div>
        <div class="well">
            <h2>Entrée de Stock</h2>
            <?php if (isset($message)) : ?>
                <div class="alert alert-info"><?php echo htmlspecialchars($message, ENT_QUOTES, 'UTF-8'); ?></div>
            <?php endif; ?>
            <form action="entree_stock.php" method="post">
                <div class="mb-3">
                    <label for="product_name" class="form-label">Nom du produit</label>
                    <input type="text" class="form-control" id="product_name" name="product_name" required>
                </div>
                <div class="mb-3">
                    <label for="quantity" class="form-label">Quantité</label>
                    <input type="number" class="form-control" id="quantity" name="quantity" required>
                </div>
                <div class="mb-3">
                    <label for="entry_date" class="form-label">Date d'entrée</label>
                    <input type="date" class="form-control" id="entry_date" name="entry_date" required>
                </div>
                <button type="submit" class="btn btn-primary" style="margin: 10px;">Ajouter</button>
            </form>
        </div>
    </div>
</body>

</html>
