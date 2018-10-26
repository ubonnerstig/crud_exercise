<?php
session_start();

require 'includes/database.php'; 
include 'includes/products.php'; 
include 'includes/functions.php'; 
	

/*
include på headern så att det blri mindre stökigt i korden (den ska ju ändå upprepas i varje html dokument)

kan köra stringreplace på produktnamnen eftersom man inte vill ha mellanrum i koden helst, så kan man namge produkterna med underscore, tex produkt_namn, och sedan byta ut det när det skrivs ut på sidan.

kan köra mt mb (margin top margin bottom) i bootstrap.
om man har bestämt sig för att använda sig av bootsrtap så bör an hålla sig till deras egna css och inte hålla på att skriva över allt. 
dumt att länka in javascript länkarna från bootstrap om man inte tänkt använda sig av dom dåd etta adderar extra tyngd till sidan.
(kanske bra om du faktiskt lär dig flexbox (8  )

Variabelnamn ( i foreach loopar tex) så är det bra med tydliga variabelnamn, så tex inte ha $products as $product, kanske istället $products as $single_product. 

kör require istället för include?
*/
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

	<link rel="stylesheet" type="text/css" href="css/style.css">

</head>
<body>
	<div class="container-fluid">
	
<?php
		include 'includes/cart.php';

	/*	highlight_string("<?php =\n" . var_export($products, true) . ";\n?>"); */
		
?>				
		<header class="row justify-content-start">
							
			<div class="col-12 col-md-3 logo">
				<a href="index.php"><h1 class="gradient-text">LIGHT <i class="fas fa-moon gradient-text"></i> <br>TRAVEL </h1></a>
			</div>
			
			<div class="col-12 col-md-6 logo">
				<?php if(isset($_SESSION['username'])){ ?>
					<h2>Signed in as: <?=$_SESSION['username']?></h2>
					<a class="login-button" href="views/logout.php">Log out</a>
				<?php }else{?>
				<form action="views/login.php" method="POST">
					<input class="login-field" aria-label="Username" placeholder="Username" name="username" type="text">
					<input class="login-field" aria-label="Password" placeholder="Password" name="password" type="password">
					<input class="login-button" type="submit" value="Log in">	
				</form>
				<?php if(isset($_GET["login_failed"])){ ?>
					<p class="error">Username and/or password incorrect</p>
				<?php } ?>
				<a href="views/register.php">Not a member? Register here</a>
				<?php } ?>
				
			</div>
			
		</header>
	
		<main class="wrap">
			<div class="row justify-content-around">
				
				<?php
				//echo date("l");
				for($i=0;$i<count($products);$i++){
					
	
					?>
					<div class="col-12 col-md-5 col-lg-3 vara_card">
						<div class="vara_card_img">
							<img src="data:image/jpeg;base64,<?=base64_encode($products[$i]['image']);?>">					
						</div>
						<h3><?=str_replace("_", " ",$products[$i]['name']);?></h3>
						<p><?=$products[$i]['description'];?></p>				
						
						<form action="views/action_page.php" method="POST" autocomplete="off">
							<input type="hidden" name="id" id="id" value="<?=$products[$i]['id'];?>">					
							<input type="hidden" name="image" id="image" value="data:image/jpeg;base64,<?=base64_encode($products[$i]['image']);?>">
							<input type="hidden" name="name" id="name" value="<?=$products[$i]['name'];?>">
							<input type="hidden" name="price" id="price" value="<?=$products[$i]['price'];?>">
							<p><input class="input-add" type="number" name="quantity" id="quantity" value="1" autocomplete="off">&nbsp;<?php if(isset($old_price[$i])){ echo "<del> " . $old_price[$i] . " </del> "; } echo $products[$i]['price'];?> SEK</p>						
							<button class="add-to-cart" type="submit" value="Add to cart"><i class="fas fa-shopping-cart gradient-text"></i> Add to cart</button>													
						</form>

					</div>
				<?php
				}
				?>

			</div> <!-- end row -->		
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