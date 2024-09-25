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

    $sqlVille = 'SELECT * FROM tvilles  ORDER BY names';
    $reqVille = $conn->query($sqlVille);

    if (isset($_POST["btn_update"])) {

        $resultfour["id"] = $_POST["id"];
        $resultfour["code"] = $_POST["codes"];
        $resultfour["designations"] = $_POST["designation"];
        $resultfour["adresse_geographique"] = $_POST["adressegeo"];
        $resultfour["adresse"] = $_POST["adressepost"];
        $resultfour["email"] = $_POST["email"];
        $resultfour["telephone"] = $_POST["telephone"];
        $resultfour["id_ville"] = $_POST["villes"];
        $resultfour["numero_compte"] = $_POST["comptec"];
        $resultfour["compte_contribuable"] = $_POST["ncompte"];
        $resultfour["code_zip"] = $_POST["codezip"];
        $idfour = $_POST["id"];



        $RSqls = "UPDATE `tclients` SET
        `designations`=:designation,
        `email`=:email,
        `adresse`=:adressepost,
        `code_zip`=:codezip,
        `id_ville`=:formatville,
        `compte_contribuable`=:comptec,
        `adresse_geographique`=:adressegeo,
        `numero_compte`=:ncompte,
        `telephone`=:telephone  WHERE `id`=$idfour";

        $query = $conn->prepare($RSqls);

        /*  $query->bindValue(":code", $_POST["codes"], PDO::PARAM_STR);*/
        $query->bindValue(":designation", $_POST["designation"], PDO::PARAM_STR);
        $query->bindValue(":adressegeo", $_POST["adressegeo"], PDO::PARAM_STR);
        $query->bindValue(":adressepost", $_POST["adressepost"], PDO::PARAM_STR);
        $query->bindValue(":email", $_POST["email"], PDO::PARAM_STR);
        $query->bindValue(":telephone", $_POST["telephone"], PDO::PARAM_STR);
        $query->bindValue(":formatville", $_POST["villes"], PDO::PARAM_INT);
        $query->bindValue(":ncompte", $_POST["ncompte"], PDO::PARAM_STR);
        $query->bindValue(":comptec", $_POST["comptec"], PDO::PARAM_STR);
        $query->bindValue(":codezip", $_POST["codezip"], PDO::PARAM_STR);

        $excecuteIsOk = $query->execute() ? "succes" : "error";
    } else {
        $id = $_GET["id"];
        $RSqls = "SELECT f.*, v.id_pays FROM `tclients` f INNER JOIN `tvilles` v ON f.id_ville = v.id WHERE f.`id` = '$id' ";
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
                                    <span class="input-group-addon" style="width:150px;">code :</span>
                                    <input type="text" onkeydown="upperCaseFun(this)" style="width:350px; text-align: left;" class="form-control" id="ecodes" name="codes" readonly value="<?php echo $resultfour["code"]; ?>">
                                </div>
                                <div class=" form-group input-group">
                                    <span class="input-group-addon" style="width:150px;">Désignation :</span>
                                    <input type="text" style="width:350px;" class="form-control" id="edesignation" name="designation" value="<?php echo $resultfour["designations"]; ?>">
                                </div>
                                <div class="form-group input-group">
                                    <span class="input-group-addon" style="width:150px;">Adresse Geo :</span>
                                    <input type="text" style="width:350px;" class="form-control" id="eadressegeo" name="adressegeo" value="<?php echo $resultfour["adresse_geographique"]; ?>">
                                </div>
                                <div class="form-group input-group">
                                    <span class="input-group-addon" style="width:150px;">Adresse Postal :</span>
                                    <input type="text" style="width:350px;" class="form-control" id="eadressepost" name="adressepost" value="<?php echo $resultfour["adresse"]; ?>">
                                </div>
                                <div class="form-group input-group">
                                    <span class="input-group-addon" style="width:150px;">Email :</span>
                                    <input type="text" style="width:350px;" class="form-control" id="eemail" name="email" value="<?php echo $resultfour["email"]; ?>">
                                </div>
                                <div class="form-group input-group">
                                    <span class="input-group-addon" style="width:150px;">Téléphone :</span>
                                    <input type="text" style="width:350px;" class="form-control" id="etelephone" name="telephone" value="<?php echo $resultfour["telephone"]; ?>">
                                </div>
                                <div class="form-group input-group">
                                    <span class="input-group-addon" style="width:150px;">Pays :</span name="formatpays">
                                    <select id="pays" name="pays" size="1" style="width:350px;" class="form-control">
                                        <?php
                                        while ($p = $reqPays->fetch(PDO::FETCH_OBJ)) {
                                            echo '<option value="' . $p->id . '" ' . ($p->id == $resultfour['id_pays'] ? "selected" : "") . '>' . $p->names . '</option>';
                                        } ?>
                                    </select>
                                </div>
                                <div class="form-group input-group">
                                    <span class="input-group-addon" style="width:150px;">Ville :</span name="formatpays">
                                    <select id="villes" name="villes" size="1" style="width:270px;" class="form-control">
                                        <?php
                                        while ($p = $reqVille->fetch(PDO::FETCH_OBJ)) {
                                            echo '<option value="' . $p->id . '" ' . ($p->id == $resultfour['id_ville'] ? "selected" : "") . ' data-pays="' . $p->id_pays . '" style="display:' . ($p->id_pays == $resultfour['id_pays'] ? "block" : "none") . '">' . $p->names . '</option>';
                                        } ?>
                                    </select>
                                    <a href="../ville/listeville.php" class="btn btn-info" style="padding: 5px 15px;" name="btn_news"><span class="glyphicon glyphicon-edit"></span> Ville</a>
                                </div>
                                <div class="form-group input-group">
                                    <span class="input-group-addon" style="width:150px;">N°Comptes :</span>
                                    <input type="text" style="width:350px;" class="form-control" id="encompte" name="ncompte" value="<?php echo $resultfour["numero_compte"]; ?>">
                                </div>
                                <div class="form-group input-group">
                                    <span class="input-group-addon" style="width:150px;">Compte C:</span>
                                    <input type="text" style="width:350px;" class="form-control" id="ecomptec" name="comptec" value="<?php echo $resultfour["compte_contribuable"]; ?>">
                                </div>
                                <div class="form-group input-group">
                                    <span class="input-group-addon" style="width:150px;">Code Zip:</span>
                                    <input type="text" style="width:350px;" class="form-control" id="ecodezip" name="codezip" value="<?php echo $resultfour["code_zip"]; ?>">
                                </div>
                                <div class="form-group input-group">
                                    <span class="input-group-addon" style="width:150px;">DDDD:</span>
                                    <input type="text" style="width:350px;" class="form-control" id="elastname" name="lastname">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success " name="btn_update"><span class="glyphicon glyphicon-edit"></span> Modififer</button>
                            <a href="liste.php" class="btn btn-default"><span class="glyphicon glyphicon-remove"></span> Annuller</a>
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
                    })
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