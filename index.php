<!DOCTYPE html>

<!-- paulirish.com/2008/conditional-stylesheets-vs-css-hacks-answer-neither/ -->
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<head>
	<meta charset="utf-8" />

	<!-- Set the viewport width to device width for mobile -->
	<meta name="viewport" content="width=device-width" />

	<title>Welcome to Foundation</title>
  
	<!-- Included CSS Files -->
	<link rel="stylesheet" href="stylesheets/foundation.css">
	<link rel="stylesheet" href="stylesheets/app.css">

	<!--[if lt IE 9]>
		<link rel="stylesheet" href="stylesheets/ie.css">
	<![endif]-->
	
	<script src="javascripts/modernizr.foundation.js"></script>

	<!-- IE Fix for HTML5 Tags -->
	<!--[if lt IE 9]>
		<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->

</head>
<body>
<div class="container">
<h3>Tabs</h3>
				<dl class="tabs">
					<dd><a href="#simple1" class="active">Simple Tab 1</a></dd>
					<dd><a href="#simple2">Simple Tab 2</a></dd>
					<dd><a href="#simple3">Simple Tab 3</a></dd>
				</dl>

				<ul class="tabs-content">
					<li class="active" id="simple1Tab">This is simple tab 1's content. Pretty neat, huh?</li>
					<li id="simple2Tab">This is simple tab 2's content. Now you see it!</li>
					<li id="simple3Tab">This is simple tab 3's content. It's, you know...okay.</li>
				</ul>
</div>