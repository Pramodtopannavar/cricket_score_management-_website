<?php
$databaseName = isset($_GET['database']) ? $_GET['database'] : null;
$dbConnection = mysqli_connect("localhost", "root", "", $databaseName) or die("Connection failed");

$q11 = "SELECT team_b FROM match_info;";
$result7 = mysqli_query($dbConnection , $q11) or die(mysqli_error($dbConnection));
$row = mysqli_fetch_assoc($result7);
$teamName = $row['team_b'];
$tableName = $teamName . "_batting";
$q10 = "CREATE TABLE IF NOT EXISTS $tableName (
    player_name VARCHAR(20),
	bating_status varchar(20),
	run int,
	ball int,
	4s int,
	6s int,
    extra int
);";
$result6 = mysqli_query($dbConnection , $q10) or die(mysqli_error($dbConnection));
$tableName1 = $teamName . "_bowling";
$q11 = "CREATE TABLE IF NOT EXISTS " . $teamName . "_bowling" . " (
    player_name VARCHAR(20),
	overs float,
	run int,
	wicket int,
	noball int,
	wide int,
    4s int,
    6s int,
    ball int
);";
$result7 = mysqli_query($dbConnection , $q11) or die(mysqli_error($dbConnection));


$player = array(
    $_POST["p_name1"],
    $_POST["p_name2"],
    $_POST["p_name3"],
    $_POST["p_name4"],
    $_POST["p_name5"],
    $_POST["p_name6"],
    $_POST["p_name7"],
    $_POST["p_name8"],
    $_POST["p_name9"],
    $_POST["p_name10"],
    $_POST["p_name11"],
    $_POST["p_name12"]
);

for ($i = 0; $i < 12; $i++) {
    $q11 = "INSERT INTO $tableName ( player_name) VALUES ( '$player[$i]')";
    $result1 = mysqli_query($dbConnection, $q11) or die(mysqli_error($dbConnection));
}
for ($i = 0; $i < 12; $i++) {
    $q12 = "INSERT INTO $tableName1 ( player_name) VALUES ( '$player[$i]')";
    $result1 = mysqli_query($dbConnection, $q12) or die(mysqli_error($dbConnection));
}
$q20="SELECT team_b FROM match_info;";
$result100=mysqli_query($dbConnection,$q20);
$row1=mysqli_fetch_assoc($result100);
header("Location: scorecaard.php?database=$databaseName");
?>


