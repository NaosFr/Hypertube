function setVideo(hash)
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
				$("#alert_div").css('background-color', '#c13c54');
				$("#alert_div").css('display', 'block');
				$("#text_alert").html('Error getting torrent, please try again later');
			}
			else
			{
				let type = "video/mp4";
				let src = "films/" + code_html;
				$('#video').attr('controls', true);
				$('#video').html('<source src="' + src + '" type="' + type + '">');
				$('#video').attr('autoplay', true);
			}
		}
	});
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
				$('#video').attr('autoplay', true);
			}
		}
	});
}
async function getTorrent(hash)
{
	$.ajax(
	{
		url : '/php/startTorrent.php',
		type : 'POST',
		data : 'hash=' + hash,
		dataType : 'html'
	});
	$("#alert_div").css('background-color', '#568456');
	$("#alert_div").css('display', 'block');
	$("#text_alert").html('Downloading... Please wait 30 seconds');
	await sleep(30000);
	setVideo(hash);
}
function sleep(ms)
{
	return new Promise(resolve => setTimeout(resolve, ms));
}
