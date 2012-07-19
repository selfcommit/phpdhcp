<?php
include "functions.php";
if (isset($_GET['device_info'])) {
//print "device info called";
$deviceID=$_GET['device_info'];
 retrieve_one_device($deviceID);
 Nav_menu();
}
 if (isset($_POST['add'])) {
	//Define posted variables
	$MAC = $_POST["MAC"]; //Mac Address supplied by the user entering the device
	$group = $_POST["group"]; //What IP group does the device belong in?
	$device_name = $_POST["device_name"]; //Device name for device table
		if (isset($_POST["ip"])) {
		$ip_required = $_POST["ip"]; //Does the device require a mac address?
		}
		add_device($MAC,$device_name,$group,$ip_required);
		Nav_menu();
 }
 
 if (isset($_POST['remove'])) {
	$MAC = $_POST["MAC"]; 
	remove_device($MAC);
	Nav_menu();
 }

 if (isset($_POST['bulk'])) 	{
	if($_POST['csv']==0)
	$CSV = explode(",",$_POST['upload']);
	else{
	print "Loading local CSV...";
	$file_content = file_get_contents("/home/doboyle/IT/DHCP.csv");
	$CSV = addslashes($file_content);
	$clean_data= addslashes($file_content);
	$CSV = explode(",",$clean_data);
	}
	add_bulk($CSV);
	Nav_menu();
}
?>