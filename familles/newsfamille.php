<?php
session_start();
require_once "../configs.php";

$excecuteIsOk = "none";

if (!isset($_SESSION["users"])) {
    header("Location: /Login.php");
} else {

    $sqlcat = 'SELECT * FROM tcategories ORDER BY designationcat';
    $reqcat = $conn->query($sqlcat);

    $sqlfamille = 'SELECT * FROM tfamilles  ORDER BY designationfam';
    $reqfamille = $conn->query($sqlfamille);

    if (!empty($_POST)) {

        if (
            isset(
                $_POST["names"],
                $_POST["code"],
            ) &&
            !empty($_POST["names"]) &&
            !empty($_POST["code"])

        ) {

            $code = $_POST["code"];
            $names = $_POST["names"];
            $idcat = $_POST["categories"];

            $RSqls = " INSERT INTO `tfamilles`(`codefam`, `designationfam`, `id_cat`) VALUES (:code,:names,:icategorie)";

            $query = $conn->prepare($RSqls);

            $query->bindValue(":code", $code, PDO::PARAM_STR);
            $query->bindValue(":names", $names, PDO::PARAM_STR);
            $query->bindValue(":icategorie", $idcat, PDO::PARAM_STR);

            $excecuteIsOk = $query->execute() ? "succes" : "error";
            $res = $query->fetch();
        } else {
            echo
            "<script> alert('Le formulaire est incomplet'); </script>";
        }
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
        echo
        "<script> alert('La Famille a été enregistré'); location.href='listefamille.php'; </script>";
    }
    if ($excecuteIsOk == "error") {
        "<script> alert('Echec de l\'enregistré de l\'Element'); </script>";
    } ?>

</head>
<header class="nav1">
    <!-- Logo-->
    <p class="slogan" href="#">
        <img src="/img/LOGO%20ATELIER%20DE%20CHOCOLATAE.jpg" alt="logoAtelier" />
        <a>L'Atelier du Chocolat</a>
    </p>
</header>

<body>
    <div class="container">
        <div style="height:50px;"></div>
        <div class="well">
            <h2 class="text-center">AJOUTER FAMILLE</h2>
            <form action="" method="POST" name="modfours" value="modfour">

                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="myModalLabel">.</h4>
                        </div>
                        <div class="modal-body">
                            <div class="container-fluid">
                                <input type="hidden" style="width:350px; text-align: left;" class="form-control" id="eid" name="id">
                                <div class="form-group input-group">
                                    <span class="input-group-addon" style="width:150px;">code :</span>
                                    <input type="text" onkeydown="upperCaseFun(this)" style="width:350px; text-align: left;" class="form-control" id="ecodes" name="code">
                                </div>
                                <div class=" form-group input-group">
                                    <span class="input-group-addon" style="width:150px;">Désignation :</span>
                                    <input type="text" onkeydown="upperCaseFun(this)" style="width:350px;" class="form-control" id="edesignation" name="names">
                                </div>
                                <div class="form-group input-group">
                                    <span class="input-group-addon" style="width:150px;">Categorie :</span name="formatpays">
                                    <select id="categorie" name="categories" size="1" style="width:350px;" class="form-control">
                                        <option>Selectionnez la Categorie</option>
                                        <?php
                                        while ($c = $reqcat->fetch(PDO::FETCH_OBJ)) {
                                            echo '<option value="' . $c->id . '"  data-code="' . $c->codecat . '">' . $c->designationcat . '</option>';
                                        } ?>
                                    </select>
                                </div>
                                <input type="hidden" onkeydown="upperCaseFun(this)" style="width:350px;" readonly class="form-control" id="affcode" name="affcode">

                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-success " name="btn_news"><span class="glyphicon glyphicon-edit"></span> Ajouter</button>
                                    <a href="listefamille.php" class="btn btn-default"><span class="glyphicon glyphicon-remove"></span> Annuller</a>
                                </div>
                            </div>
                        </div>
                    </div>
            </form>
        </div>
    </div>
    <script>
        function upperCaseFun(a) {
            setTimeout(function() {
                a.value = a.value.toUpperCase();
            }, 1);
        }
    </script>
    <script>
        $(function() {
            $('#categorie').change(function(e) {
                const code_famille = $("#categorie option:checked").attr("data-code");
                const code = $("#ecodes").val();
                $("#affcode").val(code_famille + code);
            })
            $('#ecodes').change(function(e) {
                const code = $(this).val();
                const code_famille = $("#categorie option:checked").attr("data-code");
                $("#affcode").val(code_famille + code);
            })
        })
    </script>

</body>

</html>