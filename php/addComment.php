<?php
include_once('connexion.php');

if (isset($_POST['content']) && isset($_POST['date']) && isset($_POST['movie'])
	&& $_POST['content'] != "" && $_POST['date'] != "" && $_POST['movie'] != "")
{
	$content = htmlspecialchars($_POST['content']);
	$date = htmlspecialchars($_POST['date']);
	$movie = $_POST['movie'];
	
	$req = $bdd->prepare('INSERT INTO comments (user_id, movie_id, content, created_at) VALUE (:user_id,	:movie_id, :content, :date)');
	$req->execute(array(
		'user_id' => $_SESSION['id'],
		'movie_id' => $movie,
		'content' => $content,
		'date' => $date,
	));
}

?>
