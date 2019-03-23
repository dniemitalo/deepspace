<?php
// ini_set('display_errors', 'On');
// error_reporting(E_ALL | E_STRICT);
require_once 'db.php';
$timestamp = "NOW()";
$team = trim(mysqli_real_escape_string($conn, $_POST['team']));
$event_code = trim(mysqli_real_escape_string($conn, $_POST['event_code']));
$scout_name = trim(mysqli_real_escape_string($conn, $_POST['scout_name']));
$drivetype = trim(mysqli_real_escape_string($conn, $_POST['drivetype']));
$transmission = trim(mysqli_real_escape_string($conn, $_POST['transmission']));
$driveMotors = trim(mysqli_real_escape_string($conn, $_POST['driveMotors']));
$motors_type = trim(mysqli_real_escape_string($conn, $_POST['motors_type']));
$level = trim(mysqli_real_escape_string($conn, $_POST['level']));
$hatch_type = trim(mysqli_real_escape_string($conn, $_POST['hatch_type']));
$hatch_floor = trim(mysqli_real_escape_string($conn, $_POST['hatch_floor']));
$cargo_type = trim(mysqli_real_escape_string($conn, $_POST['cargo_type']));
$cargo_floor = trim(mysqli_real_escape_string($conn, $_POST['cargo_floor']));
$climb_type = trim(mysqli_real_escape_string($conn, $_POST['climb_type']));
$climb_level = trim(mysqli_real_escape_string($conn, $_POST['climb_level']));
$sandstorm = trim(mysqli_real_escape_string($conn, $_POST['sandstorm']));
$build_appearance = trim(mysqli_real_escape_string($conn, $_POST['build_appearance']));
$wiring_appearance = trim(mysqli_real_escape_string($conn, $_POST['wiring_appearance']));
$comments = trim(mysqli_real_escape_string($conn, $_POST['comments']));
$language = trim(mysqli_real_escape_string($conn, $_POST['language']));

$fields = "timestamp,team,event_code,scout_name,drivetype,transmission,driveMotors,motors_type,level,hatch_type,hatch_floor,cargo_type,cargo_floor,climb_type,climb_level,sandstorm,build_appearance,wiring_appearance,comments,language";
$values = "$timestamp,'$team','$event_code','$scout_name','$drivetype','$transmission','$driveMotors','$motors_type','$level','$hatch_type','$hatch_floor','$cargo_type','$cargo_floor','$climb_type','$climb_level','$sandstorm','$build_appearance','$wiring_appearance','$comments','$language'";

$sql="REPLACE INTO pit ($fields) VALUES ($values)";

if(mysqli_query($conn, $sql)){
	echo "Pit Scouting record saved successfully.";
} 
else {
	echo "<br>Error:<br>".$sql."<br>".mysqli_error($conn);
}

mysqli_close($conn);

?>