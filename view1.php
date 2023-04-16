<!DOCTYPE html>
<html>
  <head>
    <title>View Your Reminders</title>
    <style>
        h1{
            font-size: 32px;
            margin: 0 0 20px;
            text-align: center;
        }
        #view-form{
            display: flex;
            flex-direction: column;
            align-items: center;
            width: 100%;
        }
        .form-box {
            margin: 20px auto 100px; /* Add a bottom margin of 100px */
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 10px;
            width: 500px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        table {
            border-collapse: collapse;
            margin: 0 auto; /* Remove the margin */
            height: auto; /* Set the height to auto */
            /*margin: 20px auto; */
            page-break-inside: avoid; /* add this line */
        
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }


        .button {
			display: inline-block;
			padding: 10px 20px;
			margin: 10px;
			background-color: #4CAF50;
			color: white;
			border: none;
			border-radius: 5px;
			box-shadow: 0 5px 10px rgba(0,0,0,.2);
			font-size: 18px;
			text-align: center;
			text-decoration: none;
			cursor: pointer;
			transition: all 0.3s ease-in-out;
		}

		.button:hover {
			background-color: #3e8e41;
			box-shadow: 0 8px 15px rgba(0,0,0,.3);
		}

		.back-button {
			position: absolute;
			bottom: 10px;
			left: 10px;
		}

		.logout-button {
			position: absolute;
			bottom: 10px;
			right: 10px;
		}

		.center {
			display: flex;
			flex-direction: row;
			justify-content: center;
			align-items: center;
			position: fixed;
			bottom: 0;
			width: 100%;
			margin-bottom: 20px;
		}



    </style>
  </head>
  <body>
    <div>
        <h1>View Your Reminders</h1>
    </div>
    <div id="view-form">
      <!-- HTML code for view1.php -->
<form method="get" class="form-box" action="">
    <label for="fromDate">Select From Date:</label>
    <input type="date" id="fromDate" name="fromDate"><br>
    <label for="toDate">Select To Date:</label>
    <input type="date" id="toDate" name="toDate"><br><br>
    <button type="button" onclick="loadReminders()">View Reminders</button>
</form>
<div id="remindersTable"></div>

<script>
function loadReminders() {
    var fromDate = document.getElementById("fromDate").value;
    var toDate = document.getElementById("toDate").value;

    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("remindersTable").innerHTML = this.responseText;
        }
    };
    xhttp.open("GET", "view_reminders.php?fromDate=" + fromDate + "&toDate=" + toDate, true);
    xhttp.send();
}
</script>

    </div>
    <br><br>
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

// Close connection
mysqli_close($conn);
?>
</div>
<div class="center">
		<a href="http://localhost/delete1.php"><button class="button">Delete</button></a>
		<a href="http://localhost/disable1.php"><button class="button">Disable</button></a>
		<a href="http://localhost/modify1.php"><button class="button">Modify</button></a>
	</div>

	<a href="home.html"><button class="button back-button">Back</button></a>
	<a href="log-out.html"><button class="button logout-button">Log Out</button></a>
  </body>
</html>