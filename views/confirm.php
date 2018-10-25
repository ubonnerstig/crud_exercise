<?php
session_start();
require '../includes/database.php'; 
include '../includes/products.php'; 
include '../includes/functions.php'; 
include '../includes/formvalidation.php'; 
	
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

	<title>Store</title>

	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">

	<link rel="stylesheet" type="text/css" href="../css/style.css">

</head>
<body>
	<div class="container-fluid">
					
		<header class="row justify-content-start">						
					<div class="col-12 col-md-6 logo">
						<a href="../index.php"><h1 class="gradient-text">LIGHT <i class="fas fa-moon gradient-text"></i> <br>TRAVEL </h1></a>
					</div>
		</header>

		<main class="wrap">

			<div class="row justify-content-around">
			
				<div class="col-12 col-md-6 checkout-form">
					<?php if(isset($_SESSION['username'])){ ?>
					<h2>Shipping information</h2>

					<?php }else{?>
					<h3>Please log in before proceeding to checkout</h3>
					<form action="login.php" method="POST">
						<input class="login-field" aria-label="Username" placeholder="Username" name="username" type="text"><br>
						<input class="login-field" aria-label="Password" placeholder="Password" name="password" type="password"><br>
						<input class="login-button" type="submit" value="Log in">	
					</form>
					<?php }?>
				</div>

				<div class="col-12 col-md-6">
					<h2>Cart</h2>
					<?php 
						if(count($cart) === 0){
							?>
						<h2>Your cart is empty!</h2>				
					<?php 
						}
						else {
							for($i=0;$i<count($cart);$i++){						
							?>
							
					<!-- DET SOM SKICKAS MED FORMULÄRET NÄR MAN LÄGGER SIN ORDER -->
					<input type="hidden" name="count" id="count" value="<?= count($cart);?>" form="order">
					<input type="hidden" name="total" id="total" value="<?=$sum;?>" form="order">
					<input type="hidden" name="<?=$i;?>image" id="image" value="<?=$cart[$i]["image"];?>" form="order">
					<input type="hidden" name="<?=$i;?>name" id="name" value="<?=$cart[$i]["name"];?>" form="order">
					<input type="hidden" name="<?=$i;?>price" id="price" value="<?=$cart[$i]["price"];?>" form="order">
					<input type="hidden" name="<?=$i;?>quantity" id="quantity" value="<?=$cart[$i]["quantity"];?>" form="order">

					<div class="row checkout_cart justify-content-between">
						<div class="list_image col-2 col-md-2">
							<img src="<?=$cart[$i]["image"];?>">
						</div>

						<h3 class="col-3 col-md-4">
							<?=$cart[$i]["name"];?>
						</h3>
						<br>
						<p class="col-2"><b>Price:</b><br>
							<?=$cart[$i]["price"];?> SEK/St</p>

						<p class="col-3"><b>Qty:</b><br>
							<a href="?minus=<?=$i?>">
								<i class="fas fa-minus-square"></i>
							</a>
							<?=$cart[$i]["quantity"];?>
							<a href="?plus=<?=$cart[$i]["product_id"]?>">
								<i class="fas fa-plus-square"></i>
							</a>|
							<a href="?remove=<?=$cart[$i]["product_id"]?>">
								<i class="fas fa-times"></i>
							</a>
						</p>
					</div><!-- end row checkout_cart -->
						<?php }?>											
							<p class="col-12"><b>Totalt:</b>
								<?=$sum;?> SEK
							</p>							
						
						<?php }	?>
													
					</div> <!-- en cart col -->

				<div class="col-12 <?php if(count($cart) === 0 || empty($_SESSION['username'])){ echo "d-none";}?>">
					<input class="checkout" type="submit" value="Place order" form="order">
				</div>
				
			</div><!--end outer row -->

		</main> <!-- end wrap -->
	<footer>		
	</footer>
	
	</div> <!-- end container-fluid -->

	<!-- Optional JavaScript -->
	<!-- jQuery first, then Popper.js, then Bootstrap JS -->
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</body>

</html>