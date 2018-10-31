<?php
session_start();
require 'includes/database_connection.php'; 
include 'includes/db_fetches.php'; 
include 'includes/functions.php'; 	
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
	<div class="row sticky-cart justify-content-end">
	<div class="col-12 col-md-6 col-lg-5 dropdown_wrap">
		<nav class="cart justify-content-end">
			<button class="cart-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle cart">
				<i class="fas fa-shopping-cart gradient-text"></i><p class="d-none d-md-inline">&ensp; SHOPPING CART</p>
			</button>

			<div class="collapse navbar-collapse" id="navbarSupportedContent">
				<ul class="cart-nav">

					<?php if (count($cart) === 0){ ?>
						<li>	
							<h2>Your cart is empty!</h2>
						</li>
					<?php } else {
						for($i=0;$i<count($cart);$i++){	?>

						<li class="row justify-content-between align-items-center cart_list">	
							<div class="list_image">
								<img src="data:image/jpeg;base64,<?=base64_encode($cart[$i]['image']);?>">	
							</div>

							<h3 class="col-3"><?=str_replace("_", " ",$cart[$i]["name"]);?></h3>

							<p class="col-3"><b>Price:</b> <br><?=priceCalculator($cart[$i]["price"]);?> SEK/st</p>

							<p class="col-2">
								<b>Qty:</b><br>
								<a href="?minus=<?=$i?>"> 
									<i class="fas fa-minus-square"></i>
								</a> 
								<?=$cart[$i]["quantity"];?>
								<a href="?plus=<?=$cart[$i]["product_id"]?>">  
									<i class="fas fa-plus-square"></i>
								</a>
							</p>
							<p class="col-1"><a href="?remove=<?=$cart[$i]["product_id"]?>"><i class="fas fa-times"></i></a></p>
						</li>
						<?php } ?>
						<li class="row justify-content-between align-items-center cart_list">	
							<p class="col-12"><b>Totalt:</b> <?= $sum;?> SEK</p>
						</li>
					<?php } ?>
					<li class="nav-item">
						<a class="nav-link checkout" href="views/checkout.php">CHECKOUT</a>
					</li>
				</ul>
			</div>
		</nav>
	</div>
</div>				
		<header class="row justify-content-between">						
			<div class="col-12 col-md-6 logo">
				<a href="index.php"><h1 class="gradient-text">LIGHT <i class="fas fa-moon gradient-text"></i> <br>TRAVEL </h1></a>
			</div>

			<div class="col-12 col-md-3 login-wrap">
				<div class="dropdown login">
					<button class="btn btn-secondary dropdown-toggle" aria_label="Log in" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						<i class="fas fa-user"></i>
					</button>
					<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
						<?php if(isset($_SESSION['username'])){ ?>
							<p class="dropdown-item"><b>Signed in as:</b><br> <?=$_SESSION['username']?></p>
							<a class="login-button mx-4 my-3" href="views/logout.php">Log out</a>
						<?php } else {?>
							<form class="px-4 py-3" action="views/login.php" method="POST">
								<div class="form-group">
									<label for="username">Username</label>
									<input class="form-control" aria-label="Username" placeholder="Username" name="username" label="username" type="text">
								</div>
								<div class="form-group">
									<label for="password">Password</label>
									<input class="form-control" aria-label="Password" placeholder="Password" name="password" label="password" type="password">
								</div>
								<input class="login-button" type="submit" value="Sign in">
							</form>
							<?php if(isset($_GET["login_failed"])){ ?>
								<p class="error dropdown-item">Username and/or password incorrect</p>
							<?php } ?>
							<div class="dropdown-divider"></div>
							<a class="dropdown-item" href="views/register.php">New around here? Sign up</a>
						<?php } ?>	
					</div> <!-- end dropdown-menu -->
				</div> <!-- end dropdown login -->
			</div> <!-- end login-wrap -->
		</header>
	
		<main class="wrap">
			<div class="row justify-content-around">	
				<?php
				//echo date("l");
				for($i=0;$i<count($products);$i++){	?>
					<div class="col-12 col-md-5 col-lg-3 vara_card">
						<div class="vara_card_img">
							<img src="data:image/jpeg;base64,<?=base64_encode($products[$i]['image']);?>">					
						</div>
						<h3><?=str_replace("_", " ",$products[$i]['name']);?></h3>
						<p><?=$products[$i]['description'];?></p>				
						
						<form action="views/action_page.php" method="POST" autocomplete="off">
							<input type="hidden" name="id" id="id" value="<?=$products[$i]['id'];?>">
							<input type="hidden" name="name" id="name" value="<?=$products[$i]['name'];?>">
							<input type="hidden" name="price" id="price" value="<?=$products[$i]['price'];?>">
							<p><input class="input-add" type="number" name="quantity" id="quantity" value="1" autocomplete="off">&nbsp;<?php if($products[$i]['price'] != priceCalculator($products[$i]['price'])){ echo "<del> " . $products[$i]['price'] . " </del> "; } echo priceCalculator($products[$i]['price']);?> SEK</p>						
							<button class="add-to-cart" type="submit" value="Add to cart"><i class="fas fa-shopping-cart gradient-text"></i> Add to cart</button>													
						</form>

					</div>
				<?php } ?>

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