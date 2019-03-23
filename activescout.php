<?php
$matchnum = $_POST['matchnum'];
$team = $_POST['team'];
$scout = $_POST['scout_name'];
require_once 'db.php';
$sql = "INSERT INTO active (timestamp, matchnum, team, scout) VALUES (NOW(), $matchnum, $team, '$scout')";
// echo $sql;
mysqli_query($conn, $sql);
?>