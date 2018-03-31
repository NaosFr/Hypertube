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

	<!-- ******* JS ***************** -->
	<script type="text/javascript" src="js/jquery.js"></script>
	<script type="text/javascript" src="js/movie.js"></script>
	<script type="text/javascript" src="js/main.js"></script>
	<script type="text/javascript" src="js/comments.js"></script>
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
	<iframe src="/test.php"></iframe>
<!-- 	<video controls id="video" style="background-color: black; height: 720px; width: 1280px;">
		<source src="films/test.mp4" >
	</video> -->

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
	<div class="wrapper">
		<div class="messages">
			<div class="new-message">
				<div class="message-form">
					<input onkeyup="keyUp(event, '<?php echo $_GET['id'] ?>')" type="text" id="new-message" class="message-input" placeholder="What`s on your mind ?" />
					<div class="send-button">
						<input onclick="addComment('<?php echo $_GET['id'] ?>');" id="comment-button" type="submit" value="COMMENT"/>
					</div>
				</div>
			</div>
			<div class="messages-list" id="message-list">
				<?php
				$req = $bdd->prepare('SELECT users.login, users.first_name, users.last_name, comments.comment, comments.date FROM comments INNER JOIN users ON comments.id_user = users.id_user WHERE id_movie = ? ORDER BY comments.id_comment DESC');
				$req->execute(array($_GET['id']));
				if ($req->rowCount() == 0)
				{
					?>
					<div id="no-message" class="message">
						<div class="message-head">
							<div class="message-head--content">
								<p class="author">
									No comments yet
								</p>
								<a href="#">
									<p class="login">
									</p>
								</a>
								<p class="date">
								</p>
							</div>
						</div>
						<p class="content">
							Be the first to write a comment !
						</p>
					</div>
					<?php
				}
				while ($data = $req->fetch())
				{
					?>
					<div class="message">
						<div class="message-head">
							<div class="message-head--content">
								<p class="author">
									<?php echo $data['first_name'].' '.$data['last_name'] ?>
								</p>
								<a href="./user.php?login=<?php echo $data['login'] ?>">
									<p class="login">
										@<?php echo $data['login'] ?>
									</p>
								</a>
								<p class="date">
									<?php echo date("d/m/y", $data['date']) ?>
								</p>
							</div>
						</div>
						<p class="content">
							<?php echo $data['comment'] ?>
						</p>
					</div>
					<?php
				}
				?>
			</div>
		</div>
	</div>
</body>
</html>
