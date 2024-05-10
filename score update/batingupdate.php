<?php
$databaseName = isset($_GET['database']) ? $_GET['database'] : null;
$battingTeam = isset($_GET['battingteam']) ? $_GET['battingteam'] : null;
$bowlingteam = isset($_GET['bowlingteam']) ? $_GET['bowlingteam'] : null;

$dbConnection = mysqli_connect("localhost", "root", "", $databaseName) or die("Connection failed");

$querytotal = "CREATE TABLE " . $battingTeam . "_batingtotal" . " (
    total_runs INT,
    total_fours INT,
    total_sixes INT,
    total_extras INT,
    total_over FLOAT,
    total_wicket INT
)";
$q0=mysqli_query($dbConnection, $querytotal);

$qcheck = "SELECT MAX(total_over) AS total_over FROM " . $battingTeam . "_batingtotal;";
$check = mysqli_query($dbConnection, $qcheck);
$row101 = mysqli_fetch_array($check);
$overcur = $row101["total_over"];

$qmatch = "SELECT over_count FROM match_info;";
 $check1 = mysqli_query($dbConnection, $qmatch);
 $row102 = mysqli_fetch_array($check1);
 $overfixed = $row102["over_count"];

if ($overcur < $overfixed) {


$playername = $_POST['batername'];
$fourRuns = $_POST['bating_4s'];
$sixRuns = $_POST['bating_6s'];
$otherRuns = $_POST['bating_run'];
$status = $_POST['bating_status'];
$Extra = $_POST['bating_extra'];

$q1="select run,ball,4s,6s,bating_status,extra from $battingTeam  where player_name = '$playername';";
$result = mysqli_query($dbConnection, $q1);
$row = mysqli_fetch_assoc($result);
$previousRuns = $row['run'];
$previousball = $row['ball'];
$previous4 = $row['4s'];
$previous6 = $row['6s'];
$previousstatus = $row['bating_status'];
$previousextra= $row['extra'];

if($Extra!=0){
   $newextra= $previousextra+$Extra;
   $newrun=$previousRuns;
    $newfours=$previous4;
    $newsix=$previous6;
    $newstatus=$status;
    $newball=$previousball;
}elseif ($fourRuns==1){
    $newrun=$previousRuns+4;
    $newfours=$previous4+1;
    $newsix=$previous6+0;
    $newstatus=$status;
    $newball=$previousball+1;
    $newextra= $previousextra;
}elseif ($sixRuns == 1) { 
    $newrun = $previousRuns + 6;
    $newfours = $previous4 + 0;
    $newsix = $previous6 + 1;
    $newstatus = $status;
    $newball = $previousball + 1;
    $newextra= $previousextra;
}else{
    $newrun = $previousRuns + $otherRuns;
    $newfours = $previous4 + 0;
    $newsix = $previous6 + 0;
    $newstatus = $status;
    $newball = $previousball + 1;
    $newextra= $previousextra;
}

$query1 = "UPDATE $battingTeam SET 4s = '$newfours', 6s = '$newsix', run = '$newrun', bating_status = '$status',ball='$newball',extra='$newextra' where player_name = '$playername';";
$updateResult = mysqli_query($dbConnection, $query1);

$q11 = "SELECT SUM(run) AS total_runs FROM $battingTeam;";
$updateResult = mysqli_query($dbConnection, $q11);
$row = mysqli_fetch_array($updateResult);
$total_run = $row["total_runs"]; 

$q12 = "SELECT SUM(4s) AS total_4s FROM $battingTeam;";
$update4s = mysqli_query($dbConnection, $q12);
$row1 = mysqli_fetch_array($update4s);
$total_4 = $row1["total_4s"]; 

$q13 = "SELECT SUM(6s) AS total_6s FROM $battingTeam;";
$update6s = mysqli_query($dbConnection, $q13);
$row2 = mysqli_fetch_array($update6s);
$total_6 = $row2["total_6s"]; 

$q14 = "SELECT SUM(extra) AS total_ex FROM $battingTeam;";
$updateex = mysqli_query($dbConnection, $q14);
$row3 = mysqli_fetch_array($updateex);
$total_extra = $row3["total_ex"]; 

$q15 = "SELECT SUM(ball) AS total_b FROM $battingTeam;";
$updateb = mysqli_query($dbConnection, $q15);
$row4 = mysqli_fetch_array($updateb);
$total_ball = $row4["total_b"]; 

$total_overs = floor($total_ball / 6) + (($total_ball % 6) / 10);

$q16 = "SELECT COUNT(*) AS total_wickets FROM $battingTeam WHERE  bating_status LIKE '%Bold%' OR bating_status LIKE '%Catch out%' OR bating_status LIKE '%Run out%';";
$updatew = mysqli_query($dbConnection, $q16);
$row5 = mysqli_fetch_array($updatew);
$total_wickets = $row5["total_wickets"];

$total_run1=$total_extra+$total_run;

$query1 = "INSERT INTO " . $battingTeam . "_batingtotal" . " 
           (total_runs, total_fours, total_sixes, total_extras, total_over, total_wicket) 
           VALUES ('$total_run1', '$total_4', '$total_6', '$total_extra', '$total_overs', '$total_wickets')";
          
 mysqli_query($dbConnection, $query1);
 
 header("Location: scorecaard.php?database=$databaseName");

}
else{
   
    header("Location: scorecaard.php?database=$databaseName"); 
}
 
?>