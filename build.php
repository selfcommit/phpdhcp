<?php
include "functions.php";
 if (isset($_POST['add'])) {
	//Define posted variables
	$MAC = $_POST["MAC"]; //Mac Address supplied by the user entering the device
	$group = $_POST["group"]; //What IP group does the device belong in?
	$device_name = $_POST["device_name"]; //Device name for device table
		if (isset($_POST["ip"])) {
		$ip_required = $_POST["ip"]; //Does the device require a mac address?
		}
		add_device($MAC,$device_name,$group,$ip_required);
 }
 
 if (isset($_POST['remove'])) {
	$MAC = $_POST["MAC"]; 
	remove_device($MAC);
 }

 if (isset($_POST['bulk'])) 	{
	$CSV = explode(",",$_POST['upload']);
	add_bulk($CSV);

}
?>