<?php
include('connexion.php');
session_start();

/////////////////////////////////
////////// CHANGE PROFIL
/////////////////////////////////

if ($_POST['submit'] === "change_profil") {


if (isset($_POST['email']) && $_POST['email'] != "" 
	&& isset($_POST['login']) && $_POST['login'] != ""
	&& isset($_POST['first_name']) && $_POST['first_name'] != ""
	&& isset($_POST['last_name']) && $_POST['last_name'] != "")
{
		$email = htmlspecialchars($_POST['email']);
		$login = htmlspecialchars($_POST['login']);
		$first_name = htmlspecialchars($_POST['first_name']);
		$last_name = htmlspecialchars($_POST['last_name']);
		$last_name = strtoupper($last_name);


		$req_login = $bdd->prepare('SELECT id_user FROM users WHERE login = ? AND id_user != '.$_SESSION['id'].'');
		$req_login->execute(array($login));

		$req_email = $bdd->prepare('SELECT id_user FROM users WHERE email = ? AND id_user != '.$_SESSION['id'].'');
		$req_email->execute(array($email));

		if($req_login->rowCount() > 0)
		{
			echo '<div id="alert_div"><p id="text_alert">ERROR : Pseudo already used !</p><span class="closebtn" onclick="del_alert()">&times;</span></div>';
		}
		else if ($req_email->rowCount() > 0) {
			echo '<div id="alert_div"><p id="text_alert">ERROR : Email already used !</p><span class="closebtn" onclick="del_alert()">&times;</span></div>';
		}
		else{
			$req = $bdd->prepare('SELECT * FROM users WHERE login = ? AND id_user = ?');
			$req->execute(array($_SESSION['login'] , $_SESSION['id']));

			if($req->rowCount() == 1)
			{

				$stmt = $bdd->prepare("UPDATE users SET 
					email=:email, 
					login=:login, 
					first_name=:first_name,
					last_name=:last_name
					WHERE id_user like :id");

				$stmt->bindParam(':id', $_SESSION['id']);
				$stmt->bindParam(':email', $email);
				$stmt->bindParam(':login', $_SESSION['login']);
				$stmt->bindParam(':first_name', $first_name);
				$stmt->bindParam(':last_name', $last_name);
				$stmt->execute();
		
				echo "<style>#alert_div { background-color: #568456!important;} </style>";
	        	echo '<div id="alert_div"><p id="text_alert">Setting change</p><span class="closebtn" onclick="del_alert()">&times;</span></div>';
			}
			else{
				echo '<div id="alert_div"><p id="text_alert">SYSTEM ERROR !</p><span class="closebtn" onclick="del_alert()">&times;</span></div>';
			}	
		}	
}
else{
	echo '<div id="alert_div"><p id="text_alert">ERROR : Not completed !</p><span class="closebtn" onclick="del_alert()">&times;</span></div>';
}

}

/////////////////////////////////
////////// CHANGE PASSWD
/////////////////////////////////


if ($_POST['submit'] === "change_passwd") {

if (isset($_POST['old_password']) && $_POST['old_password'] != "" 
	&& isset($_POST['new_password']) && $_POST['new_password'] != "")
{
		$old_passwd = htmlspecialchars($_POST['old_password']);
		$new_passwd = htmlspecialchars($_POST['new_password']);
		$old_passwd = hash("whirlpool", htmlspecialchars($old_passwd));
		$new_passwd = hash("whirlpool", htmlspecialchars($new_passwd));

		if (strlen($_POST['new_password']) < 5){
			echo '<div id="alert_div"><p id="text_alert">ERROR : Password too short</p><span class="closebtn" onclick="del_alert()">&times;</span></div>';
		}
		else if (!preg_match("#[0-9]+#", $_POST['new_password'])){
			echo '<div id="alert_div"><p id="text_alert">ERROR : Password must include a number</p><span class="closebtn" onclick="del_alert()">&times;</span></div>';
		}
		else if (!preg_match("#[a-zA-Z]+#", $_POST['new_password'])){
			echo '<div id="alert_div"><p id="text_alert">ERROR : Password must include a letter</p><span class="closebtn" onclick="del_alert()">&times;</span></div>';
		}
		else{
			$req = $bdd->prepare('SELECT * FROM users WHERE login = ? AND passwd = ?');
			$req->execute(array($_SESSION['login'] , $old_passwd));

			if($req->rowCount() == 1)
			{
				$stmt = $bdd->prepare("UPDATE users SET passwd=:passwd WHERE login like :login");
				$stmt->bindParam(':login', $_SESSION['login']);
				$stmt->bindParam(':passwd', $new_passwd);
				$stmt->execute();
				echo "<style>#alert_div { background-color: #568456!important;} </style>";
				echo '<div id="alert_div"><p id="text_alert">Password change</p><span class="closebtn" onclick="del_alert()">&times;</span></div>';
			}
			else{
				echo '<div id="alert_div"><p id="text_alert">ERROR : Password Wrong</p><span class="closebtn" onclick="del_alert()">&times;</span></div>';
			}	
		}	
}

}



?>