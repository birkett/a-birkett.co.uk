// Make a collapsable list from LI and UL elements
var spans = document.getElementsByTagName('span');
for(var i = 0; i < spans.length; i++){
	spans[i].onclick=function(){
		if(this.parentNode){
			var childList = this.parentNode.getElementsByTagName('UL');
			for(var j = 0; j< childList.length;j++){
				var currentState = childList[j].style.display;
				if(currentState=="none"){
					childList[j].style.display="block";
				}else{
					childList[j].style.display="none";
				}
			}
		}
		return false; //prevent redirect on click
	}
	spans[i].onclick();
}


function toggleposts()
{
	var h2 = document.getElementById("allposts");
	(h2.style.display == "none" || h2.style.display == "") ? h2.style.display = "block" : h2.style.display = "none";
}