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

// Select all messages
$sql = "SELECT * FROM messages ORDER BY timestamp ASC";
$result = $conn->query($sql);

$messages = array();

if ($result->num_rows > 0) {
    // Output data of each row
    while ($row = $result->fetch_assoc()) {
        $message = array(
            "chatId" => $row["chatId"],
            "messageId" => $row["messageId"],
            "senderId" => $row["senderId"],
            "message" => $row["message"],
            "timestamp" => $row["timestamp"]
        );
        $messages[] = $message;
    }
}

// Close connection
$conn->close();

// Output messages as JSON
echo json_encode($messages);
?>
