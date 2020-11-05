<?php 
session_start();
include "conn.php";

function validate($data){
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}

if(isset($_POST['username']) && isset($_POST['passwd'])){

	$username = validate($_POST['username']);
	$passwd = validate($_POST['passwd']);
	$passwd = md5($passwd);

	$query=$conn->prepare("SELECT * FROM users WHERE email= ?");
	$query->bind_param("s", $_POST['username']);
	$query->execute();
	$result = $query->get_result();
	$users = $result->fetch_assoc();

	if($users['email'] === $username && $users['passwd'] === $passwd){
		$_SESSION['name'] = $users['name'];
		header("Location: home.php");
		exit();
	} else {
		header("Location: index.php?error=Incorret username or password");
		exit();
	}
} else {
	header("Location: index.php");
	exit();
}
?>