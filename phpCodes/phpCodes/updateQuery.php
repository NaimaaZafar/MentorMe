<?php
$servername = "localhost";
$username = "NaimaZafar";
$password = "naima2922";
$dbname = "project";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
$id = $_REQUEST['id'];
$id = mysqli_real_escape_string($conn, $id);
$entry_text = $_REQUEST['entry_text'];
$entry_text = mysqli_real_escape_string($conn, $entry_text);

// Check connection
if (!$conn) {
die("Connection failed: " . mysqli_connect_error());
}
$sql = "UPDATE users SET entry_text='$entry_text' WHERE user_entries.id=$id";
if (mysqli_query($conn, $sql)) {
echo "Record updated successfully";
} else {
echo "Error updating record: " . mysqli_error($conn);
}
mysqli_close($conn);
?>