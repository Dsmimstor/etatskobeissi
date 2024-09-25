<?php
session_start();
require_once "../configs.php";

// Vérifiez si l'utilisateur est connecté, sinon redirigez-le vers la page de connexion
if (!isset($_SESSION["users"])) {
    header("Location: /Login.php");
} else {
    $sqlclient = 'SELECT * FROM tclients ORDER BY designations';
    $reqclient = $conn->query($sqlclient);
}

if (isset($_POST["btn_valider"])) {
    //$date = new DateTime();
    $date = $_POST["dateproforma"];
    // $aa = $date->format('Y');
    $aa = substr("$date", 2, 2);
    $mois = substr("$date", 5, 2);
    $index = $aa . $mois . "PR";
    $indicecode = $index;
    $sqlcompteur = 'SELECT * FROM compteur where cle="' . $index . '"';
    $reqcompteur = $conn->query($sqlcompteur);
    $nvCompteur = 1;
    if ($compteur = $reqcompteur->fetch(PDO::FETCH_OBJ)) {
        $nvCompteur = $compteur->valeur + 1;
        $RSqlcompteur = " UPDATE `compteur` SET `valeur` =  valeur +1 WHERE `cle`= '" . $index . "' ";
        $querycompteur = $conn->prepare($RSqlcompteur);
        $querycompteur->execute();
        //   $_POST["proforma"] = $indicecode . "-" . $nvCompteur;
        //$newid = str_pad($nvCompteur, 5, "0", STR_PAD_LEFT);
        $nbrcar = strlen($nvCompteur);
        if ($nbrcar == 1) {
            $querycompteur->execute();
            $nproforma = ($indicecode . "-" . "0000" . $nvCompteur);
        } elseif ($nbrcar == 2) {
            $querycompteur->execute();
            $nproforma = ($indicecode . "-" . "000" . $nvCompteur);
        } elseif ($nbrcar == 3) {
            $querycompteur->execute();
            $nproforma = ($indicecode . "-" . "00" . $nvCompteur);
        } elseif ($nbrcar == 4) {
            $querycompteur->execute();
            $nproforma = ($indicecode . "-" . "0" . $nvCompteur);
        } elseif ($nbrcar == 5) {
            $querycompteur->execute();
            $nproforma = ($indicecode . "-" . $nvCompteur);
        }
    } else {
        $RSqlcompteur = " INSERT INTO `compteur` VALUES ('" . $index . "',1)";
        $querycompteur = $conn->prepare($RSqlcompteur);
        $querycompteur->execute();
        $nbrcar = strlen($nvCompteur);
        if ($nbrcar == 1) {
            $querycompteur->execute();
            $nproforma = ($indicecode . "-" . "0000" . $nvCompteur);
        } elseif ($nbrcar == 2) {
            $querycompteur->execute();
            $nproforma = ($indicecode . "-" . "000" . $nvCompteur);
        } elseif ($nbrcar == 3) {
            $querycompteur->execute();
            $nproforma = ($indicecode . "-" . "00" . $nvCompteur);
        } elseif ($nbrcar == 4) {
            $querycompteur->execute();
            $nproforma = ($indicecode . "-" . "0" . $nvCompteur);
        } elseif ($nbrcar == 5) {
            $querycompteur->execute();
            $nproforma = ($indicecode . "-" . $nvCompteur);
        }
    }

    $RSqls = "INSERT INTO `tdocuments`(`dates`, `type`, `id_client`, `observation`, `etat`, `numero`, `source_id`) VALUES(:dates,:typef,:client,:observation,:etat,:nfacture,:source)";

    $query = $conn->prepare($RSqls);

    $query->bindValue(":dates", $_POST["dateproforma"], PDO::PARAM_STR);
    $query->bindValue(":nfacture", $nproforma, PDO::PARAM_STR);
    $query->bindValue(":typef", "PR", PDO::PARAM_STR);
    $query->bindValue(":client", $_POST["client"], PDO::PARAM_STR);
    $query->bindValue(":observation", $_POST["commentaire"], PDO::PARAM_STR);
    $query->bindValue(":etat", "3", PDO::PARAM_STR);
    $query->bindValue(":source", "0", PDO::PARAM_STR);

    $excecuteIsOk = $query->execute() ? "succes" : "error";
}


?>;

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
    <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>

    <link rel="stylesheet" href="/css/Stylefacture.css" />
    <link rel="stylesheet" href="/css/police.css" />
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
            <img src="/img/LOGO%20ATELIER%20DE%20CHOCOLATAE.jpg" alt="logoAtelier" />
            <a>L'Atelier du Chocolat</a>
        </p>
    </header>

    <div class="container">
        <div style="height:10px;"></div>
        <div class="well">
            <div class="dv1" style="text-align:center; margin:10px; box-shadow: 2px -1px 3px ;">
                <h2 style="text-shadow: 1px 1px 2px brown, 0 0 1em brown, 0 0 0.2em brown;"> DETAIL PROFORMA </h2>
            </div>

            <form action="" method="post" enctype="multipart/form-data" name="adentete" value="adentete">
                <div class="d-flex align-self-stretch" style="height:165px; display: flex;">
                    <div class="p-4 flex-fill dv" style=" padding: 1px; ">
                        <div class=" form-group1 input-group" style=" padding: 1px;">
                            <span class="input-group-addon" style="width:142px; text-align: left; ">N° Proforma :</span>
                            <span class="input-group-addon" style="width:180px; text-align: left; background-color:white;" id="proforma" name="proforma ">N° Proforma :</span>
                        <!--   <input type="text" readonly onkeydown="upperCaseFun(this)" style="width:160px; text-align: left;" id="proforma" name="proforma" required>-->
                        </div>
                        <div class=" form-group1 input-group" style=" padding: 1px;">
                            <span class="input-group-addon" style="width:122px; text-align: left;">Date proforma :</span>
                            <span class="input-group-addon" style="width:200px; text-align: left; background-color:white;"  id="dateproforma" name="dateproforma">N° Proforma :</span>
                        </div>
                        <!--                <div class=" form-group1 input-group" style=" padding: 1px;">
                        <span class="input-group-addon" style="width:122px; text-align: left;">N° B.L. :</span>
                        <input type="text" readonly onkeydown="upperCaseFun(this)" style="width:160px;" id="bonlivraison" name="bonlivraison" required>
                    </div>
                    <div class=" form-group1 input-group" style=" padding: 1px;">
                        <span class="input-group-addon" style="width:122px; text-align: left;">Date B.L. :</span>
                        <input type="date" style="width:160px;" id="datebl" name="datebl" required>
                    </div>
                    <div class=" form-group1 input-group" style=" padding: 1px;">
                        <span class="input-group-addon" style="width:122px; text-align: left;">N° Facture :</span>
                        <input type="text" readonly onkeydown="upperCaseFun(this)" style="width:160px;" id="nfature" name="nfature" required>
                    </div>
                    <div class=" form-group1 input-group" style=" padding: 1px;">
                        <span class="input-group-addon" style="width:122px; text-align: left;">Date Facture :</span>
                        <input type="date" style="width:160px;" id="datefacture" name="datefacture" required>
                    </div>
    -->
                    </div>

                    <div class="p-4 flex-fill dv" style=" padding: 2px;">
                        <div class=" form-group1 input-group" style=" padding: 1px;">
                            <span class="input-group-addon" style="width:93px; text-align: left; ">Client :</span>
                            <span class="input-group-addon" style="width:400; text-align: left; background-color:white;"  id="Client" name="Client">Client :</span>

                        </div>
                        <div class=" form-group1 input-group" style=" padding: 1px;">
                            <span class="input-group-addon" style="width:85px; text-align: left;">Adresse :</span>
                            <span class="input-group-addon" style="width:400; text-align: left; background-color:white;" id="adresse" name="adresse">Client :</span>

                        </div>
                        <div class=" form-group1 input-group" style=" padding: 1px;">
                            <span class="input-group-addon" style="width:94px; text-align: left;">Tel :</span>
                               <span class="input-group-addon" style="width:400; text-align: left; background-color:white;" id="telephone" name="telephone">Client :</span>

                        </div>
                        <div class=" form-group1 input-group" style=" padding: 1px;">
                            <span class="input-group-addon" style="width:92px; text-align: left;">Email :</span>
                             <span class="input-group-addon" style="width:400; text-align: left; background-color:white;" id="email" name="email">Client :</span>

                        </div>
                        <div class=" form-group1 input-group" style=" padding: 1px;">
                            <span class="input-group-addon" style="width:92px; text-align: left;">Observ :</span>
                            <span class="input-group-addon" style="width:400; text-align: left; background-color:white;" id="commentaire" name="commentaire">Client :</span>

                          </div>
                    </div>
                    <div class="p-4 flex-fill dv" style=" padding: 2px;">
                        <div class=" form-group1 input-group" style=" padding: 1px;">
                            <span class="input-group-addon" style="width:83px; text-align: left;">Total HT :</span>
                            <span class="input-group-addon" style="width:200px; text-align: left; background-color:white;" id="totaltva" name="totaltva">Client :</span>
                        </div>
                        <div class=" form-group1 input-group" style=" padding: 1px;">
                            <span class="input-group-addon" style="width:105px; text-align: left;"> TVA :</span>
                            <span class="input-group-addon" style="width:200px; text-align: left; background-color:white;" id="totalht" name="totalht">Client :</span>
                        </div>
                        <div class=" form-group1 input-group" style=" padding: 1px;">
                            <span class="input-group-addon" style="width:83px; text-align: left;">T. AIRSI :</span>
                            <span class="input-group-addon" style="width:200px; text-align: left; background-color:white;" id="totaltva" name="totaltva">Client :</span>
                        </div>
                        <div class=" form-group1 input-group" style=" padding: 1px;">
                            <span class="input-group-addon" style="width:285px; text-align: left;">. </span>
                            <input type="hidden" onkeydown="upperCaseFun(this)" style="width:200px;" id="email" name="email" required>
                        </div>
                        
                        <div class=" form-group1 input-group" style=" padding: 1px;">
                            <span class="input-group-addon" style="width:104px; text-align: left;">T. TTC :</span>
                            <span class="input-group-addon" style="width:200px; text-align: left; background-color:white;" id="totalttc" name="totalttc">Client :</span>
                        </div>
                    </div>
                </div>
            </form>
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
                    <?php
                    $RSql = "SELECT a.* , p.code codeprod , p.designations produit , u.abreviation unite FROM `tdetail_document` a INNER JOIN `tproduits`p ON a.id_produit = p.id  INNER JOIN `tunite` u ON a.id_unite = u.id WHERE `id_document`= '" . 2 . "' ";

                    $stmt = $conn->prepare($RSql);
                    $stmt->execute();
                    $servers = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    $server = '';
                    foreach ($servers as $server) {
                    ?>
                        <tr>
                            <td scope="row" style="text-align: center; font-size: 13px ; font-family: sans-serif ;">
                                <span class="border border-primary" id="codefour">
                                    <?= $server["codeprod"] ?>
                                </span>
                            </td>
                            <td style="text-align: left; font-size:13px ; font-family: sans-serif ; ">
                                <span class="border border-primary" id="designations">
                                    <?= $server["produit"] ?>
                                </span>
                            </td>
                            <td style=" font-size:13px ; text-align: center; font-family: sans-serif ; ">
                                <span class="border border-primary" id="prix">
                                    <?= $server["prix"] ?>
                                </span>
                            </td>
                            <td style=" font-size:13px ; font-family: sans-serif ; text-align: center">
                                <span class="border border-primary" id="quantite">
                                    <?= $server["quantite"] ?>
                                </span>
                            </td>
                            <td style=" font-size:13px ; font-family: sans-serif ;text-align: center; ">
                                <span class="border border-primary" id="unite">
                                    <?= $server["unite"] ?>
                                </span>
                            </td>
                            <td style=" font-size:13px ; font-family: sans-serif ; text-align: center;">
                                <span class="border border-primary" id="totalht">
                                    <?= $server["prix"] * $server["quantite"] ?>
                                </span>
                            </td>
                            <td style=" font-size:13px ; font-family: sans-serif ; text-align: center">
                                <a type="button" href="update.php?id=<?php echo $server["id"]; ?>" class="edit"><i class="fa fa-edit" style="font-size:19px"></i></a>
                                <a type="button" onclick="confirmer(<?php echo $server['id']; ?>)" class="supp"><i class="fa fa-trash fa-2x" style="font-size:19px"></i></a>
                            </td>
                            <td style=" font-size:13px ; font-family: sans-serif ; text-align: center ; display:none">
                                <span class="border border-primary" id="totalremise">
                                    <?= $server["totalremise"] ?>
                                </span>
                            </td>
                            <td style=" font-size:13px ; font-family: sans-serif ; text-align: center ; display:none">
                                <span class="border border-primary" id="totaltva">
                                    <?= $server["totaltva"] ?>
                                </span>
                            </td>

                            <td style=" font-size:13px ; font-family: sans-serif ; text-align: center ; display:none">
                                <span class="border border-primary" id="totalairsi">
                                    <?= $server["totalairsi"] ?>
                                </span>
                            </td>

                            <td style=" font-size:13px ; font-family: sans-serif ; text-align: center ; display:none">
                                <span class="border border-primary" id="codevente">
                                    <?= $server["codevente"] ?>
                                </span>
                            </td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
        <div class="modal-footer">
            <a href="news.php" class="btn btn-primary"><span class="glyphicon glyphicon-plus"></span> Ajouter</a>
            <a href="listevente.php" class="btn btn-default"><span class="glyphicon glyphicon-remove"></span> Quitter</a>
        </div>
    </div>
    </div>
    <script>
        $(function() {
            $('#categorie').change(function(e) {
                const id_cat = $(this).val();
                $("#famille").val(undefined);
                $("#famille option[data-categorie='" + id_cat + "']").css("display", "block");
                $("#famille option:not([data-categorie='" + id_cat + "'])").css("display", "none");
            })
        })
    </script>
</body>

</html>