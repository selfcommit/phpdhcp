<?php echo "IP addressesing class"; 


function Assign_IP ($mac,$deviceID,$group) 	{
//Takes in the mac address of a device to be added

//access the Database

//checks MAC address against existing mac addresses in IP_addresses Table

//If MAC is unique look for next available IP according to $group

//assign next available IP to device

//return IP address
							}
							

function Remove_IP ($mac) 	{
//Takes in a mac address of a device to be removed

//accesses the Database

//Checks for MAC address in IP_Addresses Table (looks for multips)

//remove all instances

//If Found, clears device ID for the IP address

							}
							
function Assign_multiIP ($mac, $deviceID,$group[])	{
//Takes in deviceID and MAC

//Checks to see if Mac addresss is in use 

//If MAC is unique, assigns device ID to IP address in Every staff Subnet (Group)

//Assigns to all subnets found in groups[]

											}

function Remove_teacherIP ($mac)	{
//Takes in deviceID and MAC

//Looks for MAC, clears DeviceID for each entry

											}											
			


function rebuild_DHCP() {
//renames /etc/dhcp/dhcpd.conf to /etc/dhcp/dhcpd.conf_old

//rebuilds DHCP file into a variable based on DB information
//Builds entry only if IP address has a DeviceID

//writes variable into file_put_contents(/etc/dhcp/dhcpd.conf)

//restarts dhcp service
exec('/bin/bash /home/doboyle/dhcp_restart.sh');
						}							
?>