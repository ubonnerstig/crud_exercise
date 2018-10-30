<?php
session_start();

require '../includes/database_connection.php'; 

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

	$statement = $pdo->prepare(
		"SELECT product_id, quantity
		FROM cart
		WHERE user_id = :user_id");
		$statement->execute([
		":user_id"     => $_SESSION["id"]
		]);
		$saved_cart = $statement->fetchAll(PDO::FETCH_ASSOC);
		
		$statement = $pdo->prepare(
		"SELECT product_id, quantity
		FROM cart
		WHERE user_id = 0");
		$statement->execute();
		$unlogged_cart = $statement->fetchAll(PDO::FETCH_ASSOC);

	if(count($unlogged_cart) === 0){

		header('Location: ../index.php');	
	}

	for($i=0;$i<count($saved_cart); $i++){

		foreach($unlogged_cart as $product){

			if($saved_cart[$i]['product_id'] == $product['product_id']){

				$quantity = $saved_cart[$i]['quantity'] + $product['quantity'];

				$statement = $pdo->prepare(
					"UPDATE cart 
					SET quantity = :quantity
					WHERE product_id = :product_id AND user_id = :user_id;
					
					DELETE FROM cart WHERE product_id = :product_id AND user_id = 0"
					);
		
					$statement->execute([
					":quantity"     => $quantity,
					":product_id"   => $saved_cart[$i]['product_id'],
					":user_id"     => $_SESSION["id"]
					]);	

			}		
		}
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
	header('Location: ../index.php?login_failed=true');
}

?>