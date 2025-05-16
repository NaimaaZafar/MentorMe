<?php
$servername = "localhost";
$username = "naimazafar";
$password = "naima29";
$dbname = "user";
$conn = new mysqli($servername, $username, $password, $dbname)
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$data = $_REQUEST['data'];
$data = mysqli_real_escape_string($conn, $data);
$sql = "INSERT INTO `usertable` (`userid`, `username`, `password`) VALUES (NULL, 'naima', '12345');";
if ($conn->query($sql) === TRUE) {
    echo "Data inserted successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
$conn->close();
?>