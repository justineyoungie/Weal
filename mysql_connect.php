<?php

//$dbc is just a variable for the credentials of the DB
//mysqli_connect method yan tapos format niyan is ('localhost','username','password','dbname')
//yung !$dbc ibig sabihin lang pag mali credentials na input para di maaccess yung DB
$dbc=mysqli_connect('localhost','root',null,'wealdb');
// server address, username of account, password of account, name of database
if (!$dbc) {
 die('Could not connect: '.mysql_error());
}

?>