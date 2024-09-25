<?php
session_start();

require ('configs.php');
// Initialiser la session
session_destroy();
unset($_SESSION["users"]);

// Détruire la session.
//if(session_destroy())
//{
	// Redirection vers la page de connexion
	header("Location: login.php");
//}
?>