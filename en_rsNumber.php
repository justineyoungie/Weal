<?php
    session_start();
    require_once("mysql_connect.php");
    if (isset($_POST['submit'])){
        $_SESSION['rsNumber'] = $_POST['rsNumber'];
        header("Location: http://".$_SERVER['HTTP_HOST'].  dirname($_SERVER['PHP_SELF'])."/en_rsCheckAvailability.php");
    }
?>
<html>
<form method="post">
    <input type="number" name="rsNumber">
    <input type="submit" name="submit">
</form>
</html>