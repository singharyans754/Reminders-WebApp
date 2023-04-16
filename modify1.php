<!DOCTYPE html>
<html>
<head>
	<title>Modify Reminder</title>
    <script>
        // Function to fetch reminder data based on selected date and subject
        function fetchReminderData() {
  const date = document.getElementById("date-dropdown").value;
  const conn = new XMLHttpRequest();
  const url = `http://localhost/fetch_reminder_data.php`;
  const params = `servername=localhost&dbname=set_remainder&username=root&password=&table=reminders&date=${date}`;
  conn.open("POST", `${url}?${params}`, true);
  conn.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  conn.onreadystatechange = function() {
    if (this.readyState === 4 && this.status === 200) {
      const results = JSON.parse(this.responseText);
      const subjectDropdown = document.getElementById("subject-dropdown");
      subjectDropdown.innerHTML = '<option value="">--Select Subject--</option>';
      if (results.length > 0) {
        for (let i = 0; i < results.length; i++) {
          const option = document.createElement("option");
          option.value = results[i].subject;
          option.textContent = results[i].subject;
          subjectDropdown.appendChild(option);
        }
        // Automatically select the first subject option
        subjectDropdown.value = results[0].subject;
      } else {
        alert("No reminder data found for the selected date.");
      }
    }
  };
  conn.send();
}


</script>
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

        #modify-form {
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
        #logout-button {
			position: fixed;
			bottom: 0;
			right: 0;
			margin: 10px;
			background-color: green;
			color: white;
			padding: 10px;
			border: none;
			border-radius: 5px;
			cursor: pointer;
		}


    </style>
</head>
<body>
    <div>
        <h1>Modify Reminders</h1>
    </div>
    <div class="form-box">
        <form id="modify-form" method="post" action="http://localhost/data_modified.php">
            <h3>Select Date:</h3>
            <select name="date" id="date-dropdown" onchange="fetchReminderData();" required>
                <option value="">--Select Date--</option>
                <?php
                    // Connect to database
                    $conn = mysqli_connect("localhost", "root", "", "set_remainder");

                    // Check if connection is successful
                    if (!$conn) {
                        die("Connection failed: " . mysqli_connect_error());
                    }

                    // Fetch unique dates from reminders table
                    $sql = "SELECT DISTINCT date FROM reminders ORDER BY date DESC";
                    $result = mysqli_query($conn, $sql);
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<option value=\"" . $row["date"] . "\">" . $row["date"] . "</option>";
                    }

                    // Close database connection
                    mysqli_close($conn);
                ?>
            </select>
            <h3>Subject:</h3>
                <select name="subject" id="subject-dropdown" onchange="fetchReminderData();" required>
                    <option value="">--Select Subject--</option>
                    <?php
                    // Connect to database
                    $conn = mysqli_connect("localhost", "root", "", "set_remainder");

                    // Check if connection is successful
                    if (!$conn) {
                        die("Connection failed: " . mysqli_connect_error());
                    }

                    // Fetch unique subjects from reminders table
                    $sql = "SELECT DISTINCT subject FROM reminders ORDER BY subject";
                    $result = mysqli_query($conn, $sql);
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<option value=\"" . $row["subject"] . "\">" . $row["subject"] . "</option>";
                    }

                    // Close database connection
                    mysqli_close($conn);
                    ?>
                </select>
            <!-- <h3>Description:</h3>
            <textarea name="description" rows="5" cols="40" placeholder="Enter description"></textarea> -->
            
            
            <h3>Description:</h3>
            <?php
                // Connect to database
                $conn = mysqli_connect("localhost", "root", "", "set_remainder");

                // Check if connection is successful
                if (!$conn) {
                    die("Connection failed: " . mysqli_connect_error());
                }

                // Fetch reminder data for the selected date and subject
                if (isset($_POST["date"]) && isset($_POST["subject"])) {
                    $date = $_POST["date"];
                    $subject = $_POST["subject"];
                    $sql = "SELECT description FROM reminders WHERE date='$date' AND subject='$subject' LIMIT 1";
                    $result = mysqli_query($conn, $sql);
                    if (mysqli_num_rows($result) > 0) {
                        $row = mysqli_fetch_assoc($result);
                        $description = $row["description"];
                    } else {
                        $description = "";
                    }
                } else {
                    $description = "";
                }

                // Close database connection
                mysqli_close($conn);
            ?>
            <textarea name="description" rows="5" cols="40" placeholder="Enter description"><?php echo $description; ?></textarea>


            
            
            
            
            
            
            
            
            
            <h3>Email Address:</h3>
            <input type="email" name="email" placeholder="Enter your Email">
            <h3>Contact Number:</h3>
            <input type="tel" name="contact" pattern="[0-9]{10}" placeholder="10 digit phone number">
            <h3>SMS No:</h3>
            <input type="tel" name="sms" pattern="[0-9]{10}" placeholder="10 digit phone number">
            <h3>Recurrence For next:</h3>
            <label><input type="checkbox" name="recurrence" value="7">7 days</label>
            <label><input type="checkbox" name="recurrence" value="5">5 days</label>
            <label><input type="checkbox" name="recurrence" value="3">3 days</label>
            <label><input type="checkbox" name="recurrence" value="2">2 days</label>
            <a href="home.html"><input style = "float: left;" type="button" value="Back"></a>
         <input style = "float: right;" type="submit" value="Save Changes">
    </form>
    <a href="login.html"><button id="logout-button">Logout</button></a>
</div>
</body>
</html>