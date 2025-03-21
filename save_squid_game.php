<?php
include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']);
    $date_started = date("Y-m-d H:i:s");

    if (!empty($name)) {

        $checkSql = "SELECT id FROM ram_quiz WHERE name = ? AND date_ended IS NULL";
        $checkStmt = $conn->prepare($checkSql);
        $checkStmt->bind_param("s", $name);
        $checkStmt->execute();
        $checkStmt->bind_result($existingId);
        if ($checkStmt->fetch()) {

            echo json_encode([
                "success" => true, 
                "message" => "Game already started for $name.", 
                "game_id" => $existingId
            ]);
            $checkStmt->close();
            $conn->close();
            exit;
        }
        $checkStmt->close();


        $sql = "INSERT INTO ram_quiz (name, score, date_started, date_ended, duration) VALUES (?, 0, ?, NULL, NULL)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $name, $date_started);

        if ($stmt->execute()) {
            $game_id = $stmt->insert_id;
            echo json_encode([
                "success" => true, 
                "message" => "Game started!", 
                "game_id" => $game_id
            ]);
        } else {
            echo json_encode([
                "success" => false, 
                "message" => "Execute failed: " . $stmt->error
            ]);
        }

        $stmt->close();
    } else {
        echo json_encode([
            "success" => false, 
            "message" => "Please enter a valid name."
        ]);
    }
}

$conn->close();
?>