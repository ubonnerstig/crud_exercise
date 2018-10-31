<header class="row justify-content-between">						
    <div class="col-12 col-md-6 logo">
        <a href="../index.php"><h1 class="gradient-text">LIGHT <i class="fas fa-moon gradient-text"></i> <br>TRAVEL </h1></a>
    </div>

    <div class="col-3 login-wrap">
        <div class="dropdown login">
            <button class="btn btn-secondary dropdown-toggle" aria_label="Log in" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-user"></i>
            </button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                <?php if(isset($_SESSION['username'])){ ?>
                    <p class="dropdown-item"><b>Signed in as:</b><br> <?=$_SESSION['username']?></p>
                    <a class="login-button mx-4 my-3" href="logout.php">Log out</a>
                <?php } else {?>
                    <form class="px-4 py-3" action="login.php" method="POST">
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
                    <a class="dropdown-item" href="register.php">New around here? Sign up</a>
                <?php } ?>	
            </div> <!-- end dropdown-menu -->
        </div> <!-- end dropdown login -->
    </div> <!-- end login-wrap -->
</header>