<?php
// Calculates price depending on which day it is (and also depending on original price if its Friday)
function priceCalculator($price){
	if(date("l") === "Monday"){
		return number_format($price*0.5,2);

	} elseif(date("l") === "Wednesday") {
		return number_format($price*1.1,2);

	} elseif(date("l") === "Friday" && $price > 200) {
		return number_format($price-20,2);
	}
	return $price;
}

// Calculates sum of cart or order
function total($cart){
	$sum=0;

	for($i=0;$i<count($cart);$i++){
		
		/*Since the price might change depending on which day it is, and a cart is saved permamentely on a user i didnt wanna send
		the calculated price to the cart database, since the user might checkout on a day when that price isnt valid. 
		Therefor we wanna calculate the price when we check the sum in the cart so it's up to date, but when we check the sum for
		an order we want to calculate the actual prices we've sent to the database*/
		if(!empty($_SESSION['order_id'])){
			$price = $cart[$i]["price"];
		} else {
			$price = priceCalculator($cart[$i]["price"]);
		}
		$sum+= $cart[$i]["quantity"] * $price;		
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


// Removes product from cart
if(isset($_GET['remove'])){
	$product_id = $_GET['remove'];

	$statement = $pdo->prepare("DELETE FROM cart WHERE product_id = :product_id AND user_id = :user_id");
	$statement->execute([
		":product_id"     => $product_id,
		":user_id"     => $_SESSION['id']
	]);

	header("Location: ?");				
}

// Increase product quantity by one
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

// Decrease product quantity by one
if(isset($_GET['minus'])){
	$index_number = $_GET['minus'];
	$product_id = $cart[$index_number]["product_id"];

	// First checks wether or not there's more than 1 in the cart before subtraction so you dont end upp with 0 qty, removes instead		
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