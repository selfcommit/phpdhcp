#!/bin/bash

echo "DHCP REstart Script successfully called. The number of seconds elapsed since 01/01/1970 is `date`." >> dhcp_test.txt
service isc-dhcp-server restart
