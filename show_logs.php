<?php

echo "
<html>
<head>
    <meta http-equiv=\"Content-Type\" content=\"text/html;charset=utf-8\">
    <link rel=\"stylesheet\" href=\"floating_table_header.css\" type=\"text/css\">
    <link rel=\"stylesheet\" href=\"../default.css\" type=\"text/css\">
    <title>Logs of Nissan Leaf</title>
</head>
<body>
<br><center><b>LOGS OF NISSAN LEAF</b><br><br>
<a href=show_logs.php><img src=\"images/refresh.png\" width=50pt></a></center><br>
<table>
    <thead><tr>
	<th>Date,<br>hour</th>
	<th>VIN,<br>mileage</th>
	<th>Position,<br>height,<br>speed, shift</th>
	<th>Tires</th>
	<th>SOC,<br>SOH</th>
	<th>Charging</th>
	<th>Acu 12V</th>
	<th>Temperature <br>of traction battery</th>
	<th>Energy and voltage<br>of traction battery</th>
    </tr></thead>
<tbody>
";
$logs = fopen('logs/Leaf.log', 'r');
echo fread($logs, filesize('logs/Leaf.log'));
fclose($logs);
echo "
</tbody></table>
</body></html>";

?>
