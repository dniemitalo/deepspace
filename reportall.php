<?php
ini_set('display_errors', 'On');
error_reporting(E_ALL | E_STRICT);
require_once('db.php');
$sql = "SELECT * FROM pit ORDER BY team";
$result = mysqli_query($conn,$sql);

//TODO: load the team numbers from teamData.js
$teamnums = array(171,469,525,648,904,930,967,1622,1625,1732,1985,2526,2530,2538,2957,3206,3352,3633,3928,4021,4260,4536,5013,5041,5576,5837,5906,5914,5935,6164,6166,6217,6317,6379,6391,6420,6424,6455,6630,6732,6889,7021,7142,7309,7411,7531,7541,7646);
$teams = array();
foreach ($teamnums as $t){
	$teams[$t] = array();
}

// $t = -1;
while ($row = mysqli_fetch_assoc($result)){
	$t = $row['team'];
	$teams[$t]['drivetype'] = $row['drivetype'];
	$teams[$t]['transmission'] = $row['transmission'];
	$teams[$t]['driveMotors'] = $row['driveMotors'];
	$teams[$t]['motors_type'] = $row['motors_type'];
	$teams[$t]['level'] = $row['level'];
	$teams[$t]['hatch_type'] = $row['hatch_type'];
	$teams[$t]['hatch_floor'] = $row['hatch_floor'];
	$teams[$t]['cargo_type'] = $row['cargo_type'];
	$teams[$t]['cargo_floor'] = $row['cargo_floor'];
	$teams[$t]['climb_type'] = $row['climb_type'];
	$teams[$t]['climb_level'] = $row['climb_level'];
	$teams[$t]['matches'] = array();
}

$sql = "SELECT * FROM matches ORDER BY team, matchnum";
$result = mysqli_query($conn,$sql);
$row = mysqli_fetch_assoc($result);
$t = $row['team'];
$m = $row['matchnum'];
$teams[$t]['matches']['matchnum']['habline'] = $row['habline'];
echo "habline: ".$teams[$t]['matches']['matchnum']['habline'];

mysqli_close($conn);


$t = $teamnums[1];
echo "team: $t <br>";
echo 'drivetype: '.$teams[$t]['drivetype'].'<br>';
echo 'transmission: '.$teams[$t]['transmission'].'<br>';
echo 'driveMotors: '.$teams[$t]['driveMotors'].'<br>';
echo 'motors_type: '.$teams[$t]['motors_type'].'<br>';
echo 'level: '.$teams[$t]['level'].'<br>';
echo 'hatch_type: '.$teams[$t]['hatch_type'].'<br>';
echo 'hatch_floor: '.$teams[$t]['hatch_floor'].'<br>';
echo 'cargo_type: '.$teams[$t]['cargo_type'].'<br>';
echo 'cargo_floor: '.$teams[$t]['cargo_floor'].'<br>';
echo 'climb_type: '.$teams[$t]['climb_type'].'<br>';
echo 'climb_level: '.$teams[$t]['climb_level'].'<br>';


?>

