<?php
include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $game_id = $_POST['game_id'];
    $date_ended = date("Y-m-d H:i:s");

    $sql = "SELECT date_started FROM ram_quiz WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $game_id);
    $stmt->execute();
    $stmt->bind_result($date_started);
    $stmt->fetch();
    $stmt->close();

    if ($date_started) {
        $duration = strtotime($date_ended) - strtotime($date_started); // Compute duration

        // Update `date_ended` at `duration`
        $update_sql = "UPDATE ram_quiz SET date_ended = ?, duration = ? WHERE id = ?";
        $update_stmt = $conn->prepare($update_sql);
        $update_stmt->bind_param("sii", $date_ended, $duration, $game_id);

        if ($update_stmt->execute()) {
            echo json_encode(["success" => true]);
        } else {
            echo json_encode(["success" => false, "message" => "Error updating game."]);
        }

        $update_stmt->close();
    }
}

$conn->close();
?>