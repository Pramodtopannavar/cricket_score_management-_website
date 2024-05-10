<?php
$databaseName = isset($_GET['database']) ? $_GET['database'] : null;
$bowlingteam = isset($_GET['bowlingteam']) ? $_GET['bowlingteam'] : null;
$battingTeam = isset($_GET['battingteam']) ? $_GET['battingteam'] : null;

$dbConnection = mysqli_connect("localhost", "root", "", $databaseName) or die("Connection failed");

$qcheck = "SELECT SUM(overs) AS total_over2 FROM $bowlingteam;";
 $updateb = mysqli_query($dbConnection, $qcheck);
 $row101 = mysqli_fetch_array($updateb);
 $overcur = $row101["total_over2"];
 echo $overcur."/t";

$qmatch = "SELECT over_count FROM match_info;";
 $check1 = mysqli_query($dbConnection, $qmatch);
 $row102 = mysqli_fetch_array($check1);
 $overfixed = $row102["over_count"];
 echo $overfixed."/t";

if ($overcur < $overfixed) {


$playername = $_POST['bowlername'];
$noball = $_POST['bowlernoball'];
$wideball = $_POST['bowlerwideball'];
$wicket = $_POST['bowlerwicket'];
$foures = $_POST['bowler4'];
$sixes = $_POST['bowler6'];
$runs = $_POST['bowlerrun'];

$q1="select overs,run,wicket,noball,wide,ball,4s,6s from $bowlingteam where player_name = '$playername';";
$result = mysqli_query($dbConnection, $q1);
$row = mysqli_fetch_assoc($result);
$previousovers = $row['overs'];
$previousRuns = $row['run'];
$previouswickets = $row['wicket'];
$previousnoballs = $row['noball'];
$previouswides = $row['wide'];
$previousballs = $row['ball'];
$previous4 = $row['4s'];
$previous6 = $row['6s'];


if($wideball==1 && $runs!=0){
    $newwideball=$previouswides+1;
    $newruns=$previousRuns+1+$runs;
    $newwicket=$previouswickets;
    $newnoball=$previousnoballs;
    $newfours=$previous4;
    $newsixes=$previous6;
    $newballs=$previousballs;
    $newover=$previousovers;

}elseif($wideball== 1 && $foures== 1 ){
    $newwideball=$previouswides+1;
    $newruns=$previousRuns+1+4;
    $newwicket=$previouswickets;
    $newnoball=$previousnoballs;
    $newfours=$previous4+1;
    $newsixes=$previous6;
    $newballs=$previousballs;
    $newover=$previousovers;
}elseif($wideball== 1 && $wicket== 1 ){
    $newwideball=$previouswides+1;
    $newruns=$previousRuns+1;
    $newwicket=$previouswickets+1;
    $newnoball=$previousnoballs;
    $newfours=$previous4;
    $newsixes=$previous6;
    $newballs=$previousballs;
    $newover=$previousovers;
}elseif($wideball== 1){
    $newwideball=$previouswides+1;
    $newruns=$previousRuns+1;
    $newwicket=$previouswickets;
    $newnoball=$previousnoballs;
    $newfours=$previous4;
    $newsixes=$previous6;
    $newballs=$previousballs;
    $newover=$previousovers;
}elseif($noball==1 && $runs!= 0){
    $newnoball=$previousnoballs+ 1;
    $newruns=$previousRuns+1+$runs;
    $newwideball=$previouswides;
    $newwicket=$previouswickets;
    $newfours=$previous4;
    $newsixes=$previous6;
    $newballs=$previousballs;
    $newover=$previousovers;
}elseif($noball==1 && $foures== 1){
    $newnoball=$previousnoballs+ 1;
    $newruns=$previousRuns+1+4;
    $newwideball=$previouswides;
    $newwicket=$previouswickets;
    $newfours=$previous4+1;
    $newsixes=$previous6;
    $newballs=$previousballs;
    $newover=$previousovers;
}elseif($noball==1 && $sixes==1){
    $newnoball=$previousnoballs+ 1;
    $newruns=$previousRuns+1+6;
    $newwideball=$previouswides;
    $newwicket=$previouswickets;
    $newfours=$previous4;
    $newsixes=$previous6+1;
    $newballs=$previousballs;
    $newover=$previousovers;
}elseif($noball==1){
    $newnoball=$previousnoballs+ 1;
    $newruns=$previousRuns+1;
    $newwideball=$previouswides;
    $newwicket=$previouswickets;
    $newfours=$previous4;
    $newsixes=$previous6;
    $newballs=$previousballs;
    $newover=$previousovers;
}elseif($wicket==1){
    $newwicket=$previouswickets+1;
    $newballs=$previousballs+1;
    $newruns=$previousRuns;
    $newwideball=$previouswides;
    $newfours=$previous4;
    $newsixes=$previous6;
    $newnoball=$previousnoballs;
    $newover=floor($newballs / 6) + (($newballs % 6) / 10);
}elseif($foures==1){
    $newfours=$previous4+1;
    $newruns=$previousRuns+4;
    $newballs=$previousballs+1;
    $newwicket=$previouswickets;
    $newwideball=$previouswides;
    $newsixes=$previous6;
    $newnoball=$previousnoballs;
    $newover=floor($newballs / 6) + (($newballs % 6) / 10);
}elseif($sixes==1){
    $newfours=$previous4;
    $newruns=$previousRuns+6;
    $newballs=$previousballs+1;
    $newwicket=$previouswickets;
    $newwideball=$previouswides;
    $newsixes=$previous6+1;
    $newnoball=$previousnoballs;
    $newover=floor($newballs / 6) + (($newballs % 6) / 10);
}else{
    $newfours=$previous4;
    $newruns=$previousRuns+$runs;
    $newballs=$previousballs+1;
    $newwicket=$previouswickets;
    $newwideball=$previouswides;
    $newsixes=$previous6;
    $newnoball=$previousnoballs;
    $newover=floor($newballs / 6) + (($newballs % 6) / 10);
}

$query1 = "UPDATE $bowlingteam 
           SET overs = '$newover', 
               run = '$newruns', 
               wicket = '$newwicket', 
               noball = '$newnoball',
               ball = '$newballs',
               wide = '$newwideball',
               4s = '$newfours',
               6s = '$newsixes'
           WHERE player_name = '$playername';";

$updateResult = mysqli_query($dbConnection, $query1);


header("Location: scorecaard.php?database=$databaseName");
}
else{
    
    header("Location: scorecaard.php?database=$databaseName");

}

?>