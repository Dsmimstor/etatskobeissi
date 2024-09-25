<?php
session_start();
require_once "../configs.php";

// Vérifiez si l'utilisateur est connecté, sinon redirigez-le vers la page de connexion
if (!isset($_SESSION["users"])) {
    header("Location: /Login.php");
} else {
    $total = 0;
    $RSqlste = "SELECT * FROM `tsociete` WHERE `id`  = '1' ";
    $queryste = $conn->prepare($RSqlste);
    $queryste->execute();
    $resultste = $queryste->fetch(PDO::FETCH_ASSOC);

    $idc = $_GET["id"];
    $sqlcmd = "SELECT d.*, c.* FROM `tdocuments` d INNER JOIN `tclients` c ON d.id_client = c.id WHERE d.`id` = '$idc' ";
    $querycmd = $conn->prepare($sqlcmd);
    $querycmd->execute();
    $resultcmd = $querycmd->fetch(PDO::FETCH_ASSOC);
    $idproforma =  $resultcmd["numeros"];
    //$date = $_POST["dateproforma"];
    $datecmd = isset($_POST["dateproforma"]) ? htmlspecialchars($_POST["dateproforma"]) : date('Y-m-d');
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
    <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>

    <link rel="stylesheet" href="/css/Stylefacture.css" />
    <script>
        function confirmer(id) {
            if (confirm("Voulez-vous supprimer cet article ?")) {
                location.href = "deleteproforma.php?id=" + id;
            }
        }
    </script>
    <script>
        function valider(id) {
            const tht = parseFloat(document.getElementById('resultat').value);
            const datecmd = document.getElementById('datecmd').value;
            const frais = parseFloat(document.getElementById('frais').value);
            const transport = parseFloat(document.getElementById('transport').value);
            if (confirm("Voulez-vous valider la commande ?")) {
                // Construire l'URL avec les paramètres de requête encodés
                const url = `validerproforma.php?id=${encodeURIComponent(id)}&tht=${encodeURIComponent(tht)}&frais=${encodeURIComponent(frais)}&transport=${encodeURIComponent(transport)}&datecmd=${encodeURIComponent(datecmd)}`;
                // Rediriger vers la page PHP avec les paramètres
                window.location.href = url;
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
                <h2 style="text-shadow: 1px 1px 2px brown, 0 0 1em brown, 0 0 0.2em brown;"> DETAIL PROFORMA </h2>
            </div>

            <form action="" method="post" enctype="multipart/form-data" name="adentete" value="adentete">
                <div class="d-flex align-self-stretch" style="height:185px; display: flex;">
                    <div class="p-4 flex-fill dv" style=" padding: 1px; ">
                    <div class="p-4 flex-fill dv" style=" padding: 1px; ">
                        <div class=" form-group1 input-group" style=" padding: 1px;">
                            <span class="input-group-addon" style="width:122px; text-align: left; ">N° Proforma :</span>
                            <input type="text" readonly onkeydown="upperCaseFun(this)" style="width:160px; text-align: left;" id="proforma" name="proforma" required value="<?php echo $resultcmd["numeros"]; ?>">
                        </div>
                        <div class=" form-group1 input-group" style=" padding: 1px;">
                            <span class="input-group-addon" style="width:122px; text-align: left;">Date proforma :</span>
                            <input type="date" readonly style="width:160px; " id="dateproforma" name="dateproforma" required value="<?php echo $resultcmd["dates"]; ?>">
                        </div>
                        <div class=" form-group1 input-group" style=" padding: 1px;">
                            <span class="input-group-addon" style="width:122px; text-align: left; ">N° Cmde :</span>
                            <input type="text" readonly onkeydown="upperCaseFun(this)" style="width:160px; text-align: left;" id="commande" name="proforma" required value="<?php echo $resultcmd["ncommande"]; ?>">
                        </div>
                        <div class=" form-group1 input-group" style=" padding: 1px;">
                            <span class="input-group-addon" style="width:122px; text-align: left;">Date Cmd :</span>
                            <input type="date" style="width:160px; " id="datecmd" name="datecmd" required value="<?php echo date('Y-m-d'); ?>">
                        </div>
                        <div class=" form-group1 input-group" style=" padding: 1px;">
                            <span class="input-group-addon" style="width:122px; text-align: left; ">N° BL :</span>
                            <input type="text" readonly onkeydown="upperCaseFun(this)" style="width:160px; text-align: left;" id="bonliv" name="bonliv" required value="<?php echo $resultcmd["nbonliv"]; ?>">
                        </div>
                        <div class=" form-group1 input-group" style=" padding: 1px;">
                            <span class="input-group-addon" style="width:122px; text-align: left;">Date BL :</span>
                            <input type="date" style="width:160px; " id="datebl" name="datebl" required value="<?php echo date('Y-m-d'); ?>">
                        </div>
                        <input type="text" readonly hidden style="width:160px; text-align: left;" id="idproforma" name="idproforma" required value="<?php echo $idc; ?>">
                    </div>

                        <input type="text" readonly hidden style="width:160px; text-align: left;" id="idproforma" name="idproforma" required value="<?php echo $idc; ?>">
                    </div>
                    <div class="p-4 flex-fill dv" style=" padding: 2px;">
                        <div class=" form-group1 input-group" style=" padding: 1px;">
                            <span class="input-group-addon" style="width:85px; text-align: left;">Client :</span>
                            <input type="text" readonly onkeydown="upperCaseFun(this)" style="width:410; " id="client" name="client" required value="<?php echo $resultcmd["designations"]; ?>">
                        </div>
                        <div class=" form-group1 input-group" style=" padding: 1px;">
                            <span class="input-group-addon" style="width:85px; text-align: left;">Adresse :</span>
                            <input type="text" readonly onkeydown="upperCaseFun(this)" style="width:410; " id="adresse" name="adresse" required value="<?php echo $resultcmd["adresse"]; ?>">
                        </div>
                        <div class=" form-group1 input-group" style=" padding: 1px;">
                            <span class="input-group-addon" style="width:85px; text-align: left;">Tel :</span>
                            <input type="text" readonly onkeydown="upperCaseFun(this)" style="width:410;" id="telephone" name="telephone" required value="<?php echo $resultcmd["telephone"]; ?>">
                        </div>
                        <div class=" form-group1 input-group" style=" padding: 1px;">
                            <span class="input-group-addon" style="width:85px; text-align: left;">Email :</span>
                            <input type="email" onkeydown="upperCaseFun(this)" readonly style="width:410;" id="email" name="email" required value="<?php echo $resultcmd["email"]; ?>">
                        </div>
                        <div class=" form-group1 input-group" style=" padding: 1px;">
                            <span class="input-group-addon" style="width:85px; text-align: left;">Adr Geo :</span>
                            <textarea name="commentaire" cols="30" rows="3" readonly style="width:410; " required value="<?php echo $resultcmd["adrgeographique"]; ?>"></textarea>
                        </div>
                    </div>

                    <div class="p-4 flex-fill dv" style=" padding: 2px;">
                        <div class=" form-group1 input-group" style=" padding: 1px;">
                            <span class="input-group-addon" style="width:95px; text-align: left;">Total HT :</span>
                            <input readonly type="text" onkeydown="upperCaseFun(this)" style="width:187px;  text-align: center;" id="totalht" name="totalht" required value="<?php echo number_format($total, 2, '.', ','); ?>">
                        </div>
                        <div class=" form-group1 input-group" style=" padding: 1px;">
                            <span class="input-group-addon" style="width:95px; text-align: left;"> Frais Ges:</span>
                            <input type="number" onkeydown="upperCaseFun(this)" style="width:187px;  text-align: center;" id="frais" name="frais" required value="<?php echo number_format(10, 2, '.', ','); ?>">
                        </div>
                        <div class=" form-group1 input-group" style=" padding: 1px;">
                            <span class="input-group-addon" style="width:83px; text-align: left;">Transport :</span>
                            <input type="number" onkeydown="upperCaseFun(this)" style="width:189px;  text-align: center;" id="transport" name="transport" required value="<?php echo number_format(30, 2, '.', ','); ?>">
                        </div>
                        <div class=" form-group1 input-group" style=" padding: 1px;">
                            <span class="input-group-addon" style="width:285px; text-align: left;">. </span>
                        </div>
                        <div class=" form-group1 input-group" style=" padding: 1px;">
                            <span class="input-group-addon" style="width:285px; text-align: left;">. </span>
                        </div>
                        <div class=" form-group1 input-group" style=" padding: 1px;">
                            <span class="input-group-addon" style="width:95px; text-align: left;">T. TTC :</span>
                            <input type="text" readonly onkeydown="upperCaseFun(this)" style="width:187px;  text-align: center;" id="totalttc" name="totalttc" required>
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
                </thead>
                <tbody>
                    <?php
                    //          $RSql = "SELECT a.* , p.code codeprod , p.designations produit , u.abreviation unite FROM `tdetail_document` a INNER JOIN `tproduits`p ON a.id_produit = p.id  INNER JOIN `tunite` u ON a.id_unite = u.id WHERE `id_document`= '" . 2 . "' ";
                    $RSql = "SELECT * FROM `tdetail_document` WHERE `id_document`= '" .  $idc . "' ";

                    $stmt = $conn->prepare($RSql);
                    $stmt->execute();
                    $servers = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    $server = '';
                    $total = 0;

                    foreach ($servers as $server) {
                    ?>
                        <tr>
                            <td scope="row" style="text-align: center; font-size: 13px ; font-family: sans-serif ;">
                                <span class="border border-primary" id="codefour">
                                    <?= $server["id"] ?>
                                </span>
                            </td>
                            <td style="text-align: left; font-size:13px ; font-family: sans-serif ; ">
                                <span class="border border-primary" id="designations">
                                    <?= $server["articles"] ?>
                                </span>
                            </td>
                            <td style=" font-size:13px ; text-align: center; font-family: sans-serif ; ">
                                <span class="border border-primary" id="prix">
                                    <?= number_format($server["prix"], 2, '.', ','); ?>
                                </span>
                            </td>
                            <td style=" font-size:13px ; font-family: sans-serif ; text-align: center">
                                <span class="border border-primary" id="quantite">
                                    <?= number_format($server["quantite"], 2, '.', ','); ?>
                                </span>
                            </td>
                            <td style=" font-size:13px ; font-family: sans-serif ;text-align: center; ">
                                <span class="border border-primary" id="unites">
                                    <?= $server["unites"] ?>
                                </span>
                            </td>
                            <td style=" font-size:13px ; font-family: sans-serif ; text-align: center;">
                                <span class="border border-primary" id="totalht">
                                    <?= number_format($server["prix"] * $server["quantite"], 2, '.', ','); ?>
                                </span>
                            </td>
                            <td style=" font-size:13px ; font-family: sans-serif ; text-align: center">
                                <a type="button" href="updateproforma.php?id=<?php echo $server['id']; ?>" class="edit"><i class="fa fa-edit" style="font-size:19px"></i></a>
                                <a type="button" onclick="confirmer(<?php echo $server['id']; ?>)" class="supp"><i class="fa fa-trash fa-2x" style="font-size:19px"></i></a>
                            </td>

                        </tr>
                    <?php
                        $total +=  $server["prix"] * $server["quantite"];
                    }
                    ?>
                </tbody>
            </table>
        </div>
        <input type="text" hidden id="resultat" name="resultat" oninput="myFunction();" value="<?php echo $total; ?>">
        <div class="modal-footer">
            <a href="newsproforma.php?id=<?php echo $idc; ?>" class="btn btn-primary"><span class="glyphicon glyphicon-plus"></span> Ajouter</a>
            <a type="button" onclick="valider(<?php echo $idc; ?>)" class="btn btn-success">Valider</a>
            <a href="listevente.php" class="btn btn-default"><span class="glyphicon glyphicon-remove"></span> Quitter</a>
        </div>
    </div>
    </div>
    <script>
        $(function(myFunction) {
            var id_resultat = parseFloat($("#resultat").val());
            var id_transport = parseFloat($("#transport").val());
            var id_frais = parseFloat($("#frais").val());
            $("#totalht").val(id_resultat.toLocaleString('fr-FR', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            }));
            var sum = id_resultat + id_transport + id_frais;
            $("#totalttc").val(sum.toLocaleString('fr-FR', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            }));
        })
    </script>
</body>

</html>