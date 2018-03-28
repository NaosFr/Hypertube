<?php 
include_once('php/connexion.php');

if ($_SESSION['id'] == "" || $_SESSION['login'] == "") {
	echo '<!-- ******* HEADER ***************** -->
	<header class="float_menu">
			<a href="/"><img src="assets/icon/logo.png" alt="logo" class="logo"/></a>
			<div class="float_menu_rigth">
				<form action="#" onsubmit="return false" accept-charset="utf-8" class="search_form">

					<input type="text" name="search" maxlength="40" />

					<input type="submit" value="'.$lang['header_search'].'" class="submit_search transition" onclick="search_movie()" />
				</form>
				<a href="signin.php"><h2>'.$lang['header_signin'].'</h2></a>
				<a href="signin.php?el=register"><h2>'.$lang['header_register'].'</h2></a>
			</div>
	</header>

<!-- ******* ALERT ***************** -->
	<div id="alert" class="alert"></div>';
}
else{
	echo '<!-- ******* HEADER ***************** -->
	<header class="float_menu">
			<a href="/"><img src="assets/icon/logo.png" alt="logo" class="logo"/></a>
			<div class="float_menu_rigth">
				<form action="#" onsubmit="return false" accept-charset="utf-8" class="search_form">

					<input type="text" name="search" maxlength="40" />

					<input type="submit" value="'.$lang['header_search'].'" class="submit_search transition" onclick="search_movie()" />
				</form>	

				<a href="setting.php"><img src="assets/icon/settings.svg" alt="setting"/></a>
				<a href="php/logout.php"><img src="assets/icon/logout.svg" alt="logout"/></a>
			</div>
	</header>

<!-- ******* ALERT ***************** -->
	<div id="alert" class="alert"></div>';
}
?>


