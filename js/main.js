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


var bol = 1;
	$("#cross").click(function(){
    	if (bol == 1) {
    		$('.navbar_filter').show();
    		bol = 0;
    	}
    	else{
    		$('.navbar_filter').hide();
    		bol = 1;
    	}	
	});
