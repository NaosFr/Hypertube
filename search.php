<?php include_once('php/connexion.php'); ?>
<!DOCTYPE html>
<html lang="<?php echo $lang['html'] ?>">
<head>
	<?php include_once('meta.php'); ?>
</head>
<body>
	<form action="/search.php" action="get">
		<input type="text" name="title">
		<input type="submit">
	</form>
	<?php
	if (check_get('title'))
	{
		$title = urlencode($_GET['title']);
		$content = json_decode(file_get_contents('https://yts.am/api/v2/list_movies.json?sort_by=title&order_by=asc&query_term='.$title), true);
		if ($content["data"]["movie_count"] > 0)
		{
			foreach ($content["data"]["movies"] as $el)
			{
				?>
				<a href="/movie?id=<?php echo $el['imdb_code'] ?>">
					<img src="<?php echo $el["large_cover_image"] ?>" />
					<?php echo $el["year"] ?>
					<?php echo $el["rating"] ?>
				</a>
				<?php
			}
		}
		else
			echo "No result !";
	}
	?>
</body>
</html>