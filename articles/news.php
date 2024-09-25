<?php
session_start();
require_once "../configs.php";
//include_once "../template/listepays.php";
$excecuteIsOk = "none";
$resultfour = [];
$nomfiche = "";

if (!isset($_SESSION["users"])) {
    header("Location: /Login.php");
} else {

    $sqlcategorie = 'SELECT * FROM tcategories ORDER BY designationcat';
    $reqcategorie = $conn->query($sqlcategorie);

    $sqlfamille = 'SELECT * FROM tfamilles  ORDER BY designationfam';
    $reqfamille = $conn->query($sqlfamille);

    $sqlsousfamille = 'SELECT * FROM tsousfamilles ORDER BY designationsousfam';
    $reqsousfamille = $conn->query($sqlsousfamille);

    $sqlunite = 'SELECT * FROM tunite  ORDER BY names';
    $requnite = $conn->query($sqlunite);

    $sqletat = 'SELECT * FROM tetat  ORDER BY id';
    $reqetat = $conn->query($sqletat);

    if (isset($_POST["btn_update"])) {

        if ($_POST["unites"] == "Selectionnez l'Unité" or $_POST["categorie"] == "Selectionnez la Categorie" or $_POST["famille"] == "Selectionnez la Famille" or $_POST["sousfamille"] == "Selectionnez la Sous Famille" or $_POST["etat"] == "Selectionnez l'Etat") {
            echo "<script> alert('Champ manquant , verifier la Categorie ou la Famille ou la Sous Famille ou Etat '); </script>";
        } else {
            $uploaddir = dirname(__DIR__);
            $uploadfile = $uploaddir . '/' . basename($_FILES['ficherImg']['name']);
            $nomfiche = $_FILES['ficherImg']['name'];

            if ($nomfiche == "") {
                $nomfiche =  $uploaddir . '/img/NoImg.jpg';
            } else {
                $nomfiche = $_FILES['ficherImg']['name'];
            }

            $destination = "/imagesrc/" . $nomfiche;
            $imagePath = pathinfo($destination, PATHINFO_EXTENSION);
            $correct = array(".png", ".jpg", ".gif", ".PNG", ".JPG", ".GIF", ".JPEG", ".jpeg");

            $tmpfiche = $_FILES['ficherImg']['tmp_name'];
            $size = $_FILES["ficherImg"]["size"];
            $type = $_FILES["ficherImg"]["type"];

            $typefile = strrchr($nomfiche, '.');

            $sqlcompteur = 'SELECT * FROM compteur where cle="' . $_POST["codes"] . '"';
            $reqcompteur = $conn->query($sqlcompteur);
            $nvCompteur = 1;
            if ($compteur = $reqcompteur->fetch(PDO::FETCH_OBJ)) {
                $nvCompteur = $compteur->valeur + 1;
                $RSqlcompteur = " UPDATE `compteur` SET `valeur` =  valeur +1 WHERE `cle`= '" . $_POST['codes'] . "' ";

                $querycompteur = $conn->prepare($RSqlcompteur);
                $querycompteur->execute();
            } else {
                $RSqlcompteur = " INSERT INTO `compteur` VALUES ('" . $_POST['codes'] . "',1)";

                $querycompteur = $conn->prepare($RSqlcompteur);
                $querycompteur->execute();
            }

     //       echo $nvCompteur;
            if (in_array($typefile, $correct)) {
                $filename = uniqid().$typefile;
                if (move_uploaded_file($tmpfiche, '../imagesrc/' . $filename )) {
                    $RSqls = "INSERT `tproduits`(
                            `id_categorie`,
                            `id_famille`,
                            `id_sousfamille`,
                            `code`,
                            `designations`,
                            `descriptions`,
                            `prix`,
                            `id_etat`,
                            `id_unite`,
                            `stocks`
                            )
                            VALUES
                            (
                            :categorie,
                            :famille,
                            :sousfamille,
                            :code,
                            :designation,
                            :descriptions,
                            :prix,
                            :etat,
                            :unites,
                            :quantite
                            )";

                    $query = $conn->prepare($RSqls);

                    $query->bindValue(":categorie", $_POST["categorie"], PDO::PARAM_STR);
                    $query->bindValue(":famille", $_POST["famille"], PDO::PARAM_STR);
                    $query->bindValue(":sousfamille", $_POST["sousfamille"], PDO::PARAM_STR);
                    $query->bindValue(":code", sprintf("%s%04d", $_POST["codes"], $nvCompteur), PDO::PARAM_STR);
                    $query->bindValue(":designation", $_POST["designation"], PDO::PARAM_STR);
                    $query->bindValue(":descriptions", $_POST["description"], PDO::PARAM_STR);
                    $query->bindValue(":prix", $_POST["prix"], PDO::PARAM_INT);
                    $query->bindValue(":etat", $_POST["etat"], PDO::PARAM_STR);
                    $query->bindValue(":unites", $_POST["unites"], PDO::PARAM_STR);
                    $query->bindValue(":quantite", $_POST["quantite"], PDO::PARAM_INT);

                    $code = sprintf("%s%04d", $_POST["codes"], $nvCompteur);

                    $RSqlimg = "INSERT `timage`(`code_prod`,`nomimages`)VALUES(:codeprod,:images)";

                    $queryimg = $conn->prepare($RSqlimg);

                    $queryimg->execute(array(
                        ':codeprod' =>  $code,
                        ':images' =>  $filename
                    ));

                    $excecuteIsOk = $query->execute() ? "succes" : "error";
                } else {
                    echo "<script> alert('Le fichier n\'a pas ete telechargé'); </script>";
                }
            } else {
                echo "<script> alert('Le fichier n\'est pas une image'); </script>";
            }
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
        echo "<script> alert('L\'element a été Ajouté'); location.href='liste.php'; </script>";
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
		<a><?php echo htmlspecialchars($resultste["designation"], ENT_QUOTES, 'UTF-8'); ?> </a>
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
                                <input type="hidden" style="width:350px; text-align: left;" class="form-control" id="eid" name="id">
                                <div class="form-group input-group">
                                    <span class="input-group-addon" style="width:150px;">Prefix du Code :</span>
                                    <input type="text" readonly onkeydown="upperCaseFun(this)" style="width:350px; text-align: left;" class="form-control" id="ecodes" name="codes">
                                </div>
                                <div class=" form-group input-group">
                                    <span class="input-group-addon" style="width:150px;">Désignation :</span>
                                    <input type="text" onkeydown="upperCaseFun(this)" style="width:350px;" class="form-control" id="edesignation" name="designation" required>
                                </div>
                                <div class="form-group input-group">
                                    <span class="input-group-addon" style="width:150px;">Prix :</span>
                                    <input type="number" style="width:350px;" class="form-control" id="eadressegeo" name="prix" value="0">
                                </div>
                                <div class="form-group input-group">
                                    <span class="input-group-addon" style="width:150px;">Etat :</span name="etat">
                                    <select id="etat" name="etat" size="1" style="width:350px;" class="form-control">
                                        <option>Selectionnez l'Etat</option>
                                        <?php
                                        while ($e = $reqetat->fetch(PDO::FETCH_OBJ)) {
                                            echo '<option value="' . $e->id . '" >' . $e->commentaires . '</option>';
                                        } ?>
                                    </select>
                                </div>

                                <div class="form-group input-group">
                                    <span class="input-group-addon" style="width:150px;">Categorie :</span name="cat">
                                    <select id="categorie" name="categorie" size="1" style="width:350px;" class="form-control">
                                        <option>Selectionnez la Categorie</option>
                                        <?php
                                        while ($c = $reqcategorie->fetch(PDO::FETCH_OBJ)) {
                                            echo '<option value="' . $c->id . '"  data-code="' . $c->id . '">' . $c->designationcat . '</option>';
                                        } ?>
                                    </select>
                                </div>
                                <div class="form-group input-group">
                                    <span class="input-group-addon" style="width:150px;">Famille :</span name="famille">
                                    <select id="famille" name="famille" size="1" style="width:350px;" class="form-control">
                                        <option>Selectionnez la Famille</option>
                                        <?php
                                        while ($f = $reqfamille->fetch(PDO::FETCH_OBJ)) {
                                            echo '<option value="' . $f->id . '"  data-code1="' . $f->id . '"  data-categorie="' . $f->id_cat . '">' . $f->designationfam . '</option>';
                                        } ?>
                                    </select>
                                </div>
                                <div class="form-group input-group">
                                    <span class="input-group-addon" style="width:150px;">Sous Famille :</span name="sousfamille">
                                    <select id="sousfamille" name="sousfamille" size="1" style="width:350px;" class="form-control">
                                        <option>Selectionnez la Sous Famille</option>
                                        <?php
                                        while ($sf = $reqsousfamille->fetch(PDO::FETCH_OBJ)) {

                                            echo '<option value="' . $sf->id . '"  data-code2="' . $sf->codesousfam . '"  data-famille="' . $sf->id_fam . '">' . $sf->designationsousfam . '</option>';
                                        } ?>
                                    </select>
                                </div>
                                <div class="form-group input-group">
                                    <span class="input-group-addon" style="width:150px;">Unité :</span name="unites">
                                    <select id="unite" name="unites" size="1" style="width:350px;" class="form-control">
                                        <option>Selectionnez l'Unité</option>
                                        <?php
                                        while ($u = $requnite->fetch(PDO::FETCH_OBJ)) {
                                            echo '<option value="' . $u->id . '" >' . $u->abreviation . '</option>';
                                        } ?>
                                    </select>
                                </div>
                                <div class="form-group input-group">
                                    <span class="input-group-addon" style="width:150px;">Quantité Initiale :</span>
                                    <input type="number" style="width:350px;" class="form-control" id="quantite" name="quantite" value="0">
                                </div>

                                <div class=" form-group input-group">
                                    <span class="input-group-addon" style="width:150px;">Description :</span>
                                    <input type="text" style="width:350px;" class="form-control" id="description" name="description">
                                </div>


                                <div class="form-group input-group">
                                    <span class="input-group-addon" style="width:150px;">Image 1 : </span><input type="file" name="ficherImg" id="fileImgs" style="width:350px;" class="form-control" accept="image/png, image/jpg, image/jpeg, image/PNG, image/JPG, image/JPEG" onchange="affimage();">
                                </div>


                                <div style="display:flex; justify-content: space-around; ">
                                    <fieldset class="text-center">
                                        <img class="rounded mx-auto d-block" id="afficheimage" width="150px" height="105px;" />
                                    </fieldset>
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success " name="btn_update"><span class="glyphicon glyphicon-edit"></span> Ajouter</button>
                            <a href="liste.php" class="btn btn-default"><span class="glyphicon glyphicon-remove"></span> Annuler</a>
                        </div>
                    </div>
                </div>

            </form>

            <script>
                function upperCaseFun(a) {
                    setTimeout(function() {
                        a.value = a.value.toUpperCase();
                    }, 1);
                }

                function affimage() {
                    let file = document.querySelector('#fileImgs').files;
                    let afficheimage = document.querySelector('#afficheimage');
                    if (file.length > 0) {
                        let fileReaders = new FileReader();
                        fileReaders.onload = function(event) {
                            document.getElementById('afficheimage').setAttribute("src", event.target.result);
                        };
                        fileReaders.readAsDataURL(file[0]);
                    }
                }

                function affimage1() {
                    let file1 = document.querySelector('#fileImgs1').files;
                    let afficheimage1 = document.querySelector('#afficheimage1');
                    if (file1.length > 0) {
                        let fileReaders1 = new FileReader();
                        fileReaders1.onload = function(event) {
                            document.getElementById('afficheimage1').setAttribute("src", event.target.result);
                        };
                        fileReaders1.readAsDataURL(file1[0]);
                    }
                }
                $(function() {
                    $('#categorie').change(function(e) {
                        const id_cat = $(this).val();
                        $("#famille").val(undefined);
                        $("#famille option[data-categorie='" + id_cat + "']").css("display", "block");
                        $("#famille option:not([data-categorie='" + id_cat + "'])").css("display", "none");
                    })
                    $('#famille').change(function(e) {
                        const id_fam = $(this).val();
                        $("#sousfamille").val(undefined);
                        $("#sousfamille option[data-famille='" + id_fam + "']").css("display", "block");
                        $("#sousfamille option:not([data-famille='" + id_fam + "'])").css("display", "none");
                    })
                    $('#sousfamille').change(function(e) {
                        const code_sous_famille = $("#sousfamille option:checked").attr("data-code2");
                        const code_famille = $("#famille option:checked").attr("data-code1");
                        const code_categorie = $("#categorie option:checked").attr("data-code");
                        $("#ecodes").val(code_categorie + code_famille + code_sous_famille);
                    })
                })
            </script>


</body>

</html>