<header class="nav1">
	<!-- Logo-->
	<p class="slogan" href="#">
		<img src="/img/SALS1L.png" alt="logoAtelier" />
		<a><?php echo htmlspecialchars($resultste["designation"], ENT_QUOTES, 'UTF-8'); ?> </a>
	</p>
</header>
<div class="menu-btn" onmouseover="onmouseovers.call(this)">
	<i class="fas fa-bars"></i>
</div>
<div class="total1">
	<div class="total">
		<div class="menugene liencache">
			<div class="side-bar">
				<!-- Header section -->
				<header>
					<!-- bouton fermer -->
					<div class="close-btn">
						<i class="fas fa-times"></i>
					</div>
					<!-- Image-->
					<img src="/img/NoImg.jpg" alt="">
					<!-- logo -->
					<h1>
						<!--David Seri-->
						<?=
						$_SESSION["users"]["noms"], " ", $_SESSION["users"]["prenoms"];
						?>
					</h1>
				</header>
				<!-- Menu -->
				<div class="menu">

					<div class="item"><a class="sub-btn"><i class="fa-solid fa-people-roof" style="margin-right:13px;"></i>GESTION IMMOBILIERS
							<i class="fas fa-angle-right dropdown"></i>
						</a>
						<div class="sub-menu">
							<a href="/immobilier/listeloco.php" class="sub-item">&nbsp<i class='fas fa-cash-register' style='font-size:13px;color:yellow'></i>&nbsp LOCAUX</a>
							<a href="/immobilier/listeloc.php" class="sub-item">&nbsp<i class='fas fa-cash-register' style='font-size:13px;color:yellow'></i>&nbsp LOCATAIRES</a>
							<a href="/immobilier/listeloca.php" class="sub-item">&nbsp<i class='fas fa-cash-register' style='font-size:13px;color:yellow'></i>&nbsp LOCATIONS</a>
							<div class="item"><a class="sub-btn"><i class="fa-solid fa-people-roof" style="margin-right:13px;"></i>COMPTES<i class="fas fa-angle-right dropdown" style="margin:8px;"></i></a>
								<div class="sub-menu">
									<a href="/immobilier/listequittance.php" class="sub-item">&nbsp &nbsp &nbsp<i class='fas fa-cash-register' style='font-size:13px;color:yellow'></i>&nbsp QUITTANCES</a>
									<a href="/immobilier/listeproformac.php" class="sub-item">&nbsp &nbsp &nbsp<i class='fas fa-cash-register' style='font-size:13px;color:yellow'></i>&nbsp CAISSES</a>
								</div>
							</div>
							<!--	<a href="../venteinterne/listevente.php" class="sub-item"><i class='fas fa-file-invoice-dollar' style='font-size:14px;color:red'></i>&nbsp LISTE DES FACTURES</a> -->
						</div>
					</div>
					<div class="item"><a class="sub-btn"><i class="fa-solid fa-people-roof" style="margin-right:13px;"></i>GESTION AUTOMOBILES
							<i class="fas fa-angle-right dropdown"></i>
						</a>
						<div class="sub-menu">
							<div class="item"><a class="sub-btn"><i class="fa-solid fa-people-roof" style="margin-right:13px;"></i>LOCATIONS<i class="fas fa-angle-right dropdown" style="margin:8px;"></i></a>
								<div class="sub-menu">
									<a href="../venteinterne/listefacture.php" class="sub-item">&nbsp &nbsp &nbsp<i class='fas fa-cash-register' style='font-size:13px;color:yellow'></i>&nbsp Nouveau</a>
									<a href="/venteinterne/listeproformac.php" class="sub-item">&nbsp &nbsp &nbsp<i class='fas fa-cash-register' style='font-size:13px;color:yellow'></i>&nbsp Liste des Locations</a>
									<a href="/venteinterne/listeproformac.php" class="sub-item">&nbsp &nbsp &nbsp<i class='fas fa-cash-register' style='font-size:13px;color:yellow'></i>&nbsp Maintenace Vehicules</a>
									<a href="/venteinterne/listeproformac.php" class="sub-item">&nbsp &nbsp &nbsp<i class='fas fa-cash-register' style='font-size:13px;color:yellow'></i>&nbsp CAISSE</a>

								</div>
							</div>
							<div class="item"><a class="sub-btn"><i class="fa-solid fa-people-roof" style="margin-right:13px;"></i>VENTES<i class="fas fa-angle-right dropdown" style="margin:8px;"></i></a>
								<div class="sub-menu">
									<a href="/venteinterne/listeproformac.php" class="sub-item">&nbsp &nbsp &nbsp<i class='fas fa-cash-register' style='font-size:13px;color:yellow'></i>&nbsp COMMANDES</a>
									<a href="/venteinterne/listeproformac.php" class="sub-item">&nbsp &nbsp &nbsp<i class='fas fa-cash-register' style='font-size:13px;color:yellow'></i>&nbsp LIVRAISONS</a>
									<a href="/venteinterne/listeproformac.php" class="sub-item">&nbsp &nbsp &nbsp<i class='fas fa-cash-register' style='font-size:13px;color:yellow'></i>&nbsp FACTURES</a>
									<a href="../venteinterne/listeproformac.php" class="sub-item">&nbsp &nbsp &nbsp<i class='fas fa-cash-register' style='font-size:13px;color:yellow'></i>&nbsp CAISSE</a>
								</div>
							</div>
							<div class="item"><a class="sub-btn"><i class="fa-solid fa-people-roof" style="margin-right:13px;"></i>ACAHTS<i class="fas fa-angle-right dropdown" style="margin:8px;"></i></a>
								<div class="sub-menu">
									<a href="/venteinterne/listeproformac.php" class="sub-item">&nbsp &nbsp &nbsp<i class='fas fa-cash-register' style='font-size:13px;color:yellow'></i>&nbsp COMMANDES</a>
									<a href="/venteinterne/listeproformac.php" class="sub-item">&nbsp &nbsp &nbsp<i class='fas fa-cash-register' style='font-size:13px;color:yellow'></i>&nbsp LIVRAISONS</a>
									<a href="/venteinterne/listeproformac.php" class="sub-item">&nbsp &nbsp &nbsp<i class='fas fa-cash-register' style='font-size:13px;color:yellow'></i>&nbsp FACTURES</a>
									<a href="/venteinterne/listeproformac.php" class="sub-item">&nbsp &nbsp &nbsp<i class='fas fa-cash-register' style='font-size:13px;color:yellow'></i>&nbsp CAISSE</a>
								</div>
							</div>
						</div>
					</div>
					<div class="item"><a class="sub-btn"><i class="fa-solid fa-folder-closed" style="margin-right:13px;"></i>GESTION MARCHANDISES
							<i class="fas fa-angle-right dropdown"></i>
						</a>
						<div class="sub-menu">
						<div class="item"><a class="sub-btn"><i class="fa-solid fa-people-roof" style="margin-right:13px;"></i>VENTES<i class="fas fa-angle-right dropdown" style="margin:8px;"></i></a>
								<div class="sub-menu">
									<a href="/venteinterne/listeproformac.php" class="sub-item">&nbsp &nbsp &nbsp<i class='fas fa-cash-register' style='font-size:13px;color:yellow'></i>&nbsp COMMANDES</a>
									<a href="/venteinterne/listeproformac.php" class="sub-item">&nbsp &nbsp &nbsp<i class='fas fa-cash-register' style='font-size:13px;color:yellow'></i>&nbsp LIVRAISONS</a>
									<a href="/venteinterne/listeproformac.php" class="sub-item">&nbsp &nbsp &nbsp<i class='fas fa-cash-register' style='font-size:13px;color:yellow'></i>&nbsp FACTURES</a>
									<a href="/venteinterne/listeproformac.php" class="sub-item">&nbsp &nbsp &nbsp<i class='fas fa-cash-register' style='font-size:13px;color:yellow'></i>&nbsp CAISSE</a>
								</div>
							</div>
							<div class="item"><a class="sub-btn"><i class="fa-solid fa-people-roof" style="margin-right:13px;"></i>ACAHTS<i class="fas fa-angle-right dropdown" style="margin:8px;"></i></a>
								<div class="sub-menu">
									<a href="/venteinterne/listeproformac.php" class="sub-item">&nbsp &nbsp &nbsp<i class='fas fa-cash-register' style='font-size:13px;color:yellow'></i>&nbsp COMMANDES</a>
									<a href="/venteinterne/listeproformac.php" class="sub-item">&nbsp &nbsp &nbsp<i class='fas fa-cash-register' style='font-size:13px;color:yellow'></i>&nbsp LIVRAISONS</a>
									<a href="/venteinterne/listeproformac.php" class="sub-item">&nbsp &nbsp &nbsp<i class='fas fa-cash-register' style='font-size:13px;color:yellow'></i>&nbsp FACTURES</a>
									<a href="/venteinterne/listeproformac.php" class="sub-item">&nbsp &nbsp &nbsp<i class='fas fa-cash-register' style='font-size:13px;color:yellow'></i>&nbsp CAISSE</a>
								</div>
							</div>
						</div>
					</div>
					<!--	<div class="item"><a class="sub-btn"><i class="fa-solid fa-cubes" style="margin-right:13px;"></i>GESTION DES PRODUITS
							<i class="fas fa-angle-right dropdown"></i>
						</a>
						<div class="sub-menu">
							<a href="../categorie/listecategorie.php" class="sub-item"><i class="fa fa-angle-right" style="font-size:13px ;color:red"></i><i class="fa fa-angle-right " style="font-size:13px ;color:red"></i>&nbsp CATEGORIES</a>
							<a href="../familles/listefamille.php" class="sub-item"><i class="fa fa-angle-right" style="font-size:13px ;color:red"></i><i class="fa fa-angle-right " style="font-size:13px ;color:red"></i>&nbsp FAMAILLES</a>
							<a href="../sousfamilles/listesousfamille.php" class="sub-item"><i class="fa fa-angle-right" style="font-size:13px ;color:red"></i><i class="fa fa-angle-right " style="font-size:13px ;color:red"></i>&nbsp SOUS FAMILLES</a>
							<a href="../articles/liste.php" class="sub-item"><i class="fa-brands fa-product-hunt" style="font-size:14px ;color:red"></i>&nbsp PRODUITS</a>
							<a href="../unites/listeunite.php" class="sub-item"><i class="fa-solid fa-weight-scale" style="font-size:14px ;color:red"></i>&nbsp UNITES</a>
							<a href="../devise/listedevise.php" class="sub-item"><i class="fa-solid fa-dollar-sign" style="font-size:14px ;color:red"></i>&nbsp DEVISE</a>
							<a href="../ville/listeville.php" class="sub-item"><i class="fa-solid fa-city" style="font-size:14px ;color:red"></i>&nbsp VILLE</a>
							<a href="../pays/listepays.php" class="sub-item"><i class="fa-solid fa-globe" style="font-size:14px ;color:red"></i>&nbsp PAYS</a>
						</div>
					</div>
					-->
					<div class="item"><a class="sub-btn"><i class="fas fa-cog" style="margin-right:13px;"></i> ADMINISTRATEUR
							<i class="fas fa-angle-right dropdown"></i>
						</a>
						<div class="sub-menu">
							<a href="" class="sub-item"><i class="fa-solid fa-user-pen" style="font-size:14px ;color:green"></i>&nbsp CREER COMPTE</a>
							<a href="" class="sub-item"><i class="fa-solid fa-user-xmark" style="font-size:14px ;color:red"></i>&nbsp SUPPRIMER COMPTE</a>
							<a href="" class="sub-item"><i class="fa-solid fa-upload" style="font-size:14px ;color:blue"></i>&nbsp IMP DONNEES</a>
							<a href="" class="sub-item"><i class="fa-solid fa-id-card" style="font-size:14px ;color:blue"></i>&nbsp PROFIL UTILISATEUR</a>
							<a href="" class="sub-item"><i class="fa-solid fa-trash-can" style="font-size:14px ;color:red"></i>&nbsp SUP BASE DE DONNEES</a>
						</div>
					</div>
					<div class="item"><a href="logout.php"><i class="fa-solid fa-arrow-right-from-bracket" style="font-size:15px ; margin-right:13px;"></i>SE DECONNECTER</a></div>
				</div>
			</div>
		</div>