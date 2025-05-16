<?php
$servername = "localhost";
$username = "naima";
$password = "";
$dbname = "project";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Delete existing messages with chatId "GlobalChat"
$deleteStmt = $conn->prepare("DELETE FROM messages WHERE chatId = ?");
$chatId = "GlobalChat";
$deleteStmt->bind_param("s", $chatId);
$deleteStmt->execute();
$deleteStmt->close();

// Insert new messages
$insertStmt = $conn->prepare("INSERT INTO messages (chatId, messageId, senderId, message, timestamp) VALUES ('GlobalChat', ?, ?, ?, ?)");
$messages = json_decode($_POST['messages'], true);

foreach ($messages as $message) {
    $insertStmt->bind_param("ssss", $message['messageId'], $message['senderId'], $message['message'], $message['timestamp']);
    $insertStmt->execute();
}

$insertStmt->close();
$conn->close();
?>
