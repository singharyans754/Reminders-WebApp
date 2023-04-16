<?php
// Connect to the database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "set_remainder";
$table = "reminders";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Get the date and subject from the request parameters
$date = $_POST["date"];
$subject = $_POST["subject"];

// Delete the reminder data from the database
$sql = "DELETE FROM $table WHERE date = '$date' AND subject = '$subject'";
if ($conn->query($sql) === TRUE) {
  echo "Reminder data deleted successfully";
} else {
  echo "Error deleting reminder data: " . $conn->error;
}

$conn->close();
?>