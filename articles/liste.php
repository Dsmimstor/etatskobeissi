<?php
session_start();
require_once "../configs.php";

// Vérifiez si l'utilisateur est connecté, sinon redirigez-le vers la page de connexion
if (!isset($_SESSION["users"])) {
    header("Location: /Login.php");
} else {
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
    <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
    
    <link rel="stylesheet" href="/css/Stylefournisseurs1.css" />
    <script>
        function confirmer(id) {
            if(confirm("Voulez-vous supprimer cet article ?")){
                location.href="delete.php?id="+id;
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
        <div style="height:50px;"></div>
        <div class="well">
            <center>
                <!--    <h2>Liste des Fournisseurs</h2>-->
                <h2>
                    LISTE DES ARTICLES</h2>
            </center>
            <div style="height:10px;"></div>
            <table width="100%" class="table table-bordered border-primary table-hover" id="tfour">
                <thead>
                    <th scope="col" class="T1">Code</th>
                    <th scope="col" class="T2">Designation</th>
                    <th scope="col" class="T3" style="width: 110px;">Sous Famille</th>
                    <th scope="col" class="T5"style="width: 60px;">Prix</th>
                    <th scope="col" class="T6" style="width: 50px;">Unité</th>
                    <th scope="col" class="T7" style="width: 60px;">Quantité</th>
                    <th scope="col" class="T4" style="width: 110px;">Etat</th>
                    <th scope="col" class="T8"style="width: 90px;">Actions</th>
                </thead>
                <tbody>
                    <?php
                $RSql = "SELECT a.*, e.commentaires etat , sf.designationsousfam sousfamille , u.abreviation unite FROM `tproduits` a INNER JOIN `tetat` e ON a.id_etat = e.id  INNER JOIN `tsousfamilles`sf ON a.id_sousfamille = sf.id  INNER JOIN `tunite` u ON a.id_unite = u.id ";

                    $stmt = $conn->prepare($RSql);
                    $stmt->execute();
                    $servers = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    $server = '';
                    foreach ($servers as $server) {
                    ?>
                        <tr>
                            <td scope="row" style="text-align: center; font-size: 15px ; font-family: sans-serif ;">
                                <span class="border border-primary" id="codefour">
                                    <?= $server["code"] ?>
                                </span>
                            </td>
                            <td style="text-align: left; font-size:15px ; font-family: sans-serif ; ">
                                <span class="border border-primary" id="designations">
                                    <?= $server["designations"] ?>
                                </span>
                            </td>
                            <td style=" font-size:15px ; text-align: center; font-family: sans-serif ; ">
                                <span class="border border-primary" id="adressefour">
                                    <?= $server["sousfamille"] ?>
                                </span>
                            </td>
                            <td style=" font-size:15px ; font-family: sans-serif ; text-align: center">
                                <span class="border border-primary" id="paysfour">
                                    <?= $server["prix"] ?>
                                </span>
                            </td>
                            <td style=" font-size:15px ; font-family: sans-serif ;text-align: center; ">
                                <span class="border border-primary" id="villefour">
                                    <?= $server["unite"] ?>
                                </span>
                            </td>
                            <td style=" font-size:15px ; font-family: sans-serif ; text-align: center;">
                                <span class="border border-primary" id="telephone">
                                    <?= $server["stocks"] ?>
                                </span>
                            </td>
                            <td style=" font-size:15px ; font-family: sans-serif ; text-align: center">
                                <span class="border border-primary" id="email">
                                    <?= $server["etat"] ?>
                                </span>
                            </td>
                            <td style=" font-size:15px ; font-family: sans-serif ; text-align: center">
                                <a type="button" href="update.php?id=<?php echo $server["id"]; ?>" class="edit"><i class="fa fa-edit" style="font-size:29px"></i></a>
                                <a type="button" onclick="confirmer(<?php echo $server['id']; ?>)" class="supp"><i class="fa fa-trash fa-2x" style="font-size:29px"></i></a>
                                <a type="button" href="affimg.php?id=<?php echo $server["id"]; ?>" class="Affimg"><i class="fa fa-image" style="font-size:28px;color:red"></i></a>
                            </td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
            <div class="modal-footer">
                <a href="news.php" class="btn btn-primary"><span class="glyphicon glyphicon-plus"></span> Ajouter</a>
                <a href="../Accueil.php" class="btn btn-default"><span class="glyphicon glyphicon-remove"></span> Quitter</a>
            </div>
        </div>
</html>