<?php 
class device 
{
	function add_device($mac,$device_name,$group,$htps_serial,$IP_Required) 	{ 
	var $mac
	var $device_name
	var $group
	var $htps_serial
	var $IP_Required

	//Connect to DB
	
	//searches devices Tables for mac address

	//If no duplicate Mac Addresss found, enters new device and populates info

	//closes DB

	//If IP address is needed, calls Assign_IP()

	//returns success or failure message
																				}
																				
	function remove_device($mac){
	var $mac

	//connects DB

	//Searches device DB for matching MAC address

	//If Mac is found, removes device, calls Remove_IP

	//closes DB

	//returns error on no devices found or success on completion
	
								}
							
	function retrieve_all_devices() {
	//Returns entire list of devices

	//List.JS allows for real time searching of list
									}
}
?>