<?php
session_start();
require_once "../configs.php";
include_once "../template/listeville.php";
$excecuteIsOk = "none";
$resultfour = [];
if (!isset($_SESSION["users"])) {
    header("Location: /Login.php");
    exit();
} else {
    $sqlPays = 'SELECT * FROM tpays ORDER BY names';
    $reqPays = $conn->query($sqlPays);

    $RSqlste = "SELECT * FROM `tsociete` WHERE `id`  = '1' ";
    $queryste = $conn->prepare($RSqlste);
    $queryste->execute();
    $resultste = $queryste->fetch(PDO::FETCH_ASSOC);


    $sqlmeuble = 'SELECT * FROM ttypelocal ORDER BY types';
    $reqmeuble = $conn->query($sqlmeuble);

    $sqlVille = 'SELECT * FROM tvilles ORDER BY names';
    $reqVille = $conn->query($sqlVille);
    if (isset($_POST["btn_update"])) {
        $resultfour["id"] = $_POST["id"];
        $resultfour["quartier"] = $_POST["quartier"];
        $resultfour["typelocal"] = $_POST["typelocal"];
        $resultfour["nbatiment"] = $_POST["nbatiment"];
        $resultfour["niveauetage"] = $_POST["niveauetage"];
        $resultfour["nombrepiece"] = $_POST["nombrepiece"];
        $resultfour["nappartement"] = $_POST["nappartement"];
        $resultfour["meuble"] = $_POST["meuble"];
        $resultfour["id_ville"] = $_POST["villes"];
        $idfour = $_POST["id"];
        $RSqls = "UPDATE `tlocal` SET
            `quartier` = :quartier,
            `typelocal` = :typelocal,
            `nbatiment` = :nbatiment,
            `niveauetage` = :niveauetage,
            `nombrepiece` = :nombrepiece,
            `nappartement` = :nappartement,
            `meuble` = :meuble,
            `locaux` = :locaux,
            `id_ville` = :formatville
            WHERE `id` = :id";

        $query = $conn->prepare($RSqls);

        $query->bindValue(":quartier", $_POST["quartier"], PDO::PARAM_STR);
        $query->bindValue(":typelocal", $_POST["typelocal"], PDO::PARAM_STR);
        $query->bindValue(":nbatiment", $_POST["nbatiment"], PDO::PARAM_STR);
        $query->bindValue(":niveauetage", $_POST["niveauetage"], PDO::PARAM_STR);
        $query->bindValue(":nombrepiece", $_POST["nombrepiece"], PDO::PARAM_STR);
        $query->bindValue(":nappartement", $_POST["nappartement"], PDO::PARAM_STR);
        $query->bindValue(":meuble", $_POST["meuble"], PDO::PARAM_STR);
        $query->bindValue(":formatville", $_POST["villes"], PDO::PARAM_INT);
        $query->bindValue(":id", $idfour, PDO::PARAM_INT);

        $locaux = $_POST["Villenom"] . " - " . $_POST["nbatiment"] . " - " . $_POST["niveauetage"] . " - " . $_POST["nappartement"] . " - " . $_POST["nombrepiece"];
        $query->bindValue(":locaux", $locaux, PDO::PARAM_STR);

        $excecuteIsOk = $query->execute() ? "succes" : "error";
    } else {
        $id = $_GET["id"];
        $RSqls = "SELECT f.*, v.id_pays FROM `tlocal` f INNER JOIN `tvilles` v ON f.id_ville = v.id WHERE f.`id` = :id";
        $query = $conn->prepare($RSqls);
        $query->bindValue(":id", $id, PDO::PARAM_INT);
        $query->execute();
        $resultfour = $query->fetch(PDO::FETCH_ASSOC);
    }

    $ville = $resultfour["id_ville"];

    $RSqlsv = "SELECT * FROM `tvilles` WHERE `id`  = '$ville' ";
    $queryv = $conn->prepare($RSqlsv);
    $queryv->execute();
    $resultv = $queryv->fetch(PDO::FETCH_ASSOC);
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
        echo "<script> alert('L\'élément a été modifié'); location.href='listeloco.php'; </script>";
    }
    if ($excecuteIsOk == "error") {
        echo "<script> alert('Échec de la modification de l\'élément'); </script>";
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
            <h2 class="text-center">MODIFIER LOCAL</h2>
            <form action="" method="POST" name="modfours" value="modfour">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="myModalLabel">.</h4>
                        </div>
                        <div class="modal-body">
                            <div class="container-fluid">
                                <input type="hidden" style="width:350px; text-align: left;" class="form-control" id="eid" name="id" value="<?php echo htmlspecialchars($resultfour["id"]); ?>">
                                <div class="form-group input-group">
                                    <span class="input-group-addon" style="width:150px;">Pays :</span>
                                    <select id="pays" name="pays" size="1" style="width:350px;" class="form-control">
                                        <?php
                                        while ($p = $reqPays->fetch(PDO::FETCH_OBJ)) {
                                            echo '<option value="' . htmlspecialchars($p->id) . '" ' . ($p->id == $resultfour['id_pays'] ? "selected" : "") . '>' . htmlspecialchars($p->names) . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group input-group">
                                    <span class="input-group-addon" style="width:150px;">Ville :</span>
                                    <select id="villes" name="villes" size="1" style="width:270px;" class="form-control">
                                        <?php
                                        while ($p = $reqVille->fetch(PDO::FETCH_OBJ)) {
                                            echo '<option value="' . htmlspecialchars($p->id) . '" ' . ($p->id == $resultfour['id_ville'] ? "selected" : "") . ' data-pays="' . htmlspecialchars($p->id_pays) . '" style="display:' . ($p->id_pays == $resultfour['id_pays'] ? "block" : "none") . '">' . htmlspecialchars($p->names) . '</option>';
                                        }
                                        ?>
                                    </select>
                                    <a href="../ville/listeville.php" class="btn btn-info" style="padding: 5px 15px;" name="btn_news"><span class="glyphicon glyphicon-edit"></span> Ville</a>
                                </div>
                                <div class="form-group input-group">
                                    <span class="input-group-addon" style="width:150px;">Quartier :</span>
                                    <input type="text" style="width:350px;" class="form-control" id="quartier" name="quartier" value="<?php echo htmlspecialchars($resultfour["quartier"]); ?>">
                                </div>
                                <div class="form-group input-group">
                                    <span class="input-group-addon" style="width:150px;">Type Local :</span>
                                    <input type="text" style="width:350px;" class="form-control" id="typelocal" name="typelocal" value="<?php echo htmlspecialchars($resultfour["typelocal"]); ?>">
                                </div>
                                <div class="form-group input-group">
                                    <span class="input-group-addon" style="width:150px;">N° Batiment :</span>
                                    <input type="text" style="width:350px;" class="form-control" id="nbatiment" name="nbatiment" value="<?php echo htmlspecialchars($resultfour["nbatiment"]); ?>">
                                </div>
                                <div class="form-group input-group">
                                    <span class="input-group-addon" style="width:150px;">Niveau étage :</span>
                                    <input type="text" style="width:350px;" class="form-control" id="niveauetage" name="niveauetage" value="<?php echo htmlspecialchars($resultfour["niveauetage"]); ?>">
                                </div>
                                <div class="form-group input-group">
                                    <span class="input-group-addon" style="width:150px;">Nom Appartement :</span>
                                    <input type="text" style="width:350px;" class="form-control" id="nappartement" name="nappartement" value="<?php echo htmlspecialchars($resultfour["nappartement"]); ?>">
                                </div>
                                <div class="form-group input-group">
                                    <span class="input-group-addon" style="width:150px;">Nombre de pièce :</span>
                                    <input type="text" style="width:350px;" class="form-control" id="nombrepiece" name="nombrepiece" value="<?php echo htmlspecialchars($resultfour["nombrepiece"]); ?>">
                                </div>
                                <div class="form-group input-group">
                                    <span class="input-group-addon" style="width:150px;">Appart Meublé :</span>
                                    <select id="meuble" name="meuble" size="1" style="width:350px;" class="form-control">
                                        <?php
                                        while ($m = $reqmeuble->fetch(PDO::FETCH_OBJ)) {
                                            echo '<option value="' . htmlspecialchars($m->id) . '" ' . ($m->id == $resultfour['id'] ? "selected" : "") . '>' . htmlspecialchars($m->types) . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>

                                <input type="hidden" style="width:350px;" class="form-control" id="Villenom" name="Villenom" value="<?php echo htmlspecialchars($resultv["names"]); ?>">
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-success" name="btn_update"><span class="glyphicon glyphicon-edit"></span> Modifier</button>
                                    <a href="listeloco.php" class="btn btn-default"><span class="glyphicon glyphicon-remove"></span> Annuler</a>
                                </div>
                            </div>
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
                document.getElementById('villes').addEventListener('change', function() {
                    var selectedOption = this.options[this.selectedIndex];
                    document.getElementById('Villenom').value = selectedOption.text;
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