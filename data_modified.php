<?php
// Connect to database
$conn = mysqli_connect("localhost", "root", "", "set_remainder");

// Check if connection is successful
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Get form data
$date = isset($_POST["date"]) ? mysqli_real_escape_string($conn, $_POST["date"]) : "";
$subject = isset($_POST["subject"]) ? mysqli_real_escape_string($conn, $_POST["subject"]) : "";
$description = isset($_POST["description"]) ? mysqli_real_escape_string($conn, $_POST["description"]) : "";
$email = isset($_POST["email"]) ? mysqli_real_escape_string($conn, $_POST["email"]) : "";
$contact = isset($_POST["contact"]) ? mysqli_real_escape_string($conn, $_POST["contact"]) : "";
$sms = isset($_POST["sms"]) ? mysqli_real_escape_string($conn, $_POST["sms"]) : "";
$recurrence = isset($_POST["recurrence"]) ? mysqli_real_escape_string($conn, $_POST["recurrence"]) : "";
// $recurrence = isset($_POST["recurrence"]) ? implode(",", $_POST["recurrence"]) : "";



// Check if required fields are provided
if (empty($date) || empty($subject)) {
    die("Date and subject are required fields.");
}

// Update data in the database
$sql = "UPDATE reminders SET ";
if (!empty($description)) {
    $sql .= "description='$description',";
}
if (!empty($email)) {
    $sql .= "email='$email',";
}
if (!empty($contact)) {
    $sql .= "contact='$contact',";
}
if (!empty($sms)) {
    $sql .= "sms='$sms',";
}
if (!empty($recurrence)) {
    $sql .= "recurrence='$recurrence',";
}
// Remove trailing comma
$sql = rtrim($sql, ",");
$sql .= " WHERE date='$date' AND subject='$subject'";

if (mysqli_query($conn, $sql)) {
    if (mysqli_affected_rows($conn) > 0) {
        echo "<script>alert('Data Updated Successfully');</script>";
    } else {
        echo "<script>alert('No data updated. Please check if the record exists.');</script>";
    }
} else {
    echo "<script>alert('Something went wrong. Please try again.');</script>";
    error_log(mysqli_error($conn)); // Log the error message to the server's error log
}

// Close database connection
mysqli_close($conn);
?> 