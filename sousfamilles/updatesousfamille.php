<?php
session_start();
require_once "../configs.php";
$excecuteIsOk = "none";
$resultfour = [];
if (!isset($_SESSION["users"])) {
    header("Location: /Login.php");
} else {


    $sqlcategorie = 'SELECT * FROM tcategories ORDER BY designationcat';
    $reqcategorie = $conn->query($sqlcategorie);

    $sqlfamille = 'SELECT * FROM tfamilles  ORDER BY designationfam';
    $reqfamille = $conn->query($sqlfamille);



    if (isset($_POST["btn_update"])) {

        $resultfour["id"] = $_POST["id"];
        $resultfour["code"] = $_POST["code"];
        $resultfour["designationfam"] = $_POST["names"];
        $resultfour["id_fam"] = $_POST["familles"];
        $resultfour["codesousfamille"] = $_POST["affcode"];
        $idfour = $_POST["id"];


        $RSqls = "UPDATE `tsousfamilles` SET
       `id_fam`=:idfam,
        `codesousfam`=:code,
        `designationsousfam`=:names,
        `codesousfamille`=:codesfam  WHERE `id`=$idfour";

        $query = $conn->prepare($RSqls);

        /*  $query->bindValue(":code", $_POST["codes"], PDO::PARAM_STR);*/
        $query->bindValue(":code", $_POST["code"], PDO::PARAM_STR);
        $query->bindValue(":names", $_POST["names"], PDO::PARAM_STR);
        $query->bindValue(":idfam", $_POST["familles"], PDO::PARAM_INT);
        $query->bindValue(":codesfam", $_POST["affcode"], PDO::PARAM_STR);


        $excecuteIsOk = $query->execute() ? "succes" : "error";
    } else {
        $id = $_GET["id"];
        $RSqls = "SELECT * FROM `tsousfamilles` WHERE `id` = '$id' ";

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
        "<script> alert('La Sous Famille a été modifié'); location.href='listesousfamille.php'; </script>";
    }
    if ($excecuteIsOk == "error") {
        "<script> alert('Echec de la modification de la Sous Famille'); </script>";
    } ?>
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
        <a>L'Atelier du Chocolat</a>
    </p>
</header>

<body>
    <div class="container">
        <div style="height:50px;"></div>
        <div class="well">
            <h2 class="text-center"> MODIFER SOUS FAMILLE</h2>
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
                                    <input type="text" onkeydown="upperCaseFun(this)" style="width:350px; text-align: left;" class="form-control" id="abreviation" name="code" value="<?php echo $resultfour["codesousfam"]; ?>">
                                </div>
                                <div class=" form-group input-group">
                                    <span class="input-group-addon" style="width:150px;">Désignation :</span>
                                    <input type="text" onkeydown="upperCaseFun(this)" style="width:350px;" class="form-control" id="names" name="names" value="<?php echo $resultfour["designationsousfam"]; ?>">
                                </div>
                                <div class="form-group input-group">
                                    <span class="input-group-addon" style="width:150px;">Famille :</span name="formatpays">
                                    <select id="sfamille" name="familles" size="1" style="width:350px;" class="form-control">
                                        <option>Selectionnez la Famille</option>
                                        <?php
                                        while ($c = $reqfamille->fetch(PDO::FETCH_OBJ)) {
                                            echo '<option value="' . $c->id . '" ' . ($c->id == $resultfour['id_fam'] ? "selected" : "") . '  data-code="' . $c->codefam . '">' . $c->designationfam . '</option>';
                                        } ?>
                                    </select>
                                </div>
                                <input type="hidden" onkeydown="upperCaseFun(this)" style="width:350px;" readonly class="form-control" id="affcodes" name="affcode" value="<?php echo $resultfour["codesousfamille"]; ?>">

                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-success " name="btn_update"><span class="glyphicon glyphicon-edit"></span> Modififer</button>
                                    <a href="listesousfamille.php" class="btn btn-default"><span class="glyphicon glyphicon-remove"></span> Annuller</a>
                                </div>
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
            $('#sfamille').change(function(e) {
                const code_famille = $("#sfamille option:checked").attr("data-code");
                const codes = $("#abreviation").val();
                $("#affcodes").val(code_famille + codes);
            })
            $('#abreviation').change(function(e) {
                const codes = $(this).val();
                const code_famille = $("#sfamille option:checked").attr("data-code");
                $("#affcodes").val(code_famille + codes);
            })
        })
    </script>

</body>

</html>