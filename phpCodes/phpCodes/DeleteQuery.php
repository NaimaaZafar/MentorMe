<?php
$servername = "localhost";
$username = "NaimaZafar";
$password = "naima2922";
$dbname = "project";
// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

$id = $_REQUEST['id'];
$id = mysqli_real_escape_string($conn, $id);

// Check connection
if (!$conn) {
die("Connection failed: " . mysqli_connect_error());
}
// sql to delete a record
$sql = "DELETE FROM users WHERE id=$id";
if (mysqli_query($conn, $sql)) {
echo "Record deleted successfully";
} else {
echo "Error deleting record: " . mysqli_error($conn);
}
mysqli_close($conn);
?>