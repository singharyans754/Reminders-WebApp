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
$sql = "SELECT description, email, contact, sms FROM reminders WHERE subject='$subject' AND date='$date'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
  $row = mysqli_fetch_assoc($result);
  echo "Description: ".$row["description"]."<br>";
  echo "Email: ".$row["email"]."<br>";
  echo "Contact: ".$row["contact"]."<br>";
  echo "SMS: ".$row["sms"]."<br>";
} else {
  echo "No data found.";
}

mysqli_close($conn);
