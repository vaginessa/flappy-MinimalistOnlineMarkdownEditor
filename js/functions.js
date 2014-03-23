function getCookie(c_name)
	{
	    var i,x,y,ARRcookies=document.cookie.split(";");
	    for (i=0;i<ARRcookies.length;i++)
	    {
	        x=ARRcookies[i].substr(0,ARRcookies[i].indexOf("="));
	        y=ARRcookies[i].substr(ARRcookies[i].indexOf("=")+1);
	        x=x.replace(/^\s+|\s+$/g,"");
	        if (x==c_name)
	        {
	            return unescape(y);
	        }
	     }
	}

function setCookie(cname,cvalue,exdays)
	{
		var d = new Date();
		d.setTime(d.getTime()+(exdays*24*60*60*1000));
		var expires = "expires="+d.toGMTString();
		document.cookie = cname + "=" + cvalue + "; " + expires;
	}

function setCurrentFileName(id)
	{	
		// function to set the current file name in top of the page
		var currentFileNameCookie = getCookie("cacheFileName");
		document.getElementById(id).innerHTML = '<strong>Current file: '+currentFileNameCookie+'</strong>';
	}

function saveToFile()
	{
		// check for cached file name if any (from last saving or loading)
		var nameToSaveCookie = getCookie("cacheFileName");
		// ask before saving file
		var nameToSave = prompt("Save file? (will be overwritten)\nNo need to type file extention.",nameToSaveCookie);
		// continue if we get any filename
		if (nameToSave!=null)
		{	
			// check if logged in and if yes -> send the user name to save.php 
			var getMyCookie = getCookie("username_log");
			if (typeof getMyCookie != 'undefined') {
		    	var subFolder = getMyCookie;
			}else{
				var subFolder = '';
			}
			//get the text from textarea #markdown
		    var textToSave = localStorage.getItem("markdown");
		    // create request link
			var data = new FormData();
			data.append("data" , textToSave);
			data.append("name" , nameToSave);
			data.append("subFolder" , subFolder);
			var xhr = (window.XMLHttpRequest) ? new XMLHttpRequest() : new activeXObject("Microsoft.XMLHTTP");
			// send the request to save.php
			xhr.open( 'post', './save.php', true );
			xhr.send(data);
			// alert with the paths, just for control
			alert ('File '+nameToSave+' was saved to:\n./saved/'+subFolder+'/'+nameToSave);
			// set cookie of current file name for future saving and current file display
			setCookie("cacheFileName",nameToSave,"14");
			// input the current file name value
			setCurrentFileName("current-file");
			// Reload list of files (just in case we're saving new file)
		    $.ajax({
		    	url:'listfiles.php',
		    	complete: function (response) {
		        $('#listfiles').html(response.responseText);
		    },
		    	error: function () {
		        $('#listfiles').html('Bummer: there was an error!');
		      	},
		  	});
		}
	}

function loadFromFile(fileToLoad)
	{	
		// ask before opennig file
		var fileToLoad = prompt("Open file?\nNo need to type file extention.\n(unsaved text will be lost)",fileToLoad);
		// continue if we get any filename
		if (fileToLoad!=null)
		{	
			// since we're not using admin folder this is'nt needed
			// var fileToLoad = fileToLoad.replace('admin/','');
			// check if logged in
			var getMyCookie = getCookie("username_log");
			if (typeof getMyCookie != 'undefined') {
		    	var filename = './saved/'+getMyCookie+'/'+fileToLoad+'.md';
			}else{
				var filename = './saved/'+fileToLoad+'.md';
			}
			// alert with the paths, just for control
			// alert ('File '+fileToLoad+' was loaded from:\n'+filename);
			// read the file and insert its content to #markdown texarea
		    $.get(filename, null, function(response){
				 $("#markdown").val(response);
			});
		    // set cookie of current file name for future saving and current file display
			setCookie("cacheFileName",fileToLoad,"14")
			// input the current file name value in the top of page
			setCurrentFileName("current-file");
		}
	}
function deleteFile(fileToDelete,subFolder)
	{	
		// ask before deleting
		var fileToDelete = prompt("Delete this file?\nNo need to type file extention.",fileToDelete);
		// wait for confirmation of deleting choosen file
		if (fileToDelete!=null)
		{	
			// since we're not using admin folder this is'nt needed
			// var fileToDelete = fileToDelete.replace('admin/','');
			// check if logged in
			var getMyCookie = getCookie("username_log");
				if (typeof getMyCookie != 'undefined') {
		    	var filename = './saved/'+getMyCookie+'/'+fileToDelete+'.md';
			}else{
				var filename = './saved/'+fileToDelete+'.md';
			}
			// create request link
			var data = new FormData();
			data.append("name" , fileToDelete);
			data.append("subFolder" , subFolder);
			var xhr = (window.XMLHttpRequest) ? new XMLHttpRequest() : new activeXObject("Microsoft.XMLHTTP");
			// send the request to delete.php
			xhr.open( 'post', './delete.php', true );
			xhr.send(data);
			// alert with the paths, just for control
			alert ('File '+fileToDelete+' was deleted from:\n'+filename);
			// Reload list of files after deleting
		    $.ajax({
		    	url:'listfiles.php',
		    	complete: function (response) {
		        $('#listfiles').html(response.responseText);
		    },
		    	error: function () {
		        $('#listfiles').html('Bummer: there was an error!');
		      	},
		  	});
		}
	}