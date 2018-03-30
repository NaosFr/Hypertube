<?php
include_once('php/connexion.php');

if (!check_get('id'))
{
	header('Location: /');
	exit;
}

$content = json_decode(file_get_contents('https://yts.am/api/v2/list_movies.json?sort_by=title&order_by=asc&query_term='.$_GET['id']), true);

if ($content["data"]["movie_count"] != 1)
{
	header('Location: /');
	exit;
}
$movie = $content["data"]["movies"][0];
?>
<!DOCTYPE html>
<html>
<head>
	<?php include_once('meta.php'); ?>

	<!-- ******* CSS ***************** -->
	<link rel="stylesheet" type="text/css" href="css/main.css">
	<link rel="stylesheet" type="text/css" href="css/form.css">
	<link rel="stylesheet" type="text/css" href="css/responsive.css">
	<link rel="stylesheet" type="text/css" href="css/comments.css">

	<script type="text/javascript" src="js/jquery.js"></script>
	<script type="text/javascript" src="js/movie.js"></script>
	<script type="text/javascript" src="js/main.js"></script>
</head>
<body>
	<?php include_once('header.php'); ?>

	<div id="alert" class="alert">
		<div style="display: none;" id="alert_div">
			<p id="text_alert"></p>
			<span class="closebtn" onclick="del_alert()">&times;</span>
		</div>
	</div>
	<?php
	// display movie name

	// echo $movie["title"]."<br />";

	foreach ($movie["torrents"] as $el)
	{
		echo "<span style=\"cursor: pointer;\" onclick=\"getPath('".$el['hash']."')\">".$movie["title"]." - ".$el["quality"]." ".$el["size"]." ".$el["seeds"]." ".$el["peers"]."</span>";
		echo "<br />";
		echo "<br />";
		echo "<br />";
		echo "<br />";
	}

	?>
	<video id="video" style="background-color: black; height: 720px; width: 1280px;">
	</video>

	<?php

	// display cast and crew

	// $content = json_decode(file_get_contents('https://api.themoviedb.org/3/movie/'.$_GET['id'].'/credits?api_key=68a139112eb59bd80702070df4874941'), true);
	// echo "cast<br />";
	// $i = 0;
	// foreach ($content["cast"] as $el)
	// {
	// 	if ($el["profile_path"] != "null")
	// 	{
	// 		echo $el["name"];
	// 		echo "<br />";
	// 		echo "<img src=\"http://image.tmdb.org/t/p/w500".$el["profile_path"]."\" />";
	// 		echo "<br />";
	// 		$i++;
	// 	}
	// 	if ($i > 4)
	// 		break ;
	// }
	// echo "<br />";
	// echo "crew<br />";
	// foreach ($content["crew"] as $el)
	// {
	// 	if ($el["profile_path"] != "null" && $el["profile_path"] != "" && ($el["job"] == "Producer" || $el["job"] == "Director" || $el["job"] == "Executive Producer"  || $el["job"] == "Writer"))
	// 	{
	// 		echo $el["name"]." ".$el["job"];
	// 		echo "<br />";
	// 		echo "<img src=\"http://image.tmdb.org/t/p/w500".$el["profile_path"]."\" />";
	// 		echo "<br />";
	// 	}
	// }

	?>
	<?php
		include_once('./movie_comments.php');
		include_once('./php/getComments.php');
		$comments = getCommentsByMovieID($_GET['id']);
		movieComments($comments);
	?>
	<div style="display:none" id="user-login">gduron</div>
	<div style="display:none" id="user-first-name">Gaetan</div>
	<div style="display:none" id="user-last-name">Duron</div>
</body>
	<script type="text/javascript" src="./js/comments.js"></script>
</html>
