<?php
session_start();
require '../includes/database.php'; 

	if(isset($_POST)){
		//Checks to see if QTY from post is empty or set to 0, in that case sends back to index
		if(empty($_POST["quantity"]) || $_POST["quantity"] == 0){
			header("Location: ../index.php?");				
		}				
		else {
			$statement = $pdo->prepare("SELECT product_id, name, price, image, quantity FROM cart");
			$statement->execute();
			$cart = $statement->fetchAll(PDO::FETCH_ASSOC);
			/*
			highlight_string("<?php =\n" . var_export($_POST, true) . ";\n?>");

			echo "<br>";

			highlight_string("<?php =\n" . var_export($cart, true) . ";\n?>");
			$_SESSION['cart'] = $cart; */

			//Checks to see if cart is empty, if yes, just add product
			if (count($cart) === 0){
				echo "<br>";
				echo "empty cart";
				$statement = $pdo->prepare(
				"INSERT INTO cart (product_id, name, price, image, quantity)
				VALUES (:product_id, :name, :price, :image, :quantity);"
				);
	
				$statement->execute([
				":product_id"     => $_POST["id"],
				":name"     => $_POST["name"],
				":price"     => $_POST["price"],
				":image"     => $_POST["image"],
				":quantity"     => $_POST["quantity"]
				]);	
				
				if(isset($_SESSION["id"])){
				$statement = $pdo->prepare(
				"UPDATE cart 
				SET user_id = :user_id
				WHERE user_id = 0;"
				);
			
				$statement->execute([
				":user_id"     => $_SESSION["id"]
				]);
				}

				header("Location: ../index.php?");
			}
			else {
				//Checks whether or not a products with the same name exists in cart. If so, add qty
				for($si=0;$si<count($cart); $si++){
					if($_POST["name"] === $cart[$si]["name"]){
					
						$quantity = $cart[$si]["quantity"] + $_POST["quantity"];

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

				//Adds product to cart if product name doesnt already exist
				$statement = $pdo->prepare(
				"INSERT INTO cart (product_id, name, price, image, quantity)
				VALUES (:product_id, :name, :price, :image, :quantity);"
				);
	
				$statement->execute([
				":product_id"     => $_POST["id"],
				":name"     => $_POST["name"],
				":price"     => $_POST["price"],
				":image"     => $_POST["image"],
				":quantity"     => $_POST["quantity"]
				]);	

				if(isset($_SESSION["id"])){
				$statement = $pdo->prepare(
				"UPDATE cart 
				SET user_id = :user_id
				WHERE user_id = 0;"
				);
			
				$statement->execute([
				":user_id"     => $_SESSION["id"]
				]);
				}
				
				header("Location: ../index.php?");
			}
		}
	}
?>