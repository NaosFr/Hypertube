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
	function remove($el)
	{
		return ($el[3]);
	}
	if (check_get('title'))
	{
		$opts = array(
			'http' => array(
			'method' => "GET",
			'header' => "Accept-language: en\r\n"."Cookie: foo=bar\r\n"
			)
		);
		$context = stream_context_create($opts);
		$title = htmlspecialchars($_GET['title']);
		$title = preg_replace("/ +/", "%20", $title);
		$content = file_get_contents('http://www.imdb.com/find?q='.$title.'&s=tt&ttype=ft&ref_=fn_tt_pop', false, $context);
		preg_match_all("/(<td class=\"result_text\">)(.*?)(<\/td>)/si", $content, $titles);
		preg_match_all("/(<td class=\"primary_photo\">)(.*?)(src=\")(.*?)(\")(.*?)(<\/td>)/si", $content, $photos);
		$src = $photos[4];
		$title = $titles[0];
		foreach ($src as $key => $el)
			$src[$key] = preg_replace_callback("/(.*?)(@)(.*?)(.)(.*?)/si", "remove", $el);
		foreach ($title as $key => $el)
			echo $el."<br />";
	}
	?>
</body>
</html>