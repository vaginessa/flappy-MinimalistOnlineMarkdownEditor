<?php
include "./core.php";
?>
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
		<link rel="stylesheet" href="css/restyle.css" type="text/css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
		<script src="js/main.js"></script>
		<script src="js/showdown.js"></script>
		<script src="js/functions.js"></script>
		<script>
		function activeFolder(id){
			$( id ).toggle( "slow" );
		}
		</script>
	</head>
	<body>
		<div id="left-column">
			<div id="top_panels_container">
				<div class="top_panel" id="quick-listfiles">
					<div class="close">×</div>
					<?php 
					// check for privileges
					checkLogin();
					?>
					<br />
					<script type="text/javascript">
					var pathToFile = getCookie("cacheFilePath");
					document.getElementById('current-folder').innerHTML=pathToFile;
					</script>
					<div id="current-folder">
					</div>
					<div id="listfiles">
					<script type="text/javascript">
					var pathToFile = getCookie("cacheFilePath");
					listFolderFiles(pathToFile);
					</script>
					</div>
				</div>
			</div>
			<div class="wrapper">
				<div class="buttons-container">
					<span id="success"></span>
					<span id="current-file" class="button toppanel">Current file: 
					<strong><?php if (isset($_COOKIE['cacheFileName'])){echo $_COOKIE['cacheFileName'];};?></strong></span>
					<a href="#" class="button toppanel" data-toppanel="quick-listfiles">List Files / Login</a>
					<a href="#" class="button toppanel" onClick="newFile()">New</a>
					<a href="#" class="button toppanel" onClick="newFolder()">New Folder</a>
					<a href="#" class="button toppanel" onClick="saveFile()">Save</a>
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
	</body>
</html>