<?php 
include('php/connexion.php');
session_start();

if ($_SESSION['id'] == "" || $_SESSION['login'] == "") {
	echo '<!-- ******* HEADER ***************** -->
	<header class="float_menu">
			<a href="index.php"><img src="assets/icon/logo.png" alt="logo" class="logo"/></a>
			<div class="float_menu_rigth">
				<form action="#" onsubmit="return false" accept-charset="utf-8" class="search_form">

				    <input type="text" name="search" maxlength="40" required/>

				    <input type="submit" value="SEARCH" class="submit_search transition" onclick="search()" />
				</form>
				<a href="signin.php"><h2>SIGN IN</h2></a>
				<a href="signin.php?el=register"><h2>REGISTER</h2></a>
			</div>
	</header>

<!-- ******* ALERT ***************** -->
	<div id="alert" class="alert"></div>';
}
else{
	echo '<!-- ******* HEADER ***************** -->
	<header class="float_menu">
			<a href="index.php"><img src="assets/icon/logo.png" alt="logo" class="logo"/></a>
			<div class="float_menu_rigth">
				<form action="#" onsubmit="return false" accept-charset="utf-8" class="search_form">

				    <input type="text" name="search" maxlength="40" required/>

				    <input type="submit" value="SEARCH" class="submit_search transition" onclick="search()" />
				</form>	

				<a href="setting.php"><img src="assets/icon/settings.svg" alt="setting"/></a>
				<a href="php/logout.php"><img src="assets/icon/logout.svg" alt="logout"/></a>
			</div>
	</header>

<!-- ******* ALERT ***************** -->
	<div id="alert" class="alert"></div>';
}
?>


