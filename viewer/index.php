<?php
// Establishing database connection
$con = mysqli_connect("localhost", "root", "") or die("Connection failed");


// Retrieve existing database names
$query = "SHOW DATABASES";
$result = mysqli_query($con, $query);

$query = "SHOW DATABASES";
$result1 = mysqli_query($con, $query);
function isMatchIdValid($matchId, $existingDatabases) {
  return in_array($matchId, $existingDatabases);
}
$existingDatabases = array();
if ($result1) {
    while ($row1 = mysqli_fetch_assoc($result1)) {
        $existingDatabases[] = $row1['Database'];
    }
    mysqli_free_result($result1);
} else {
    // Handle database query error more gracefully
    die("Error retrieving databases: " . mysqli_error($con));
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate match ID
    $matchId = $_POST['matchid'];
   
    if (isMatchIdValid($matchId, $existingDatabases)) {
        header("Location: show.php?database=$matchId");
    } else {
        echo "<p style='color: red;'>Please Enter Correct match ID and This ID Don't exist.</p>";}}
?>


<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <title>Student CRUD</title>
</head>
<body>
  
    <div class="container mt-4">

       

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Match Details
                        </h4>
                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
      <br>
      <label for="matchid" >Match id:</label>
<input type="number" id="matchid" name="matchid"  required>
	  <input type="submit" value="View Score" class="btn btn-danger btn-sm">
    </form>
                    </div>
                    <div class="card-body">

                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>MATCH ID</th>
                                    <th>MATCH TEAMS</th>
                                    <th>VENUE</th>
                                    <th>OVERS</th>
                                    <th>TOSS</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php while ($row = mysqli_fetch_assoc($result)) {
                              $database=$row['Database'];
                              $dbConnection=mysqli_connect("localhost", "root", "","$database");
                              if ($dbConnection) {
                                $q1 = "SELECT * FROM match_info";
                                $result1 = mysqli_query($dbConnection, $q1);
                        
                                // Check if the query was executed successfully
                                if ($result1) {
                                    while ($row1 = mysqli_fetch_assoc($result1)) {
                                        // Output table rows
                                        ?>
                                        <tr>
                                            <td><?php echo $database ?></td>
                                            <td><?php echo $row1['team_a'] . " vs " . $row1['team_b'] ?></td>
                                            <td><?php echo $row1['venue'] ?></td>
                                            <td><?php echo $row1['over_count'] ?></td>
                                            <td><?php echo $row1['toss'] ?></td>
                                            <td>
                                                <form>
                                                    <button formaction="/homepage/viewer/show.php"  type="submit" name="database" class="btn btn-danger btn-sm" value="<?php echo $database ?>">View Score</button>
                                                </form>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                } }
                                          } ?><br>  
                                
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>
                                  </body>
      </html>