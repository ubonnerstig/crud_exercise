<?php
session_start();

if (empty($_SESSION) == false){

			$firstname = $_SESSION['firstname'];
			$lastname = $_SESSION['lastname'];
			$street = $_SESSION['street'];
			$postal = $_SESSION['postal'];
			$city = $_SESSION['city'];
			$phone = $_SESSION['phone'];
			$email = $_SESSION['email'];
			
				
			$count = $_SESSION['count'];
			$total = $_SESSION['total'];
			
			for($i=0;$i<$count;$i++){
								
			$image[$i] = $_SESSION[$i . "image"];
			$name[$i] = $_SESSION[$i . "name"];
			$price[$i] = $_SESSION[$i . "price"];
			$quantity[$i] = $_SESSION[$i . "quantity"];
			}
}

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
		include 'cart.php'
?>

		<header class="row justify-content-start">
			<div class="col-12 col-md-6 logo">
				<a href="index.php">
					<h1 class="gradient-text">LIGHT <i class="fas fa-moon gradient-text"></i> <br>TRAVEL </h1>
				</a>
			</div>
		</header>

		<main class="wrap">

			<div class="row justify-content-around">

				<?php if(empty($_SESSION)==false){ ?>
				<div class="col-12">
					<h2>Thanks for your order, <?=$firstname?>!</h2>
					<p>Below you can find your order details.</p>
				</div>

				<div class="col-12 col-md-6">
					<h2>Shipment information</h2>
					<p>
						<?=$firstname . " " . $lastname ?><br>
						<?=$street?><br>
						<?=$postal . " " . $city ?>
					</p>
					<p>
						Mail: <?=$email?><br>
						Phone: <?=$phone?><br>
					</p>
				</div>


			<div class="col-12 col-md-6">
					<h2>Purchase</h2>				
						<?php 
							for($i=0;$i<$count;$i++){								
							?>
					<div class="row justify-content-around checkout_cart">
						<div class="list_image col-2 col-md-2">
							<img src="<?=$image[$i];?>">
						</div>

						<h3 class="col-3 col-md-3">
							<?=$name[$i];?>
						</h3>

						<p class="col-2 col-md-2"><b>Qty:</b>
							<?=$quantity[$i];?>
						</p>

						<p class="col-4"><b>Price:</b><br>
							<?=$price[$i];?> SEK/st <br> 
							<?=$price[$i]*$quantity[$i];?> SEK/<?=$quantity[$i];?>st
						</p>
					</div>
					
					<?php }?>
					<div class="col-12">
						<p>
							<b>Totalt:</b>
							<?=$total;?> SEK
						</p>
					</div>

						<?php }else { ?>
						
						<div class="col-12">
							<h2>Your cart is empty!</h2>
						</div>
					
					<?php }
					session_destroy(); // FÖRSTÖR SESSION PGA ANNARS FINNS ENS ORDER KVAR PÅ URL'EN OCH DET ÄR KNAS??
					 ?>
				</div> <!-- end cart row -->
			</div>

	</main> <!-- end wrap -->

	<footer class="row">

	</footer>

	</div> <!-- end container-fluid -->

	<!-- Optional JavaScript -->
	<!-- jQuery first, then Popper.js, then Bootstrap JS -->
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</body>

</html>