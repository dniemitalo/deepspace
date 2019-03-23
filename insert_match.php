<?php
// ini_set('display_errors', 'On');
// error_reporting(E_ALL | E_STRICT);
require_once 'db.php';

try{
	$timestamp = "NOW()";
	$team = trim(mysqli_real_escape_string($conn, $_POST['team']));
	$event_code = trim(mysqli_real_escape_string($conn, $_POST['event_code']));
	$scout_name = trim(mysqli_real_escape_string($conn, $_POST['scout_name']));
	$matchnum = trim(mysqli_real_escape_string($conn, $_POST['matchnum']));
	$practice = trim(mysqli_real_escape_string($conn, $_POST['practice']));
	$habline = trim(mysqli_real_escape_string($conn, $_POST['habline']));
	echo "habline: $habline";
	$sandstorm_preload = trim(mysqli_real_escape_string($conn, $_POST['sandstorm_preload']));
	$sandstorm_action = trim(mysqli_real_escape_string($conn, $_POST['sandstorm_action']));
	$sandstorm_success = trim(mysqli_real_escape_string($conn, $_POST['sandstorm_success']));
	$hatch_made = trim(mysqli_real_escape_string($conn, $_POST['hatch_made']));
	$hatch_missed = trim(mysqli_real_escape_string($conn, $_POST['hatch_missed']));
	$cargo_made = trim(mysqli_real_escape_string($conn, $_POST['cargo_made']));
	$cargo_missed = trim(mysqli_real_escape_string($conn, $_POST['cargo_missed']));
	$difficulty = trim(mysqli_real_escape_string($conn, $_POST['difficulty']));
	$climb = trim(mysqli_real_escape_string($conn, $_POST['climb']));
	$foul = trim(mysqli_real_escape_string($conn, $_POST['foul']));
	$defense = trim(mysqli_real_escape_string($conn, $_POST['defense']));
	$incap = trim(mysqli_real_escape_string($conn, $_POST['incap']));
	$comments = trim(mysqli_real_escape_string($conn, $_POST['comments']));

	$fields = "timestamp,team,event_code,scout_name,matchnum,practice,habline,sandstorm_preload,sandstorm_action,sandstorm_success,hatch_made,hatch_missed,cargo_made,cargo_missed,difficulty,climb,foul,defense,incap,comments";
	$values = "'$timestamp','$team','$event_code','$scout_name','$matchnum','$practice','$habline','$sandstorm_preload','$sandstorm_action','$sandstorm_success','$hatch_made','$hatch_missed','$cargo_made','$cargo_missed','$difficulty','$climb','$foul','$defense','$incap','$comments'";
}
catch (Exception $e) {
	//Stop the page before deleting old records if the POST data isn't found
	die($fields."\n".$values."\nException:\n" . $e->getMessage());
}

//delete old versions of this team/matchnum combination
$sql="DELETE FROM matches WHERE matchnum='{$_POST['matchnum']}' AND team='{$_POST['team']}'";
mysqli_query($conn, $sql);

$sql="INSERT INTO matches ($fields) VALUES ($values)";

if(mysqli_query($conn, $sql)){
	echo "Match $matchnum, Team $team saved successfully.";
} 
else {
	echo mysqli_error($conn)."\n".$sql;
}

mysqli_close($conn);

?>