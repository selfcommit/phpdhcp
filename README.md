phpdhcp
=======

##Web page for managing District wide ip addressing 

###Notes:
Adding a static entry to dhcp3 on ubuntu.

####Define the scope
> subnet 192.168.1.0 netmask 255.255.255.0 {
>
>        option routers                  192.168.1.1;
>        option subnet-mask              255.255.255.0;
>        option broadcast-address        192.168.1.255;
>        option domain-name-servers      194.168.4.100;
>        option ntp-servers              192.168.1.1;
>        option netbios-name-servers     192.168.1.1;
>        option netbios-node-type 2;
>        default-lease-time 86400;
>        max-lease-time 86400;
>		
*Define the individual Hosts
>	host bla1 {
>                hardware ethernet DD:GH:DF:E5:F7:D7;
>                fixed-address 192.168.1.2;
>        }
>        host bla2 {
>                hardware ethernet 00:JJ:YU:38:AC:45;
>                fixed-address 192.168.1.20;
>        }
>} * <-- Don't forget to close the scope/subnet