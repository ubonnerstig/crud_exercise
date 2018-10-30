<?php
// Calculates sum of cart or order
	function total($cart){
		$sum=0;
		for($i=0;$i<count($cart);$i++){
			$sum+= $cart[$i]["quantity"] * $cart[$i]["price"];		
		}
		return number_format($sum,2);
	}

	//Checks if the function is gonna calculate the total of the cart or the order, depending on if an order is placed or not
	if(!empty($_SESSION['order_id'])){
		$product_array = $order;
	} else {
		$product_array = $cart;
	}
	$sum = total($product_array);


// To add/subtract quantity, and remove products from cart

if(isset($_GET['remove'])){
	$product_id = $_GET['remove'];

	$statement = $pdo->prepare("DELETE FROM cart WHERE product_id = :product_id AND user_id = :user_id");
	$statement->execute([
		":product_id"     => $product_id,
		":user_id"     => $_SESSION['id']
	]);

	header("Location: ?");				
}

if(isset($_GET['plus'])){
	$product_id = $_GET['plus'];

	$statement = $pdo->prepare(
	"UPDATE cart 
	SET quantity = quantity + 1
	WHERE product_id = :product_id AND user_id = :user_id;"
	);

	$statement->execute([
	":product_id"     => $product_id,
	":user_id"     => $_SESSION['id']
	]);

	header("Location: ?");				
}

if(isset($_GET['minus'])){
	$index_number = $_GET['minus'];
	$product_id = $cart[$index_number]["product_id"];

// Checks wether or not there's more than 1 in the cart before subtraction so you dont end upp with 0 qty, removes instead
			
	if($cart[$index_number]["quantity"] > 1){
		$statement = $pdo->prepare(
		"UPDATE cart 
		SET quantity = quantity - 1
		WHERE product_id = :product_id AND user_id = :user_id;"
		);
	
		$statement->execute([
		":product_id"     => $product_id,
		":user_id"     => $_SESSION['id']
		]);

		header("Location: ?");					
	} else {
		$statement = $pdo->prepare("DELETE FROM cart WHERE product_id = :product_id AND user_id = :user_id;");
		$statement->execute([
		":product_id"     => $product_id,
		":user_id"     => $_SESSION['id']
	]);
		header("Location: ?");	
	}			
}

?>