<?php
// Initialiser la session
require ('configs.php');
//session_start();
// Vérifiez si l'utilisateur est connecté, sinon redirigez-le vers la page de connexion
if (!isset($_SESSION["users"])) {

	header("Location: pagedecouverture.php");
	exit();
}
else
{
	header("Location: Accueil.php");
	exit();

}
?>

<!DOCTYPE html>
<html>
	<head>
		<link rel="stylesheet" href="style.css" />
	</head>
	<body>
		<div class="sucess">
			<!--	<h1>Bienvenue <?php echo $_SESSION['username']; ?>!</h1>
<p>C'est votre tableau de bord.</p>
<a href="logout.php">Déconnexion</a> -->
		</div>
	</body>
</html>