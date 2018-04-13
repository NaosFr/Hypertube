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
				let iframe = '<iframe id="iframe" name="iframe" src="php/player.php?hash=' + hash + '"></iframe>'
				$('#player').html(iframe);
			}
		}
	});
}

function views(hash, id_movie)
{

	var formData = {
		'hash'		: hash,
		'id_movie'	: id_movie
	};

	$.ajax({
	   	type        : 'POST',
	   	url         : 'php/views.php',
	   	data        : formData,
	   	encode      : true,
	   	success		: function(data){

	   	}
	})
}


function getPath(hash, id_movie)
{
	views(hash, id_movie);

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
				getTorrent(hash, id_movie);
			}
			else
			{
				let iframe = '<iframe id="iframe" name="iframe" src="php/player.php?hash=' + hash + '"></iframe>'
				$('#player').html(iframe);
			}
		}
	});
}
async function getTorrent(hash, id_movie)
{
	$.ajax(
	{
		url : '/php/startTorrent.php',
		type : 'POST',
		data : 'hash=' + hash + '&imdb=' + id_movie,
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
