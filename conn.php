<?php 
$server = "localhost";
$db_user = "elizabeth";
$db_passwd = "3liz4B3TH2020!Covid19";
$db_name = "cengbox";

$conn = new mysqli($server, $db_user, $db_passwd, $db_name);

if($conn->connect_error){
	die ("Connection Failed!" . connect_error());
}


?>