<?php

// Script which serves to save to log informations sent by mobile application Leaf Spy Pro
// and previously grabbed from ELM327 adapter connected to electric vehicle Nissan Leaf.
//
// 1) On server:
//    Create FTP account. You have to set it later in Automate script LeafSpy FTP Upload (default is "user@host.com")
//    Run server.sh with crontab (it should be run all the time).
// 2) On car's cellphone:
//    Install Automate from Google Play and run three scripts from directory "Automate scripts"
//    Install and configure Leaf Spy to save log file every 5 minute.
//    Requirements concerning Leaf Spy Pro and cellphone:
//    - Leaf Spy Pro should be run on cellphone and shown on the display (not minimized)
//    - Leaf Spy Pro should be always displaying and display can't be blocked
//    - Leaf Spy Pro: night mode is recommended
//    - Leaf Spy Pro: enable "Always keep GPS active"
//    - Leaf Spy Pro: enable "Stay Awake"
//    - Leaf Spy Pro: enable "Display Bright"
//    - Leaf Spy Pro: enable "Disable Sound"
//    - Leaf Spy Pro: enable "Skip Reading Headlight Status"
//    - phone settings: set display brightness setting to minimum
//    Troubleshoots:
//    - cellphone stopped sending data - try to call this number
//    - in example folder you have an example of log file

require("logs/last.log");
echo "
<table width=70%><tr>
<td width=25% align=center>$date<br><b>$day<br>$time</b></td>
<td width=25% align=center>Battery state<br>(SOC)<br><img width=50px src=Leaf/images/SOC.png><br><b>" . $SOC . "%</b></td>
<td width=25% align=center>Battery state of health<br>(SOH)<br><img width=50px src=Leaf/images/SOH.png><br><b>" . $SOH . "%</b></td>
<td width=25% align=center>Temperature<br>of traction battery<br><img width=50px src=Leaf/images/BatTemp.png><br><b>" . $bat_temp_tyl_posrodku . ", " . $bat_temp_srodek_prawa . " i " . $bat_temp_przod_prawa . "°C</b></td>
</tr><tr><td><br></td></tr><tr>
<td width=25% align=center>Charging<br><img width=50px src=Leaf/images/PlugState.png><br><b>$wtyczka</b>";
if ($wtyczka == "plugged") { echo "<br>Charging power: <b>" . $ladowanie_moc . "W</b>"; }; echo "</td>";
echo "
<td width=25% align=center>Acu 12V<br><img width=50px src=Leaf/images/acu_12V.jpg><br><b>" . $bat_12V . "V</b></td>
<td witdh=25% align=center>Car's position: <br> <b>$dlugosc_geograficzna</b><br>, <b>$szerokosc_geograficzna</b><br><a href=\"$MapUrl\">Map</a></td>
<td witdh=25% align=center>
<a href=\"Leaf/show_logs.php\"><img src=\"images/logs.png\" width=40></a><br>
<a href=\"Leaf/show_logs.php\">More specific logs</a>
</td>
</tr></table>";

?>
