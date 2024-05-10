<?php
$databaseName = isset($_GET['database']) ? $_GET['database'] : null;
header("Location: secondinings.php?database=$databaseName");
?>