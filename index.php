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
include "functions.php";
$file=File_get_contents('/etc/dhcp/dhcpd.conf');
$file2=File_get_contents('dhcp_test.txt');
?>
<body>
<div class="container">
<h3>PHP DHCP</h3>
				<dl class="tabs">
					<dd><a href="#simple1" class="active">Add a Device</a></dd>
					<dd><a href="#simple2">Remove a Device</a></dd>
					<dd><a href="#simple3">All Devices</a></dd>
					<dd><a href="#simple4">Bulk Import</a></dd>
					<dd><a href="#simple5">DHCP File</a></dd>
		
				</dl>

				<ul class="tabs-content">
					<li class="active" id="simple1Tab">
					
					<form name="add" action="build.php" method="post">
					<input type="text" class="input-text" placeholder="Enter Device Name" name="device_name">
					<input type="text" class="input-text" placeholder="Enter Device Mac Address" name="MAC">
					
					Is an IP Required?
					<select id="customDropdown" name="ip">
					<option value="1">Yes</option>
					<option value="0">No</option>
					</select>
					
					<label for="customDropdown">Select a Group</label>
					<select id="customDropdown" name="group">
					<option value="1">Staff Laptop</option>
					<option value="4">4th Grade student</option>
					<option value="5">5th Grade student</option>
					<option value="6">6th Grade student</option>
					<option value="7">7th Grade student</option>
					<option value="8">8th Grade student</option>
					<option value="9">9th Grade student</option>
					<option value="10">10th Grade student</option>
					<option value="11">11th Grade student</option>
					<option value="12">12th Grade student</option>
					<option value="17">HHS Wired Device</option>
					<option value="18">HES Wired Device</option>
					<option value="19">ARS Wired Device</option>
					<option value="20">AMS Wired Device</option>
					<option value="21">HES Wired Device</option>
					<option value="22">SME Wired Device</option>
					<option value="23">TRI Wired Device</option>
					<option value="24">WFE Wired Device</option>
					<option value="25">WRE Wired Device</option>
					<option value="26">BOE Wired Device</option>
					<option value="27">Staff Mobile Device</option>
					</select>
					<br/>
					<input type="Submit" name="add" class="nice green button" value="Enter Address">
					</form>
					</li>
					
					<li id="simple2Tab">
					<form name="remove" action="build.php" method="post">
					<input type="text" class="input-text" placeholder="Enter Device Mac Address" name="MAC">
					<input type="Submit" name="remove" class="nice red button" value="Remove Device">
					</form>
					</li>
					
					<li id="simple3Tab"><?php retrieve_all_devices(); ?>
					</li>
					
					<li id="simple4Tab">
					<?php rebuild_DHCP(); ?>
					</li>
					<li id="simple5Tab"><?php echo'<pre>'.$file.'</pre>'?>
					</li>
				</ul>
</div>

<script src="javascripts/jquery.min.js"></script>
	<script src="javascripts/foundation.js"></script>
	<script src="javascripts/app.js"></script>
	
</body>
</html>