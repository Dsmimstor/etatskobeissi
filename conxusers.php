<?php


require_once('configs.php');

if (isset($_POST["submitcnx"])) {

	$password1 = $_POST["password1"];
	$username = $_POST["username"];


	if (!filter_var($username = $_POST["username"], FILTER_VALIDATE_EMAIL)) {
		$sql = "SELECT * FROM `tutilisateurs` WHERE `username` =:username ";
	} else {
		$sql = "SELECT * FROM `tutilisateurs` WHERE `emailut` =:username ";
	}

	$requete = $conn->prepare($sql);

	$requete->bindValue(":username",  $_POST["username"], PDO::PARAM_STR);

	$requete->execute();

	$res = $requete->fetch();

	if ($res) {

	

		if (password_verify($password1, $res['passwords'])) {
			session_start();
			$_SESSION["users"] = [
				"id" => $res["id"],
				"pseudo" => $res["username"],
				"email" => $res["emailut"],
				"roles" => $res["roles"],
				"noms" => $res["nomut"],
				"prenoms" => $res["prenomsut"]
			];

				header("Location: Accueil.php");

		} else {
			echo "<script> alert( 'Mot de passe incorrecte'); </script>";
			//$Erreur = 'Le nom utilisateur ou le mot de passe est incorrect.';
		}
	} else {
		echo
		"<script> alert('le Pseudo ou le mail existe pas'); </script>";
		//$Erreur = 'le Pseudo ou le mail existe pas';
	}
}
