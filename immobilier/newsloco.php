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
    $sqlPays = 'SELECT * FROM tpays ORDER BY names';
    $reqPays = $conn->query($sqlPays);

    $sqlmeuble = 'SELECT * FROM ttypelocal ORDER BY types';
    $reqmeuble = $conn->query($sqlmeuble);

    $sqlVille = 'SELECT * FROM tvilles  ORDER BY names';
    $reqVille = $conn->query($sqlVille);

    $RSqlste = "SELECT * FROM `tsociete` WHERE `id`  = '1' ";
    $queryste = $conn->prepare($RSqlste);
    $queryste->execute();
    $resultste = $queryste->fetch(PDO::FETCH_ASSOC);

    if (isset($_POST["btn_update"])) {

        $RSqls = "INSERT `tlocal`(`id_ville`, `quartier`,`typelocal`,`nbatiment`,`niveauetage`,`nappartement`,`nombrepiece`,`meuble`,`locaux`,`statuts`)
                             VALUES(:villes,:quartier,:typelocal,:nbatiment,:niveauetage,:nappartement,:nombrepiece,:meuble,:locaux,:statuts)";

        $query = $conn->prepare($RSqls);

        $query->bindValue(":villes", $_POST["villes"], PDO::PARAM_INT);
        $query->bindValue(":quartier", $_POST["quartier"], PDO::PARAM_STR);
        $query->bindValue(":typelocal", $_POST["typelocal"], PDO::PARAM_STR);
        $query->bindValue(":nbatiment", $_POST["nbatiment"], PDO::PARAM_STR);
        $query->bindValue(":niveauetage", $_POST["niveauetage"], PDO::PARAM_STR);
        $query->bindValue(":nappartement", $_POST["nappartement"], PDO::PARAM_STR);
        $query->bindValue(":nombrepiece", $_POST["nombrepiece"], PDO::PARAM_STR);
        $query->bindValue(":meuble", $_POST["meuble"], PDO::PARAM_STR);
        $locaux = $_POST["Villenom"] . " " . $_POST["nbatiment"] . " " . $_POST["niveauetage"] . " " . $_POST["nappartement"] . " " . $_POST["nombrepiece"];
        $query->bindValue(":locaux", $locaux, PDO::PARAM_STR);
        $query->bindValue(":statuts", "Non Occupé", PDO::PARAM_STR);


        $excecuteIsOk = $query->execute() ? "succes" : "error";
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
    <title>ETS KOBEISSI</title>
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
        echo "<script> alert('L\'element a été ajouté'); location.href='listeloco.php'; </script>";
    }
    if ($excecuteIsOk == "error") {
        echo "<script> alert('Echec de la modification de l'element'); </script>";
    }
    ?>

</head>
<header class="nav1">
    <!-- Logo-->
    <p class="slogan" href="#">
        <img src="/img/SALS1L.png" alt="logoAtelier" />
        <a><?php echo $resultste["designation"]; ?> </a>
    </p>
</header>

<body>
    <div class="container">
        <div style="height:50px;"></div>
        <div class="well">
            <!--    <h2>Liste des Fournisseurs</h2>-->
            <h2 class="text-center">CREER LOCAL</h2>
            <form action="" method="POST" name="modfours" value="modfour">

                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="myModalLabel">.</h4>
                        </div>
                        <div class="modal-body">
                            <div class="container-fluid">
                                <div class="form-group input-group">
                                    <span class="input-group-addon" style="width:150px;">Pays :</span name="formatpays">
                                    <select id="pays" name="pays" size="1" style="width:350px;" class="form-control">
                                        <option>Selectionnez le pays</option>
                                        <?php
                                        while ($p = $reqPays->fetch(PDO::FETCH_OBJ)) {
                                            echo '<option value="' . $p->id . '" >' . $p->names . '</option>';
                                        } ?>
                                    </select>
                                </div>
                                <div class="form-group input-group">
                                    <span class="input-group-addon" style="width:150px;">Ville :</span name="formatpays">
                                    <select id="villes" name="villes" size="1" style="width:350px;" class="form-control">
                                        <option>Selectionnez la ville</option>
                                        <?php
                                        while ($p = $reqVille->fetch(PDO::FETCH_OBJ)) {
                                            echo '<option value="' . $p->id . '" data-pays="' . $p->id_pays . '">' . $p->names . '</option>';
                                        } ?>
                                    </select>
                                </div>
                                <div class=" form-group input-group">
                                    <span class="input-group-addon" style="width:150px;">Quartier :</span>
                                    <input type="text" style="width:350px;" class="form-control" id="quartier" name="quartier">
                                </div>
                                <div class="form-group input-group">
                                    <span class="input-group-addon" style="width:150px;">Type Local :</span>
                                    <input type="text" style="width:350px;" class="form-control" id="typelocal" name="typelocal">
                                </div>
                                <div class="form-group input-group">
                                    <span class="input-group-addon" style="width:150px;">N° Batiment :</span>
                                    <input type="text" style="width:350px;" class="form-control" id="nbatiment" name="nbatiment">
                                </div>
                                <div class="form-group input-group">
                                    <span class="input-group-addon" style="width:150px;">Niveau étage :</span>
                                    <input type="text" style="width:350px;" class="form-control" id="niveauetage" name="niveauetage">
                                </div>
                                <div class="form-group input-group">
                                    <span class="input-group-addon" style="width:150px;">Nom Appartement :</span>
                                    <input type="text" style="width:350px;" class="form-control" id="nappartement" name="nappartement">
                                </div>
                                <div class="form-group input-group">
                                    <span class="input-group-addon" style="width:150px;">Nombre de Pièces :</span>
                                    <input type="text" style="width:350px;" class="form-control" id="nombrepiece" name="nombrepiece">
                                </div>
                                <div class="form-group input-group">
                                    <span class="input-group-addon" style="width:150px;">Appart Meublé :</span>
                                    <select id="meuble" name="meuble" size="1" style="width:350px;" class="form-control">
                                        <option>Selectionner le type</option>
                                        <?php
                                        while ($m = $reqmeuble->fetch(PDO::FETCH_OBJ)) {
                                            echo '<option value="' . $m->id . '" >' . $m->types . '</option>';
                                        } ?>
                                    </select>
                                </div>
                                <div class="form-group input-group">
                                    <input type="hidden" style="width:350px;" class="form-control" id="Villenom" name="Villenom">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-success " name="btn_update"><span class="glyphicon glyphicon-edit"></span> Ajouter</button>
                                <a href="listeloco.php" class="btn btn-default"><span class="glyphicon glyphicon-remove"></span> Annuler</a>
                            </div>
                        </div>
                    </div>

            </form>
            <script>
                $(function() {
                    $('#pays').change(function(e) {
                        const id_pays = $(this).val();
                        $("#villes").val(undefined);
                        $("#villes option[data-pays='" + id_pays + "']").css("display", "block");
                        $("#villes option:not([data-pays='" + id_pays + "'])").css("display", "none");
                    });

                    $('#villes').change(function(e) {
                        const selectedText = $("#villes option:selected").text();
                        $('#Villenom').val(selectedText);
                    });
                })
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