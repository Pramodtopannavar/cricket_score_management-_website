<?php
$databaseName = isset($_GET['database']) ? $_GET['database'] : null;
header("Location: scorecaard.php?database=$databaseName");
?>