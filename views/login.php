<?php
session_start();

require '../includes/database.php'; 
include '../includes/products.php'; 

$username = $_POST["username"];
$password = $_POST["password"];

$statement = $pdo->prepare("SELECT * FROM users
	WHERE username = :username");

$statement->execute(
	[
		":username" => $username,
	]
);

$fetched_user = $statement->fetch();

$is_password_correct = password_verify($password, $fetched_user["password"]);

if ($is_password_correct){
	$_SESSION["username"] = $fetched_user["username"];
	$_SESSION["id"] = $fetched_user["id"];

	if(count($cart) === 0){

		//header('Location: ../index.php');	
	}

	$statement = $pdo->prepare(
	"UPDATE cart 
	SET user_id = :user_id
	WHERE user_id = 0;"
	);

	$statement->execute([
	":user_id"     => $_SESSION["id"]
	]);

	header('Location: ../index.php');



} else {
	unset($_SESSION["username"]);
	//header('Location: ../index.php?login_failed=true');
}


?>