<footer class="container-fluid ">
	<div style=" color: black;">
		Utilisateur :
		<?=
		$_SESSION["users"]["pseudo"];
		?>
	</div>
	<div style="text-shadow: 2px 2px #000;">Logiciel de Gestion de Stock </div>
	<div id="times"><input type="text" value="<?php  echo date('d/m/Y'); ?>" disabled="disabled" ></div>
</footer>
</div>
<!-- Jquery CND link-->
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>-->
<script src="/js/cdnjs.js"></script>
<script type="text/javascript">
	$(document).ready(function() {
		//jquery for toggle sub menus
		$('.sub-btn').click(function() {
			$(this).next('.sub-menu').slideToggle();
			$(this).find('.dropdown').toggleClass('rotate');
		});
		//jquery pour basculer le sous-menu
		$('.menu-btn').click(function() {
			$('.side-bar').addClass('active');
			$('.menu-btn').css("visibility", "hidden");
		});

		$('.close-btn').click(function() {
			$('.side-bar').removeClass('active');
			$('.menu-btn').css("visibility", "visible");
		});
		$('.close-btn2').click(function() {
			$('.side-bar').removeClass('active');
			$('.menu-btn').css("visibility", "visible");
		});
	});
</script>
<script type="text/javascript">
	function startTime() {
		var today = new Date();
		var annee = today.getFullYear();
		var mois = today.getMonth() + 1;
		var jour = today.getDate();
		var heure = (today.getHours() - 1);
		var minute = today.getMinutes();
		var seconde = today.getSeconds();
		m = checkTime(minute);
		document.getElementById('time').innerHTML =
			//	" - " +heure+ ":" + minute;
			+jour + "/" + mois + "/" + annee + " - " + heure + ":" + minute;
		var t = setTimeout(startTime, 500);
	}

	function checkTime(i) {
		if (i < 10) {
			i = "0" + i
		}; // add zero in front of numbers < 10
		return i;
	}
	startTime();
</script>

<script >
	$(document).ready(function() {
		//jquery for toggle sub menus
		$('.sub-btn').onmouseover(function() {
			$(this).next('.sub-menu').slideToggle();
			$(this).find('.dropdown').toggleClass('rotate');
		});
		//jquery pour basculer le sous-menu
		$('.menu-btn').onmouseover(function() {
			$('.side-bar').addClass('active');
			$('.menu-btn').css("visibility", "hidden");
		});

		$('.close-btn').onmouseover(function() {
			$('.side-bar').removeClass('active');
			$('.menu-btn').css("visibility", "visible");
		});
		$('.close-btn2').onmouseover(function() {
			$('.side-bar').removeClass('active');
			$('.menu-btn').css("visibility", "visible");
		});
	});
</script>

<script >
(function onmouseovers() {
	alert('Bjr');
});
</script>