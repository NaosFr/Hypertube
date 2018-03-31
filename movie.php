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

	<style type="text/css">
		.search_form{
			display: none;
		}
	</style>

</head>
<body>
	<?php include_once('header.php'); ?>

	<div id="alert" class="alert">
		<div style="display: none;" id="alert_div">
			<p id="text_alert"></p>
			<span class="closebtn" onclick="del_alert()">&times;</span>
		</div>
	</div>


	<div class="select_container">
		<div class="select">
			<?php

			foreach ($movie["torrents"] as $el)
			{
				echo "<span style='cursor: pointer;' onclick=\"getPath('".$el['hash']."')\"> 🔴 ".$movie["title"]." - ".$el["quality"]." </span>";
				echo "<br />";
			}

			?>
		</div>
		<div id="player"></div>
	</div>

	<div class="messages">
		<div class="message-form">
			<input onkeyup="keyUp(event, '<?php echo $_GET['id'] ?>')" type="text" id="new-message" class="message-input" placeholder="<?php echo $lang['movie_placeholder'] ?>" />
			<input onclick="addComment('<?php echo $_GET['id'] ?>');" id="comment-button" type="submit" value="<?php echo $lang['movie_button'] ?>"/>
		</div>
		<div class="messages-list" id="message-list">
			<?php
			$req = $bdd->prepare('SELECT users.login, users.first_name, users.last_name, comments.comment, comments.date FROM comments INNER JOIN users ON comments.id_user = users.id_user WHERE id_movie = ? ORDER BY comments.id_comment DESC');
			$req->execute(array($_GET['id']));
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
</body>
</html>
