<?php
include_once('php/connexion.php');

if (isset($_POST['email']) && $_POST['email'] != "")
{

	if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))
	{
		echo "<style>.alert { display: block!important; } </style>";
		$txt = "ERROR : Not a valid email";
	}
	else{
		$email = htmlspecialchars($_POST['email']);
		$cle_passwd = md5(microtime(TRUE)*100000);
		$stmt = $bdd->prepare("UPDATE users SET cle_passwd=:cle_passwd WHERE email like :email");
		$stmt->bindParam(':cle_passwd', $cle_passwd);
		$stmt->bindParam(':email', $email);
		$stmt->execute();

		
		ini_set( 'display_errors', 1 );
		error_reporting( E_ALL );

		$sujet = "Reset password" ;

		$header = "From: adm@matcha.com\nMIME-Version: 1.0\nContent-Type: text/html; charset=utf-8\n";

				$message = '<html>
								<head>
									<title>Reset password</title>
								</head>
								<body>
									<img src="http://localhost:8888/assets/icon/favicon.png" style="width: 100px;">
									<p>To change your password, please click on the link below or copy / paste in your internet browser.<br>http://localhost:8888/php/new_passwd.php?log='.$email.'&cle='.urlencode($cle_passwd).'<br>------------------------------------------------------------------------------------------<br>This is an automatic email, please do not reply.</p>
								</body>
							</html>';

		mail($email, $sujet, $message, $header);

		echo "<style>#alert_div { background-color: #568456!important;} </style>";
		$txt =  '<div id="alert_div"><p id="text_alert">Email send</p><span class="closebtn" onclick="del_alert()">&times;</span></div>';
	}
}

?>

<!DOCTYPE html>
<html lang="<?php echo $lang['html'] ?>">
<head>
	<?php include_once('meta.php'); ?>
		
	<!-- ******* CSS ***************** -->
	<link rel="stylesheet" type="text/css" href="css/main.css">
	<link rel="stylesheet" type="text/css" href="css/form.css">
	<link rel="stylesheet" type="text/css" href="css/responsive.css">
</head>

<body>
<!-- ******* HEADER ***************** -->
	<header class="float_menu">
			<a href="/"><img src="assets/icon/logo.png" alt="logo" class="logo"/></a>
			<div class="float_menu_rigth">
				<a href="/"><h2>HOME</h2></a>
			</div>
	</header>

<!-- ******* ERROR ***************** -->
	<div id="alert" class="alert">
		<?php echo $txt;?>
	</div>


<!-- ******* FORMULAIRE ***************** -->
	<section class="page_account-forgot" id="form">
		<div class="banner" style="height: 180px;"></div>
			<!-- Form -->
			<form method="post" action="passwd_forgot.php" accept-charset="utf-8">

				<label for="email"><p>EMAIL</p></label>
				<br/>
				<input type="email" name="email" required />
				
				<p class="register"><a href="account_register.php">REGISTER</a></p>
				<!-- SIGN IN -->
				<input type="submit" name="go_login_account" value="SEND" class="submit"/>
			</form>
			<!-- /end Form -->
	</section>

<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/main.js"></script>
</body>
</html>