function AJAXOpen(target, data, SuccessCallBack)
{
    if (window.XMLHttpRequest) {
        xmlhttp = new XMLHttpRequest();
    } else {
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }

    xmlhttp.onreadystatechange = function() {
        if (xmlhttp.readyState === 4) {
            switch(xmlhttp.status) {
                case 200:
                    document.getElementById("response").innerHTML = '<p class="success">' + xmlhttp.responseText + '</p>';
                    SuccessCallBack();
                    break;

                case 205:
                    location.reload();
                    break;

                default:
                    document.getElementById("response").innerHTML = '<p class="failed">' + xmlhttp.responseText + '</p>';
                    break;
            }
        }
    }
    xmlhttp.open("POST", target, true);
    xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
    xmlhttp.send(data);

}
