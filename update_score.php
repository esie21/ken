<?php
include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']);
    $score = intval($_POST['score']);

    if (!empty($name)) {

        $sql = "UPDATE ram_quiz SET score = score + ? WHERE name = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("is", $score, $name);

        if ($stmt->execute()) {
            echo json_encode(["success" => true, "message" => "Score updated successfully!"]);
        } else {
            echo json_encode(["success" => false, "message" => "Update failed: " . $stmt->error]);
        }

        $stmt->close();
    } else {
        echo json_encode(["success" => false, "message" => "Invalid player name."]);
    }
}

$conn->close();
?>