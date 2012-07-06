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
		print "This device is already in the database as Device ID $deviceID <br>";

		}else	{
		
		//If no duplicate Mac Addresss found, enters new device and populates info
		print "No entry was found for this device, adding it to the database. <br>";
		mysql_query("INSERT INTO `Device_Table` (`MAC`, `User`, `HTPS_SERIAL`) VALUES ('$MAC','dummy','bad_Serial');");
		$request = mysql_query("SELECT DeviceID FROM `Device_Table` WHERE MAC='$MAC'");
		$row = mysql_fetch_assoc($request);
		$deviceID = $row['DeviceID'];
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
																			
function add_bulk($CSV)	{ 
	$database="phpdhcp";																			
	print "<br> Bulk called <br>";
	print_r($CSV);
	$entries = count($CSV)/4;
	print "<br> $entries Devices entries found";
	
		for ($x=0; $x < $entries; $x++) {
		print "<br> Attempting to send device $entries";
		$MAC = $CSV[0] + (4*$x);
		$device_name = $CSV[1] + (4*$x);
		$group = $CSV[2] + (4*$x);
		$ip_required = $CSV[3] + (4*$x);
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
			$request = mysql_query("SELECT * FROM `IP_Table` WHERE `DeviceID`='0' AND `Group`=$group") or die("Fail within AssignIP: " . mysql_error()); //check for free IPS
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
	
		if ($row['DeviceID']==-10 xor $row['DeviceID']==-6 xor $row['DeviceID']==-3)	{

			if ($row['DeviceID']==-10) 	{
			print "Subnet Found.";	
			$subnet_array=explode(".",$row['IPAddress']);
			$subnet_min=$subnet_array[0].".".$subnet_array[1].".0.3";
			$subnet_max=$subnet_array[0].".".$subnet_array[1].".0.4";
			print_r($subnet_array);
			$dhcp_info .= "subnet $row[IPAddress] netmask 255.255.252.0 {  \r\n";
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
										
//Builds entry only if IP address has a DeviceID
		
//writes variable into file_put_contents(/etc/dhcp/dhcpd.conf)

file_put_contents("/etc/dhcp/dhcpd.conf",$dhcp_info);

//restarts dhcp service
exec('/bin/bash /home/doboyle/dhcp_restart.sh');
disconnect_DB($con);
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
			Print "Remove device found";
		}else{
			print "No device found";
		}
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
	$request=mysql_query("SELECT * FROM `Device_Table` WHERE `MAC` IS NOT NULL") or die("Fail within retrieve All: " . mysql_error());
	
	while ($row = mysql_fetch_assoc($request))	{
	print "<br>"."\t DeviceID ".$row['DeviceID']."\t MAC ".$row['MAC']."\t User ".$row['User']."\t HTPS_SERIAL ".$row['HTPS_SERIAL']."<br>";
												}
	mysql_free_result($request);  //clear memory after
	
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