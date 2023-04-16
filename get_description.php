<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "set_remainder";
$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

$subject = $_GET["subject"];
$date = $_GET["date"];
$sql = "SELECT description FROM reminders WHERE subject='$subject' AND date='$date'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
  $row = mysqli_fetch_assoc($result);
  echo $row["description"];
} else {
  echo "No description found.";
}

mysqli_close($conn);
?>