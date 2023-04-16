<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "set_remainder";
$table = "reminders";

// Connect to database
$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $date = mysqli_real_escape_string($conn, $_POST["date"]);
    $subject = mysqli_real_escape_string($conn, $_POST["subject"]);
    $description = mysqli_real_escape_string($conn, $_POST["description"]);

    // Delete the reminder data from the database
    $sql = "DELETE FROM $table WHERE date='$date' AND subject='$subject'";
    if (mysqli_query($conn, $sql)) {
        echo "Record deleted successfully";
    } else {
        echo "Error deleting record: " . mysqli_error($conn);
    }
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Delete Remainders</title>
    <style>
    h1 {
      font-size: 32px;
      margin: 0 0 20px;
      text-align: center; /* center the heading */
    }
  
  .form-box {
    margin: 20px auto; /* Set margin to "auto" and remove left and right margins */
    padding: 20px;
    border: 1px solid #ccc;
    border-radius: 10px;
    width: 500px;
    display: flex;
    flex-direction: column;
    align-items: center;
    }
  
    #delete-form {
    display: flex;
    flex-direction: column;
    align-items: center;
    width: 100%;
    }
  
    input[type="date"], input[type="time"], select, textarea, input[type="email"], input[type="tel"], input[type="button"], input[type="submit"] {
    width: 100%;
    padding: 10px;
    margin: 10px 0;
    border: none;
    border-radius: 5px;
    background-color: #f2f2f2;
    }
  
    input[type="button"], input[type="submit"] {
    background-color: #4CAF50;
    color: white;
    cursor: pointer;
    }
    
    input[type="button"]:hover, input[type="submit"]:hover {
    background-color: #3e8e41;
    }
    
    h3 {
    margin-top: 20px;
    margin-bottom: 10px;
    text-align: left;
    width: 100%;
    font-size: 16px;
    }
  
  </style>
</head>
<body>
    <div>
        <h1>Delete Remainders</h1>
    </div>
    <div class="form-box">
        <form id="delete-form" method="post">
        <h3>Select Date:</h3>
        <input type="date" name="date" id="date" required onchange="printDescription()">
        <h3>Subject:</h3>
        <select name="subject" id="subject" onchange="printDescription()">
        <option value="study">Study</option>
        <option value="fun">Fun</option>
        <option value="work">Work</option>
        <option value="other">Other</option>
        </select>

        <h3>Description:</h3>
        <textarea name="description" id="description" rows="5" cols="40" readonly></textarea>
        <br>
        <a href="home.html"><input style="float: left;" type="button" value="Back"></a>
        <input style="float: right;" type="submit" value="Confirm">
    </form>
    </div>
    <a href="login.html"><button style="float: right;">Logout</button></a>

    <script>
    function getDescription(subject) {
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("description").value = this.responseText;
        }
        };
        xhr.open("GET", "get_description.php?subject=" + subject, true);
        xhr.send();
    }

    function printDescription() {
        var date = document.getElementById("date").value;
        var subject = document.getElementById("subject").value;
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            if (this.responseText == "No description found.") {
            document.getElementById("description").value = "No data is present.";
            } else {
            document.getElementById("description").value = this.responseText;
            }
        }
        };
        xhr.open("GET", "get_description.php?date=" + date + "&subject=" + subject, true);
        xhr.send();
    }
    </script>
</body>
</html>