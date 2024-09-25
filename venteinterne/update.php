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

    $sqlcategorie = 'SELECT * FROM tcategories ORDER BY designationcat';
    $reqcategorie = $conn->query($sqlcategorie);


    $sqlfamille = 'SELECT * FROM tfamilles  ORDER BY designationfam';
    $reqfamille = $conn->query($sqlfamille);

    $sqlsousfamille = 'SELECT * FROM tsousfamilles ORDER BY designationsousfam';
    $reqsousfamille = $conn->query($sqlsousfamille);

    $sqlunite = 'SELECT * FROM tunite  ORDER BY abreviation';
    $requnite = $conn->query($sqlunite);

    $sqletat = 'SELECT * FROM tetat  ORDER BY id';
    $reqetat = $conn->query($sqletat);

    $id = $_GET["id"];

    if (isset($_POST["btn_update"])) {

        $resultfour["id"] = $_POST["id"];
        $resultfour["id_categorie"] = $_POST["categorie"];
        $resultfour["id_famille"] = $_POST["famille"];
        $resultfour["id_sousfamille"] = $_POST["sousfamille"];
        $resultfour["code"] = $_POST["codes"];
        $resultfour["designations"] = $_POST["designation"];
        $resultfour["descriptions"] = $_POST["description"];
        $resultfour["prix"] = $_POST["prix"];
        $resultfour["id_etat"] = $_POST["etat"];
        $resultfour["id_unite"] = $_POST["unite"];
        $resultfour["stocks"] = $_POST["quantite"];
        $idfour = $_POST["id"];


        $uploaddir = dirname(__DIR__);



        if ($_FILES['ficherImg']['name'] != '') {
            $uploadfile = $uploaddir . '/' . basename($_FILES['ficherImg']['name']);
            $nomfiche = $_FILES['ficherImg']['name'];
            $tmpfiche = $_FILES['ficherImg']['tmp_name'];
            $typefile = strrchr($nomfiche, '.');

            $correct = array(".png", ".jpg", ".gif", ".PNG", ".JPG", ".GIF", ".JPEG", ".jpeg");

            if (in_array($typefile, $correct)) {
                $filename = uniqid() . $typefile;
                if (move_uploaded_file($tmpfiche, '../imagesrc/' . $filename)) {

                    $idfotos = $_POST["codes"];

                    $RSqlimg = " UPDATE `timage` SET `nomimages` =:images WHERE `code_prod`= '$idfotos' ";

                    $queryimg = $conn->prepare($RSqlimg);

                    $queryimg->execute(array(
                        ':images' => $filename
                    ));



                    $RSqls = "UPDATE `tproduits` SET
                    `id_categorie`=:categorie,
                    `id_famille`=:famille,
                    `id_sousfamille`=:sousfamille,
                    `code`=:code,
                    `designations`=:designation,
                    `descriptions`=:descriptions,
                    `prix`=:prix,
                    `id_etat`=:etat,
                    `id_unite`=:unite,
                    `stocks`=:quantite
                    WHERE `id`=$idfour";

                    $query = $conn->prepare($RSqls);

                    /*  $query->bindValue(":code", $_POST["codes"], PDO::PARAM_STR);*/
                    $query->bindValue(":categorie", $_POST["categorie"], PDO::PARAM_STR);
                    $query->bindValue(":famille", $_POST["famille"], PDO::PARAM_STR);
                    $query->bindValue(":sousfamille", $_POST["sousfamille"], PDO::PARAM_STR);
                    $query->bindValue(":code", $_POST["codes"], PDO::PARAM_STR);

                    $query->bindValue(":designation", $_POST["designation"], PDO::PARAM_STR);
                    $query->bindValue(":descriptions", $_POST["description"], PDO::PARAM_STR);
                    $query->bindValue(":prix", $_POST["prix"], PDO::PARAM_INT);
                    $query->bindValue(":etat", $_POST["etat"], PDO::PARAM_STR);
                    $query->bindValue(":unite", $_POST["unite"], PDO::PARAM_STR);
                    $query->bindValue(":quantite", $_POST["quantite"], PDO::PARAM_INT);
                    $date =  time();
                    $dt = \DateTime::createFromFormat("Y-m-d H:i:s", $date);

                    $excecuteIsOk = $query->execute() ? "succes" : "error";
                } else {
                    echo "<script> alert('Le fichier n\'a pas été déplacé '); </script>";
                    //     $idfotos = $_POST["codes"];
                    $Sqlresult = "SELECT a.* , f.id_cat , sf.id_fam  FROM `tproduits` a  INNER JOIN `tsousfamilles`sf ON a.id_sousfamille = sf.id INNER JOIN tfamilles f ON f.id=sf.id_fam  WHERE a.`id` = '$id' ";
                    $query = $conn->prepare($Sqlresult);
                    $query->execute();
                    $Sqlresultat = $query->fetch(PDO::FETCH_ASSOC);


                    // $idfotos = $Sqlresultat["code"];
                    $sqlfoto = "SELECT * FROM `timage` WHERE `code_prod` = '$idfotos' ";
                    $reqfoto = $conn->query($sqlfoto);
                    $reqfoto->execute();
                    $Sqlresultatfoto = $reqfoto->fetch(PDO::FETCH_ASSOC);
                    //  $chemain = "$uploaddir/";Gestions\img
                    $chemain = "../img/";
                }
            } else {
                echo "<script> alert('Le fichier n\'est pas une image '); </script>";
                //     $idfotos = $_POST["codes"];
                $Sqlresult = "SELECT a.* , f.id_cat , sf.id_fam  FROM `tproduits` a  INNER JOIN `tsousfamilles`sf ON a.id_sousfamille = sf.id INNER JOIN tfamilles f ON f.id=sf.id_fam  WHERE a.`id` = '$id' ";
                $query = $conn->prepare($Sqlresult);
                $query->execute();
                $Sqlresultat = $query->fetch(PDO::FETCH_ASSOC);

                //$idfoto = $Sqlresultat["code"];
                $sqlfoto = "SELECT * FROM `timage` WHERE `code_prod` = '$idfotos' ";
                $reqfoto = $conn->query($sqlfoto);
                $reqfoto->execute();
                $Sqlresultatfoto = $reqfoto->fetch(PDO::FETCH_ASSOC);
                //  $chemain = "$uploaddir/";Gestions\img
                $chemain = "../img/";
            }
        } else {
            $RSqls = "UPDATE `tproduits` SET
            `id_categorie`=:categorie,
            `id_famille`=:famille,
            `id_sousfamille`=:sousfamille,
            `code`=:code,
            `designations`=:designation,
            `descriptions`=:descriptions,
            `prix`=:prix,
            `id_etat`=:etat,
            `id_unite`=:unite,
            `stocks`=:quantite
            WHERE `id`=$idfour";

            $query = $conn->prepare($RSqls);

            /*  $query->bindValue(":code", $_POST["codes"], PDO::PARAM_STR);*/
            $query->bindValue(":categorie", $_POST["categorie"], PDO::PARAM_STR);
            $query->bindValue(":famille", $_POST["famille"], PDO::PARAM_STR);
            $query->bindValue(":sousfamille", $_POST["sousfamille"], PDO::PARAM_STR);
            $query->bindValue(":code", $_POST["codes"], PDO::PARAM_STR);
            //    $idfotos = $_POST["codes"];
            $query->bindValue(":designation", $_POST["designation"], PDO::PARAM_STR);
            $query->bindValue(":descriptions", $_POST["description"], PDO::PARAM_STR);
            $query->bindValue(":prix", $_POST["prix"], PDO::PARAM_INT);
            $query->bindValue(":etat", $_POST["etat"], PDO::PARAM_STR);
            $query->bindValue(":unite", $_POST["unite"], PDO::PARAM_STR);
            $query->bindValue(":quantite", $_POST["quantite"], PDO::PARAM_INT);
            $date =  time();
            $dt = \DateTime::createFromFormat("Y-m-d H:i:s", $date);

            $excecuteIsOk = $query->execute() ? "succes" : "error";
        }
    } else {
        // $idfotos = $_POST["codes"];

        $Sqlresult = "SELECT a.* , f.id_cat , sf.id_fam  FROM `tproduits` a  INNER JOIN `tsousfamilles`sf ON a.id_sousfamille = sf.id INNER JOIN tfamilles f ON f.id=sf.id_fam  WHERE a.`id` = '$id' ";
        $query = $conn->prepare($Sqlresult);
        $query->execute();
        $Sqlresultat = $query->fetch(PDO::FETCH_ASSOC);

        $idfotos = $Sqlresultat["code"];
        $cate = $Sqlresultat["id_categorie"];
        var_dump($cate);
        $sqlfoto = "SELECT * FROM `timage` WHERE `code_prod` = '$idfotos' ";
        $reqfoto = $conn->query($sqlfoto);
        $reqfoto->execute();
        $Sqlresultatfoto = $reqfoto->fetch(PDO::FETCH_ASSOC);
        //  $chemain = "$uploaddir/";Gestions\img
        $chemain = "../imagesrc/";
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

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@500&family=Montserrat:wght@100&family=Yellowtail&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700" rel="stylesheet">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
    <link href="/css/bootstrap.min.css">
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
        <img src="/img/LOGO%20ATELIER%20DE%20CHOCOLATAE.jpg" alt="logoAtelier" />
        <a>L'Atelier du Chocolat</a>
    </p>
</header>

<body>
    <div class="container">
        <div style="height:50px;"></div>
        <div class="well">
            <!--    <h2>Liste des Fournisseurs</h2>-->
            <h2 class="text-center">MODIFER ARTICLE</h2>
            <form action="" method="POST" name="modfours" value="modfour" enctype="multipart/form-data">

                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">

                        </div>
                        <div class="modal-body">

                            <div class="container-fluid">
                                <input type="hidden" style="width:350px; text-align: left;" class="form-control" id="eid" name="id" value="<?php echo $Sqlresultat["id"]; ?>">

                                <div class="form-group input-group">
                                    <span class="input-group-addon" style="width:150px;">Code :</span>
                                    <input type="text" readonly onkeydown="upperCaseFun(this)" style="width:350px; text-align: left;" class="form-control" id="ecodes" name="codes" value="<?php echo $Sqlresultat["code"]; ?>">
                                </div>
                                <div class=" form-group input-group">
                                    <span class="input-group-addon" style="width:150px;">Désignation :</span>
                                    <input type="text" style="width:350px;" onkeydown="upperCaseFun(this)" class="form-control" id="edesignation" name="designation" value="<?php echo $Sqlresultat["designations"]; ?>">

                                </div>
                                <div class="form-group input-group">
                                    <span class="input-group-addon" style="width:150px;">Prix :</span>
                                    <input type="number" style="width:350px;" class="form-control" id="eadressegeo" name="prix" value="<?php echo $Sqlresultat["prix"]; ?>">
                                </div>

                                <div class="form-group input-group">
                                    <span class="input-group-addon" style="width:150px;">Etat :</span name="formatpays">
                                    <select id="etat" name="etat" size="1" style="width:350px;" class="form-control">
                                        <?php
                                        while ($e = $reqetat->fetch(PDO::FETCH_OBJ)) {
                                            echo '<option value="' . $e->id . '" ' . ($e->id == $Sqlresultat['id_etat'] ? "selected" : "") . '>' . $e->commentaires . '</option>';
                                        } ?>
                                    </select>
                                </div>

                                <div class="form-group input-group">
                                    <span class="input-group-addon" style="width:150px;">Categorie :</span name="formatpays">

                                    <select id="categorie" name="categorie" size="1" style="width:350px;" class="form-control">
                                        <?php
                                        while ($c = $reqcategorie->fetch(PDO::FETCH_OBJ)) {
                                            echo '<option value="' . $c->id . '" ' . ($c->id == $Sqlresultat['id_categorie'] ? "selected" : "") . '  data-code="' . $c->id . '">' . $c->designationcat . '</option>';
                                        } ?>
                                    </select>
                                </div>

                                <div class="form-group input-group">
                                    <span class="input-group-addon" style="width:150px;">Famille :</span name="formatpays">
                                    <select id="famille" name="famille" size="1" style="width:350px;" class="form-control">
                                        <?php
                                        while ($f = $reqfamille->fetch(PDO::FETCH_OBJ)) {
                                            echo '<option value="' . $f->id . '" ' . ($f->id == $Sqlresultat['id_famille'] ? "selected" : "") . ' data-categorie="' . $f->id_cat . '" style="display:' . ($f->id_cat == $Sqlresultat['id_cat'] ? "block" : "none") . '">' . $f->designationfam . '</option>';
                                        } ?>
                                    </select>
                                </div>

                                <div class="form-group input-group">
                                    <span class="input-group-addon" style="width:150px;">Sous Famille :</span name="formatpays">
                                    <select id="sousfamille" name="sousfamille" size="1" style="width:350px;" class="form-control">
                                        <?php
                                        while ($sf = $reqsousfamille->fetch(PDO::FETCH_OBJ)) {
                                            echo '<option value="' . $sf->id . '" ' . ($sf->id == $Sqlresultat['id_sousfamille'] ? "selected" : "") . ' data-famille="' . $sf->id_fam . '" style="display:' . ($sf->id_fam == $resultfour['id_fam'] ? "block" : "none") . '">' . $sf->designationsousfam . '</option>';
                                        } ?>
                                    </select>
                                </div>

                                <div class="form-group input-group">
                                    <span class="input-group-addon" style="width:150px;">Unité :</span name="unite">
                                    <select id="unite" name="unite" size="1" style="width:350px;" class="form-control">
                                        <option>Selectionnez l'Unité</option>
                                        <?php
                                        while ($u = $requnite->fetch(PDO::FETCH_OBJ)) {
                                            echo '<option value="' . $u->id . '" ' . ($u->id == $Sqlresultat['id_unite'] ? "selected" : "") . '>' . $u->abreviation . '</option>';
                                        } ?>
                                    </select>
                                </div>

                                <div class="form-group input-group">
                                    <span class="input-group-addon" style="width:150px;">Quantité Initiale :</span>
                                    <input type="number" style="width:350px;" class="form-control" id="quantite" name="quantite" value="<?php echo $Sqlresultat["stocks"]; ?>">
                                </div>

                                <div class=" form-group input-group">
                                    <span class="input-group-addon" style="width:150px;">Description :</span>
                                    <input type="text" style="width:350px;" class="form-control" id="description" name="description" value="<?php echo $Sqlresultat["descriptions"]; ?>">
                                </div>

                                <div class="form-group input-group">
                                    <span class="input-group-addon" style="width:150px;">Image 1 : </span><input type="file" name="ficherImg" id="fileImgs" style="width:350px;" class="form-control" accept="image/png, image/jpg, image/jpeg, image/PNG, image/JPG, image/JPEG" onchange="affimage();">
                                    <input type="hidden" style="width:350px; text-align: left;" class="form-control" id="idf" name="ficherImgold" value="<?php echo $Sqlresultatfoto["nomimages"]; ?>">
                                </div>

                                <div style="display:bloc ; justify-content: center; align-items: center;">
                                    <fieldset class="text-center">
                                        <img class="rounded mx-auto d-block gallery-item" id="afficheimage" width="200px" height="110px;" src="<?php echo $chemain . $Sqlresultatfoto["nomimages"]; ?>" />
                                    </fieldset>
                                </div>

                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-success " name="btn_update"><span class="glyphicon glyphicon-edit"></span> Modififer</button>
                                    <a href="liste.php" class="btn btn-default"><span class="glyphicon glyphicon-remove"></span> Annuler</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="/js/bootstrap.bundle.min.js"></script>
    <script src="/js/main.js"></script>
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

    <script>
        $(function() {
            $('#famille').change(function(e) {
                const id_fam = $(this).val();
                $("#sousfamille").val(undefined);
                $("#sousfamille option[data-famille='" + id_fam + "']").css("display", "block");
                $("#sousfamille option:not([data-famille='" + id_fam + "'])").css("display", "none");
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

    <script>
        $(function() {
            $('#sousfamille').change(function(e) {
                const code_sous_famille = $("#sousfamille option:checked").attr("data-code2");
                const code_famille = $("#famille option:checked").attr("data-code1");
                const code_categorie = $("#categorie option:checked").attr("data-code");
                $("#ecodes").val(code_categorie + code_famille + code_sous_famille);
            })
        })
    </script>

    <script>
        function affimage() {
            let file = document.querySelector('input[type=file]').files;
            let afficheimage = document.querySelector('#afficheimage');
            if (file.length > 0) {
                let fileReaders = new FileReader();
                fileReaders.onload = function(event) {
                    document.getElementById('afficheimage').setAttribute("src", event.target.result);
                };
                fileReaders.readAsDataURL(file[0]);
            }
        }
    </script>
    <script>
        const updateButton = document.getElementById("updateDetails");
        const cancelButton = document.getElementById("cancel");
        const dialog = document.getElementById("favDialog");
        dialog.returnValue = "favAnimal";

        function openCheck(dialog) {
            if (dialog.open) {
                console.log("Dialog open");
            } else {
                console.log("Dialog closed");
            }
        }

        // Update button opens a modal dialog
        updateButton.addEventListener("click", () => {
            dialog.showModal();
            openCheck(dialog);
        });

        // Form cancel button closes the dialog box
        cancelButton.addEventListener("click", () => {
            dialog.close("animalNotChosen");
            openCheck(dialog);
        });
    </script>

</body>

</html>