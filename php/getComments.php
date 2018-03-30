<?php
include_once('php/connexion.php');

function getCommentsByMovieID ($id) {
	$comments = [
			[
				'last_name'=>'Wyborska',
				'first_name'=>'Hugo',
				'login'=>'hugowyb',
				'date'=>'March 18',
				'content'=>'Researchers at Whitehead Institute have uncovered a framework for regeneration that may explain and predict how stem cells in adult, regenerating tissue determine where to form replacement structures.'
			],
			[
				'last_name'=>'Wyborska',
				'first_name'=>'Hugo',
				'login'=>'hugowyb',
				'date'=>'March 18',
				'content'=>'Researchers at Whitehead Institute have uncovered a framework for regeneration that may explain and predict how stem cells in adult, regenerating tissue determine where to form replacement structures.'
			],
		];

	return $comments;
}	
?>
