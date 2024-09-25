<?php
session_start();
require_once "../configs.php";
//include_once "../template/listepays.php";
include_once "../template/listeville.php";
$excecuteIsOk = "none";
$resultfour = [];
if (!isset($_SESSION["users"])) {
    header("Location: /Login.php");
} else {
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

    if (isset($_POST["btn_update"])) {

        if ($_POST["villes"] == "Selectionnez la Ville" or $_POST["idlocaux"] == "" or $_POST["nomlocataire"] == "Nom Locataire" or $_POST["ncni"] == "" or $_POST["dateentree"] == "" or $_POST["datesortie"] == "" or $_POST["caution"] == "" or $_POST["dateprevers"] == "" or $_POST["typelocation"] == "Periode de location") {
            echo "<script> alert('Champ manquant , Remplissez tous les champs '); </script>";
        } else {

            $idloc["id"] = $_POST["id"];

            $resultfour["code"] = $_POST["villes"];
            $resultfour["designations"] = $_POST["idlocaux"];
            $resultfour["nomlocataire"] = $_POST["nomlocataire"];
            $resultfour["ncni"] = $_POST["ncni"];
            $resultfour["dateentree"] = $_POST["dateentree"];
            $resultfour["datesortie"] = $_POST["datesortie"];
            $resultfour["caution"] = $_POST["caution"];
            $resultfour["telephone"] = $_POST["loyer"];
            $resultfour["dateprevers"] = $_POST["dateprevers"];


            $RSqls = "UPDATE `tlocataire` SET
        `id_villes`=:villes,
        `id_local`=:idlocaux,
        `id_locataire`=:nomlocataire,
        `ncni`=:ncni,
        `dateentree`=:dateentree,
        `datesortie`=:datesortie,
        `caution`=:caution,
        `id_typelocation`=:typelocation,
        `loyer`=:loyer,
        `dateprevers`=:dateprevers  WHERE `id`=$idloc";

            $query = $conn->prepare($RSqls);



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


            $excecuteIsOk = $query->execute() ? "succes" : "error";
        }
    } else {
        $id = $_GET["id"];
        $RSqls = "SELECT f.*, lc.designations locataire, l.locaux locaux , tl.typelocation typelocations FROM `tlocataire` f INNER JOIN `tclients` lc ON f.id_locataire = lc.id INNER JOIN `tlocal` l ON f.id_local = l.id INNER JOIN `ttypelocation` tl ON f.id_typelocation = tl.id WHERE f.`id` = '$id' ";

        $query = $conn->prepare($RSqls);
        $query->execute();
        $resultfour = $query->fetch(PDO::FETCH_ASSOC);
        // $npays = $resultfour["paysfour"];
        // $nville = $resultfour["villefour"];

    }
}
?>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="/img/Iconadc.jpg" />
    <title>L'Atelier du Chocolat</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>

    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@500&family=Montserrat:wght@100&family=Yellowtail&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700" rel="stylesheet">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="/css/Stylefournisseurs1.css" />
    <?php
    if ($excecuteIsOk == "succes") {
        echo "<script> alert('L\'element a été modifié'); location.href='liste.php'; </script>";
    }
    if ($excecuteIsOk == "error") {
        echo "<script> alert('Echec de la modification de l\'element'); </script>";
    }
    ?>


</head>
<header class="nav1">
    <!-- Logo-->
    <p class="slogan" href="#">
        <img src="/img/SALS1L.png" alt="logoAtelier" />
        <a>ETATS KOBEISSI</a>
    </p>
</header>

<body>
    <div class="container">
        <div style="height:50px;"></div>
        <div class="well">
            <!--    <h2>Liste des Fournisseurs</h2>-->
            <h2 class="text-center">MODIFER CLIENT</h2>
            <form action="" method="POST" name="modfours" value="modfour">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="myModalLabel">.</h4>
                        </div>
                        <div class="modal-body">
                            <div class="container-fluid">
                                <input type="hidden" style="width:350px; text-align: left;" class="form-control" id="eid" name="id" value="<?php echo $resultfour["id"]; ?>">
                                <div class="form-group input-group">
                                    <span class="input-group-addon" style="width:150px;">Ville :</span>
                                    <select id="villes" name="villes" size="1" style="width:350px;" class="form-control">
                                        <option value="">Sélectionnez la Ville</option>
                                        <?php
                                        while ($vi = $reqVille->fetch(PDO::FETCH_OBJ)) {
                                            $selected = ($vi->id == $resultfour['id_villes']) ? 'selected' : '';
                                            echo '<option value="' . htmlspecialchars($vi->id) . '" ' . $selected . ' data-code="' . htmlspecialchars($vi->id) . '">' . htmlspecialchars($vi->names) . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group input-group">
                                    <span class="input-group-addon" style="width:150px;">Local :</span>
                                    <select id="idlocaux" name="idlocaux" size="1" style="width:350px;" class="form-control">
                                        <option>Selectionnez le local</option>
                                        <?php
                                        while ($lc = $reqlocal->fetch(PDO::FETCH_OBJ)) {
                                            echo '<option value="' . htmlspecialchars($lc->id) . '" ' . htmlspecialchars($lc->id == $resultfour['id_villes'] ? "selected" : "") . ' data-villes="' . $lc->id_ville . '" style="display:' .  htmlspecialchars($lc->id_ville == $Sqlresultat['id'] ? "block" : "none") . '">' .  htmlspecialchars($lc->locaux) . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group input-group">
                                    <span class="input-group-addon" style="width:150px;">Nom Locataire :</span>
                                    <select id="nomlocataire" name="nomlocataire" size="1" style="width:350px;" class="form-control">
                                        <option>Selectionner Locataire</option>
                                        <?php
                                        while ($n = $reqloc->fetch(PDO::FETCH_OBJ)) {
                                            echo '<option value="' . htmlspecialchars($n->code) . '" ' . htmlspecialchars($n->id == $resultfour['id_locataire'] ? "selected" : "") . '>' . htmlspecialchars($n->designations) . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group input-group">
                                    <span class="input-group-addon" style="width:150px;">Cni ou Passeport :</span>
                                    <input type="text" style="width:350px;" class="form-control" id="ncni" name="ncni" value="<?php echo $resultfour["ncni"]; ?>">
                                </div>
                                <div class="form-group input-group">
                                    <span class="input-group-addon" style="width:150px;">Date Entrée :</span>
                                    <input type="date" style="width:350px;" class="form-control" id="dateentree" name="dateentree" value="<?php echo $resultfour["dateentree"]; ?>">
                                </div>
                                <div class="form-group input-group">
                                    <span class="input-group-addon" style="width:150px;">Date Sortie :</span>
                                    <input type="date" style="width:350px;" class="form-control" id="datesortie" name="datesortie" value="<?php echo $resultfour["datesortie"]; ?>">
                                </div>
                                <div class="form-group input-group">
                                    <span class="input-group-addon" style="width:150px;">Type de location :</span>
                                    <select id="typrlocation" name="typelocation" size="1" style="width:350px;" class="form-control">
                                        <option>Periode de location</option>
                                        <?php
                                        while ($me = $reqmeuble->fetch(PDO::FETCH_OBJ)) {
                                            echo '<option value="' . $me->id . '" ' . ($me->id == $resultfour['id_typelocation'] ? "selected" : "") . '>' . $me->typelocation . '</option>';
                                        } ?>
                                    </select>
                                </div>
                                <div class="form-group input-group">
                                    <span class="input-group-addon" style="width:150px;">Caution :</span>
                                    <input type="text" style="width:350px;" class="form-control" id="caution" name="caution" value="<?php echo $resultfour["caution"]; ?>">
                                </div>
                                <div class="form-group input-group">
                                    <span class="input-group-addon" style="width:150px;">Loyer :</span>
                                    <input type="text" style="width:350px;" class="form-control" id="loyer" name="loyer" value="<?php echo $resultfour["loyer"]; ?>">
                                </div>
                                <div class="form-group input-group">
                                    <span class="input-group-addon" style="width:150px;">Date Premier Vers :</span>
                                    <input type="date" style="width:350px;" class="form-control" id="dateprevers" name="dateprevers" value="<?php echo $resultfour["dateprevers"]; ?>">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success " name="btn_update"><span class="glyphicon glyphicon-edit"></span> Modififer</button>
                            <a href="listeloca.php" class="btn btn-default"><span class="glyphicon glyphicon-remove"></span> Annuller</a>
                        </div>
                    </div>
                </div>
            </form>
            <script>
                $(function() {
                    $('#villes').change(function(e) {
                        const id_ville = $(this).val();
                        $("#idlocaux").val(undefined);
                        $("#idlocaux option[data-villes='" + id_ville + "']").css("display", "block");
                        $("#idlocaux option:not([data-villes='" + id_ville + "'])").css("display", "none");
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

</body>

</html>