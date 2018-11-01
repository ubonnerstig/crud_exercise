<?php
session_start();

require '../includes/database_connection.php'; 

//Saves info fromm $_POST in new variables
$username = $_POST["username"];
$password = $_POST["password"];

//Fetching user info from database where the username is the same as sent with $_POST
$statement = $pdo->prepare("SELECT * FROM users
	WHERE username = :username");

$statement->execute(
	[
		":username" => $username,
	]
);
$fetched_user = $statement->fetch();

//Verifying if password is correct
$is_password_correct = password_verify($password, $fetched_user["password"]);

//If password is correct, username and user id get saved into SESSION variables
if ($is_password_correct){
	$_SESSION["username"] = $fetched_user["username"];
	$_SESSION["id"] = $fetched_user["id"];

	//Getting the users previously saved cart from database
	$statement = $pdo->prepare(
	"SELECT product_id, quantity
	FROM cart
	WHERE user_id = :user_id");
	$statement->execute([
	":user_id"     => $_SESSION["id"]
	]);
	$saved_cart = $statement->fetchAll(PDO::FETCH_ASSOC);
	
	//Getting the cart that's been saved to the database, but doesnt belong to an userID
	$statement = $pdo->prepare(
	"SELECT product_id, quantity
	FROM cart
	WHERE user_id = 0");
	$statement->execute();
	$unlogged_cart = $statement->fetchAll(PDO::FETCH_ASSOC);

	//If there is nothing in the unlogged cart, go back to index
	if(count($unlogged_cart) === 0){
		header('Location: ../index.php');	
	}

	//Looping through both the users saved cart and the unlogged cart to see if any products are the same, and if so update the qty and remove the extra row
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

	// If product from unlogged cart doesnt already exist in user cart, update the user id for the item.
	$statement = $pdo->prepare(
	"UPDATE cart 
	SET user_id = :user_id
	WHERE user_id = 0;"
	);

	$statement->execute([
	":user_id"     => $_SESSION["id"]
	]);

	header('Location: ../index.php');

// Is the pasword is wrong, send back with error message
} else {
	header('Location: checkout.php?login_failed=true');
}

?>