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



// Data from client
$userId = $_POST['userId'];
$email = $_POST['email'];
$name = $_POST['name'];
$contactNumber = $_POST['contactNumber'];
$profileImageUrl = $_POST['profileImageUrl'];
$coverImageUrl = $_POST['coverImageUrl'];
$bio = $_POST['bio'];
$location = $_POST['location'];
$education = $_POST['education'];
$lastOnlineTimestamp = $_POST['lastOnlineTimestamp'];
$expertise = json_decode($_POST['expertise'], true);
$favorites = json_decode($_POST['favorites'], true);
$reviews = json_decode($_POST['reviews'], true);
$sessions = json_decode($_POST['sessions'], true);
$notifications = json_decode($_POST['notifications'], true);

// Proceed with the rest of the script...



// Begin transaction
$conn->begin_transaction();

try {
    // Update user
    $stmt = $conn->prepare("UPDATE Users SET email=?, name=?, contactNumber=?, profileImageUrl=?, coverImageUrl=?, bio=?, location=?, education=?, lastOnlineTimestamp=? WHERE userId=?");
    $stmt->bind_param("ssssssssss", $email, $name, $contactNumber, $profileImageUrl, $coverImageUrl, $bio, $location, $education, $lastOnlineTimestamp, $userId);
    $stmt->execute();
    $stmt->close();

    // Update expertise
    $stmt = $conn->prepare("DELETE FROM UserExpertise WHERE userId=?");
    $stmt->bind_param("s", $userId);
    $stmt->execute();
    $stmt->close();

    $stmt = $conn->prepare("INSERT INTO UserExpertise (userId, expertise) VALUES (?, ?)");
    foreach ($expertise as $skill) {
        $stmt->bind_param("ss", $userId, $skill);
        $stmt->execute();
    }
    $stmt->close();

    // Update favorites
    $stmt = $conn->prepare("DELETE FROM UserFavorites WHERE userId=?");
    $stmt->bind_param("s", $userId);
    $stmt->execute();
    $stmt->close();

    $stmt = $conn->prepare("INSERT INTO UserFavorites (userId, mentorId) VALUES (?, ?)");
    foreach ($favorites as $mentorId) {
        $stmt->bind_param("ss", $userId, $mentorId);
        $stmt->execute();
    }
    $stmt->close();

    // Update reviews
    $stmt = $conn->prepare("DELETE FROM Reviews WHERE userId=?");
    $stmt->bind_param("s", $userId);
    $stmt->execute();
    $stmt->close();

    $stmt = $conn->prepare("INSERT INTO Reviews (userId, mentorId, targetUserName, rating, comment, timestamp) VALUES (?, ?, ?, ?, ?, ?)");
    foreach ($reviews as $review) {
        $stmt->bind_param("ssssss", $userId, $review['mentorId'], $review['targetUserName'], $review['rating'], $review['comment'], $review['timestamp']);
        $stmt->execute();
    }
    $stmt->close();

    // Update sessions
    $stmt = $conn->prepare("DELETE FROM Sessions WHERE menteeId=?");
    $stmt->bind_param("s", $userId);
    $stmt->execute();
    $stmt->close();

    $stmt = $conn->prepare("INSERT INTO Sessions (mentorId, menteeId, scheduledTime, status) VALUES (?, ?, ?, ?)");
    foreach ($sessions as $session) {
        $stmt->bind_param("ssss", $session['mentorId'], $userId, $session['scheduledTime'], $session['status']);
        $stmt->execute();
    }
    $stmt->close();

    // Update notifications
    $stmt = $conn->prepare("DELETE FROM Notifications WHERE userId=?");
    $stmt->bind_param("s", $userId);
    $stmt->execute();
    $stmt->close();

    $stmt = $conn->prepare("INSERT INTO Notifications (userId, message, timestamp) VALUES (?, ?, ?)");
    foreach ($notifications as $notification) {
        $timestamp = time(); // Assume current time for the example
        $stmt->bind_param("sss", $userId, $notification, $timestamp);
        $stmt->execute();

    }
    $stmt->close();

    // Commit transaction
    $conn->commit();
    echo "User updated successfully with all related data";
} catch (Exception $e) {
    // An error occurred, roll back the transaction
    $conn->rollback();
    echo "Error: " . $e->getMessage();
}

$conn->close();
?>
