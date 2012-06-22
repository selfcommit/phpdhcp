<?php
function add_device($MAC,$device_name,$group,$ip_required)	{  
	$database="phpdhcp";
	echo "Add Device Function Called <br>";
	$IS_MAC=mac_validation($MAC); //Checks to see if the Mac address supplied is valid
		if($IS_MAC) {
		echo "Valid Mac Address has been entered. <br>";
		}else{
		die('Your Mac Address is invalid, Please Go Back and try again');
					}
	//access the Database
	$con = connect_DB();
	$db = mysql_select_db($database);
	
		if (!$db)	{
		die('Could not Find the DB: ' .mysql_error());
					}
	//searches devices Tables for mac address
	$request = mysql_query("SELECT DeviceID FROM `Device_Table` WHERE MAC='$MAC'");
		if(mysql_num_rows($request) != 0){
		$row = mysql_fetch_array($request);
		$deviceID = $row[0];
		print "This device is already in the database as Device ID $deviceID <br>";

		}else	{
		
		//If no duplicate Mac Addresss found, enters new device and populates info
		print "No entry was found for this device, adding it to the database. <br>";
		mysql_query("INSERT INTO `Device_Table` (`MAC`, `User`, `HTPS_SERIAL`) VALUES ('$MAC','dummy','bad_Serial');");
		$request = mysql_query("SELECT DeviceID FROM `Device_Table` WHERE MAC='$MAC'");
		$row = mysql_fetch_array($request);
		$deviceID = $row[0];
		print "The Device was successfully added to the database.  It's deviceID is $deviceID <br>";
				}

		//Close DB connection
		disconnect_DB($con);
		
		//If IP address is needed, calls Assign_IP()
		if ($ip_required == 1) {
		echo "This device requires an ip, Calling Assign_IP <br>";
		echo "Before it is passed, The group ID id is $group <br>";
		Assign_IP($MAC,$deviceID,$group);
		}else	{
		echo "This device Needs no ip, we're done here.<br>";
				}
	//returns success or failure message
																			}


function mac_validation($val) { 
return (bool)preg_match('/^([0-9a-fA-F][0-9a-fA-F]:){5}([0-9a-fA-F][0-9a-fA-F])$/', 
$val); 
}

function Assign_IP ($MAC,$deviceID,$group) 	{
	print "Assign_IP called successfully <br>";
	$database="phpdhcp";
	$con = connect_DB();
	$db = mysql_select_db($database);
		if (!$db)	{
		die('Could not Find the DB: ' .mysql_error());
					}
	echo "After it passed to Assign_IP the GroupID is $group <br>";
		if ( $group==1)	{
		print "Teacher Laptops - Multip IP Add!";
		}else{
		$request = mysql_query("SELECT * FROM `IP_Table` WHERE DeviceID='$deviceID'"); //checks DeviceID against existing DeviceIDs in IP_addresses Table
			if(mysql_num_rows($request) != 0){
			$row = mysql_fetch_array($request);
			print "This Decvice already has IP ".$row['IPAddress']." see device with deviceid of $deviceID <br>";
			}else{
			//If DeviceID is unique look for next available IP according to $group
			print "No IP entry found for this device, adding it now.";
			$request = mysql_query("SELECT * FROM `IP_Table` WHERE `DeviceID`='0' AND `Group`=$group") or die("Can not query DB: " . mysql_error()); //check for free IPS
				if(mysql_num_rows($request) != 0)	{
				$row = mysql_fetch_array($request);
				//var_dump($row);
				$newIPID = $row['IPID'];
				print "Now Assigning IP Address IPID $newIPID ".$row['IPAddress']." to Device $deviceID";
				mysql_query("UPDATE `IP_Table` SET `DeviceID`=$deviceID WHERE `IPID`=$newIPID") or die("Failure in IP Table Update: " . mysql_error());
				mysql_query("UPDATE `IP_Table` SET `MAC`='$MAC' WHERE `IPID`=$newIPID") or die("Failure in IP Table Update: " . mysql_error());
				//var_dump($row);
				}else	{	
				print "Something went wrong, are we out of IP addresses?";
						}
				}
			}
disconnect_DB($con);
//return IP address
							}
							

function Remove_IP ($mac) 	{
//Takes in a mac address of a device to be removed

//accesses the Database

//Checks for MAC address in IP_Addresses Table (looks for multips)

//remove all instances

//If Found, clears device ID for the IP address

							}

function rebuild_DHCP() {
//access the Database
	$database="phpdhcp";
	$con = connect_DB();
	$db = mysql_select_db($database);
//renames /etc/dhcp/dhcpd.conf to /etc/dhcp/dhcpd.conf_old
if(rename("/etc/dhcp/dhcpd.conf","/etc/dhcp/dhcpd.conf_old")){
print "rename was successfull";
}else{
print "Rename didn't work, are premissions set correctly?";
}
//rebuilds DHCP file into a variable based on DB information
$request=mysql_query("SELECT * FROM `IP_Table` WHERE `MAC` IS NOT NULL") or die("Can not query DB: " . mysql_error());
	if(mysql_num_rows($request) != 0)	{
	$row = mysql_fetch_array($request);
	foreach ($row as $entry){
		print "<br>$entry<br>";
							}
										}
//Builds entry only if IP address has a DeviceID
		
//writes variable into file_put_contents(/etc/dhcp/dhcpd.conf)

//restarts dhcp service
exec('/bin/bash /home/doboyle/dhcp_restart.sh');
}
																				
function remove_device($mac){
	//connects DB

	//Searches device DB for matching MAC address

	//If Mac is found, removes device, calls Remove_IP

	//closes DB

	//returns error on no devices found or success on completion
	
								}
							
function retrieve_all_devices() {
//access the Database
	$database="phpdhcp";
	$con = connect_DB();
	$db = mysql_select_db($database);
//populate array	
	$request = mysql_query("SELECT MAC FROM Device_Table");
	if (mysql_num_rows($request) != 0){
	$row = mysql_fetch_array($request);
	var_dump($row);
	return $row;
	//mysql_free_result($request);  //clear memory after
	}else{
	die('Could not Print Device list: ' . mysql_error());
	}
	}
									
	
function connect_DB() 	{
		$username="phpdhcp";
		$servername="localhost";
		$password="YAG6e2RWmJdXJz5B";
		
		$con = mysql_connect($servername,$username,$password);
			if (!$con)	{
			die('Could not connect: ' . mysql_error());
						}
		return $con;
						}
						
function disconnect_DB($con)	{
		mysql_close($con);
									}
									
?>