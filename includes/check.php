<?php

/*
NO HTML
Mission: Spara en användare i databasen
1. Hantera post variabler: $_POST
2. Koppling till databas: PDO
3. Spara användaren i databasen

*/

require '../includes/database.php'; 

// Same value in both $_POST["username] and $suername
$username = $_POST["username"];
$password = $_POST["password"];

// password_hash must always have two arguments
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// $statement can have any variabel name, no whitespacesbetween $pdo and prepare
$statement = $pdo->prepare("INSERT INTO users
	(username, password) VALUES (:username, :password)");

// Execute populates the statement and runs it
$statement->execute(
	[
		":username" => $username,
		":password" => $hashed_password
	]
);

header('Location: index.php');

?>