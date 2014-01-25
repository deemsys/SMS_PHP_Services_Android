<?php
$dbhost							= "localhost:3306";
$dbuser							= "root";
$dbpass							= "";
$dbname							= "deemsyspro_deem";

$conn = mysql_connect($dbhost, $dbuser, $dbpass) or die ("Error connecting to database");
echo $conn;
mysql_select_db($dbname);
?>