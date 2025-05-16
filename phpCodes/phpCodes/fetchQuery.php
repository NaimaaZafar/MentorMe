<?php
// Assuming your database connection details
$servername = "localhost";
$username = "NaimaZafar";
$password = "naima2922";
$dbname = "project";
$table = "users";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query to select all data from your table
$sql = "SELECT * FROM $table";
$result = $conn->query($sql);

if ($result) {
    if ($result->num_rows > 0) {
        // Array to hold the fetched data
        $data = array();

        // Fetch data and add it to the array
        while($row = $result->fetch_assoc()) {
            $data[] = $row;
        }

        // Encode the data array to JSON format
        $json_response = json_encode($data);

        // Output JSON response
        header('Content-Type: application/json');
        echo $json_response;
    } else {
        echo "No data found";
    }
} else {
    echo "Error: " . $conn->error;
}

// Close connection
$conn->close();
?>