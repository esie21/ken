<?php
// Database connection
$conn = new mysqli("localhost", "root", "", "ram_db");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$image_folder = "img/";

$files = scandir($image_folder);

foreach ($files as $file) {
    // Skip the "." and ".."
    if ($file != "." && $file != "..") {
        $name = pathinfo($file, PATHINFO_FILENAME);
        $image_path = $image_folder . $file; // Full path image

        // Prevent SQL Injection
        $safe_name = $conn->real_escape_string($name);
        $safe_image_path = $conn->real_escape_string($image_path);

        // Check if existing
        $check = $conn->query("SELECT * FROM computer_parts WHERE image_parts = '$safe_image_path'");
        if ($check->num_rows == 0) {
            // Insert to database
            $sql = "INSERT INTO computer_parts (name_parts, image_parts) VALUES ('$safe_name', '$safe_image_path')";
            if ($conn->query($sql) === TRUE) {
                echo "Inserted: $safe_name <br>";
            } else {
                echo "Error inserting $safe_name: " . $conn->error . "<br>";
            }
        } else {
            echo "Skipped (Already Exists): $safe_name <br>";
        }
    }
}

$conn->close();
?>