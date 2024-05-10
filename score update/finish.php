<?php
$databaseName = isset($_GET['database']) ? $_GET['database'] : null;

header("Location: complete.php?database=$databaseName");
?>