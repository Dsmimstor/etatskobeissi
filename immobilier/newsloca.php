<?php
session_start();
require_once "../configs.php";
include_once "../template/listeville.php";

$excecuteIsOk = "none";
$resultfour = [];

// Vérification de la session utilisateur
if (!isset($_SESSION["users"])) {
    header("Location: /Login.php");
    exit();
} else {
    // Récupération des données nécessaires pour le formulaire

    $sqllocal = "SELECT * FROM `tlocal` WHERE `statuts`  = 'Non Occupé'";
    $reqlocal = $conn->query($sqllocal);

    $RSqlloc = "SELECT * FROM `tclients` WHERE `typelog`  = 'GI'";
    $reqloc = $conn->query($RSqlloc);

    $sqlmeuble = 'SELECT * FROM ttypelocation ORDER BY id';
    $reqmeuble = $conn->query($sqlmeuble);

    $sqlVille = 'SELECT * FROM tvilles ORDER BY names';
    $reqVille = $conn->query($sqlVille);

    $RSqlste = "SELECT * FROM `tsociete` WHERE `id`  = '1'";
    $queryste = $conn->prepare($RSqlste);
    $queryste->execute();
    $resultste = $queryste->fetch(PDO::FETCH_ASSOC);

    // Traitement du formulaire
    if (isset($_POST["btn_update"])) {
        if ($_POST["villes"] == "Selectionnez la Ville" or $_POST["idlocaux"] == "" or $_POST["nomlocataire"] == "Nom Locataire" or $_POST["ncni"] == "" or $_POST["dateentree"] == "" or $_POST["datesortie"] == "" or $_POST["caution"] == "" or $_POST["dateprevers"] == "" or $_POST["typelocation"] == "Periode de location") {
            echo "<script> alert('Champ manquant , Remplissez tous les champs '); </script>";
        } else {
            $RSqls = "INSERT INTO `tlocataire`(`id_villes`, `id_local`, `id_locataire`, `ncni`, `dateentree`, `datesortie`, `caution`, `id_typelocation`, `loyer`, `dateprevers`)
                    VALUES(:villes, :idlocaux, :nomlocataire, :cni, :dateentree, :datesortie, :caution, :typelocation, :loyer, :dateprevers)";

            $query = $conn->prepare($RSqls);

            // Liaison des valeurs
            $query->bindValue(":villes", $_POST["villes"], PDO::PARAM_INT);
            $query->bindValue(":idlocaux", $_POST["idlocaux"], PDO::PARAM_INT);
            $query->bindValue(":nomlocataire", $_POST["nomlocataire"], PDO::PARAM_INT);
            $query->bindValue(":cni", $_POST["ncni"], PDO::PARAM_STR);
            $query->bindValue(":dateentree", $_POST["dateentree"], PDO::PARAM_STR);
            $query->bindValue(":datesortie", $_POST["datesortie"], PDO::PARAM_STR);
            $query->bindValue(":caution", $_POST["caution"], PDO::PARAM_STR);
            $query->bindValue(":typelocation", $_POST["typelocation"], PDO::PARAM_STR);
            $query->bindValue(":loyer", $_POST["loyer"], PDO::PARAM_STR);
            $query->bindValue(":dateprevers", $_POST["dateprevers"], PDO::PARAM_STR);

            // Exécution de la requête
            $excecuteIsOk = $query->execute() ;


            $idloc = $_POST["idlocaux"];
            $RSqlsm = "UPDATE `tlocal` SET
                `statut` = :statut
                WHERE `id` = :id";

            $querym = $conn->prepare($RSqlsm);

            $querym->bindValue(":statut", "Occupé", PDO::PARAM_STR);
            $query->bindValue(":id", $idloc, PDO::PARAM_INT);

            $excecuteIsOkm = $querym->execute() ? "succes" : "error";
        }
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
    <title>ETS KOBEISSI</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
    <link rel="stylesheet" href="/css/Stylefournisseurs1.css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@500&family=Montserrat:wght@100&family=Yellowtail&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700" rel="stylesheet">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css" />

    <?php
    if ($excecuteIsOk == "succes") {
        echo "<script> alert('L\'élément a été ajouté'); location.href='listeloca.php'; </script>";
    }
    if ($excecuteIsOk == "error") {
        echo "<script> alert('Échec de la modification de l\'élément'); </script>";
    }
    ?>
</head>
<header class="nav1">
    <p class="slogan">
        <img src="/img/SALS1L.png" alt="logoAtelier" />
        <a><?php echo htmlspecialchars($resultste["designation"]); ?></a>
    </p>
</header>

<body>
    <div class="container">
        <div style="height:50px;"></div>
        <div class="well">
            <h2 class="text-center">AJOUTER UN LOCATAIRE</h2>
            <form action="" method="POST" name="modfours" value="modfour">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="myModalLabel">.</h4>
                        </div>
                        <div class="modal-body">
                            <div class="container-fluid">
                                <div class="form-group input-group">
                                    <span class="input-group-addon" style="width:150px;">Ville :</span>
                                    <select id="villes" name="villes" size="1" style="width:350px;" class="form-control">
                                        <option>Selectionnez la Ville</option>
                                        <?php
                                        while ($v = $reqVille->fetch(PDO::FETCH_OBJ)) {
                                           /* echo '<option value="' . htmlspecialchars($v->id) . '">' . htmlspecialchars($v->names) . '</option>';*/
                                            echo '<option value="' . htmlspecialchars($v->id). '"  data-ville="' . htmlspecialchars($v->id) . '">' . $v->names . '</option>';

                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group input-group">
                                    <span class="input-group-addon" style="width:150px;">Local :</span>
                                    <select id="idlocaux" name="idlocaux" size="1" style="width:350px;" class="form-control">
                                        <option>Selectionnez le local</option>
                                        <?php
                                        while ($v = $reqlocal->fetch(PDO::FETCH_OBJ)) {
                                            echo '<option value="' . htmlspecialchars($v->id) . '" data-ville="' . htmlspecialchars($v->id_ville) . '">' . htmlspecialchars($v->locaux) . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group input-group">
                                    <span class="input-group-addon" style="width:150px;">Nom Locataire :</span>
                                    <select id="nomlocataire" name="nomlocataire" size="1" style="width:350px;" class="form-control">
                                        <option>Selectionner Locataire</option>
                                        <?php
                                        while ($m = $reqloc->fetch(PDO::FETCH_OBJ)) {
                                            echo '<option value="' . htmlspecialchars($m->id) . '">' . htmlspecialchars($m->designations) . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group input-group">
                                    <span class="input-group-addon" style="width:150px;">Cni ou Passeport :</span>
                                    <input type="text" style="width:350px;" class="form-control" id="ncni" name="ncni">
                                </div>
                                <div class="form-group input-group">
                                    <span class="input-group-addon" style="width:150px;">Date Entrée :</span>
                                    <input type="date" style="width:350px;" class="form-control" id="dateentree" name="dateentree">
                                </div>
                                <div class="form-group input-group">
                                    <span class="input-group-addon" style="width:150px;">Date Sortie :</span>
                                    <input type="date" style="width:350px;" class="form-control" id="datesortie" name="datesortie">
                                </div>
                                <div class="form-group input-group">
                                    <span class="input-group-addon" style="width:150px;">Periode de location :</span>
                                    <select id="typrlocation" name="typelocation" size="1" style="width:350px;" class="form-control">
                                        <option>Periode de location</option>
                                        <?php
                                        while ($m = $reqmeuble->fetch(PDO::FETCH_OBJ)) {
                                            echo '<option value="' . $m->id . '" >' . $m->typelocation . '</option>';
                                        } ?>
                                    </select>
                                </div>
                                <div class="form-group input-group">
                                    <span class="input-group-addon" style="width:150px;">Caution :</span>
                                    <input type="number" style="width:350px;" class="form-control" id="caution" name="caution">
                                </div>
                                <div class="form-group input-group">
                                    <span class="input-group-addon" style="width:150px;">Loyer :</span>
                                    <input type="number" style="width:350px;" class="form-control" id="loyer" name="loyer">
                                </div>
                                <div class="form-group input-group">
                                    <span class="input-group-addon" style="width:150px;">Date Premier Vers :</span>
                                    <input type="date" style="width:350px;" class="form-control" id="dateprevers" name="dateprevers">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-success" name="btn_update"><span class="glyphicon glyphicon-edit"></span> Ajouter</button>
                                <a href="listeloca.php" class="btn btn-default"><span class="glyphicon glyphicon-remove"></span> Annuler</a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <script>
                $(function() {
                    $('#villes').change(function(e) {
                        const id_ville = $(this).val();
                        $("#idlocaux").val(undefined);
                        $("#idlocaux option[data-ville='" + id_ville + "']").css("display", "block");
                        $("#idlocaux option:not([data-ville='" + id_ville + "'])").css("display", "none");
                    });
                });
            </script>
            <script>
                function upperCaseFun(a) {
                    setTimeout(function() {
                        a.value = a.value.toUpperCase();
                    }, 1);
                }
            </script>
        </div>
    </div>
</body>

</html>