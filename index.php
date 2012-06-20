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

	<title>PHP DHCP</title>
  
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
<?php

include "classes/class.database.php";
$databee = new database();
$file=File_get_contents('/etc/dhcp/dhcpd.conf');
$file2=File_get_contents('dhcp_test.txt');
?>
<body>
<div class="container">
<h3>PHP DHCP</h3>
				<dl class="tabs">
					<dd><a href="#simple1" class="active">Edit Form</a></dd>
					<dd><a href="#simple2">DHCP File</a></dd>
					<dd><a href="#simple3">Devices</a></dd>
				</dl>

				<ul class="tabs-content">
					<li class="active" id="simple1Tab">
					<form>
					<input type="text" class="input-text" placeholder="Inline label">
					</form>
					<?php 

					?></li>
					<li id="simple2Tab"><?php echo'<pre>'.$file2.'</pre>'?>
					</li>
					<li id="simple3Tab">Device list here</li>
				</ul>
</div>

<script src="javascripts/jquery.min.js"></script>
	<script src="javascripts/foundation.js"></script>
	<script src="javascripts/app.js"></script>
	
</body>
</html>