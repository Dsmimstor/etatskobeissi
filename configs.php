<?php

define("HOSTSERVER", "localhost");
define("DBUSERNAME", "root");
define("DBPASSWORD", "");
//define("DBNAME", "bdsalsexpress");
define("DBNAME", "dbgestionskoub");

$dsn = "mysql:dbname=".DBNAME.";host=".HOSTSERVER;
// Connexion à la base de données MySQL

try {
	$conn = new PDO($dsn, DBUSERNAME, DBPASSWORD);
	//$conn->exec("SET NAMES utf8");
	$conn->exec("SET NAMES utf8mb4");

}
catch (PDOException $e)
{
	die("ERREUR : Impossible de se connecter. " . $e->getMessage());
}

