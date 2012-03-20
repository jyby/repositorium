function CheckTitle(title){
    	//divTitle = document.getElementById('checked_title');

		if (window.XMLHttpRequest){// code for IE7+, Firefox, Chrome, Opera, Safari
 		  xmlhttp=new XMLHttpRequest();
		}
 		else{// code for IE6, IE5
   			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
   		}
		xmlhttp.onreadystatechange=function(){
			if (xmlhttp.readyState==4 && xmlhttp.status==200){		
				document.getElementById('checked_title').innerHTML = "<pre>"+xmlhttp.responseText+"</pre>";
				//divTitle.innerHTML=xmlhttp.responseText;
				}
		}
		xmlhttp.open("GET","checktitles/check_title?q="+title,true);
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

function CheckTag(tag){
		//document.write('<b>Hello World</b>');
    	divTag = document.getElementById('checked_tags');
		var tags="";
		if (window.XMLHttpRequest){// code for IE7+, Firefox, Chrome, Opera, Safari
 		  xmlhttp=new XMLHttpRequest();
		}
 		else{// code for IE6, IE5
   			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
   		}
 		
		xmlhttp.open("GET","checktags/check_tag?q="+tag,true);
		xmlhttp.onreadystatechange=function(){
			if (xmlhttp.readyState==4 && xmlhttp.status==200){
		//		alert(xmlhttp.responseText);
				divTag.innerHTML=xmlhttp.responseText;
				}
		}
		
 		xmlhttp.send();		
}

function CheckFile(filename){
    	divFile = document.getElementById('checked_attachFile');
		if (window.XMLHttpRequest){// code for IE7+, Firefox, Chrome, Opera, Safari
 		  xmlhttp=new XMLHttpRequest();
		}
 		else{// code for IE6, IE5
   			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
   		}
 		
		xmlhttp.open("GET","checkfiles/check_file?q="+filename,true);
		xmlhttp.onreadystatechange=function(){
			if (xmlhttp.readyState==4 && xmlhttp.status==200){
				divFile.innerHTML=xmlhttp.responseText;
				}
		}
		
 		xmlhttp.send();		
}