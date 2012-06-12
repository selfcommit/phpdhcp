<?php echo "IP addressesing class"; 


function Assign_IP ($mac,$group) 	{
//Takes in the mac address of a device to be added

//access the Database

//checks MAC address against existing mac addresses in IP_addresses Table

//If MAC is unique look for next available IP according to $group

//assign next available IP to device

//return IP address
							}
							
function Remove_IP ($mac) 	{
//Takes in a mac address of a device to be added

//accesses the Database

//Checks for MAC address in IP_Addresses Table

//If Found, clears device ID for the IP address

							}

function rebuild_DHCP() {
//renames /etc/dhcp/dhcpd.conf to /etc/dhcp/dhcpd.conf_old

//rebuilds DHCP file into a variable based on DB information
//Builds entry only if IP address has a DeviceID

//writes variable into file_put_contents(/etc/dhcp/dhcpd.conf)

//restarts dhcp service
exec('bash /home/doboyle/dhcp_restart.sh');
						}							
?>