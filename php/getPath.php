<?php

include_once('connexion.php');

if (!check_post('hash'))
{
	echo "error";
	exit;
}

$req = $bdd->prepare('SELECT path, downloaded FROM hash WHERE hash = ?');
$req->execute(array($_POST['hash']));

if ($req->rowCount() != 1)
{
	echo "error";
	exit;
}

$data = $req->fetch();

if ($data['downloaded'] < 10)
{
	echo "error";
	exit;
}

echo $data['path'];

?>
