// get time for including in new file
Date.prototype.today = function () 
	{ 
    return ((this.getDate() < 10)?"0":"") + this.getDate() +"/"+(((this.getMonth()+1) < 10)?"0":"") + (this.getMonth()+1) +"/"+ this.getFullYear();
	};

Date.prototype.timeNow = function () 
	{
     return ((this.getHours() < 10)?"0":"") + this.getHours() +":"+ ((this.getMinutes() < 10)?"0":"") + this.getMinutes() +":"+ ((this.getSeconds() < 10)?"0":"") + this.getSeconds();
	};

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
	};

function setCookie(cname,cvalue,exdays)
	{
		var d = new Date();
		d.setTime(d.getTime()+(exdays*24*60*60*1000));
		var expires = "expires="+d.toGMTString();
		document.cookie = cname + "=" + cvalue + "; " + expires;
	};

function setActiveFolder(dir,a_dir)
	{
		setCookie("cacheActiveFilePath",dir,"14");
		setCookie("cacheFilePath",a_dir,"14");
		var el = document.getElementById(dir);
		el.style.display = 'block';
	};

function setCurrentFileName(id)
	{	
		// function to set the current file name in top of the page
		var currentFileNameCookie = getCookie("cacheFileName");
		document.getElementById(id).innerHTML = '<strong>Current file: '+currentFileNameCookie+'</strong>';
	};

function saveFile()
	{
		// check for cached file name if any (from last saving or loading)
		var nameToSaveCookie = getCookie("cacheFileName");
		// ask before saving file
		var confirmMe = confirm("Save "+nameToSaveCookie+"? (will be overwritten)");
		if (confirmMe == true)
		{	
			//get the text from textarea #markdown
		    var textToSave = localStorage.getItem("markdown");
		    // get the right path to the file
		    var pathToSaveCookie = getCookie("cacheFilePath");
		    // create request link
			var data = new FormData();
			data.append("do" , "savefile");
			data.append("data" , textToSave);
			data.append("filename" , nameToSaveCookie);
			data.append("pathtosave" , pathToSaveCookie);
			var xhr = (window.XMLHttpRequest) ? new XMLHttpRequest() : new activeXObject("Microsoft.XMLHTTP");
			// send the request to save.php
			xhr.open( 'post', './core.php', true );
			xhr.send(data);
			// set cookie of current file name for future saving and current file display
			setCookie("cacheFileName",nameToSaveCookie,"14", "/");
			setCookie("cacheFilePath",pathToSaveCookie,"14", "/");
			// input the current file name value
			setCurrentFileName("current-file");
			// Reload list of files
			listFolderFiles(pathToSaveCookie);
		}
	};

function newFile()
	{
		// ask before saving file		
		var nameToSave = prompt("Please input file name,\n(will be overwritten if exist)\nNo need to type file extention.",'');
		// continue if we get any filename
		if (nameToSave!=null)
		{
			//get the text from textarea #markdown
			var filename = './saved/default/new_file.md';
			var pathToSaveCookie = getCookie("cacheFilePath");
			// set the default file template and insert its content to #markdown texarea
		    $.get(filename, null, function(response){
		    	var textToSave = response;
			    // send data to save.php and get result
				var data = new FormData();
				data.append("do" , "savefile");
				data.append("data" , textToSave);
				data.append("filename" , nameToSave);
				data.append("pathtosave" , pathToSaveCookie);
				var xhr = (window.XMLHttpRequest) ? new XMLHttpRequest() : new activeXObject("Microsoft.XMLHTTP");
				// send the request to save.php
				xhr.open( 'post', './core.php', true );
				xhr.send(data);
				// pass new data to textarea
				$("#markdown").val(response);
				// set cookie of current file name and pathfor future saving and current file display
				setCookie("cacheFileName",nameToSave,"14", "/");
				setCookie("cacheFilePath",pathToSaveCookie,"14", "/");
				// input the current file name value in the top of page
				setCurrentFileName("current-file");
				// Reload list of files
				listFolderFiles(pathToSaveCookie);
			});
		}
	};

function loadFile(fileToLoad,pathToFile)
	{	
		// ask before opennig file
		var fileToLoad = prompt("Open file?\nNo need to type file extention.\n(unsaved text will be lost)",fileToLoad);
		// continue if we get any filename
		if (fileToLoad!=null)
		{	
		    var filename = pathToFile+'/'+fileToLoad+'.md';
			// read the file and insert its content to #markdown texarea
		    $.get(filename, null, function(response){
				 $("#markdown").val(response);
			});
		    // set cookie of current file name and pathfor future saving and current file display
			setCookie("cacheFileName",fileToLoad,"14", "/");
			setCookie("cacheFilePath",pathToFile,"14", "/");
			// input the current file name value in the top of page
			setCurrentFileName("current-file");
		}
	};

function deleteFile(fileToDelete,pathToFile)
	{	
		// ask before deleting
		var confirmMe = confirm("Delete this file?\n"+fileToDelete+"\nCan't be undone.");
		// wait for confirmation of deleting choosen file
		if (confirmMe == true)
		{	
			// create request link
			var data = new FormData();
			data.append("do" , "deletefile");
			data.append("filename" , fileToDelete);
			data.append("pathToFile" , pathToFile);
			var xhr = (window.XMLHttpRequest) ? new XMLHttpRequest() : new activeXObject("Microsoft.XMLHTTP");
			// send the request to delete.php
			xhr.open( 'post', './core.php', true );
			xhr.send(data);
			// Reload list of files after deleting
			listFolderFiles(pathToFile);
		}
	};

function newFolder()
	{
		//get the text from textarea #markdown
		var pathToSaveCookie = getCookie("cacheFilePath");
		// ask before saving file		
		var folderName = prompt("Please input folder name,\nyou are creating folder in: \""+pathToSaveCookie+"/\" .",'');
		// continue if we get any filename
		if (folderName!=null)
		{
		    // send data to save.php and get result
			var data = new FormData();
			data.append("do" , "createdir");
			data.append("folderpath" , pathToSaveCookie+"/"+folderName);
			var xhr = (window.XMLHttpRequest) ? new XMLHttpRequest() : new activeXObject("Microsoft.XMLHTTP");
			// send the request to save.php
			xhr.open( 'post', './core.php', true );
			xhr.send(data);
			// pass new data to textarea
			// set cookie of current file name and pathfor future saving and current file display
			setCookie("cacheFilePath",pathToSaveCookie+"/"+folderName,"14", "/");
			// Reload list of files
			listFolderFiles(pathToSaveCookie)
		};
	};

function deleteFolder(folderToDelete)
	{
		var confirmMe = confirm("Delete this folder with all in it?\n"+folderToDelete+"\nCan't be undone.");
		// continue if we get any filename
		if (confirmMe == true)
		{
		    // send data to save.php and get result
			var data = new FormData();
			data.append("do" , "deletedir");
			data.append("dirpath" , folderToDelete);
			var xhr = (window.XMLHttpRequest) ? new XMLHttpRequest() : new activeXObject("Microsoft.XMLHTTP");
			// send the request to save.php
			xhr.open( 'post', './core.php', true );
			xhr.send(data);
			// Reload list of files
			listFolderFiles(pathToSaveCookie)
		};
	};	

function listFolderFiles(newDir)
	{
		// check for cached file name if any (from last saving or loading)
		// var pathToListFiles = getCookie("cacheFilePath");
	    // create request link
		var data = new FormData();
		data.append("do" , "listfiles");
		data.append("newdir" , newDir);
		var xhr = (window.XMLHttpRequest) ? new XMLHttpRequest() : new activeXObject("Microsoft.XMLHTTP");
		
		xhr.onreadystatechange = function() {
		    if (xhr.readyState == 4) {
		        $('#listfiles').html(xhr.responseText);
		    }
		}
		
		// send the request to save.php
		xhr.open( 'post', './core.php', true );
		xhr.send(data);
		// set cookie of current file name for future saving and current file display
		setCookie("cacheFilePath",newDir,"14", "/");
		// Reload list of files (just in case we're saving new file)
	};