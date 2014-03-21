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
		var currentFileNameCookie = getCookie("cacheFileName");
		document.getElementById(id).innerHTML = '<strong>Current file: '+currentFileNameCookie+'</strong>';
	}

function saveToFile()
	{
		var nameToSaveCookie = getCookie("cacheFileName");
		var nameToSave = prompt("Save file w/o .md? (will be overwritten)",nameToSaveCookie);
		
		if (nameToSave!=null)
		{	
			var getMyCookie = getCookie("username_log");
			if (typeof getMyCookie != 'undefined') {
		    	var subFolder = getMyCookie;
			}else{
				var subFolder = '';
			}
		    var textToSave = localStorage.getItem("markdown");
			var data = new FormData();
			data.append("data" , textToSave);
			data.append("name" , nameToSave);
			data.append("subFolder" , subFolder);
			var xhr = (window.XMLHttpRequest) ? new XMLHttpRequest() : new activeXObject("Microsoft.XMLHTTP");
			xhr.open( 'post', './save.php', true );
			xhr.send(data);
			// alert with the paths, just for control
			alert ('File '+nameToSave+' was saved 666 to: ./save/'+subFolder+nameToSave);
			setCookie("cacheFileName",nameToSave,"14");
			// input the current file name value
			setCurrentFileName("current-file");
			// Reload list of files
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
		var fileToLoad = prompt("Open file w/o .md?",fileToLoad);

		if (fileToLoad!=null)
		{	
			var fileToLoad = fileToLoad.replace('admin/','');

			var getMyCookie = getCookie("username_log");
				if (typeof getMyCookie != 'undefined') {
		    	var filename = './saved/'+getMyCookie+'/'+fileToLoad+'.md';
			}else{
				var filename = './saved/'+fileToLoad+'.md';
			}
			// alert with the paths, just for control
			// alert ('File '+fileToLoad+' was loaded from:<br />'+filename);
		    $.get(filename, null, function(response){
				 $("#markdown").val(response);
			});
		    // set cookie of current file name for future saving
			setCookie("cacheFileName",fileToLoad,"14")
			// input the current file name value
			setCurrentFileName("current-file");
		}
	}
function deleteFile(fileToDelete,subFolder)
	{	
		var fileToDelete = prompt("Delete file w/o .md?",fileToDelete);

		if (fileToDelete!=null)
		{	
			var fileToDelete = fileToDelete.replace('admin/','');

			var getMyCookie = getCookie("username_log");
				if (typeof getMyCookie != 'undefined') {
		    	var filename = './saved/'+getMyCookie+'/'+fileToDelete+'.md';
			}else{
				var filename = './saved/'+fileToDelete+'.md';
			}
			var data = new FormData();
			data.append("name" , fileToDelete);
			data.append("subFolder" , subFolder);
			var xhr = (window.XMLHttpRequest) ? new XMLHttpRequest() : new activeXObject("Microsoft.XMLHTTP");
			xhr.open( 'post', './delete.php', true );
			xhr.send(data);
			// alert with the paths, just for control
			// alert ('File '+fileToLoad+' was loaded from:<br />'+filename);
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