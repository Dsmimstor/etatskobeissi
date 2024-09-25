<?php
require_once('configs.php');
//require ('util.php');
//int_session();
require('inscription.php');
require_once('conxusers.php');
?>

<!DOCTYPE html>
<html lang="fr">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Connexion</title>

	<link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
	<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
	<link rel="shortcut icon" href="/img/Iconadc.jpg" />

	<link rel="stylesheet" media="screen" href="screen.css" type="text/css" />
	<link rel="stylesheet" href="/css/stylesinscription.css">
	
</head>

<body>
	<!--<div class="Imglogo"><img src="img/SALS1.png" /></div>-->
	<!--  <div class="imagehaut"><img src="img/SALS1.png" class="img" /></div> -->
	<div class="wrapper">

		<span class="bg-animate"></span>
		<span class="bg-animate2"></span>

		<div class="form-box login">
			<h2 class="animation" style="--i:0;--j:21;">Connexion</h2>
			<form action="" method="POST" name="login" autocomplete="off">
				<div class="input-box animation" style="--i:1;">
					<!--<input type="text" required>-->
					<input type="text" name="username" id="Pseudo" autocomplete="off" required />
					<label for="">Nom Utilisateur ou Email</label>
					<i class='bx bxs-user'></i>
				</div>
				<div class="input-box animation" style="--i:2;">
					<!--<input type="password" class="Passinscrip" required>-->
					<input type="password" name="password1" id="password" class="Passinscrip" autocomplete="off" required />
					<label for="">Mot de passe</label>
					<i data-feather="eye" class="Insceye"></i>
					<i data-feather="eye-off" class="Insceyeoff"></i>
					
				</div>
				<button type="submit" class="btn animation" name="submitcnx" style="--i:3;">Connexion</button>
				<div class="logreg-link animation" style="--i:4;">
					<p style="color:red" ;>
						<?php
						//echo ('$Erreur');
						//echo  "$Erreur";
						?>
					</p>

					<p>Vous êtes nouveau ici ? <a href="#" class="register-link ">S'inscrire</a></p>
				</div>
			</form>
		</div>
		<div class="info-text login">
			<h2 class="animation" style="--i:0">Bienvenu</h2>
			<h2 class="animation" style="--i:1"> à </h2>
			<h2 class="animation" style="--i:2">ETATS KOUBEISSI</h2>
			<p class="animation" style="--i:3">Treichville </p>
			<p class="animation" style="--i:4">Whatsapp 00225 07 69 181 474 </p>
			<p class="animation" style="--i:5">Email: etatskobeissi@gmail.com</p>
		</div>
		<div class="form-box register">
			<h2 class="animation" style="--i:17; --j:0">Inscription</h2>
			<form action="" method="POST" name="register" autocomplete="off">
				<div class="input-box1 animation" style="--i:18; --j:1">
					<input type="text" name="noms" required value="" autocomplete="off">
					<label for="">Nom </label>
					<i class='bx bxs-user'></i>
				</div>
				<div class="input-box1 animation" style="--i:19; --j:2">
					<input type="text" name="prenoms" required value="" autocomplete="off">
					<label for="">Prenom</label>
					<i class='bx bxs-user'></i>
				</div>
				<div class="input-box1 animation" style="--i:20; --j:3">
					<input type="text" name="email" required value="" autocomplete="off">
					<label for="">Email</label>
					<i class='bx bxs-envelope'></i>
				</div>
				<div class="input-box1 animation" style="--i:21; --j:4">
					<input type="text" name="pseudo" required value="" autocomplete="off">
					<label for="">Nom Utilisateur</label>
					<i class='bx bxs-user'></i>
				</div>
				<div class="input-box1-1 animation" style="--i:22; --j:5">
					<input type="password" name="passwordrgt" class="Pass" required value="" autocomplete="off">
					<label for="">Mot de passe</label>
					<i data-feather="eye" class="Passeye"></i>
					<i data-feather="eye-off" class="Passeyeoff"></i>
				</div>
				<div class="input-box1-1 animation" style="--i:23; --j:6">
					<input type="password" name="confirpassword" class="Pass1" required value="" autocomplete="off">
					<label for="">Confirmer le Mot de passe</label>
					<i data-feather="eye" class="Passeye1"></i>
					<i data-feather="eye-off" class="Passeyeoff1"></i>
				</div>
				<button type="submit" class="btn1 animation" name="submitenr" style="--i:24; --j:7">Enregistrer</button>
				<button type="" class="btn1 animation" style="--i:25; --j:8">Annuler</button>
				<div class="logreg-link animation" style="--i:26; --j:9">
					<p>Vous êtes nouveau ici ? <a href="#" class="login-link">Se Connecter</a></p>
				</div>
			</form>
		</div>

		<div class="info-text register">
			<h2 class="animation" style="--i:0">Bienvenu</h2>
			<h2 class="animation" style="--i:1"> à </h2>
			<h2 class="animation" style="--i:2">ETATS KOUBEISSI</h2>
			<p class="animation" style="--i:3">Treichville </p>
			<p class="animation" style="--i:4">Whatsapp 00225 07 69 181 474 </p>
			<p class="animation" style="--i:5">Email: etatskobeissi@gmail.com</p>
		</div>
		<script src="/icons.js"></script>
		<script src="script.js">
		</script>
		<script src="https://unpkg.com/feather-icons"></script>
		<script>
			feather.replace();
		</script>
		<script>
			const eye = document.querySelector('.Insceye');
			const eyeoff = document.querySelector('.Insceyeoff');
			const passwordField = document.querySelector('.Passinscrip[type=password]');

			eye.addEventListener('click', () => {
				eye.style.display = "none";
				eyeoff.style.display = "block";
				passwordField.type = "text";
			});

			eyeoff.addEventListener('click', () => {
				eyeoff.style.display = "none";
				eye.style.display = "block";
				passwordField.type = "password";
			});
		</script>

		<script>
			//const eye1 = document.querySelector('.feather-circle');
			//const eyeoff1 = document.querySelector('.feather-x-circle');
			const eye1 = document.querySelector('.Passeye');
			const eyeoff1 = document.querySelector('.Passeyeoff ');

			const passwordField1 = document.querySelector('.Pass[type=password]');

			eye1.addEventListener('click', () => {
				eye1.style.display = "none";
				eyeoff1.style.display = "block";
				passwordField1.type = "text";
			});

			eyeoff1.addEventListener('click', () => {
				eyeoff1.style.display = "none";
				eye1.style.display = "block";
				passwordField1.type = "password";
			});
		</script>

		<script>
			const eye2 = document.querySelector('.Passeye1');
			const eyeoff2 = document.querySelector('.Passeyeoff1');
			const passwordField2 = document.querySelector('.Pass1[type=password]');

			eye2.addEventListener('click', () => {
				eye2.style.display = "none";
				eyeoff2.style.display = "block";
				passwordField2.type = "text";
			});

			eyeoff2.addEventListener('click', () => {
				eyeoff2.style.display = "none";
				eye2.style.display = "block";
				passwordField2.type = "password";
			});
		</script>
</body>

</html>