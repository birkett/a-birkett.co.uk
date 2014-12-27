//Post a new comment via AJAX
function postcomment()
{
	if (window.XMLHttpRequest) { xmlhttp=new XMLHttpRequest(); }
	else { xmlhttp=new ActiveXObject("Microsoft.XMLHTTP"); }
	xmlhttp.onreadystatechange=function()
	{
		if (xmlhttp.readyState==4)
		{
			switch(xmlhttp.status)
			{
			case 200:
				document.getElementById("response").innerHTML='<p class="success">Comment posted!</p>';
				document.getElementById("formusername").value="";
				document.getElementById("formcomment").value="";
				break;
			default:
				document.getElementById("response").innerHTML='<p class="failed">'+xmlhttp.response+'</p>';
			}
		}
	}
	xmlhttp.open("POST","actions.php",true);
	var p = document.getElementById("formpostid").value;
	var u = document.getElementById("formusername").value;
	var c = document.getElementById("formcomment").value;
	xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	xmlhttp.send("mode=postcomment&postid="+p+"&username="+u+"&comment="+c+"&challenge="+Recaptcha.get_challenge()+"&response="+Recaptcha.get_response());
	Recaptcha.reload();
}