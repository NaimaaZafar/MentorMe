<?php
$servername = "localhost";
$username = "NaimaZafar";
$password = "naima2922";
$dbname = "project";
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve data sent from Android app
$data = $_REQUEST['data'];

// Escape special characters to prevent SQL injection
$data = mysqli_real_escape_string($conn, $data);

// Insert data into database
$sql = "INSERT INTO users (name) VALUES ('$data')";

if ($conn->query($sql) === TRUE) {
    echo "Data inserted successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// Close connection
$conn->close();
?>