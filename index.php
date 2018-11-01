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
		<?php 
		include 'includes/cart-index.php';
		include 'includes/header-index.php';
		?>				
		<main class="wrap">
			<div class="row justify-content-around">	
				<?php for($i=0;$i<count($products);$i++){ ?>
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
		
		<footer> </footer>
	</div> <!-- end container-fluid -->	
	<!-- Optional JavaScript -->
	<!-- jQuery first, then Popper.js, then Bootstrap JS -->
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>	
</body>
</html>