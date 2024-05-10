<?php
$databaseName = isset($_GET['database']) ? $_GET['database'] : null;
$dbConnection = mysqli_connect("localhost", "root", "", $databaseName) or die("Connection failed");

$querytoss="select toss from match_info;";
$res=mysqli_query($dbConnection, $querytoss);
$row=mysqli_fetch_assoc($res);
 $tossResult =$row['toss'];

$queryelected="select elected from match_info;";
$res1=mysqli_query($dbConnection, $queryelected);
$row1=mysqli_fetch_assoc($res1);
 $tosselected =$row1['elected'];

$queryteam1="select team_a from match_info;";
$res2=mysqli_query($dbConnection, $queryteam1);
$row2=mysqli_fetch_assoc($res2);
 $team1 =$row2['team_a'];

$queryteam2="select team_b from match_info;";
$res3=mysqli_query($dbConnection, $queryteam2);
$row3=mysqli_fetch_assoc($res3);
 $team2 =$row3['team_b'];

$battingTeam = '';
$bowlingTeam='';
if ($tossResult === $team1) {
    $battingTeam = ($tosselected === "Bat") ? $team1 : $team2;
    $bowlingTeam = ($tosselected === "Bowl") ? $team1 : $team2;
} elseif ($tossResult === $team2) {
   $battingTeam = ($tosselected === "Bat") ? $team2 : $team1;
   $bowlingTeam = ($tosselected === "Bowl") ? $team2 : $team1;
}

$batting_team = $battingTeam . "_batting";
$queryplayername="select player_name from $batting_team;";
$res5=mysqli_query($dbConnection, $queryplayername);



$bowling_team = $bowlingTeam . "_bowling";
$queryplayername1="select player_name from $bowling_team;";
$res6=mysqli_query($dbConnection, $queryplayername1);

$query10 = "SELECT player_name, bating_status, run, ball, 4s, 6s FROM $batting_team WHERE run IS NOT NULL;";
$res8=mysqli_query($dbConnection, $query10);

$query101="SELECT player_name,overs,run,wicket,noball,wide from $bowling_team WHERE run IS NOT NULL;";
$res9=mysqli_query($dbConnection, $query101);

$querytotal = "CREATE TABLE " . $battingTeam . "_batingtotal" . " (
  total_runs INT,
  total_fours INT,
  total_sixes INT,
  total_extras INT,
  total_over FLOAT,
  total_wicket INT
)";
$q0=mysqli_query($dbConnection, $querytotal);

$query111 = "SELECT total_runs, total_fours, total_sixes, total_wicket, total_over, total_extras FROM " . $batting_team . "_batingtotal ORDER BY total_over DESC,total_extras Desc LIMIT 1;";

$res10=mysqli_query($dbConnection, $query111);



?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css" />
    <!-- favicon -->
    <link rel="shortcut icon" href="../../../../images/favicon/circle-cropped.png" type="image/x-icon">
    <!-- jquary -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- fafa icons -->
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"
    />
    <link
      rel="stylesheet"
      href="path/to/font-awesome/css/font-awesome.min.css"
    />
    <!-- bootstrap -->
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6"
      crossorigin="anonymous"
    />
    
</head>
<body>
     <!-- START MAIN CONTENT -->
     
      <div id="first_innings">
      
      <div class="page_title_section">
        <p class="cricket_ti"><i>First Innings</i></p>
        
      </div><br>


      
         
<!-- PREVIEW -->
        <div class="first_team_score_preview">
          <div id="first_table_rowid" class="table_row">
            <div id="first_table_column1id" class="table_column1">BATSMAN</div>
            <div id="first_score_headingid" class="score_headingid">
            <div id="first_table_column2id" class="table_column2">  </div>
              <div id="first_table_column2id" class="table_column2">R</div>
              <div id="first_table_column2id" class="table_column2">B</div>
              <div id="first_table_column2id" class="table_column2">4s</div>
              <div id="first_table_column2id" class="table_column2">6s</div>
            </div>
          </div>

          <div
            class="hr_line_for_scoreboard"
            style="border: 1px solid gray"
          ></div>
          <?php while ($row10 = mysqli_fetch_assoc($res8)) {?>
          <div class="table_row">
                <div class="table_column1">
                    <p class="p_nm"><?php echo $row10['player_name']?></p>
                    
                </div>
                <div class="score_headingid">
                <div class='table_column2'><?php echo $row10['bating_status']?></div>
                    <div class='table_column2'><?php echo $row10['run']?></div>
                    <div class='table_column2'><?php echo $row10['ball']?></div>
                    <div class='table_column2'><?php echo $row10['4s']?></div>
                    <div class='table_column2'><?php echo $row10['6s']?></div>
                    
                </div></div><?php } ?><br>

                
          
          <div class="table_row">
                <div class="table_column1">
                    <p class="p_nm">Total Runs</p>
                    
                </div>
                <div class="score_headingid">
                    <div class='table_column2'>W</div>
                    <div class='table_column2'>O</div>
                    <div class='table_column2'>4s</div>
                    <div class='table_column2'>6s</div>
                    <div class='table_column2'>Extra</div>
                    
                </div></div>
                <div
            class="hr_line_for_scoreboard"
            style="border: 1px solid gray"
          ></div>

          <?php if (is_object($res10)) {
          if(mysqli_num_rows($res10) > 0) {
          while ($row200 = mysqli_fetch_assoc($res10)) {
            ?>
          <div class="table_row">
                <div class="table_column1">
                    <p class="p_nm"><?php echo $row200['total_runs']?></p>
                    
                </div>
                <div class="score_headingid">
                <div class='table_column2'><?php echo $row200['total_wicket']?></div>
                    <div class='table_column2'><?php echo $row200['total_over']?></div>
                    <div class='table_column2'><?php echo $row200['total_fours']?></div>
                    <div class='table_column2'><?php echo $row200['total_sixes']?></div>
                    <div class='table_column2'><?php echo $row200['total_extras']?></div>
                    
                </div></div><?php } } } ?><br>
            

          
        </div>

        <div class="first_team_score_preview2">
            <div id="first_table_rowid" class="table_row">
              <div id="first_table_column1id" class="table_column1">BOWLER</div>
              <div id="first_score_headingid" class="score_headingid">
                <div id="first_table_column2id" class="table_column2">O</div>
                <div id="first_table_column2id" class="table_column2">R</div>
                <div id="first_table_column2id" class="table_column2">W</div>
                <div id="first_table_column2id" class="table_column2">NB</div>
                <div id="first_table_column2id" class="table_column2">WD</div>
              </div>
            </div>

            <div
              class="hr_line_for_scoreboard"
              style="border: 1px solid gray"
            ></div>
            <!-- TABLE ROW -->
            <?php while ($row11 = mysqli_fetch_assoc($res9)) {?>
             <div class="table_row">
                <div class="table_column1">
                    <p class="p_nm"><?php echo $row11['player_name']?></p>
                    
                </div>
                <div class="score_headingid">
                    <div class='table_column2'><?php echo $row11['overs']?></div>
                    <div class='table_column2'><?php echo $row11['run']?></div>
                    <div class='table_column2'><?php echo $row11['wicket']?></div>
                    <div class='table_column2'><?php echo $row11['noball']?></div>
                    <div class='table_column2'><?php echo $row11['wide']?></div>
                </div>

            </div> <?php } ?>
          </div>
          <form action="show2.php?database=<?php echo $databaseName ?>" method="post" class="centered-form">
    <input id="saveForm" class="button_text styled-button" type="submit" name="submit" value="Second Innings" />
</form>
         
      </div>
      </div>
      



    

</body>
</html>