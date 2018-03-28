<?php
include_once('connexion.php');

if ($_POST['submit'] === "search")
{
	if (isset($_POST['movie']) && $_POST['movie'] != "")
	{
		$title = htmlspecialchars($_POST['movie']);
		$title = urlencode($title);
		$content = json_decode(file_get_contents('https://yts.am/api/v2/list_movies.json?sort_by=title&order_by=asc&query_term='.$title), true);
		if ($content["data"]["movie_count"] > 0)
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
}

?>