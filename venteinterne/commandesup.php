<?php
session_start();
require_once "../configs.php";

$excecuteIsOk = "none";
$resultfour = [];
$nomfiche = "";

$y =  date('Y');
$m =  date('m');
$d =  date('d');


// Vérifiez si l'utilisateur est connecté, sinon redirigez-le vers la page de connexion
if (!isset($_SESSION["users"])) {
    header("Location: /Login.php");
} else {
    $sqlclient = 'SELECT * FROM tclients ORDER BY designations';
    $reqclient = $conn->query($sqlclient);

    $RSqlste = "SELECT * FROM `tsociete` WHERE `id`  = '1' ";
    $queryste = $conn->prepare($RSqlste);
    $queryste->execute();
    $resultste = $queryste->fetch(PDO::FETCH_ASSOC);

    if (isset($_POST["btn_update"])) {
        if ($_POST["idclient"] == "SELECTIONNER CLIENT" or $_POST["proforma"] == "" or $_POST["dateproforma"] == "") {
            echo "<script> alert('Champ manquant , selectionnez un client '); </script>";
        } else {
            $sqlcompteur = 'SELECT * FROM compteur where cle="' . $_POST["proforma"] . '"';
            $reqcompteur = $conn->query($sqlcompteur);
            $nvCompteur = 1;
            if ($compteur = $reqcompteur->fetch(PDO::FETCH_OBJ)) {
                $nvCompteur = $compteur->valeur + 1;
                $RSqlcompteur = " UPDATE `compteur` SET `valeur` =  valeur +1 WHERE `cle`= '" . $_POST['proforma'] . "' ";
                $querycompteur = $conn->prepare($RSqlcompteur);
                $querycompteur->execute();
            } else {
                $RSqlcompteur = " INSERT INTO `compteur` VALUES ('" . $_POST['proforma'] . "',1)";
                $querycompteur = $conn->prepare($RSqlcompteur);
                $querycompteur->execute();
            }
            $ncommande = sprintf("%s%04d", $_POST["proforma"], $nvCompteur);
            var_dump($nvCompteur);
            var_dump($ncommande);
            $RSqls = "INSERT `tdocuments`(
                            `dates`,
                            `types`,
                            `id_client`,
                            `observation`,
                            `etat`,
                            `numeros`,
                            `source_id`,
                            `totalht`,
                            `tfrais`,
                            `ttransport`,
                            `etatcmd`
                            )
                            VALUES
                            (
                            :dates,
                            :types,
                            :id_client,
                            :observation,
                            :etat,
                            :numeros,
                            :source_id,
                            :totalht,
                            :tfrais,
                            :ttransport,
                            :etatcmd
                            )";

            $query = $conn->prepare($RSqls);
            $query->bindValue(":dates", $_POST["dateproforma"], PDO::PARAM_STR);
            $query->bindValue(":types", "PR", PDO::PARAM_STR);
            $query->bindValue(":id_client", $_POST["idclient"], PDO::PARAM_STR);
            var_dump($ncommande);
            $query->bindValue(":numeros", $ncommande);
            //$query->bindValue(":numero", $ncommande, PDO::PARAM_STR);
            $query->bindValue(":etat", "", PDO::PARAM_STR);
            $query->bindValue(":observation", "", PDO::PARAM_STR);
            $query->bindValue(":source_id", $nvCompteur, PDO::PARAM_INT);
            $query->bindValue(":totalht", 0, PDO::PARAM_INT);
            $query->bindValue(":tfrais", 0, PDO::PARAM_INT);
            $query->bindValue(":ttransport", 0, PDO::PARAM_INT);
            $query->bindValue(":etatcmd", "Emis", PDO::PARAM_STR);

            $excecuteIsOk = $query->execute() ? "succes" : "error";
            if ($excecuteIsOk) {
                header("Location: detailventeproforma.php");
            }
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
    <title>SALS EXPRESS</title>

    <!--<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">-->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <!--<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@500&family=Montserrat:wght@100&family=Yellowtail&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700" rel="stylesheet">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <!--<script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>-->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="/css/Stylefacture.css" />
    <script>
        function confirmer(id) {

            if (confirm("Voulez-vous supprimer cet article ?")) {
                location.href = "delete.php?id=" + id;
            }
        }
    </script>
</head>

<body>
    <header class="nav1">
        <!-- Logo-->
        <p class="slogan" href="#">
            <img src="/img/SALS1L.png" alt="logoAtelier" />
            <a><?php echo htmlspecialchars($resultste["designation"], ENT_QUOTES, 'UTF-8'); ?> </a>
        </p>
    </header>

    <div class="container">
        <div style="height:10px;"></div>
        <div class="well">
            <div class="dv1" style="text-align:center; margin:10px; box-shadow: 2px -1px 3px ;">
                <h2 style="text-shadow: 1px 1px 2px brown, 0 0 1em brown, 0 0 0.2em brown;"> COMMANDE CLIENT </h2>
            </div>
            <form action="" method="POST" name="modfours" value="modfour">
                <div class="d-flex align-self-stretch" style="height:185px; display: flex;">
                    <div class="p-4 flex-fill dv" style=" padding: 1px; ">
                        <div class=" form-group1 input-group" style=" padding: 1px;">
                            <span class="input-group-addon" style="width:120px; text-align: left; ">N° Commande :</span>
                            <input type="text" readonly onkeydown="upperCaseFun(this)" style="width:130px; text-align: left;" id="proforma" name="proforma" value="<?php echo $y . 'FP-' . $m; ?>">
                        </div>
                        <div class=" form-group1 input-group" style=" padding: 1px;">
                            <span class="input-group-addon" style="width:122px; text-align: left;">Date Cmd :</span>
                            <input type="date" style="width:130px; " id="dateproforma" name="dateproforma">
                        </div>
                        <div class=" form-group1 input-group" style=" padding: 1px;">
                            <span class="input-group-addon" style="width:122px; text-align: left;">N° B.L. :</span>
                            <input type="text" readonly onkeydown="upperCaseFun(this)" style="width:130px;" id="bonlivraison" name="bonlivraison">
                        </div>
                        <div class=" form-group1 input-group" style=" padding: 1px;">
                            <span class="input-group-addon" style="width:122px; text-align: left;">Date B.L. :</span>
                            <input type="date" readonly style="width:130px;" id="datebl" name="datebl">
                        </div>
                        <div class=" form-group1 input-group" style=" padding: 1px;">
                            <span class="input-group-addon" style="width:122px; text-align: left;">N° Facture :</span>
                            <input type="text" readonly onkeydown="upperCaseFun(this)" style="width:130px;" id="nfature" name="nfature">
                        </div>
                        <div class=" form-group1 input-group" style=" padding: 1px;">
                            <span class="input-group-addon" style="width:122px; text-align: left;">Date Facture :</span>
                            <input type="date" readonly style="width:130px;" id="datefacture" name="datefacture">
                        </div>
                    </div>

                    <div class="p-4 flex-fill dv" style=" padding: 2px;">
                        <div class=" form-group1 input-group" style=" padding: 1px;">
                            <span class="input-group-addon" style="width:85px; text-align: left; ">Client :</span>
                            <select id="idclient" name="idclient" onchange="detail()" size="1" style="width:263px;" class="form-control1 ">
                                <option>SELECTIONNER CLIENT</option>
                                <?php
                                while ($c = $reqclient->fetch(PDO::FETCH_OBJ)) {
                                    echo '<option value="' . $c->id . '"  data-client="' . $c->id . '" data-adresse="' . $c->adresse . '" data-telephone="' . $c->telephone . '" data-email="' . $c->email . '">' . $c->designations . '</option>';
                                }
                                ?>
                            </select>
                            <a href="../venteinterne/listeclient.php" class="btn btn-primary" style="padding: 1px 5px; width:75px; height: 25px; margin:2px;" name="btn_news">Client</a>
                        </div>
                        <div class=" form-group1 input-group" style=" padding: 1px;">
                            <span class="input-group-addon" style="width:85px; text-align: left;">Adresse :</span>
                            <!--   <input type="text" readonly onkeydown="upperCaseFun(this)" style="width:350px; " id="adresses" name="adresse">-->
                            <input type="text" readonly onkeydown="upperCaseFun(this)" style="width:350px;" id="adresse" name="adresse">

                        </div>
                        <div class=" form-group1 input-group" style=" padding: 1px;">
                            <span class="input-group-addon" style="width:85px; text-align: left;">Tel :</span>
                            <input type="text" readonly onkeydown="upperCaseFun(this)" style="width:350px;" id="telephone" name="telephone">
                        </div>
                        <div class=" form-group1 input-group" style=" padding: 1px;">
                            <span class="input-group-addon" style="width:85px; text-align: left;">Email :</span>
                            <input type="email" onkeydown="upperCaseFun(this)" style="width:350px;" id="email" name="email">
                        </div>
                        <div class=" form-group1 input-group" style=" padding: 1px;">
                            <span class="input-group-addon" style="width:85px; text-align: left;">Adr Geo :</span>
                            <textarea name="adrgeo" id="adrgeo" cols="20" rows="3" style="width:350px; height: 50px;"></textarea>
                        </div>
                    </div>

                    <div class="p-4 flex-fill dv" style=" padding: 2px;">
                        <div class=" form-group1 input-group" style=" padding: 1px;">
                            <span class="input-group-addon" style="width:105px; text-align: left;"> </span>
                            <!--        <input type="text" readonly onkeydown="upperCaseFun(this)" style="width:140px; " id="adresse1" name="adresse1" required> -->
                        </div>
                        <div class=" form-group1 input-group" style=" padding: 1px;">
                            <span class="input-group-addon" style="width:105px; text-align: left;">Total HT :</span>
                            <input type="text" readonly onkeydown="upperCaseFun(this)" style="width:140px;" id="totalht" name="totalht" required>
                        </div>
                        <div class=" form-group1 input-group" style=" padding: 1px;">
                            <span class="input-group-addon" style="width:105px; text-align: left;"> </span>
                            <!--        <input type="text" readonly onkeydown="upperCaseFun(this)" style="width:140px; " id="adresse1" name="adresse1" required> -->
                        </div>

                        <div class=" form-group1 input-group" style=" padding: 1px;">
                            <span class="input-group-addon" style="width:105px; text-align: left;">Frais Ges :</span>
                            <input type="text" readonly onkeydown="upperCaseFun(this)" style="width:140px;" id="frais" name="frais" required>
                        </div>
                        <div class=" form-group1 input-group" style=" padding: 1px;">
                            <span class="input-group-addon" style="width:105px; text-align: left;"> </span>
                            <!--        <input type="text" readonly onkeydown="upperCaseFun(this)" style="width:140px; " id="adresse1" name="adresse1" required> -->
                        </div>

                        <div class=" form-group1 input-group" style=" padding: 1px;">
                            <span class="input-group-addon" style="width:105px; text-align: left;">Transport :</span>
                            <input type="text" readonly onkeydown="upperCaseFun(this)" style="width:140px;" id="transport" name="transport" required>
                        </div>

                        <div class=" form-group1 input-group" style=" padding: 1px;">
                            <span class="input-group-addon" style="width:105px; text-align: left;"> </span>
                            <!--        <input type="text" readonly onkeydown="upperCaseFun(this)" style="width:140px; " id="adresse1" name="adresse1" required> -->
                        </div>

                        <div class=" form-group1 input-group" style=" padding: 1px;">
                            <span class="input-group-addon" style="width:105px; text-align: left;">TTC :</span>
                            <input type="text" readonly onkeydown="upperCaseFun(this)" style="width:140px;" id="totalttc" name="totalttc" required>
                        </div>
                    </div>
            </form>
            <div class="p-4 flex-fill dv" style=" padding: 10px;">
                <button type="submit" class="btn btn-success " name="btn_update" style=" padding: 8px; margin:15px;"><span class="glyphicon glyphicon-edit"></span> Valider</button>

                <a href="listevente.php" class="btn btn-default" style=" padding: 8px; margin:15px;"><span class="glyphicon glyphicon-remove"></span> Quitter</a>
            </div>
        </div>
        <table width="100%" class="table table-bordered border-primary table-hover" id="tfour">
            <thead>
                <th scope="col" class="T1">Code</th>
                <th scope="col" class="T2">Designation</th>
                <th scope="col" class="T3" style="width: 60px; ">Prix</th>
                <th scope="col" class="T5" style="width: 50px;">Quantité</th>
                <th scope="col" class="T6" style="width: 50px;">Unité</th>
                <th scope="col" class="T7" style="width: 110px;">Total Ht</th>
                <th scope="col" class="T8" style="width: 90px;">Actions</th>
                <th scope="col" class="T4" style="width: 20px; display:none">Total Remise</th>
                <th scope="col" class="T4" style="width: 20px; display:none">Total TVA</th>
                <th scope="col" class="T4" style="width: 20px; display:none">Total AIRSI</th>
                <th scope="col" class="T4" style="width: 50px; display:none">Code Vente</th>
                <th scope="col" class="T4" style="width: 50px; display:none">ID</th>
            </thead>
            <tbody>

            </tbody>
        </table>
    </div>
    <div class="modal-footer">
        <!--   <a href="news.php" class="btn btn-primary"><span class="glyphicon glyphicon-plus"></span> Ajouter</a>-->
        <a href="listevente.php" class="btn btn-default"><span class="glyphicon glyphicon-remove"></span> Quitter</a>
    </div>
    </div>
    </div>
    <script>
        // $(function() {

        //    $('#idclient').change(function recid() {
        //         var id = $(this).find('option:selected').val();
        //         alert(id);
        //     });
        // })

        $(function() {
            $('#idclient').change(function(e) {
                const id_client = $(this).val();
                const option = $("#idclient option[data-client='" + id_client + "']");
                $("#adresse").val(option.data("adresse"))
                $("#telephone").val(option.data("telephone"))
                $("#email").val(option.data("email"))
                $("#adrgeo").val(option.data("adrgeographique"))
            })

            $('#sousfamille').change(function(e) {
                const code_sous_famille = $("#sousfamille option:checked").attr("data-code2");

                $("#ecodes").val(code_categorie + code_famille + code_sous_famille);
            })
        })
    </script>
</body>

</html>