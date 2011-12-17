function CheckTitle(title){
    	divTitle = document.getElementById('checked_title');

		if (window.XMLHttpRequest){// code for IE7+, Firefox, Chrome, Opera, Safari
 		  xmlhttp=new XMLHttpRequest();
		}
 		else{// code for IE6, IE5
   			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
   		}
 		
		xmlhttp.open("GET","checktitles?q="+title,true);
		xmlhttp.onreadystatechange=function(){
			if (xmlhttp.readyState==4 && xmlhttp.status==200){		
				divTitle.innerHTML=xmlhttp.responseText;
				}
		}

 		xmlhttp.send();		
}

function CheckContent(text){
    	divText = document.getElementById('checked_content');
		if (window.XMLHttpRequest){// code for IE7+, Firefox, Chrome, Opera, Safari
 		  xmlhttp=new XMLHttpRequest();
		}
 		else{// code for IE6, IE5
   			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
   		}
 		
		xmlhttp.open("GET","checkcontents?q="+text,true);
		xmlhttp.onreadystatechange=function(){
			if (xmlhttp.readyState==4 && xmlhttp.status==200){
		//		alert(xmlhttp.responseText);
				divText.innerHTML=xmlhttp.responseText;
				}
		}
		
 		xmlhttp.send();		
}

function CheckTag(){
    	divTag = document.getElementById('checked_tags');
		var tags="";
		if (window.XMLHttpRequest){// code for IE7+, Firefox, Chrome, Opera, Safari
 		  xmlhttp=new XMLHttpRequest();
		}
 		else{// code for IE6, IE5
   			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
   		}
 		
		xmlhttp.open("GET","checktexts?q="+tags,true);
		xmlhttp.onreadystatechange=function(){
			if (xmlhttp.readyState==4 && xmlhttp.status==200){
		//		alert(xmlhttp.responseText);
				divTag.innerHTML=xmlhttp.responseText;
				}
		}
		
 		xmlhttp.send();		
}

function CheckFile(filename){
    	divFile = document.getElementById('checked_file');
		if (window.XMLHttpRequest){// code for IE7+, Firefox, Chrome, Opera, Safari
 		  xmlhttp=new XMLHttpRequest();
		}
 		else{// code for IE6, IE5
   			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
   		}
 		
		xmlhttp.open("GET","checktexts?q="+filename,true);
		xmlhttp.onreadystatechange=function(){
			if (xmlhttp.readyState==4 && xmlhttp.status==200){
				divFile.innerHTML=xmlhttp.responseText;
				}
		}
		
 		xmlhttp.send();		
}