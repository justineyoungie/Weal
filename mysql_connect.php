<?php
$dbc=mysqli_connect('localhost','root',NULL,'wealdb');
// server address, username of account, password of account, name of database
if (!$dbc) {
 die('Could not connect: '.mysql_error());
}

// require_once('mysql_connect.php');
?>