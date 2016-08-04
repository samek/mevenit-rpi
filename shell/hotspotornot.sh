#!/bin/bash -x
###this script takes care of starting hotspot if rpi is not connected##
###if an argument is given then it will forcefully stop/reset wlan
###otherwise it'll just start hotspot if needed


FORCE=$1

if  [ -n "$FORCE" ]; then 
	echo "stopping hotspot";
	stop_hotspot
fi;




FPING="/usr/bin/fping"
IFC="/sbin/ifconfig"
IWID="/sbin/iwgetid"
PS="/bin/ps"
DHCLIENT="/sbin/dhclient"




##global pid##
DHCLIENT_PID=
##global ssid##
SSID=

check_dhcp_process() {
	if [ -z "$1" ]; then  
		return 1;
	fi;
	get_dhclient_pid $1
	if [ -z "$DHCLIENT_PID" ]; then 
		$DHCLIENT -nw -w $1 
		return 0;
	fi;
	return 0;
}

kill_dhcp_process() {
	if  [ -z  "$1" ]; then 
		return 1
	fi;
	get_dhclient_pid $1
	kill -9  $DHCLIENT_PID
}


get_dhclient_pid() {
	DHCLIENT_PID=
	if [ -z "$1" ]; then 
		return 0;
	fi;
	device=$1;
	pid=$(pgrep -a dhclient |grep $device | awk '{print $1}')
	DHCLIENT_PID=$pid
}


are_we_connected() {
	$FPING google.com
	return $?
}

wlan_ssid() {
	SSID=$($IWID -r)
}



reset_wlan0() {
	ip addr flush dev wlan0;
	ifconfig wlan0 down;
	ifdown wlan0
}

start_hotspot() {
	##reset wlan0##
	reset_wlan0
	kill_dhcp_process wlan0
	systemctl start hostapd
	ifconfig wlan0 10.5.5.1 netmask 255.255.255.0 up
	systemctl start isc-dhcp-server
}

stop_hotspot() {
	systemctl stop isc-dhcp-server
	systemctl stop hostapd
	reset_wlan0
	ifup wlan0
	check_dhcp_process wlan0
}





are_we_connected
connected=$?

if [ $connected -ne 0 ]; then 
	### We are not  online or aliens are attacking us##
	echo "We are not connected..."
	start_hotspot
else 
	echo "We are connected"
	wlan_ssid
	echo $SSID
fi;
