async function setVideo(hash)
{
	let stop = 0;
	while (stop == 0)
	{
		await sleep(1000);
		$.ajax(
		{
			url : '/php/getPath.php',
			type : 'POST',
			data : 'hash=' + hash,
			dataType : 'html',
			success : function(code_html, statut)
			{
				if (code_html != "error" && stop == 0)
				{
					let type = "video/mp4";
					let src = "films/" + code_html;
					$('#video').attr('controls', true);
					$('#video').html('<source src="' + src + '" type="' + type + '">');
					stop = 1;
				}
			}
		});
	}
}
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
	setVideo(hash);
}
function sleep(ms)
{
	return new Promise(resolve => setTimeout(resolve, ms));
}
