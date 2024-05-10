<?php
$databaseName = isset($_GET['database']) ? $_GET['database'] : null;
$dbConnection = mysqli_connect("localhost", "root", "", $databaseName) or die("Connection failed");
$q20 = "SELECT team_a FROM match_info;";
    $result100 = mysqli_query($dbConnection, $q20);
$row=mysqli_fetch_assoc($result100);
$q21 = "SELECT team_b FROM match_info;";
    $result101 = mysqli_query($dbConnection, $q21);
$row1=mysqli_fetch_assoc($result101);

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Score Entry</title>
  <style>
   body {
  position: relative; /* Ensure relative positioning for absolute positioning of child elements */
  height: 100vh; /* Ensure full height of viewport */
  margin: 0; /* Remove default margin */
  padding: 0; /* Remove default padding */
  background-image: url('/score update/image/toss.png');
  
}

.match-form {
  position: absolute;
  top: 10%; /* Position 10% from the top of the viewport */
  left: 50%; /* Horizontally center the form */
  transform: translateX(-50%); /* Adjust horizontal positioning */
  width: 300px;
  padding: 20px;
  border: 1px solid #ccc;
  border-radius: 5px;
  backdrop-filter: blur(10px);
}

.match-form h2 {
  text-align: center;
  margin-bottom: 20px;
}

.match-form label {
  display: block;
  margin-bottom: 5px;
}

.match-form input[type="text"],
.match-form input[type="number"],
.match-form select {
  width: 100%;
  padding: 5px;
  margin-bottom: 10px;
  border: 1px solid #ccc;
  border-radius: 5px;
  margin-top: 5px;
}


.match-form input[type="submit"] {
  width: 100%;
  padding: 10px;
  background-color: #4CAF50;
  color: white;
  border: none;
  border-radius: 5px;
  cursor: pointer;
  margin-top: 20px;
}

.match-form input[type="submit"]:hover {
  background-color: #45a049;
}
  </style>
</head>
<body>
  <div class="match-form">
    <h2>TOSS REPORT</h2>
    <form action="player_name.php?database=<?php echo $databaseName?>" method="post">
      <br><label for="toss-team">Toss Won By:</label>
      <select id="toss-team" name="toss-team">
        <option value="<?php echo $row['team_a'];?>"><?php echo $row['team_a'];?></option>
        <option value="<?php echo $row1['team_b'];?>"><?php echo $row1['team_b'];?></option>
      </select><br><br>
      <label for="team-elected">Elected :</label>
      <select id="team-elected" name="decided">
        <option value="Bat">Bat</option>
        <option value="Bowl">Bowl</option>
      </select><br>
	  <input type="submit" value="Create Match">
    </form>
  </div>
</body>
</html>
