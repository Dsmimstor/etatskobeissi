<?php
session_start();
require_once "../configs.php";
$excecuteIsOk = "none";
$resultfour = [];
if (!isset($_SESSION["users"])) {
    header("Location: /Login.php");
} else {
    $RSqlste = "SELECT * FROM `tsociete` WHERE `id`  = '1' ";
    $queryste = $conn->prepare($RSqlste);
    $queryste->execute();
    $resultste = $queryste->fetch(PDO::FETCH_ASSOC);

    if (isset($_POST["btn_update"])) {

        $resultfour["id"] = $_POST["id"];
        $resultfour["value"] = $_POST["abreviation"];
        $resultfour["name"] = $_POST["names"];
        $idfour = $_POST["id"];

        $RSqls = "UPDATE `tdevise` SET
        `abreviation`=:abreviation,
        `names`=:names  WHERE `id`=$idfour";

        $query = $conn->prepare($RSqls);

        /*  $query->bindValue(":code", $_POST["codes"], PDO::PARAM_STR);*/
        $query->bindValue(":abreviation", $_POST["abreviation"], PDO::PARAM_STR);
        $query->bindValue(":names", $_POST["names"], PDO::PARAM_STR);

        $excecuteIsOk = $query->execute()?"succes":"error";
    } else {
        $id = $_GET["id"];
        $RSqls = "SELECT * FROM `tdevise` WHERE `id`  = '$id' ";
        $query = $conn->prepare($RSqls);
        $query->execute();
        $resultfour = $query->fetch(PDO::FETCH_ASSOC);
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
    <?php 
    if ($excecuteIsOk == "succes") {
        echo
            "<script> alert(La devise a été modifié'); location.href='listedevise.php'; </script>";
    }
    if ($excecuteIsOk == "error") {
        "<script> alert(L\'Echec de la modification de l\'Enregistrement'); </script>";
        }?>
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@500&family=Montserrat:wght@100&family=Yellowtail&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700" rel="stylesheet">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="/css/Stylefournisseurs1.css" />
</head>
<header class="nav1">
    <!-- Logo-->
    <p class="slogan" href="#">
        <img src="/img/LOGO%20ATELIER%20DE%20CHOCOLATAE.jpg" alt="logoAtelier" />
        <a><?php echo $resultste["designation"]; ?> </a>
    </p>
</header>

<body>
    <div class="container">
        <div style="height:50px;"></div>
        <div class="well">
            <center>
                <!--    <h2>Liste des Fournisseurs</h2>-->
                <h2>
                    MODIFER DEVISE</h2>
            </center>
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
                                    <span class="input-group-addon" style="width:150px;">Abreviation :</span>
                                    <input type="text" style="width:350px; text-align: left;" class="form-control" id="abreviation" name="abreviation"  value="<?php echo $resultfour["abreviation"]; ?>">
                                </div>
                                <div class=" form-group input-group">
                                    <span class="input-group-addon" style="width:150px;">Désignation :</span>
                                    <input type="text" style="width:350px;" class="form-control" id="names" name="names" value="<?php echo $resultfour["names"]; ?>">
                                </div>
                          <div class="modal-footer">
                            <button type="submit" class="btn btn-success " name="btn_update"><span class="glyphicon glyphicon-edit"></span> Modififer</button>
                            <a href="listedevise.php" class="btn btn-default"><span class="glyphicon glyphicon-remove"></span> Annuller</a>
                        </div>
                    </div>
                </div>

            </form>
</body>

</html>