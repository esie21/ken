<?php
$host = "localhost"; // Database host (karaniwang 'localhost')
$user = "root"; // MySQL username (default: root)
$pass = ""; // MySQL password (default: blank)
$dbname = "ram_db";

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>