<?php
// Calculates sum of cart
	function total($cart){
		$sum=0;
		for($i=0;$i<count($cart);$i++){
			$sum+= $cart[$i]["quantity"] * $cart[$i]["price"];		
		}
		return number_format($sum,2);
	}
	$sum = total($cart);


// To add/subtract quantity, and remove products from cart

if(isset($_GET['remove'])){
	$product_id = $_GET['remove'];

	$statement = $pdo->prepare("DELETE FROM cart WHERE product_id = :product_id");
	$statement->execute([
		":product_id"     => $product_id,
	]);

	header("Location: ?");				
}

if(isset($_GET['plus'])){
	$product_id = $_GET['plus'];

	$statement = $pdo->prepare(
	"UPDATE cart 
	SET quantity = quantity + 1
	WHERE product_id = :product_id;"
	);

	$statement->execute([
	":product_id"     => $product_id
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
		WHERE product_id = :product_id;"
		);
	
		$statement->execute([
		":product_id"     => $product_id
		]);

		header("Location: ?");					
	} else {
		$statement = $pdo->prepare("DELETE FROM cart WHERE product_id = :product_id");
		$statement->execute([
		":product_id"     => $product_id,
	]);
		header("Location: ?");	
	}			
}

?>