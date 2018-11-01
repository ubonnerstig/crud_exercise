<?php
session_start();

require '../includes/database_connection.php'; 
include '../includes/db_fetches.php'; 
include '../includes/functions.php'; 
	
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
		<?php 
		include '../includes/cart.php';
		include '../includes/header.php';
		?>	
		<main class="wrap">
			<div class="row justify-content-around">
				<?php if(empty($_SESSION['order_id'])){ ?>

					<div class="col-12">
						<h2>Your cart is empty!</h2>
					</div>

				<?php } else { ?>

					<div class="col-12">
						<h2>Thanks for your order, <?=$user_info[0]['firstname']?>!</h2>
						<p>Your order number is <b><?=$order[0]["order_id"]?></b>. Below you can find your order details.</p>
					</div>
					
					<div class="col-12 col-md-6">
						<h2>Shipment information</h2>
						<p>
							<?=$user_info[0]['firstname'] . " " . $user_info[0]['lastname'] ?><br>
							<?=$user_info[0]['street']?><br>
							<?=$user_info[0]['postal'] . " " . $user_info[0]['city'] ?>
						</p>
						<p>
							<b>Mail:</b> <?=$user_info[0]['email']?><br>
							<b>Phone:</b> <?=$user_info[0]['phone']?><br>
						</p>
					</div>

					<div class="col-12 col-md-6">
						<h2>Purchase</h2>				
						<?php for($i=0;$i<count($order);$i++){ ?>
							<div class="row justify-content-around checkout_cart">
								<div class="list_image col-2 col-md-2">
									<img src="data:image/jpeg;base64,<?=base64_encode($order[$i]['image']);?>">
								</div>

								<h3 class="col-3 col-md-3">
									<?=str_replace("_", " ",$order[$i]["product_name"]);?>
								</h3>

								<p class="col-2 col-md-2"><b>Qty:</b>
									<?=$order[$i]['quantity'];?>
								</p>

								<p class="col-4"><b>Price:</b><br>
									<?=number_format($order[$i]['price'],2);?> SEK/st <br> 
									<?=number_format($order[$i]['price']*$order[$i]['quantity'],2);?> SEK/<?=$order[$i]['quantity'];?>st
								</p>
							</div>
						
						<?php } ?>
						<div class="col-12">
							<p>
								<b>Total:</b>
								<?=$sum;?> SEK
							</p>
						</div>
					</div> 
				<?php }
				/* Makes sure order_id is empty after user leaves the page, both so the 'total' function starts calculating total from cart again, 
				and so the user cant go back to the order confirmation via url.*/
				unset($_SESSION['order_id']);
				?>
				
			</div><!-- row justify-content-around -->
		</main> <!-- end wrap -->
		<footer class="row"> </footer>
	</div> <!-- end container-fluid -->

	<!-- Optional JavaScript -->
	<!-- jQuery first, then Popper.js, then Bootstrap JS -->
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</body>
</html>