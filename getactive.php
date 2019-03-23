<?php
require_once 'db.php';
$sql = "
SELECT
  active.*
FROM
  (SELECT
     scout, MAX(timestamp) AS timestamp
   FROM
     active
   WHERE timestamp >= NOW() - INTERVAL 10 MINUTE
   GROUP BY
     scout) AS latest_active
INNER JOIN
  active
ON
  active.scout = latest_active.scout AND
  active.timestamp = latest_active.timestamp
ORDER BY matchnum
  ";

$array = [];
if($result = mysqli_query($conn, $sql)){
	while ($row = mysqli_fetch_assoc($result)){
		$array[] = $row;
	}
}
echo json_encode($array);
mysqli_close($conn);
?>