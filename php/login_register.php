<?php
include('connexion.php');
session_start();

if ($_POST['submit'] == "login") {

	if (isset($_POST['login']) && isset($_POST['password'])
		&& $_POST['login'] != "" && $_POST['password'] != "")
		{
			$login = htmlspecialchars($_POST['login']);
			$passwd = htmlspecialchars($_POST['password']);
			$passwd = hash("whirlpool", htmlspecialchars($passwd));
			
			$req = $bdd->prepare('SELECT id_user, confirm FROM users WHERE login = ? AND passwd = ?');
			$req->execute(array($login, $passwd));
			if($req->rowCount() == 1)
			{
				$data = $req->fetch();
				if ($data['confirm'] == 0)
				{
					echo '<div id="alert_div"><p id="text_alert">ERROR : Email not confirmed !</p><span class="closebtn" onclick="del_alert()">&times;</span></div>';
				}
				else
				{
					$_SESSION['id'] = $data['id_user'];
					$_SESSION['login'] = $login;
					
					echo '<script>document.location.href="../index.php";</script>';
					exit;
				}
			}
			else
			{
				echo '<div id="alert_div"><p id="text_alert">ERROR : login or password wrong!</p><span class="closebtn" onclick="del_alert()">&times;</span></div>';
			}
	}

}

else if ($_POST['submit'] === "register") {
	if (isset($_POST['login']) && $_POST['login'] != ""
	 && isset($_POST['password']) && $_POST['password'] != ""
	 && isset($_POST['password_conf']) && $_POST['password_conf'] != ""
	 && isset($_POST['email']) && $_POST['email'] != ""
	 && isset($_POST['first_name']) && $_POST['first_name'] != ""
	 && isset($_POST['last_name']) && $_POST['last_name'] != "")
	{	
		
			if ($_POST['password'] != $_POST['password_conf'])
			{
				echo '<div id="alert_div"><p id="text_alert">ERROR : Passwords don\'t match</p><span class="closebtn" onclick="del_alert()">&times;</span></div>';
			}
			else if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))
			{
				echo '<div id="alert_div"><p id="text_alert">ERROR : ERROR : Not a valid email !</p><span class="closebtn" onclick="del_alert()">&times;</span></div>';
			}
			else if (strlen($_POST['password']) < 5)
			{
				echo '<div id="alert_div"><p id="text_alert">ERROR : Password too short !</p><span class="closebtn" onclick="del_alert()">&times;</span></div>';
				$txt = "";
			}
			else if (!preg_match("#[0-9]+#", $_POST['password']))
			{
				echo '<div id="alert_div"><p id="text_alert">ERROR : ERROR : Password must include a number !</p><span class="closebtn" onclick="del_alert()">&times;</span></div>';
			}
			else if (!preg_match("#[a-zA-Z]+#", $_POST['password']))
			{
				echo '<div id="alert_div"><p id="text_alert">ERROR : Password must include a letter !</p><span class="closebtn" onclick="del_alert()">&times;</span></div>';
			}
			else{
				$email = htmlspecialchars($_POST['email']);
				$login = htmlspecialchars($_POST['login']);
				$first_name = htmlspecialchars($_POST['first_name']);
				$last_name = htmlspecialchars($_POST['last_name']);
				$passwd = htmlspecialchars($_POST['password']);
				$passwd_conf = htmlspecialchars($_POST['password_conf']);
				$passwd = hash("whirlpool", htmlspecialchars($passwd));
				$passwd_conf = hash("whirlpool", htmlspecialchars($passwd_conf));
				
				$req = $bdd->prepare('SELECT id_user FROM users WHERE login = ?');
				$req->execute(array($login));

				$req2 = $bdd->prepare('SELECT id_user FROM users WHERE email = ?');
				$req2->execute(array($email));

				if($req->rowCount() > 0)
				{
					echo '<div id="alert_div"><p id="text_alert">ERROR : Pseudo already use !</p><span class="closebtn" onclick="del_alert()">&times;</span></div>';
				}
				else if ($req2->rowCount() > 0)
				{
					echo '<div id="alert_div"><p id="text_alert">ERROR : Email already use !</p><span class="closebtn" onclick="del_alert()">&times;</span></div>';
				}
				else
				{
					$cle = md5(microtime(TRUE)*100000);

					$req = $bdd->prepare('INSERT INTO users (email, login, first_name, last_name, passwd, confirm, cle) VALUES (:email, :login, :first_name, :last_name, :passwd, 0, :cle)');
					$req->execute(array(
						'email' => $email,
						'login' => $login,
						'first_name' => $first_name,
						'last_name' => $last_name,
						'passwd' => $passwd,
						'cle' => $cle
						));

					ini_set( 'display_errors', 1 );
			    	error_reporting( E_ALL );

					$sujet = "Active your account" ;
					$header = "From: adm@hypertube.com\nMIME-Version: 1.0\nContent-Type: text/html; charset=utf-8\n";

					$message = '<html>
							      <head>
							       <title>Welcome to Matcha</title>
							      </head>
							      <body>
							       <p>To validate your account, please click on the link below or copy / paste in your internet browser.<br>http://localhost:8888/php/activation.php?log='.urlencode($login).'&cle='.urlencode($cle).'<br>------------------------------------------------------------------------------------------<br>This is an automatic email, please do not reply.</p>
							      </body>
							     </html>';

					mail($email, $sujet, $message, $header);

					$id = $bdd->lastInsertId();
					mkdir('../data/'.$id.'');
					copy('../data/user.jpg', '../data/'.$id.'/user.jpg');

					echo "<style>#alert_div { background-color: #568456!important;} </style>";
					echo '<div id="alert_div"><p id="text_alert">SUCCES : Please confirm your email !</p><span class="closebtn" onclick="del_alert()">&times;</span></div>';
					exit;
			}
		}
	}
}

else if ($_POST['submit'] === "forgot") {
	if (isset($_POST['email']) && $_POST['email'] != "")
	{

		if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))
		{
			echo '<div id="alert_div"><p id="text_alert">ERROR : Not a valid email !</p><span class="closebtn" onclick="del_alert()">&times;</span></div>';
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

			$header = "From: adm@hypertube.com\nMIME-Version: 1.0\nContent-Type: text/html; charset=utf-8\n";

					$message = '<html>
							      <head>
							       <title>Reset password</title>
							      </head>
							      <body>
							       <p>To change your password, please click on the link below or copy / paste in your internet browser.<br>http://localhost:8888/php/new_passwd.php?log='.$email.'&cle='.urlencode($cle_passwd).'<br>------------------------------------------------------------------------------------------<br>This is an automatic email, please do not reply.</p>
							      </body>
							     </html>';

			mail($email, $sujet, $message, $header);

			echo "<style>#alert_div { background-color: #568456!important;} </style>";
			echo '<div id="alert_div"><p id="text_alert">SUCCES : Email send ! </p><span class="closebtn" onclick="del_alert()">&times;</span></div>';
		}
	}
}
	
?>