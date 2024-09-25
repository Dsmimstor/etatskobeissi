<?php

try{
	$bddPDO = new PDO('mysql:host=localhost;dbname=dbgestions', 'root', 'root');
}
catch(PDOException $e){
	echo "<p>Erreur : " .$e -> getMessage();
	die();
}
?>
