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
					<h2>Shipping information</h2>
					<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST" id="order">
						<input class="input-style" aria-label="Name" placeholder="Name" id="firstname" name="firstname" type="text">
						<span class="error"><?=$firstnameErr;?></span><br>
						<input class="input-style" aria-label="Surname" id="lastname" name="lastname" type="text" placeholder="Surname">
						<span class="error"><?=$lastnameErr;?></span><br>
						<input class="input-style" aria-label="Street" id="street" name="street" type="text" placeholder="Street">
						<span class="error"><?=$streetErr;?></span><br>
						<input class="input-style" aria-label="Post code" id="postal" name="postal" type="number" size="5" maxlength="5" placeholder="Post code">
						<span class="error"><?=$postalErr;?></span><br>	
						<input class="input-style" aria-label="City" id="city" name="city" type="text" placeholder="City">
						<span class="error"><?=$cityErr;?></span><br>
						<input class="input-style" aria-label="Phone number" id="phone" name="phone" type="number" placeholder="Phone number">
						<span class="error"><?=$phoneErr;?></span><br>
						<input class="input-style" aria-label="E-mail" id="email" name="email" type="email" placeholder="E-mail">
						<span class="error"><?=$emailErr;?></span><br>
														
					</form>
					
				</div>

				<div class="col-12 col-md-6">
					<h2>Cart</h2>
					<?php if(isset($_SESSION["cart"])){
						if(count($_SESSION["cart"]) == 0){
							?>
						<h2>Your cart is empty!</h2>				
					<?php 
						}
						else {
							for($i=0;$i<count($_SESSION["cart"]);$i++){						
							?>
							
					<!-- DET SOM SKICKAS MED FORMULÄRET NÄR MAN LÄGGER SIN ORDER -->
					<input type="hidden" name="count" id="count" value="<?= count($_SESSION["cart"]);?>" form="order">
					<input type="hidden" name="total" id="total" value="<?=$sum;?>" form="order">
					<input type="hidden" name="<?=$i;?>image" id="image" value="<?=$_SESSION["cart"][$i]["image"];?>" form="order">
					<input type="hidden" name="<?=$i;?>name" id="name" value="<?=$_SESSION["cart"][$i]["name"];?>" form="order">
					<input type="hidden" name="<?=$i;?>price" id="price" value="<?=$_SESSION["cart"][$i]["price"];?>" form="order">
					<input type="hidden" name="<?=$i;?>quantity" id="quantity" value="<?=$_SESSION["cart"][$i]["quantity"];?>" form="order">

					<div class="row checkout_cart justify-content-between">
						<div class="list_image col-2 col-md-2">
							<img src="<?=$_SESSION["cart"][$i]["image"];?>">
						</div>

						<h3 class="col-3 col-md-4">
							<?=$_SESSION["cart"][$i]["name"];?>
						</h3>
						<br>
						<p class="col-2"><b>Price:</b><br>
							<?=$_SESSION["cart"][$i]["price"];?> SEK/St</p>

						<p class="col-3"><b>Qty:</b><br>
							<a href="?minus=<?=$i?>">
								<i class="fas fa-minus-square"></i>
							</a>
							<?=$_SESSION["cart"][$i]["quantity"];?>
							<a href="?plus=<?=$i?>">
								<i class="fas fa-plus-square"></i>
							</a>|
							<a href="?remove=<?=$i?>">
								<i class="fas fa-times"></i>
							</a>
						</p>
					</div><!-- end row checkout_cart -->
						<?php }?>											
							<p class="col-12"><b>Totalt:</b>
								<?=$sum;?> SEK
							</p>							
						
						<?php }
					}
					else{?>
						<div class="col-12">
							<h2>Your cart is empty!</h2>
						</div>
						<?php } ?>
													
					</div> <!-- en cart col -->

				<div class="col-12 <?php if(count($_SESSION["cart"]) === 0){ echo "d-none";}?>">
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