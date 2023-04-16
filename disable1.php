<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "set_remainder";
$conn = mysqli_connect($servername, $username, $password, $dbname);

//Check the connection to the server database
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

//If the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //Get the selected date and subject
    $date = $_POST["date"];
    $subject = $_POST["subject"];
    
    //Get the reminder with the selected date and subject
    $sql = "SELECT * FROM reminders WHERE date='$date' AND subject='$subject'";
    $result = mysqli_query($conn, $sql);
    
    //If the reminder exists
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $description = $row["description"];
        $status = $row["status"];
        
        //If the reminder is enabled
        if ($status == "enable") {
            //Update the reminder status to "disable"
            $sql = "UPDATE reminders SET status='disable' WHERE date='$date' AND subject='$subject'";
            if (mysqli_query($conn, $sql)) {
                echo '<script>alert("Reminder is disabled");</script>';
            } else {
                echo '<script>alert("Error updating reminder: ' . mysqli_error($conn) . '");</script>';
            }
        } else {
            echo '<script>alert("Reminder is already disabled");</script>';
        }
    } else {
        echo '<script>alert("Reminder not found");</script>';
    }
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Disable Reminder</title>
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

        #disable-form {
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
        <h1>Disable Reminders</h1>
    </div>
    <div class="form-box">
    <form id="disable-form" method="POST">
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