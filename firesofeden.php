<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
    	<title>The Fires of Eden</title>
		<link rel="stylesheet" href="style.css" type="text/css">
	</head>
	<body>
		<h1>The Fires of Eden</h1>
		<a href="/~loomisc/campaign_map_03.jpg">
		<img src="campaign_map_03.jpg" alt="Campaign Map" style="width:500px;">
		</a>
		<div>
			<form method="POST" action=<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>>
				<fieldset>
					<legend>Select Region</legend>
					<p>Select Faction to Update 
						<select name="region">
							<option value="r1">Region 1</option>
							<option value="r2">Region 2</option>
							<option value="r3">Region 3</option>
							<option value="r4">Region 4</option>
							<option value="r5">Region 5</option>
							<option value="r6">Region 6</option>
							<option value="r7">Region 7</option>
						</select>
					</p>
				</fieldset>
				<input type="submit" name="selectregion" value="Select Region">
			</form>
		</div>
		<div>						
		<?php 
					
if (!empty($_POST)): 
					
$service_url = 'http://api.openweathermap.org/data/2.5/forecast/daily?q=oakland&units=imperial&cnt=7&APPID=ac8c02ef8cf7667fb84c8c8dc20ec383';
$curl = curl_init($service_url);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$curl_response = curl_exec($curl);
if ($curl_response === false) {
    $info = curl_getinfo($curl);
    curl_close($curl);
    die('error occured during curl exec. Additioanl info: ' . var_export($info));
}
curl_close($curl);
$decoded = json_decode($curl_response);
if (isset($decoded->response->status) && $decoded->response->status == 'ERROR') {
    die('error occured: ' . $decoded->response->errormessage);
}
$daily = $decoded->list;
					$i=0;
echo '<table><tr>';
  while($i < 7)
  {
	  echo '<th>' . date('m-d-Y', strtotime('+' . $i++ . ' day')) . '</th>';
}
echo '</tr>';
echo '<tr>';
echo '<td>response ok!</td>';
echo '<td>' . $decoded->city->name . '</td>';
echo '<td>' . $daily[0]->temp->day . '</td>';
echo '</tr>';
echo '</table>';
		?>

		<?php endif; ?>
		</div>
	</body>
</html>