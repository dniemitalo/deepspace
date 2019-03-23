<?php
ini_set('display_errors', 'On');
error_reporting(E_ALL | E_STRICT);

//load field names

$field_list_display = file('pit_field_list.txt', FILE_IGNORE_NEW_LINES);

//database query
require_once('db.php');
$sql = "SELECT team,drivetype,transmission,driveMotors,motors_type,level,hatch_type,hatch_floor,cargo_type,cargo_floor,climb_type,climb_level,sandstorm,build_appearance,wiring_appearance,language,comments FROM pit ORDER BY team";
//$sql = "SELECT $fields, timestamp FROM pit GROUP BY team ORDER BY team, MIN(timestamp)";
echo $sql;
$result = mysqli_query($conn,$sql);
$filename = 'pitscouting.csv';
$f = fopen('php://memory', 'w'); 

//header rows
//change first header row, because starting a CSV with "ID" makes excel throw a filetype error (??)
//No more id field, so this is all unnecessary. Keeping here for future reference.
// $field_list_display[0] = "pit_ID";
fputcsv($f, $field_list_display);
//data rows
while ($row=mysqli_fetch_assoc($result)){
	fputcsv($f,$row);
}
fseek($f, 0);
header('Content-Type: application/csv');
header('Content-Disposition: attachment; filename="'.$filename.'";');
fpassthru($f);

mysqli_close($conn);
?>