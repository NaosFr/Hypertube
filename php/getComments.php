<?php
function getCommentsByMovieID ($id, $bdd) {
	$comments = [
			[
				'last_name'=>'No comments yet',
				'first_name'=>'',
				'login'=>'',
				'date'=>'',
				'content'=>''
			],
		];
	
	$req = $bdd->prepare('SELECT users.login, users.first_name, users.last_name, content, created_at AS date FROM comments JOIN users ON comments.user_id=users.id_user WHERE movie_id = :movie_id;');
	$req->execute(array(
		'movie_id' => $id,
	));
	if($req->rowCount() > 0)
	{
		$comments = $req->fetchAll();
	}

	return $comments;
}	
?>
