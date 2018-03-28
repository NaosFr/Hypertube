<?php
include_once('connexion.php');

if (!isset($_POST['submit']) || !isset($_POST['movie']) || !isset($_POST['genre']) || !isset($_POST['page']))
	exit;

if ($_POST['submit'] === "search")
{
	$title = htmlspecialchars($_POST['movie']);
	$title = urlencode($title);
	$genre = htmlspecialchars($_POST['genre']);
	$genre = urlencode($genre);
	$page = htmlspecialchars($_POST['page']);
	$page = urlencode($page);
	$url = 'https://yts.am/api/v2/list_movies.json?limit=50';
	$url .= '&page='.$page;
	if (!empty($title))
		$url .= '&sort_by=title&order_by=asc&query_term='.$title;
	else
		$url .= '&sort_by=rating&order_by=desc';
	if (!empty($genre))
		$url .= '&genre='.$genre;
	$content = json_decode(file_get_contents($url), true);
	if ($content["data"]["movie_count"] > 0 && $content["data"]["movies"])
	{
		foreach ($content["data"]["movies"] as $el)
		{
			echo '<a href="/movie.php?id='.$el['imdb_code'].'"><div>
					<img src="'.$el["large_cover_image"].'" />
					<div class="info_movie transition">
						<p>'.$el["year"].'</p>
						<p>'.$el["rating"].'</p>
					</div>
				</div></a>';
		}
	}
	else
		echo '<p class="no_result">'.$lang['search_empty'].'</p>';
}

?>