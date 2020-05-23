<?php

// Settings
$log_path = "/home/user/Leaf/logs_synced_with_LeafSpy/LOG_FILES";
$log_file_name = "Log_DC413267_cf0c3.csv";

// get date and time
$date = substr_replace(shell_exec("date -r $log_path/$log_file_name \"+%Y.%m.%d\""),"",-1);
$time = substr_replace(shell_exec("date -r $log_path/$log_file_name \"+%H:%M:%S\""),"",-1);
$days = array('Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'); // names of week days in your language
$day = substr_replace(shell_exec("date -r $log_path/$log_file_name \"+%w\""),"",-1);
$day = $days[$day];

// read the variables from last line of the log file in CSV format
$log_file = array_pop(file(("$log_path/$log_file_name"))); // get only the last line of log file
$log_file = str_getcsv($log_file);
$VIN = $log_file[120];
$przebieg = $log_file[123];
$ladowania_DC = $log_file[124];
$ladowania_AC = $log_file[125];
$szerokosc_geograficzna = str_replace(".","",$log_file[1]); $szerokosc_geograficzna = str_replace(" ",".",$szerokosc_geograficzna);
$dlugosc_geograficzna = str_replace(".","",$log_file[2]); $dlugosc_geograficzna = str_replace(" ",".",$dlugosc_geograficzna);
$MapUrl = "https://www.google.com/maps/@?api=1&map_action=map&basemap=satellite&layer=traffic&center=" . $szerokosc_geograficzna . "," . $dlugosc_geograficzna . "";
$wysokosc = $log_file[3];
$predkosc = $log_file[4];
$bat_12V = $log_file[122];
$bat_Wh = $log_file[5] * 80 / 1000; // convert GIDs into kWh
$bat_voltage = $log_file[8];
$bat_voltage_delta = $log_file[13];
$bat_temp_tyl_posrodku = $log_file[16];
$bat_temp_srodek_prawa = $log_file[22];
$bat_temp_przod_prawa = $log_file[18];
$opona_lewy_przod = $log_file[126] * 0.0689475729317831; $opona_lewy_przod = number_format($opona_lewy_przod, 2, '.', '');
$opona_prawy_przod = $log_file[127] * 0.0689475729317831; $opona_prawy_przod = number_format($opona_prawy_przod, 2, '.', '');
$opona_prawy_tyl = $log_file[128] * 0.0689475729317831; $opona_prawy_tyl = number_format($opona_prawy_tyl, 2, '.', '');
$opona_lewy_tyl = $log_file[129] * 0.0689475729317831; $opona_lewy_tyl = number_format($opona_lewy_tyl, 2, '.', '');
$ladowanie = $log_file[142];
switch ($ladowanie)
{
case 0:
  $ladowanie = "no charging";
  break;
case 1:
  $ladowanie = "AC 100-120V";
  break;
case 2:
  $ladowanie = "AC 200-240V";
  break;
case 3:
  $ladowanie = "DC";
  break;
}
$ladowanie_moc = $log_file[143];
$bieg = $log_file[144];
switch ($bieg)
{
case 0:
  $bieg = "not ready";
  break;
case 1:
  $bieg = "P";
  break;
case 2:
  $bieg = "R";
  break;
case 3:
  $bieg = "N";
  break;
case 4:
  $bieg = "D";
  break;
case 7:
  $bieg = "B";
  break;
}
$wtyczka = $log_file[141];
switch ($wtyczka)
{
case 0:
  $wtyczka = "unplugged or waiting for charging";
  break;
case 1:
  $wtyczka = "partially plugged";
  break;
case 2:
  $wtyczka = "plugged";
  break;
}
$SOC = $log_file[6] / 10000; $SOC = number_format($SOC, 2, '.', ''); // cut to last two digits after comma
$SOH = $log_file[131];

// save information about last visit
$log = $log . "<?php

\$date = \"$date\";
\$day = \"$day\";
\$time = \"$time\";
\$VIN = \"$VIN\";
\$przebieg = \"$przebieg\";
\$ladowania_DC = \"$ladowania_DC\";
\$ladowania_AC = \"$ladowania_AC\";
\$szerokosc_geograficzna = \"$szerokosc_geograficzna\";
\$dlugosc_geograficzna = \"$dlugosc_geograficzna\";
\$MapUrl = \"$MapUrl\";
\$wysokosc = \"$wysokosc\";
\$predkosc = \"$predkosc\";
\$bat_12V = \"$bat_12V\";
\$bat_Wh = \"$bat_Wh\";
\$bat_voltage = \"$bat_voltage\";
\$bat_voltage_delta = \"$bat_voltage_delta\";
\$bat_temp_tyl_posrodku = \"$bat_temp_tyl_posrodku\";
\$bat_temp_srodek_prawa = \"$bat_temp_srodek_prawa\";
\$bat_temp_przod_prawa = \"$bat_temp_przod_prawa\";
\$opona_lewy_przod = \"$opona_lewy_przod\";
\$opona_prawy_przod = \"$opona_prawy_przod\";
\$opona_prawy_tyl = \"$opona_prawy_tyl\";
\$opona_lewy_tyl = \"$opona_lewy_tyl\";
\$ladowanie = \"$ladowanie\";
\$ladowanie_moc = \"$ladowanie_moc\";
\$bieg = \"$bieg\";
\$wtyczka = \"$wtyczka\";
\$SOC = \"$SOC\";
\$SOH = \"$SOH\";

?>
";
unlink('logs/last.log');
$log_file = fopen('logs/last.log', 'w');
fwrite($log_file, $log);
fclose($log_file);

// save to log
$log = "<tr>
<td>$date<br><b>$day<br>$time</b></td>
<td>$VIN<br>$przebieg km</td>
<td><a href=\"$MapUrl\">$dlugosc_geograficzna<br>$szerokosc_geograficzna</a>,<br>" . $wysokosc . "m,<br>" . $predkosc . "km/h, $bieg</td>
<td>left front<br>$opona_lewy_przod bar,<br>right front<br>$opona_prawy_przod bar,<br>right rear<br>$opona_prawy_tyl bar,<br>left rear<br>$opona_lewy_tyl bar</td>
<td>" . $SOC . "%,<br>" . $SOH . "%</td>
<td>$ladowania_DC (DC) i $ladowania_AC (AC),<br>$wtyczka,<br>" . $ladowanie_moc . "W ($ladowanie)</td>
<td>" . $bat_12V . "V</td>
<td>middle rear " . $bat_temp_tyl_posrodku . "°C,<br>middle right " . $bat_temp_srodek_prawa . "°C,<br>front right " . $bat_temp_przod_prawa . "°C</td>
<td>" . $bat_Wh . "kWh,<br>" . $bat_voltage . "V,<br>difference " . $bat_voltage_delta . "mV</td>
<tr>";

$log_file = fopen('logs/Leaf.log', 'a');
fwrite($log_file, $log);
fclose($log_file);

// rotate logs to last 5000 lines
$log_content = `tail -5000 logs/Leaf.log`;
unlink('logs/Leaf.log');
$log_file = fopen('logs/Leaf.log', 'w');
fwrite($log_file, $log_content);
fclose($log_file);

?>
