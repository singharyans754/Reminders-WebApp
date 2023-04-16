<?php
$hostname = "localhost";
$username = "root";
$password = "";
$dbname = "set_remainder";
$table = "reminders";

// Create connection
$conn = mysqli_connect($hostname, $username, $password, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Fetch data from table based on date range
if (isset($_GET['fromDate']) && isset($_GET['toDate'])) {
    $fromDate = $_GET['fromDate'];
    $toDate = $_GET['toDate'];
    $sql = "SELECT * FROM $table WHERE `Date` BETWEEN '$fromDate' AND '$toDate' ORDER BY `Date` ASC";
    $result = mysqli_query($conn, $sql);
}

// Print table with fetched data
if (isset($result) && mysqli_num_rows($result) > 0) {
    echo "<table>";
    echo "<tr><th>Date</th><th>Subject</th><th>Description</th><th>Email Address</th><th>Contact Number</th><th>SMS No.</th><th>Recurrence</th><th>Status</th></tr>";
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr><td>" . $row["date"] . "</td><td>" . $row["subject"] . "</td><td>" . $row["description"] . "</td><td>" . $row["email"] . "</td><td>" . $row["contact"] . "</td><td>" . $row["sms"] . "</td><td>" . $row["recurrence"] . "</td><td>" . $row["status"] . "</td></tr>";
    }
    echo "</table>";
}

// Close connection
mysqli_close($conn);
?>
