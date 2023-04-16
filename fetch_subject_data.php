<?php
// Get database credentials
$servername = $_GET["localhost"];
$username = $_GET["root"];
$password = $_GET[""];
$dbname = $_GET["set_remainder"];
$table = $_GET["reminders"];
$date = $_GET["date"];

// Connect to database
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check if connection is successful
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Fetch subjects from reminders table based on selected date
$sql = "SELECT DISTINCT subject FROM $table WHERE date='$date' ORDER BY subject";
$result = mysqli_query($conn, $sql);

// Check if query is successful
if ($result) {
    // Store results in array
    $results_array = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $results_array[] = $row;
    }
    // Return results as JSON
    echo json_encode($results_array);
} else {
    // Return error message
    echo "Error: " . mysqli_error($conn);
}

// Close database connection
mysqli_close($conn);
?>
