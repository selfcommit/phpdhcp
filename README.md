To do:
-Complete the subnet editing page

-Add credentials to the page

phpDHCP
=======

##Web page for managing District wide ip addressing 

###Notes:

###DHCP config file location:
/etc/dhcp/dhcpd.conf
###Adding a static entry to dhcp3 on ubuntu:

####Define the scope
<code>
 subnet 192.168.1.0 netmask 255.255.255.0 {

        option routers                  192.168.1.1;
        option subnet-mask              255.255.255.0;
        option broadcast-address        192.168.1.255;
        option domain-name-servers      194.168.4.100;
        option ntp-servers              192.168.1.1;
        option netbios-name-servers     192.168.1.1;
        option netbios-node-type 2;
        default-lease-time 86400;
        max-lease-time 86400;
	;Define the individual Hosts
	host bla1 {
                hardware ethernet DD:GH:DF:E5:F7:D7;
                fixed-address 192.168.1.2;
        }
        host bla2 {
                hardware ethernet 00:JJ:YU:38:AC:45;
                fixed-address 192.168.1.20;
        }
	} ;<-- Don't forget to close the scope/subnet
</code>

Group Codes and their meanings:
117 HS Wired Devices
118 MS Wired Devices
119 Auten Rd Wired Devices
120 AMS Wired Devices
121 HES Wired Devices
122 Sunny Mead Wired Devices
123 Triangle Wired Devices
124 WoodFern Wired Devices
125 Woods Rd Wired Devices
126 BoE Wired Devices
217-226 Cart Devices network
317-326 Staff Laptop Network
417-426 Staff Mobile Devices
517-526 HTPS1 (Grades 12,8,4)
617-626 HTPS2 (Grades 11,7,3)
717-726 HTPS3 (Grades 10,6,2)
817-826 HTPS4 (Grades 9,5,1)