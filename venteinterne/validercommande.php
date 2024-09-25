<!DOCTYPE html>
<html lang="en">
<?php
session_start();
require_once "../configs.php";

// Vérifiez si l'utilisateur est connecté
if (!isset($_SESSION["users"])) {
    header("Location: /Login.php");
    exit();
} else {
    $date = date('m/d/Y');
    $y = date('Y');
    $m = date('m');
    $d = date('d');

    $indexfacture = $y . 'BL-' . $m;

    $sqlcompteur = 'SELECT * FROM compteur WHERE cle = :indexfacture';
    $reqcompteur = $conn->prepare($sqlcompteur);
    $reqcompteur->execute([':indexfacture' => $indexfacture]);
    $nvCompteur = 1;

    if ($compteur = $reqcompteur->fetch(PDO::FETCH_OBJ)) {
        $nvCompteur = $compteur->valeur + 1;
        $RSqlcompteur = "UPDATE `compteur` SET `valeur` = valeur + 1 WHERE `cle` = :indexfacture";
        $querycompteur = $conn->prepare($RSqlcompteur);
        $querycompteur->execute([':indexfacture' => $indexfacture]);
    } else {
        $RSqlcompteur = "INSERT INTO `compteur` (`cle`, `valeur`) VALUES (:indexfacture, 1)";
        $querycompteur = $conn->prepare($RSqlcompteur);
        $querycompteur->execute([':indexfacture' => $indexfacture]);
    }

    $ncommande = sprintf("%s%04d", $indexfacture, $nvCompteur);

    // Valider et assainir les entrées
    $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
    $tht = filter_input(INPUT_GET, 'tht', FILTER_VALIDATE_FLOAT);
    $frais = filter_input(INPUT_GET, 'frais', FILTER_VALIDATE_FLOAT);
    $transport = filter_input(INPUT_GET, 'transport', FILTER_VALIDATE_FLOAT);
    $datebl = $_GET['datebl'];
    $etatcmd = "Valider";
   
    // Vérifiez si les entrées sont valides
    if ($id === false || $tht === false || $frais === false || $transport === false || $datebl === false) {
        die("Entrée invalide");
    }

    try {
        // Préparer la requête SQL avec des paramètres nommés
        $RSqls = "UPDATE `tdocuments` SET
                    `datebl` = :dates,
                    `nbonliv` = :nbonliv,
                    `typesbl` = :typesbl,
                    `etatcmd` = :etatcmd
                  WHERE `id` = :id";

        $query = $conn->prepare($RSqls);

        // Lier les paramètres
        $query->bindValue(":dates", $datebl, PDO::PARAM_STR);
        $query->bindValue(":nbonliv", $ncommande, PDO::PARAM_STR);
        $query->bindValue(":typesbl", "BL", PDO::PARAM_STR);
      //  $query->bindValue(":totalht", $tht, PDO::PARAM_STR);
       // $query->bindValue(":tfrais", $frais, PDO::PARAM_STR);
        //$query->bindValue(":ttransport", $transport, PDO::PARAM_STR);
        $query->bindValue(":etatcmd", $etatcmd, PDO::PARAM_STR);
        $query->bindValue(":id", $id, PDO::PARAM_INT);

        // Exécuter la requête
        $executeIsOk = $query->execute() ? "succès" : "erreur";

        // Rediriger en fonction du résultat de l'exécution
        if ($executeIsOk === "succès") {
            header("Location: listebl.php");
            exit();
        } else {
            echo "Erreur lors de la mise à jour.";
        }
    } catch (PDOException $e) {
        // Gérer les erreurs
        echo "Erreur : " . $e->getMessage();
    }
}
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
<input type="date"  style="width:160px; " id="datecmd" name="datecmd" required value="<?php echo $datecmd; ?>">
  
</body>

</html>