<?php
require_once('configs.php');
if (isset($_POST["submitenr"])) {
	$code = $_POST["noms"];
	$noms = $_POST["noms"];
	$prenoms = $_POST["prenoms"];
	$pseudo1 = strip_tags($_POST["pseudo"]);
	$passwords = $_POST["passwordrgt"];
	$confirpasswords = $_POST["confirpassword"];
	$confirpassword = password_hash($confirpasswords, PASSWORD_ARGON2ID);

	// $email = $_POST["email"];
	if (!filter_var($email = $_POST["email"], FILTER_VALIDATE_EMAIL)) {
		echo
		"<script> alert('Veuillez saisir un mail valide'); </script>";
	} else {

		$duplicate = "SELECT * FROM `tutilisateurs` WHERE `username`  = '$pseudo1'  or `emailut`  = '$email' ";
		$result = $conn->query($duplicate);
		$result->fetchAll();

		if ($result > 0) {
			echo
			"<script> alert('Le Pseudo ou le nom utilisateur est deja utilisé');</script>";
		} else {

			if ($passwords == $confirpasswords) {

				$adju = "INSERT INTO `tutilisateurs`(`nomut`,`prenomsut`,`username`,`passwords`,`emailut`,`codeut`,`roles`) VALUES ('$noms','$prenoms',:pseudos,'$confirpassword', :emails,'$code','[\"ROLE_USER\"]')";

				$query = $conn->prepare($adju);
				$query->bindValue(":pseudos", $pseudo1, PDO::PARAM_STR);
				$query->bindValue(":emails", $_POST["email"], PDO::PARAM_STR);

				$query->execute();

				echo
				"<script> alert('Enregistrement terminé'); </script>";
			} else {
				echo
				"<script> alert('Le mot de passe est different de la confirmation'); </script>";
			}
		}
	}
}
