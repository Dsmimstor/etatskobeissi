<?php
session_start();
require_once "../configs.php";
//include_once "../template/listepays.php";
$excecuteIsOk = "none";
$resultfour = [];
$nomfiche = "";

$y =  date('Y');
$m =  date('m');
$d =  date('d');

if (!isset($_SESSION["users"])) {
    header("Location: /Login.php");
} else {
    $RSqlste = "SELECT * FROM `tsociete` WHERE `id`  = '1' ";
    $queryste = $conn->prepare($RSqlste);
    $queryste->execute();
    $resultste = $queryste->fetch(PDO::FETCH_ASSOC);
    
    $id = $_GET["id"];
    $iddocument= $_GET["id"];
    $RSqlncmd = "SELECT * FROM `tdocuments` WHERE `id` = '$id' ";
    $queryncmd = $conn->prepare($RSqlncmd);
    $queryncmd->execute();
    $resultncmd = $queryncmd->fetch(PDO::FETCH_ASSOC);

    if (isset($_POST["btn_update"])) {
        $RSqls = "INSERT `tdetail_document`(
                            `prix`,
                            `quantite`,
                            `id_document`,
                            `articles`,
                            `sites`
                            )
                            VALUES
                            (
                            :prix,
                            :quantite,
                            :id_document,
                            :articles,
                            :sites
                            )";
        $query = $conn->prepare($RSqls);
        $query->bindValue(":prix", $_POST["prix"], PDO::PARAM_INT);
        $query->bindValue(":quantite", $_POST["quantite"], PDO::PARAM_INT);
        $query->bindValue(":id_document", $id, PDO::PARAM_STR);
        $query->bindValue(":articles", $_POST["articles"], PDO::PARAM_STR);
        $query->bindValue(":sites", $_POST["sites"], PDO::PARAM_STR);
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
    <title>SALS EXPRESS</title>
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
        echo "<script> alert('La commande a été Ajoutée');window.location.href='detailventeproforma.php?id=" . $iddocument . "';</script>";
    }
    if ($excecuteIsOk == "error") {
        echo "<script> alert('Echec de l Ajoutée de l'element'); </script>";
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
            <h2 class="text-center">AJOUTER ARTICLE</h2>
            <form action="" method="post" enctype="multipart/form-data" name="modfours" value="modfour">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-body">
                            <div class="container-fluid">
                                <div class="form-group input-group">
                                    <span class="input-group-addon" style="width:150px;">Code de vente :</span>
                                    <input type="text" readonly onkeydown="upperCaseFun(this)" style="width:350px; text-align: left;" class="form-control" id="ecodes" name="codes" value="<?php echo $resultncmd["numeros"]; ?>">
                                </div>
                                <div class="form-group input-group">
                                    <span class="input-group-addon" style="width:150px;">Article :</span>
                                    <input type="text" onkeydown="upperCaseFun(this)" style="width:350px;" class="form-control" id="articles" name="articles">
                                </div>
                                <div class="form-group input-group">
                                    <span class="input-group-addon" style="width:150px;">Site :</span>
                                    <input type="text" style="width:350px;" class="form-control" id="sites" name="sites">
                                </div>
                                <div class="form-group input-group">
                                    <span class="input-group-addon" style="width:150px;">Prix :</span>
                                    <input type="number" step='0.01' style="width:350px;" class="form-control" id="prix" name="prix" oninput="calculate()" value="0">
                                </div>
                                <div class="form-group input-group">
                                    <span class="input-group-addon" style="width:150px;">Quantité :</span>
                                    <input type="number" style="width:350px;" class="form-control" id="quantite" name="quantite" oninput="calculate()" value="0">
                                </div>
                                <div class="form-group input-group">
                                    <span class="input-group-addon" style="width:150px;">Total HT :</span>
                                    <input type="number" style="width:350px;" class="form-control" id="ttotalht" name="ttotalht" value="0" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success " name="btn_update"><span class="glyphicon glyphicon-edit"></span> Ajouter</button>
                            <a type="button" href="/venteinterne/detailventeproforma.php?id=<?php echo $id; ?>" class="btn btn-default"><span class="glyphicon glyphicon-remove"></span> Annuler</a>
                        </div>
                    </div>
                </div>
            </form>
            ;
        </div>
    </div>
    </div>
    <script>
        function upperCaseFun(a) {
            setTimeout(function() {
                a.value = a.value.toUpperCase();
            }, 1);
        }

        function calculate() {

            var myBox1 = document.getElementById('prix').value;
            var myBox2 = document.getElementById('quantite').value;
            var result = document.getElementById('ttotalht');
            var myResult = myBox1 * myBox2;
            document.getElementById('ttotalht').value = myResult;

        }
    </script>
</body>

</html>