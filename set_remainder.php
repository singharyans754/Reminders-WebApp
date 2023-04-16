<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "set_remainder";

$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the form data.
$date = isset($_POST['date']) ? $_POST['date'] : '';
$subject = isset($_POST['subject']) ? $_POST['subject'] : '';
$description = isset($_POST['description']) ? $_POST['description'] : '';
$email = isset($_POST['email']) ? $_POST['email'] : '';
$contact = isset($_POST['contact']) ? $_POST['contact'] : '';
$sms = isset($_POST['sms']) ? $_POST['sms'] : '';
$recurrence = isset($_POST['recurrence']) ? $_POST['recurrence'] : '';

// Insert the data into the table
$sql = "INSERT INTO `reminders`(`date`, `subject`, `description`, `email`, `contact`, `sms`, `recurrence`, `status`) 
        VALUES ('$date','$subject','$description','$email','$contact','$sms','$recurrence', 'enable')";


if ($conn->query($sql) === TRUE) {
    echo "Data saved successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// Close the database connection
$conn->close();

?>
