<?php
require 'db_connect.php'; // Ensure this file connects to your MariaDB

$query = "SELECT date_started, name, score, duration FROM ram_quiz 
          WHERE score > 0 AND duration IS NOT NULL 
          ORDER BY score DESC, duration ASC";
          
$result = $conn->query($query);

$players = [];
while ($row = $result->fetch_assoc()) {
    $players[] = $row;
}

echo json_encode($players);
?>