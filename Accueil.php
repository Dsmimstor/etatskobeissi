<?php
// Initialiser la session

require('configs.php');
session_start();
// Vérifiez si l'utilisateur est connecté, sinon redirigez-le vers la page de connexion
if (!isset($_SESSION["users"])) {
	header("Location: Login.php");
	exit();
} else {
	$total = 0;
	$RSqlste = "SELECT * FROM `tsociete` WHERE `id`  = '1' ";
	$queryste = $conn->prepare($RSqlste);
	$queryste->execute();
	$resultste = $queryste->fetch(PDO::FETCH_ASSOC);
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
	<!-- Required meta tags -->
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<meta name="description" content="Gescom" />
	<!-- CSS -->
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css" integrity="sha384-PJsj/BTMqILvmcej7ulplguok8ag4xFTPryRq8xevL7eBYSmpXKcbNVuy+P0RMgq" crossorigin="anonymous" />
	<link rel="preconnect" href="https://fonts.googleapis.com" />
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
	<link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@500&family=Montserrat:wght@100&family=Yellowtail&display=swap" rel="stylesheet" />
	<link href="https://fonts.googleapis.com/css?family=Roboto:400,700" rel="stylesheet">
	<link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css" />
	<link rel="stylesheet" media="screen" href="screen.css" type="text/css" />
	<link rel="stylesheet" media="print" href="print.css" type="text/css" />
	<link rel="stylesheet" href="print.css">
	<link rel="stylesheet" href="/css/StyleAccueil.css" />
	<!-- Style file-->
	<!-- Style Icone-->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
	<link rel="shortcut icon" href="/img/Iconadc.jpg" />
	<title>ETS KOBEISSI</title>
</head>
<!-- bouton fermer -->

<body class="close-btn1">
	<!-- Bouton Menu-->
	<?php
	include_once "template/menulat.php";
	?>
	<div class="centretrav"></div>
	<div class="menugene1"></div>
	</div>
	<?php
	include_once "template/footer.php";
	?>
	<script src="https://kit.fontawesome.com/4d6eb40d90.js" crossorigin="anonymous">
	</script>

</body>

</html>