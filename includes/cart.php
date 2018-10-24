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
					<?php }
					else {
						for($i=0;$i<count($cart);$i++){	?>

						<li class="row justify-content-between align-items-center cart_list">	
							<div class="list_image">
								<img src="<?=$cart[$i]["image"];?>">
							</div>

							<h3 class="col-3"><?=str_replace("_", " ",$cart[$i]["name"]);?></h3>

							<p class="col-3"><b>Price:</b> <br><?=$cart[$i]["price"];?> SEK/st</p>

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
						<a class="nav-link checkout" href="confirm.php">CHECKOUT</a>
					</li>
				</ul>
			</div>
		</nav>
	</div>
</div>