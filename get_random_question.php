<?php
// Database connection
$conn = new mysqli("localhost", "root", "", "ram_db");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$question = $conn->query("SELECT * FROM computer_parts ORDER BY RAND() LIMIT 1")->fetch_assoc();
$correct_answer = $question['name_parts'];
$image = $question['image_parts'];

// 3 Wrong answer
$wrong_answers = [];
$result = $conn->query("SELECT name_parts FROM computer_parts WHERE name_parts != '$correct_answer' ORDER BY RAND() LIMIT 3");
while ($row = $result->fetch_assoc()) {
    $wrong_answers[] = $row['name_parts'];
}

// include the correct answer to choices at i-shuffle
$choices = $wrong_answers;
$choices[] = $correct_answer;
shuffle($choices);

// Return JSON response
echo json_encode([
    'image' => $image,
    'choices' => $choices,
    'correct' => $correct_answer
]);

$conn->close();
?>