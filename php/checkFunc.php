<?php


$host = "webgardeningrds.cepe7iq3kfqk.eu-north-1.rds.amazonaws.com";
$dbname = "webgardening";
$username = "postgres";
$password = "paroladb";
$dbconn = pg_connect("host=$host port=5432 dbname=$dbname user=$username password=$password");

$query = "SELECT * FROM my_harvests";
$result = pg_query($dbconn, $query);

while ($row = pg_fetch_assoc($result)) {
    $harvName = $row['har_name'];
    $harDatePlanted = $row['date_planted'];
    $harDateFinished = $row['harvest_date'];


    echo '<div class="flower_harvest">';
    echo '<h3>' . $harvName . '</h3>';
    echo '<p>Date Planted: ' . $harDatePlanted . '</p>';
    echo '<p>Date of Harvest: ' . $harDateFinished . '</p>';
    echo '</div>';
}
?>