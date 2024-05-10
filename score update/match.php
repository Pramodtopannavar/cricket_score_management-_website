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
  background-image: url('/score update/image/match.png');
  
}

.match-form {
  position: absolute;
  top: 10%; /* Position 10% from the top of the viewport */
  left: 50%; /* Horizontally center the form */
  transform: translateX(-50%); /* Adjust horizontal positioning */
  width: 350px;
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
.match-form input[type="number"] {
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
<?php
// Establishing database connection
$con = mysqli_connect("localhost", "root", "") or die("Connection failed");

// Function to check if the match ID matches existing database names
function isMatchIdValid($matchId, $existingDatabases) {
    return !in_array($matchId, $existingDatabases);
}

// Retrieve existing database names
$query = "SHOW DATABASES";
$result = mysqli_query($con, $query);
$existingDatabases = array();
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $existingDatabases[] = $row['Database'];
    }
    mysqli_free_result($result);
} else {
    // Handle database query error more gracefully
    die("Error retrieving databases: " . mysqli_error($con));
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate match ID
    $matchId = $_POST['matchid'];
    if (!isMatchIdValid($matchId, $existingDatabases)) {
        echo "<p style='color: red;'>Please change the match ID. This ID is reserved for an existing database name.</p>";
    } else {
        // Match ID is valid, proceed with database creation and data insertion
        // Sanitize match ID to ensure it contains only alphanumeric characters and underscores
        
$matchId = preg_replace("/[^a-zA-Z0-9_]/", "", $matchId);



        $databaseName = "" . $matchId;
        $createDatabaseQuery = "CREATE DATABASE `$databaseName`";
        if (mysqli_query($con, $createDatabaseQuery)) {
            // Database created successfully
            $dbConnection = mysqli_connect("localhost", "root", "", $databaseName) or die("Connection failed");

            // Create table if not exists
            $q1 = "CREATE TABLE IF NOT EXISTS match_info (
                team_a VARCHAR(20),
                team_b VARCHAR(20),
                over_count INT(4),
                venue VARCHAR(20)
            )";
            if (mysqli_query($dbConnection, $q1)) {
                // Table created successfully
                $team1 = $_POST['team1-name'];
                $team2 = $_POST['team2-name'];
                $over_c = $_POST['overs'];
                $venue = $_POST['venue'];
                // Insert data into table
                $q2 = "INSERT INTO match_info (team_a, team_b, over_count, venue) VALUES ('$team1', '$team2', $over_c, '$venue')";
                if (mysqli_query($dbConnection, $q2)) {
                    // Data inserted successfully
                    mysqli_close($dbConnection);
                    // Redirect to toss.php
                    header("Location: toss.php?database=$databaseName");
                    exit();
                } else {
                    die("Error inserting data into table: " . mysqli_error($dbConnection));
                }
            } else {
                die("Error creating table: " . mysqli_error($dbConnection));
            }
        } else {
            die("Error creating database: " . mysqli_error($con));
        }
    }
}
?>

  <div class="match-form">
    <h2>Create a New Match</h2>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
    <BR><label for="matchid">Match id:</label>
<input type="number" id="matchid" name="matchid" required><br><br>

     <label for="team1-name">Team 1 Name:</label>
      <input type="text" id="team1-name" name="team1-name" required><br><br>
      <label for="team2-name">Team 2 Name:</label>
      <input type="text" id="team2-name" name="team2-name" required><br><br>
      <label for="overs">Overs:</label>
      <input type="number" id="overs" name="overs" min="1" max="50" required><br><br>
      <label for="venue">Venue:</label>
      <input type="text" id="venue" name="venue"><br><br>
      
      <input type="submit" value="Create Match">
    </form>
  </div>
</body>
</html>
