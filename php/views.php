<?php
include_once('connexion.php');

	$movies = htmlspecialchars($_POST['id_movies']);
	$id = $_SESSION['id'];

	echo $movies;
	$req = $bdd->prepare('SELECT * FROM views WHERE id_user = ? AND hash_movie = ?');
	$req->execute(array($id, $movies));
			
	if($req->rowCount() == 0)
	{
		$req = $bdd->prepare('INSERT INTO views (id_user, hash_movie) VALUES (:id_user, :hash_movie)');
		$req->execute(array(
			'id_user' => $id,
			'hash_movie' => $movies
		));

	}
	

?>

