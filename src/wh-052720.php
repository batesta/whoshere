<?php
/** Who's Here Version 1.5
    5/13/20 - Changed column width to better fit
	5/26/20 - Sometimes users are shown 'here' but don't have AP data. Show them 'away'
*/
define('__ROOT__', dirname(dirname(__FILE__)));
require_once(__ROOT__.'/whoshere/config.php');
require_once('client.php');  # Change to location of UniFi API

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
<title>$title</title>
<body>
<div id=\"container\"><h1>$header</h1>";
/**
*  *  * load the class using the composer autoloader
*   *   */
echo "<center><h2>Updated " . date("h:i:sa") . "</h2></center>";


/**
 *  *  * initialize the Unifi API connection class, log in to the controller and request the alarms collection
 *   *   * (this example assumes you have already assigned the correct values to the variables used)
 *    *    */
$unifi_connection = new UniFi_API\Client($controller_user, $controller_password, $controller_url, $site_id, $controller_version, false);
$login            = $unifi_connection->login();


$array = array();
foreach (file($myFile) as $line)
{
            list($key, $value) = explode('  ', $line, 2) + array(NULL, NULL);
                if ($value !== NULL)
                            {
                                            $array[$key] = rtrim($value);
                                                }
}
echo "<table class=\"status_table\"><tr><td class=\"headline\">Person</td><td class=\"headline\">Status</td><td style=\"width:230px\" class=\"headline\">Since</td><td class=\"headline\">Hotspot</td></tr>\n";
while (list($name, $user_mac) = each($array)) { 


        $connected_users    = $unifi_connection->list_clients($user_mac);
        if (!empty($connected_users[0]->mac) AND (!empty($aps[$connected_users[0]->ap_mac]))) {
               echo "<tr><td>" . $name . "</td><td class=\"Online\">Here</td><td></td><td>" . $aps[$connected_users[0]->ap_mac] .  "</td>\n";

		    }
        else
        {
                $user_history = $unifi_connection->stat_client($user_mac);
                echo "<tr><td>" . $name . "</td><td class=\"Offline\"><b>Not Here</b></td><td>" . date ('l, F jS -  g:i A',$user_history[0]->last_seen) . "</td><td></td> \n ";
#               print_r ($user_history);
        }

#       echo "Done with ". $name;
#       $previous_connection= $unifi_connection->stat_client($mac);
        #       print_r ($previous_connection);
        #

		}
		
echo "</table><center>Who's Here Version " . $version . " by Thomas Bates\n<br> Licensed until GNU General Public License v3.0</center>";
?>
