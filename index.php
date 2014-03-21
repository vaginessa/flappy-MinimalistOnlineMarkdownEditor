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
	</head>
	<body>
		<div id="left-column">
			<div id="top_panels_container">
				<div class="top_panel" id="quick-reference">
					<div class="close">×</div>
						<table>
						<tr>
						<td>
						<pre><code><span class="highlight">*</span>This is italicized<span class="highlight">*</span>, and <span class="highlight">**</span>this is bold<span class="highlight">**</span>.</code></pre>
						</td>
						<td><p>Use <code>*</code> or <code>_</code> for emphasis.</p></td>
						</tr>
						<tr>
						<td>
						<pre><code>This is a first level header
						<span class="highlight">============================</span></code></pre>
						</td>
						<td><p>You can alternatively put hash marks at the beginning of the line: <code>#&nbsp;H1</code>, <code>##&nbsp;H2</code>, <code>###&nbsp;H3</code>...</p></td>
						</tr>
						<tr>
						<td>
						<pre><code>This is a link to <span class="highlight">[Google](http://www.google.com)</span></code></pre>
						</td>
						<td><p></p></td>
						</tr>
						<tr>
						<td>
						<pre><code>First line.<span class="highlight"> </span>
						Second line.</code></pre>
						</td>
						<td><p>End a line with two spaces for a linebreak.</p></td>
						</tr>
						<tr>
						<td>
						<pre><code><span class="highlight">- </span>Unordered list item
						<span class="highlight">- </span>Unordered list item</code></pre>
						</td>
						<td><p>Unordered (bulleted) lists use asterisks, pluses, and hyphens (<code>*</code>, <code>+</code>, and <code>-</code>) as list markers.</p></td>
						</tr>
						<tr>
						<td>
						<pre><code><span class="highlight">1. </span>Ordered list item
						<span class="highlight">2. </span>Ordered list item</code></pre>
						</td>
						<td><p>Ordered (numbered) lists use regular numbers, followed by periods, as list markers.</p></td>
						</tr>
						<tr>
						<td><pre><code><span class="highlight"> </span>/* This is a code block */</code></pre></td>
						<td><p>Indent four spaces for a preformatted block.</p></td>
						</tr>
						<tr>
						<td><pre><code>Let's talk about <span class="highlight">`</span>&lt;html&gt;<span class="highlight">`</span>!</code></pre></td>
						<td><p>Use backticks for inline code.</p></td>
						</tr>
						<tr>
						<td>
						<pre><code><span class="highlight">![Valid XHTML](http://w3.org/Icons/valid-xhtml10)</span></code></pre>
						</td>
						<td><p>Images are exactly like links, but they have an exclamation point in front of them.</p></td>
						</tr>
					</table>
					<p><a href="http://daringfireball.net/projects/markdown/syntax" target="_blank">Full Markdown documentation</a></p>
				</div>
				<div class="top_panel" id="quick-login-area">
					<div class="close">×</div>
					<?php 
					// check for privileges
					if (isset($_COOKIE['username_log'])) {
						$loggedas = $_COOKIE['username_log'];
						echo "Logged as: ".$loggedas."<br />";
						echo '<a href="index.php?logout=1">Logout</a>';
					}else{
						echo "You are here as Guest<br />";
					};
					include(str_replace('\\','\\\\','')."password_protect.php");
					?>
				</div>
				<div class="top_panel" id="quick-listfiles">
					<div class="close">×</div>
					<div id="listfiles">
					<?php
					include "listfiles.php";
					?>
					</div>
				</div>
			</div>
			<div class="wrapper">
				<div class="buttons-container">
					<span id="current-file" class="button toppanel">Current file: 
					<strong><?php echo $_COOKIE['cacheFileName'];?></strong></span>
					<a href="#" class="button toppanel" data-toppanel="quick-login-area">Private</a>
					<a href="#" class="button toppanel" data-toppanel="quick-listfiles">Files</a>
					<a href="#" class="button toppanel" onClick="loadFromFile()">Load</a>
					<a href="#" class="button toppanel" onClick="saveToFile()">Save as...</a>
					<a href="#" class="button toppanel" data-toppanel="quick-reference">Quick reference</a>
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
		<script src="js/functions.js"></script>
	</body>
</html>