<?php
//Request event match data (schedule)

//Request team data (numbers, name location, etc)
$curl = curl_init();
$season = $_POST['season'];
$eventcode = $_POST['eventcode'];
$url = "https://www.thebluealliance.com/api/v3/event/{$season}{$eventcode}?X-TBA-Auth-Key=mfRYpEpNbmiknYuH9Y1UfBgN8IXb1DXj5d18898PeajWHRdA69M6qTOtvZRz7zYZ";
echo $url;
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
$result = "var eventData = ".curl_exec($curl);
curl_close($curl);

$filename = 'eventData.js';
file_put_contents($filename, $result);

//Request team data (numbers, name location, etc)
$curl = curl_init();
$season = $_POST['season'];
$eventcode = $_POST['eventcode'];
$url = "https://www.thebluealliance.com/api/v3/event/{$season}{$eventcode}/teams?X-TBA-Auth-Key=mfRYpEpNbmiknYuH9Y1UfBgN8IXb1DXj5d18898PeajWHRdA69M6qTOtvZRz7zYZ";
echo $url;
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
$result = "var teamData = ".curl_exec($curl);
curl_close($curl);

$filename = 'teamData.js';
file_put_contents($filename, $result);

$curl = curl_init();
$season = $_POST['season'];
$eventcode = $_POST['eventcode'];
$url = "https://www.thebluealliance.com/api/v3/event/{$season}{$eventcode}/matches?X-TBA-Auth-Key=mfRYpEpNbmiknYuH9Y1UfBgN8IXb1DXj5d18898PeajWHRdA69M6qTOtvZRz7zYZ";
echo $url;
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
$result = "var scheduleData = ".curl_exec($curl);
curl_close($curl);

$filename = 'scheduleData.js';
file_put_contents($filename, $result);

echo "Requests executed...?";
?>