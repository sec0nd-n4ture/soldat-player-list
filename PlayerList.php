<?php
$playercount = 0;
echo '<html>
<center>
<font size="20" color="#d5ed9c" face="Verdana"><strong>List of players playing Soldat</strong></font>
<br />
<br />
<br />
<br />
<br />
<br />
</center>
</html>';
echo '
<html>
<style>
body {
    background-color: #118C4E;
}
</style>
</html>
';
$ch = curl_init();

$optArray = array(
    CURLOPT_URL => 'http://api.soldat.pl/v0/servers?empty=no&bots=no',
    CURLOPT_RETURNTRANSFER => true
);

curl_setopt_array($ch, $optArray);
$result = curl_exec($ch);
curl_close($ch);

$json_a=json_decode($result,true);
$num = count($json_a['Servers']);
$num = $num - 1;
while ($num >= 0){ 
	$ch2 = curl_init();

	$array2 = array(
		CURLOPT_URL => 'http://api.soldat.pl/v0/server/' . $json_a['Servers'][$num]['IP'] . '/' . $json_a['Servers'][$num]['Port'] . '/players',
		CURLOPT_RETURNTRANSFER => true
	);

	curl_setopt_array($ch2, $array2);
	$result2 = curl_exec($ch2);
	curl_close($ch2);
	echoPlayers($result2);
	
	$ch3 = curl_init();

	$array3 = array(
		CURLOPT_URL => 'http://api.soldat.pl/v0/server/' . $json_a['Servers'][$num]['IP'] . '/' . $json_a['Servers'][$num]['Port'],
		CURLOPT_RETURNTRANSFER => true
	);

	curl_setopt_array($ch3, $array3);
	$result3 = curl_exec($ch3);
	curl_close($ch3);
	$json_c = json_decode($result3, true);
	$playercount = $playercount + $json_c['NumPlayers'];
	$num = $num - 1;
}

function echoPlayers($jsoninput) {
	
	$json_b=json_decode($jsoninput,true);
	$num2 = count($json_b['Players']);
	$num2 = $num2 - 1;
	
	
	while ($num2 >= 0) {
		echo '<html>';
		echo '<center>';
		echo '<font size="6" color="#C1E1A6" face="Lucida Sans Unicode">' . htmlspecialchars($json_b['Players'][$num2]) . '</font>' 
		.
		'<br />
		'
		.
		'
		<img src="/soldier.png" alt="Logo">
		</html>
		';
		echo '</center>';
		echo '</html>';
		echo '<br />';

		$num2 = $num2 - 1;
	}
}

	echo '<html>
<center>
<br />
<font size="40" color="#d5ed9c" face="Verdana"><strong>Total: ' . $playercount . '</strong></font>
<br />
<br />
<br />

</center>
</html>';

?>