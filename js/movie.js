function getPath(hash)
{
	$.ajax(
	{
		url : '/php/getPath.php',
		type : 'POST',
		data : 'hash=' + hash,
		dataType : 'html',
		success : function(code_html, statut)
		{
			if (code_html == "error")
			{
				getTorrent(hash);
				return ;
			}
			else
			{
				let type = "video/mp4";
				let src = "films/" + code_html;
				$('#video').attr('controls', true);
				$('#video').html('<source src="' + src + '" type="' + type + '">');
			}
		}
	});
}
function getTorrent(hash)
{
	$.ajax(
	{
		url : '/php/startTorrent.php',
		type : 'POST',
		data : 'hash=' + hash,
		dataType : 'html'
	});
	getPath(hash);
}
