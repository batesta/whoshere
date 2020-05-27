<?php
/** Who's Here Version 1.5
    5/13/20 - Changed column width to better fit
	5/26/20 - Sometimes users are shown 'here' but don't have AP data. Show them 'away'
*/

echo "<html>
<meta http-equiv=\"refresh\" content=\"120\"/>
<style type=\"text/css\"><!--
body { font-family: Verdana, \"Lucida Sans\", Arial, Helvetica, sans-serif; font-size: 100%; }
<html>body { font-size: 14px; /* for FF */ }
div#container { width: 37em; margin: 0 auto; position: relative; }
.datetime { font-size: 87%; font-weight: bolder; text-align: center; margin-bottom: 2em; }
.version { font-size: 73%; text-align: center; color: black; background: white; }
.version a { font-weight: bolder; color: black; text-decoration: none; }
h1 { color: #500000; border-bottom: 1px solid #999999; text-align: center; margin-bottom: 1em; margin-top: 2em; }
div#alert { border: 1px solid red; padding: 0.2em 1.5em; margin: 1em 0; }
.status_table { border: 1px solid #333333; border-collapse: collapse; width: 100%; }
.status_table td { color: #333333; border: 1px solid #444444; text-align: center; padding: 0.3em; }
.status_table td.headline { font-weight: bolder; text-align: center; background-color: #CFCCCC; padding: 0.4em 0.4em 0.3em 1.5em; }
.hidden { display: none !important; }
.Online { background-color: #D9FFB3; padding-left: 0.8em !important; }
.Offline { background-color: #FFB6B6; padding-left: 0.8em !important; }
!--></style>
<title>Redemption Gateway - Who's here?</title>
<body>
<div id=\"container\"><h1>Who's Here?</h1>";
/**
*  *  * load the class using the composer autoloader
*   *   */
echo "<center><h2>Updated " . date("h:i:sa") . "</h2></center>";
require_once('client.php');

/**
 *  *  * initialize the Unifi API connection class, log in to the controller and request the alarms collection
 *   *   * (this example assumes you have already assigned the correct values to the variables used)
 *    *    */
$controller_user = "whoshere";
$controller_password = "W97jeq@7JFDHs&2#qj0r";
$controller_url = "https://192.168.92.10:8443";
$site_id = "jy32d13j";
$controller_version = "5.10.21.0";
date_default_timezone_set('America/Phoenix');
$unifi_connection = new UniFi_API\Client($controller_user, $controller_password, $controller_url, $site_id, $controller_version, false);
$login            = $unifi_connection->login();

$aps = array('78:8a:20:08:cd:2c' => "Sound Booth",
        '78:8a:20:08:b2:e4' => "Security Office",
        '78:8a:20:08:d9:cc' => "Conference Room",
        '78:8a:20:08:ce:ac' => "Bullpen",
        '78:8a:20:0a:95:f0' => "Room 306 - Resource",
        '78:8a:20:0a:9d:b4' => "Room 301 - Kid's Check in",
		'b4:fb:e4:81:49:57' => "Lobby - West",
		'78:8a:20:08:e1:a4' => "Gym",
		'78:8a:20:0a:39:d8' => "Lobby Southwest",
		'78:8a:20:0a:48:b8' => "Room 304",
		'78:8a:20:0a:9a:40' => "Room 200",
		'78:8a:20:0a:9b:30' => "Room 302",
		'78:8a:20:4b:3d:10' => "Room 204",
		'78:8a:20:53:77:79' => "Room 203",
		'78:8a:20:86:7d:97' => "Room 201",
		'78:8a:20:d0:19:d7' => "Room 206",
		'78:8a:20:d3:99:93' => "Room 307",
		'80:2a:a8:19:3e:3d' => "Room 100",
		'b4:fb:e4:81:4a:d1' => "Tech Galley",
		'b4:fb:e4:81:4d:2c' => "Lobby East",
		'78:8a:20:0a:40:70' => "The Box",
		'78:8a:20:0a:48:b8' => "Room 304",
		'b4:fb:e4:81:49:5d' => "Stage Right",
		'b4:fb:e4:81:4d:50' => "Stage Left");

		
$myFile = "users.txt";
$array = array();
foreach (file($myFile) as $line)
{
            list($key, $value) = explode('  ', $line, 2) + array(NULL, NULL);
                if ($value !== NULL)
                            {
                                            $array[$key] = rtrim($value);
                                                }
}
#print_r ($array);
echo "<table class=\"status_table\"><tr><td class=\"headline\">Person</td><td class=\"headline\">Status</td><td style=\"width:230px\" class=\"headline\">Since</td><td class=\"headline\">Hotspot</td></tr>";
while (list($name, $user_mac) = each($array)) { 


#        echo "Looking for ". $name . ".  He has MAC " . $user_mac. "[end]";
        $connected_users    = $unifi_connection->list_clients($user_mac);
#      print_r ($connected_users);
        if (!empty($connected_users[0]->mac) AND (!empty($aps[$connected_users[0]->ap_mac]))) {
               echo "<tr><td>" . $name . "</td><td class=\"Online\">Here</td><td></td><td>" . $aps[$connected_users[0]->ap_mac] .  "</td>";

		    }
        else
        {
                $user_history = $unifi_connection->stat_client($user_mac);
                echo "<tr><td>" . $name . "</td><td class=\"Offline\"><b>Not Here</b></td><td>" . date ('l, F jS -  g:i A',$user_history[0]->last_seen) . "</td><td></td>";
#               print_r ($user_history);
        }

#       echo "Done with ". $name;
#       $previous_connection= $unifi_connection->stat_client($mac);
        #       print_r ($previous_connection);
        #

		}
		
echo "</table><center>Who's Here Version 1.5-051320</center>";
?>
