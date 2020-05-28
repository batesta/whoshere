<?php 
$header = "Who's Here?"; # Header
$title = "Redemption Gateway - Who's Here?"; #Title of HTML page
$controller_user = "whoshere"; # Username you used
$controller_password = "abc123"; #Password you used
$controller_url = "https://192.168.x.x:8443";  #URL You use to connect to UniFi controller
$site_id = "abc123"; # Site Code used to access users you want to monitor.  Get this by going to the site in UniFi and copying from the URL.
$controller_version = "5.10.21.0";
date_default_timezone_set('America/Phoenix');

# Array contains hotspot MAC addresses, and common name to use in displaying hotspot.
$aps = array(
        'b7:c5:21:08:82:32' => "Sound Booth",
        '8e:f1:fe:f2:30:cc' => "Security Office",
        'aa:a2:92:68:c4:ea' => "Conference Room",
        'b6:98:4e:f7:a1:ca' => "Bullpen",
        '12:d1:a8:58:58:b8' => "Room 306 - Resource",
        '8e:15:0d:ae:3d:b4' => "Room 301 - Kid's Check in",
		'ae:1c:a8:10:f4:0b' => "Lobby - West",
		'f3:9a:1c:2f:97:24' => "Gym",
		'a1:1d:4d:b0:64:b2' => "Lobby Southwest",
		'9c:16:e0:c8:eb:cf' => "Room 304",
		'52:fa:66:7e:16:e2' => "Room 200");
$myFile = "users.txt"; # List of users
$version = "1.5-052720" # Version
?>