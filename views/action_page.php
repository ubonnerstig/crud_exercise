<?php
session_start();
require '../includes/database.php'; 

if(isset($_POST)){
	//Checks to see if QTY from post is empty or set to 0, in that case sends back to index
	if(empty($_POST["quantity"]) || $_POST["quantity"] == 0){
		header("Location: ../index.php?");				
	} else {
		$statement = $pdo->prepare("SELECT product_id, user_id, name, price, quantity FROM cart");
		$statement->execute();
		$cart = $statement->fetchAll(PDO::FETCH_ASSOC);
		/*
		highlight_string("<?php =\n" . var_export($_POST, true) . ";\n?>");

		echo "<br>";

		highlight_string("<?php =\n" . var_export($cart, true) . ";\n?>");
		//$_SESSION['cart'] = $cart; 
*/
			//Checks whether or not a products with the same name exists in cart. If so, add qty
			for($i=0;$i<count($cart); $i++){
				if($_POST["name"] == $cart[$i]["name"] && $_SESSION["id"] == $cart[$i]["user_id"]){
				
					$quantity = $cart[$i]["quantity"] + $_POST["quantity"];

					$statement = $pdo->prepare(
					"UPDATE cart 
					SET quantity = :quantity
					WHERE name = :name;"
					);
		
					$statement->execute([
					":quantity"     => $quantity,
					":name"     => $_POST["name"]
					]);	

					header("Location: ../index.php?");
					return;
				} 
			}
		//If no product has the same name AND same user_id, add a new product to cart for this user
		$statement = $pdo->prepare(
		"INSERT INTO cart (product_id, user_id, name, price, quantity)
		VALUES (:product_id, :user_id, :name, :price, :quantity);"
		);

		$statement->execute([
		":product_id"     => $_POST["id"],
		":user_id"     => $_SESSION["id"],
		":name"     => $_POST["name"],
		":price"     => $_POST["price"],
		":quantity"     => $_POST["quantity"]
		]);	

		header("Location: ../index.php?");		
	} 
}

?>