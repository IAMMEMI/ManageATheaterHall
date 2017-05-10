<?php
$servername = "localhost";
$username = "Memi";
$password = "PalermO93";
$dbname = "ingsw";

$connect = @mysql_connect($servername, $username, $password) or die (mysql_error());
@mysql_select_db($dbname) or die (mysql_error());

?>