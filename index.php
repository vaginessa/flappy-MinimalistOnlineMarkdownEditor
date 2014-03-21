<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
		<title>Minimalist Online Markdown Editor</title>
		<meta name="description" content="This is the simplest and slickest online Markdown editor. Just write Markdown and see what it looks like as you type. And convert it to HTML in one click."/>
		<link rel="shortcut icon" href="favicon.ico" type="image/x-icon"/>
		<meta property="og:image" content="http://markdown.pioul.fr/images/markdown.png"/>
		<link rel="stylesheet" href="css/main.css" type="text/css">
		<link rel="stylesheet" href="css/ionicons.css" type="text/css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
		<script src="js/main.js"></script>
		<script src="js/showdown.js"></script>
	</head>
	<body>
		<div id="left-column">
			<div id="top_panels_container">
				<div class="top_panel" id="quick-reference">
					<div class="close">×</div>
					<?php
					include "listfiles.php";
					?>
				</div>
			</div>
			<div class="wrapper">
				<div class="buttons-container">
					<a href="#" class="button toppanel" data-toppanel="quick-reference">Files</a>
					<a href="#" onClick="loadFromFile()" class="button toppanel">Load</a>
					<a href="#" onClick="saveToFile()" class="button toppanel">Save</a>
					<a href="#" class="button icon-arrow-expand feature" data-feature="fullscreen" data-tofocus="markdown" title="Go fullscreen"></a>
					<div class="clear"></div>
				</div>
				<textarea id="markdown" class="full-height" placeholder="Write Markdown">Clear plate, clear mind... ;)</textarea>
			</div>
		</div>
		<div id="right-column">
			<div class="wrapper">
				<div class="buttons-container">
					<div class="button-group">
						<a href="#" class="button switch" data-switchto="html">HTML</a>
						<a href="#" class="button switch" data-switchto="preview">Preview</a>
					</div>
					<a href="#" class="button icon-arrow-down-a feature" data-feature="auto-scroll" title="Toggle auto-scrolling to the bottom of the preview panel"></a>
					<a href="#" class="button icon-arrow-expand feature" data-feature="fullscreen" data-tofocus="" title="Go fullscreen"></a><!-- data-tofocus is set dynamically by the HTML/preview switch -->
					<div class="clear"></div>
				</div>
				<textarea id="html" class="full-height"></textarea>
				<div id="preview" class="full-height"></div>
			</div>
		</div>
		<div class="clear"></div>
		<div class="buttons-container fullscreen">
			<div class="button-group">
				<a href="#" class="button switch" data-switchto="markdown">Markdown</a>
				<a href="#" class="button switch" data-switchto="html">HTML</a>
				<a href="#" class="button switch" data-switchto="preview">Preview</a>
			</div>
			<a href="#" class="button icon-arrow-expand feature" data-feature="fullscreen" title="Exit fullscreen"></a>
			<div class="clear"></div>
		</div>
		<script type="text/javascript">
		function saveToFile()
			{
				var nameToSave = prompt("Name of the file w/o .md","mome-");

				if (nameToSave!=null)
				{
					  /*x = "Hello " + person + "! How are you today?";
					  document.getElementById("demo").innerHTML=x;*/
					
					//var textToSave = document.getElementById('markdown').innerHTML; 
				    var textToSave = localStorage.getItem("markdown");
					var data = new FormData();
					data.append("data" , textToSave);
					data.append("name" , nameToSave);
					var xhr = (window.XMLHttpRequest) ? new XMLHttpRequest() : new activeXObject("Microsoft.XMLHTTP");
					xhr.open( 'post', './save.php', true );
					xhr.send(data);
					//alert("Saved to "+nameToSave+".md");
				}
			}
		function loadFromFile(fileToLoad)
			{
				var fileToLoad = prompt("Open file w/o .md",fileToLoad);
				if (fileToLoad!=null)
				{
				    var filename = './saved/'+fileToLoad+'.md';
				    $.get(filename, null, function(response){
	   				 $("#markdown").val(response);
					});
					//alert("Loaded from "+fileToLoad+".md");	
				}
			}
		</script>
	</body>
</html>