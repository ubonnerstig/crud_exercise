<?php
session_start();

require '../includes/database_connection.php';
include '../includes/db_fetches.php'; 
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
		<?php 
		include '../includes/cart.php';
		include '../includes/header.php';
		?>					
		<main class="wrap">

			<div class="row justify-content-around">
			
				<div class="col-12 col-md-6 checkout-form">
					<h2>User information</h2>
					<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST" id="register">
						<input class="input-style" aria-label="Username" placeholder="Username" id="username" name="username" type="text">
						<span class="error"><?=$usernameErr;?></span><br>
						<input class="input-style" aria-label="Password" id="password" name="password" type="password" placeholder="Password (min 8 charachters)">
						<span class="error"><?=$passwordErr;?></span><br>
						<input class="input-style" aria-label="Verify password" id="verifypassword" name="verifypassword" type="password" placeholder="Verify password">
						<span class="error"><?=$verifypasswordErr;?></span><br>	
					</form>
					<?php if(isset($_GET["success"])){ ?>
					<p class="success">Registration complete</p>
				<?php } ?>
				</div>
	
				<div class="col-12 col-md-6 checkout-form">
					<h2>Shipping information</h2>
					
					<input class="input-style" aria-label="Name" placeholder="Name" id="firstname" name="firstname" type="text" form="register">
					<span class="error"><?=$firstnameErr;?></span><br>
					<input class="input-style" aria-label="Surname" id="lastname" name="lastname" type="text" placeholder="Surname" form="register">
					<span class="error"><?=$lastnameErr;?></span><br>
					<input class="input-style" aria-label="Street" id="street" name="street" type="text" placeholder="Street" form="register">
					<span class="error"><?=$streetErr;?></span><br>
					<input class="input-style" aria-label="Post code" id="postal" name="postal" type="number" size="5" maxlength="5" placeholder="Post code" form="register">
					<span class="error"><?=$postalErr;?></span><br>	
					<input class="input-style" aria-label="City" id="city" name="city" type="text" placeholder="City" form="register">
					<span class="error"><?=$cityErr;?></span><br>
					<input class="input-style" aria-label="Phone number" id="phone" name="phone" type="number" placeholder="Phone number" form="register">
					<span class="error"><?=$phoneErr;?></span><br>
					<input class="input-style" aria-label="E-mail" id="email" name="email" type="email" placeholder="E-mail" form="register">
					<span class="error"><?=$emailErr;?></span><br>
				</div>

				<div class="col-12 mt-5">
					<input class="checkout" type="submit" value="Register" form="register">
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