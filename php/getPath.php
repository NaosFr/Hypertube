<?php

include_once('connexion.php');

if (!check_post('hash'))
{
	echo "error";
	exit;
}

$req = $bdd->prepare('SELECT path FROM hash WHERE hash = ?');
$req->execute(array($_POST['hash']));

if ($req->rowCount() != 1)
{
	echo "error";
	exit;
}

$data = $req->fetch();

echo $data['path'];

?>
