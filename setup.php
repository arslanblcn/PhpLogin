<?php
require_once "conn.php";
$createQuery = "CREATE TABLE users (id INT(3) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
		name VARCHAR(30) NOT NULL, 
		email VARCHAR(30) NOT NULL, 
		passwd VARCHAR(32) NOT NULL)";

if($conn->query($createQuery) === TRUE){
	echo "[+] Users table created successfully \n";
} else {
	echo "[-] Error when creating table \n" . $conn->error;
}

$passwd = md5("Sup3rS3cr3tPasswd!");
$insertQuery = "INSERT INTO users (name, email, passwd) VALUES ('John Doe', 'johndoe@example.com', '$passwd'),
				('Elizabeth Sky', 'elizabethsky@example.com', '$passwd')";

if ($conn->query($insertQuery) === TRUE) {
	echo "[+] Values added successfully \n";
} else {
	echo "[-] Error when inserting values \n" . $conn->error;
}
?>