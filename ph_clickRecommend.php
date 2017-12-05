<?php
    session_start();
    require_once("mysql_connect.php");
?>
<html>
    <form action="ph_generateNeededMaterials.php" method="post">
        <input type="submit" value="Generate">
    </form>
</html>