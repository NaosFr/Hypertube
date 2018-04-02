function del_alert(){
	var element = document.getElementById("alert_div");
	element.parentNode.removeChild(element);
}
function setLanguage(lang)
{
	if (lang)
	{
		$.ajax(
		{
			url : '/php/setLanguage.php',
			type : 'POST',
			data : 'lang=' + lang,
			dataType : 'html',
			success : function(code_html, statut)
			{
				if (code_html == "error")
					return ;
				location.reload();
			}
		});
	}
}
