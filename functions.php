<?php
function add_device($MAC,$device_name,$group,$ip_required)	{  
	$database="phpdhcp";
	echo "<br> Add Device Function Called <br>";
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
		$row = mysql_fetch_assoc($request);
		$deviceID = $row['DeviceID'];
		print "This device is already in the database as Device ID <a href=build.php?device_info=$deviceID>$deviceID</a>, updating record...<br>";
		mysql_query("UPDATE `Device_Table` SET `device_name` = '$device_name'  WHERE `MAC`='$MAC'") or die("Failure in add device -> device name Update: " . mysql_error());
		mysql_query("UPDATE `Device_Table` SET `ip_required` = '$ip_required'  WHERE `MAC`='$MAC'") or die("Failure in add device -> ip_required Update: " . mysql_error());
		}else	{
		
		//If no duplicate Mac Addresss found, enters new device and populates info
		print "No entry was found for this device, adding it to the database. <br>";
		mysql_query("INSERT INTO `Device_Table` (`MAC`, `device_name`,`ip_required`) VALUES ('$MAC','$device_name','$ip_required');");
		$request = mysql_query("SELECT DeviceID FROM `Device_Table` WHERE MAC='$MAC'");
		$row = mysql_fetch_assoc($request);
		$deviceID = $row['DeviceID'];
		print "The Device was successfully added to the database.  It's deviceID is <a href=build.php?device_info=$deviceID>$deviceID</a> <br>";
				}
		
		//If IP address is needed, calls Assign_IP()
		if ($ip_required == 1) {
		
		switch ($group) {
			case 1:
			echo "Case 1 called - Teacher Laptop" ;
			$group="317,318,319,320,321,322,323,324,325,326";
			break;
			case 2:
			echo "Case 2 called - Teacher Mobile Device Non-Laptop" ;
			$group="417,418,419,420,421,422,423,424,425,426";
			break;
			case 3:
			echo "Case 3 called - Cart Devices" ;
			$group="217,218,219,220,221,222,223,224,225,226";
			break;
			case 4:
			echo "Case 4 called - 4th Grade student" ;
			$group="817,818,819,820,821,822,823,824,825,826";
			break;
			case 5:
			echo "Case 5 called - 5th Grade student" ;
			$group="817,818,819,820,821,822,823,824,825,826";
			break;
			case 6:
			echo "Case 11 called - 11th Grade student" ;
			$group="717,718,719,720,721,722,723,724,725,726";
			break;
			case 7:
			echo "Case 7 called - 7th Grade student" ;
			$group="617,618,619,620,621,622,623,624,625,626";
			break;
			case 8:
			echo "Case 8 called - 8th Grade student" ;
			$group="517,518,519,520,521,522,523,524,525,526";
			break;
			case 9:
			echo "Case 9 called - 9th Grade student" ;
			$group="817,818,819,820,821,822,823,824,825,826";
			break;
			case 10:
			echo "Case 11 called - 11th Grade student" ;
			$group="717,718,719,720,721,722,723,724,725,726";
			break;
			case 11:
			echo "Case 11 called - 11th Grade student" ;
			$group="617,618,619,620,621,622,623,624,625,626";
			break;
			case 12:
			echo "Case 12 called - 12th Grade student" ;
			$group="517,518,519,520,521,522,523,524,525,526";
			break;
			case 17:
			echo "Case 17 called - HHS Wired Device" ;
			$group="117";
			break;
			case 18:
			echo "Case 18 called - MS Wired Device" ;
			$group="118";
			break;
			case 19:
			echo "Case 19 called - Auten Road Wired Device" ;
			$group="119";
			break;
			case 20:
			echo "Case 20 called - MS Wired Device" ;
			$group="120";
			break;
			case 21:
			echo "Case 21 called - HES Wired Device" ;
			$group="121";
			break;
			case 22:
			echo "Case 22 called - Sunny Mead Wired Device" ;
			$group="122";
			break;
			case 23:
			echo "Case 23 called - Triangle Wired Device" ;
			$group="123";
			break;
			case 24:
			echo "Case 24 called - Woodfern Wired Device" ;
			$group="124";
			break;
			case 25:
			echo "Case 25 called - Woodfern Wired Device" ;
			$group="125";
			break;
			case 26:
			echo "Case 26 called - BoE Wired Device" ;
			$group="126";
			break;			
		}
		echo "This device requires an ip, Calling Assign_IP <br>";
		echo "Before it is passed, The group ID is $group <br>";
		Assign_IP($MAC,$deviceID,$group);
		}else	{
		echo "This device Needs no ip, calling remove IP<br>";
		Remove_IP ($MAC);
				}
}
																			
function add_bulk($CSV)	{ 
	$database="phpdhcp";																			
	print "<br> Bulk called <br> <pre>";
	print_r($CSV);
	$entries = count($CSV)/4;
	print "</pre><br> $entries Devices entries found";
	
		for ($x=0; $x < $entries; $x++) {
		print "<br> Attempting to send device $x";
		$MAC = $CSV[0 + (4*$x)];
		print "On Pass $x The Mac is = $MAC";
		$device_name = $CSV[1 + (4*$x)];
		$group = $CSV[2 + (4*$x)];
		$ip_required = $CSV[3 + (4*$x)];
		add_device($MAC,$device_name,$group,$ip_required);
		}
		

															}
function mac_validation($val) { 
	return (bool)preg_match('/^([0-9a-fA-F][0-9a-fA-F]:){5}([0-9a-fA-F][0-9a-fA-F])$/', $val); 
}

function Assign_IP ($MAC,$deviceID,$group) 	{
	print "Assign_IP called successfully <br>";
	$database="phpdhcp";
	$con = connect_DB();
	$db = mysql_select_db($database);
		if (!$db)	{
		die('Could not Find the DB: ' .mysql_error());
					}
	//echo "After it passed to Assign_IP the GroupID is $group <br>";
		$group=explode(",",$group);
		$networks=sizeof($group);
		
		$request = mysql_query("SELECT * FROM `IP_Table` WHERE DeviceID='$deviceID'"); //checks DeviceID against existing DeviceIDs in IP_addresses Table
		if(mysql_num_rows($request) != 0){
		$row = mysql_fetch_array($request);
		print "This Decvice already has an IP see device with deviceid of <a href=build.php?device_info=$deviceID>$deviceID</a> <br>";
		}else{
			for($x=0; $x < $networks ; $x++) {
			//If DeviceID is unique look for next available IP according to $group
			//print "No IP entry found for this device, adding it now.";
			$request = mysql_query("SELECT * FROM `IP_Table` WHERE `DeviceID`='0' AND `Group`=$group[$x]") or die("Fail within AssignIP: " . mysql_error()); //check for free IPS
				if(mysql_num_rows($request) != 0)	{
				$row = mysql_fetch_array($request);
				//var_dump($row);
				$newIPID = $row['IPID'];
				print "<br>Now Assigning IP Address IPID $newIPID ".$row['IPAddress']." to Device <a href=build.php?device_info=$deviceID>$deviceID</a><br>";
				mysql_query("UPDATE `IP_Table` SET `DeviceID`=$deviceID WHERE `IPID`=$newIPID") or die("Failure in IP Table Update: " . mysql_error());
				mysql_query("UPDATE `IP_Table` SET `MAC`='$MAC' WHERE `IPID`=$newIPID") or die("Failure in IP Table Update: " . mysql_error());
				//var_dump($row);
				}else	{	
				print "Something went wrong, are we out of IP addresses?";
						}
				}
		
			}
			
	mysql_close($con);
}
							

function Remove_IP ($MAC) 	{
	//Takes in a mac address of a device to be removed
	print "Remove IP Called with $MAC";
	//accesses the Database
	$database="phpdhcp";
	$con = connect_DB();
	$db = mysql_select_db($database);
		if (!$db)	{
		die('Could not Find the DB: ' .mysql_error());
					}
	//Checks for MAC address in IP_Addresses Table (looks for multips)
	$request = mysql_query("SELECT * FROM `IP_Table` WHERE `MAC`= '$MAC'") or die("Fail within RemoveIP: " . mysql_error()); //check for free IPS
				if(mysql_num_rows($request) != 0)	{
				$row = mysql_fetch_array($request);
				$DeviceID = $row['DeviceID'];
				//remove all instances
				mysql_query("UPDATE `IP_Table` SET `MAC`=0 WHERE `DeviceID`= $DeviceID") or die("Failure clearing MAC in IP RemoveIP: " . mysql_error());
				mysql_query("UPDATE `IP_Table` SET `DeviceID`=0 WHERE `DeviceID`= $DeviceID") or die("Failure clearing DeviceID in IP RemoveIP: " . mysql_error());	
				}

	//If Found, clears device ID for the IP address

							}

function rebuild_DHCP() {
	//access the Database
	$database="phpdhcp";
	$con = connect_DB();
	$db = mysql_select_db($database);
	$dhcp_info = "# The ddns-updates-style parameter controls whether or not the server will \r\n
# attempt to do a DNS update when a lease is confirmed. We default to the \r\n
# behavior of the version 2 packages ('none', since DHCP v2 didn't \r\n
# have support for DDNS.) \r\n
ddns-update-style none; \r\n

# option definitions common to all supported networks... \r\n
option domain-name \"hillsborough.k12.nj.us\";  \r\n
default-lease-time 600; \r\n
max-lease-time 7200; \r\n

# If this DHCP server is the official DHCP server for the local \r\n
# network, the authoritative directive should be uncommented. \r\n
authoritative; \r\n

# Use this to send dhcp log messages to a different log file (you also \r\n
# have to hack syslog.conf to complete the redirection). \r\n
log-facility local7; \r\n \r\n

\r\n
subnet 172.16.3.0 netmask 255.255.255.0 {
}
\r\n" ;
 
	//renames /etc/dhcp/dhcpd.conf to /etc/dhcp/dhcpd.conf_old
		if(rename("/etc/dhcp/dhcpd.conf","/etc/dhcp/dhcpd.conf_old")){
		print "rename of /etc/dhcp/dhcpd.conf to /etc/dhcp/dhcpd.conf_old was successfull <br/>";
		}else{
		//die("Rename didn't work, are premissions set correctly?");

		}

//rebuilds DHCP file into a variable based on DB information
$request=mysql_query("SELECT * FROM `IP_Table` WHERE `DeviceID`!=0 ORDER BY `Group`,`DeviceID`") or die("Fail within DHCP Build: " . mysql_error());
	if(mysql_num_rows($request) != 0)	{
	//$row = mysql_fetch_assoc($request);
	//print_r($row);
		while ($row = mysql_fetch_assoc($request))	{
			print "<br>"."IPID ".$row['IPID']."Device ID ".$row['DeviceID']." MAC Address ".$row['MAC']."IPAddress".$row['IPAddress']."<br>";
			//Builds entry only if IP address has a DeviceID
			if ($row['DeviceID']==-10 xor $row['DeviceID']==-6 xor $row['DeviceID']==-3)	{

				if ($row['DeviceID']==-10) 	{
				print "Subnet Found.";	
				//$subnet_array=explode(".",$row['IPAddress']);
				//$subnet_min=$subnet_array[0].".".$subnet_array[1].".0.3";
				//$subnet_max=$subnet_array[0].".".$subnet_array[1].".0.4";
				//print_r($subnet_array);
				$dhcp_info .= "subnet $row[IPAddress] netmask 255.255.248.0 {  \r\n";
				}
										
				if ($row['DeviceID']==-6) 	{
				print "Gateway Found.";
				$dhcp_info .= "option routers $row[IPAddress]; \r\n";
				}							
										
				if ($row['DeviceID']==-3) 	{
				print "Broadcast Found.";
				$dhcp_info .= "option broadcast-address $row[IPAddress];
				} \r\n";
				}							
																				
			}else	{
				if (mac_validation($row['MAC'])) 	{
				print "adding DHCP entry for device ".$row['DeviceID']."\r\n";
				$dhcp_info .= " \t host $row[DeviceID] { hardware ethernet $row[MAC]; fixed-address $row[IPAddress]; } \r\n";
					}else	{
					print "Can Not add DHCP for Device ".$row['DeviceID']. " The MAC address is not valid.";
				}
			}
		}
	}

	//writes variable into file_put_contents(/etc/dhcp/dhcpd.conf)
	file_put_contents("/etc/dhcp/dhcpd.conf",$dhcp_info);

	//restarts dhcp service
	exec('/bin/bash /home/doboyle/dhcp_restart.sh');
	mysql_close($con);
}
																				
function remove_device($MAC){
	//connects DB
	$database="phpdhcp";
	$con = connect_DB();
	$db = mysql_select_db($database);

	//Searches device DB for matching MAC address
	//$request = mysql_query("SELECT * FROM `IP_Table` WHERE DeviceID='$deviceID'")
	$request = mysql_query("SELECT * FROM `Device_Table` WHERE MAC='$MAC'") or die("Fail within Remove Device: " . mysql_error());
		if(mysql_num_rows($request) != 0){
			$row = mysql_fetch_assoc($request);
			$DeviceID = $row['DeviceID'];
			Print "<br>Device found, removing now, updating DB<br>";
			mysql_query("UPDATE `Device_Table` SET `MAC`=0 WHERE `DeviceID`=$DeviceID") or die("Failure clearing MAC in IP RemoveIP: " . mysql_error());
			//mysql_query("UPDATE `Device_Table` SET `User`=0 WHERE `DeviceID`=$DeviceID") or die("Failure clearing MAC in IP RemoveIP: " . mysql_error());
			//mysql_query("UPDATE `Device_Table` SET `HTPS_SERIAL`=0 WHERE `DeviceID`=$DeviceID") or die("Failure clearing MAC in IP RemoveIP: " . mysql_error());
		}else{
			print "<br>No device found<br>";
		}
	//If Mac is found, removes device, calls Remove_IP
	Remove_IP ($MAC);
	//closes DB
		mysql_close($con);
	//returns error on no devices found or success on completion
	
								}
							
function retrieve_all_devices() {
//access the Database
	$database="phpdhcp";
	$con = connect_DB();
	$db = mysql_select_db($database);
//populate array	
	$request=mysql_query("SELECT * FROM `Device_Table` WHERE `MAC` IS NOT NULL") or die("Fail within retrieve All: " . mysql_error());
	
	while ($row = mysql_fetch_assoc($request))	{
	print "<br>"."\t DeviceID ".$row['DeviceID']."\t MAC ".$row['MAC']."\t device_Name ".$row['device_name']."<br>";
												}
	mysql_free_result($request);  //clear memory after
	
								}
function retrieve_one_device($deviceID) {
//access the Database
	$database="phpdhcp";
	$con = connect_DB();
	$db = mysql_select_db($database);
//populate array	
//populate array	
	$request=mysql_query("SELECT * FROM `Device_Table` WHERE `deviceID`=$deviceID") or die("Fail within retrieve one: " . mysql_error());
	
	while ($row = mysql_fetch_assoc($request))	{
	print "<br>"."\t Information for Device ".$row['DeviceID']."<br> MAC Address: ".$row['MAC']."<br> Device Name: ".$row['device_name']."<br>";
												}
	mysql_free_result($request);  //clear memory after
	

}

function Nav_menu(){

print "<br><a href=index.php>Go back to entry page</a><br>";
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

									
?>