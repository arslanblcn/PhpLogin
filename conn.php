<?php 
$server = "localhost";
$db_user = "elizabeth";
$db_passwd = "elizabeth";
$db_name = "cengbox";

$conn = new mysqli($server, $db_user, $db_passwd, $db_name);

if($conn->connect_error){
	die ("Connection Failed!" . connect_error());
}


?>
