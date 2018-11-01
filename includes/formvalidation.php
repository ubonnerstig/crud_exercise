<?php

if(isset($_SERVER)){
	
	/*Trims away unnecessary characters, removes backslashes and making sure users cant execute scripts with the form*/
	function test_input($data) {
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}
	
	// Giving all variables below an empty string as value so they are predefined
	$username = $password = $verifypassword = $firstname = $lastname = $street = $postal = $city = $phone = $email = "";
	$usernameErr = $passwordErr = $verifypasswordErr = $firstnameErr = $lastnameErr = $streetErr = $postalErr = $cityErr = $phoneErr = $emailErr = "";

	if ($_SERVER["REQUEST_METHOD"] == "POST") {
	
		// If the post variable is empty, set a value to the error variable which prints out on the page
		if (empty($_POST["username"])) {
			$usernameErr = "*";
		} else {
			$username = test_input($_POST["username"]);
			//Checks if the variable contains anything else than the preg_match values, and if so returns error message
			if (!preg_match("/^[a-zA-Z]*$/",$username)) {
		  	$usernameErr = "Only letters and white space allowed"; 
			}
		}
		
		if (empty($_POST["password"])) {
			$passwordErr = "*";
		} else {
			$password = test_input($_POST["password"]);
			// Makes sure the password is longer than 8 characters, otherwise returns an error
			if (strlen($password) < 8) {
			$passwordErr = "Password is too short"; 
			}
			if (!preg_match("/^[a-zA-Z0-9!@#$%]*$/",$password)) {
		  	$passwordErr = "Only a-z, 0-9, !@#$% allowed"; 
			}
		}
		
		if (empty($_POST["verifypassword"])) {
			$verifypasswordErr = "*";
		} else {
			$verifypassword = test_input($_POST["verifypassword"]);
			if ($password !== $verifypassword) {
		  	$verifypasswordErr = "Passwords don't match"; 
			}
		}
		
		if (empty($_POST["firstname"])) {
			$firstnameErr = "*";
		} else {
			$firstname = test_input($_POST["firstname"]);
			if (!preg_match("/^[a-öA-Ö ]*$/",$firstname)) {
		  	$firstnameErr = "Only letters and white space allowed"; 
			}
		}
		
		if (empty($_POST["lastname"])) {
			$lastnameErr = "*";
		} else {
			$lastname = test_input($_POST["lastname"]);
			if (!preg_match("/^[a-öA-Ö ]*$/",$lastname)) {
		  	$lastnameErr = "Only letters and white space allowed"; 
			}
		}
		
		if (empty($_POST["street"])) {
			$streetErr = "*";
		} else {
			$street = test_input($_POST["street"]);
			if (!preg_match("/^[a-öA-Ö0-9 ]*$/",$street)) {
		  	$streetErr = "Only letters, numbers and white space allowed"; 
			}
		}
		
		if (empty($_POST["postal"])) {
			$postalErr = "*";
		} else {
			$postal = test_input($_POST["postal"]);
			if (!preg_match("/^[0-9]*$/", $postal)){
				$postalErr = "Only numbers allowed";
			}
		}
		
		if (empty($_POST["city"])) {
			$cityErr = "*";
		} else {
			$city = test_input($_POST["city"]);
			if (!preg_match("/^[a-öA-Ö ]*$/",$city)) {
		  	$cityErr = "Only letters and white space allowed"; 
			}
		}
		
		if (empty($_POST["phone"])) {
			$phoneErr = "*";
		} else {
			$phone = test_input($_POST["phone"]);
			if (!preg_match("/^[0-9]*$/", $phone)){
				$phoneErr = "Only numbers allowed";
			}
		}
		
		if (empty($_POST["email"])) {
			$emailErr = "*";
		} else {
			$email = test_input($_POST["email"]);
			if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      		$emailErr = "Invalid email format"; 
			}
		}
		
		//Makes sure all error variables are empty before proceeding
		if (empty($usernameErr) && empty($passwordErr) && empty($verifypasswordErr) && empty($firstnameErr) && empty($lastnameErr) && empty($streetErr) && empty($postalErr) && empty($cityErr) && empty($phoneErr) && empty($emailErr)){

			// Gets email and username from database to check if there already is a user with the username and/or email the new user is trying to register with
			$statement = $pdo->prepare("SELECT username, email FROM users");
			$statement->execute();
			$users = $statement->fetchAll(PDO::FETCH_ASSOC);

			//If username or email is already taken, returns an error message
			for($i=0;$i<count($users);$i++){
				if($username == $users[$i]['username']){
					$usernameErr = "Username already taken";
					return;
				} 
				elseif($email == $users[$i]['email']){
					$emailErr = "Email already registered"; 
					return;
				}
			}
			
			//Hashes and salts password and saves it to an variable
			$hashed_password = password_hash($password, PASSWORD_DEFAULT);
			

			//Saves username email and password in the users database
			$statement = $pdo->prepare(
			"INSERT INTO users (username, email, password)
			VALUES (:username, :email, :password);"
			);

			$statement->execute([
			":username"     => $username,
			":email"     => $email,
			":password"     => $hashed_password,
			]);

			/* Since the userID isnt created until you have inserted the info into database, I cant get it in the first step,
			so fetching it in a second step to be able to insert it together with the rest of the userinfo into its own db*/
			$statement = $pdo->prepare(
			"SELECT id FROM users
			WHERE username = :username;"
			);

			$statement->execute([
			":username"     => $username,
			]);

			$user_id = $statement->fetch();

			//Inserting the fetched userID into database together witch shipping and contact info
			$statement = $pdo->prepare(
			"INSERT INTO user_info (user_id, firstname, lastname, street, postal, city, phone, email)
			VALUES (:user_id, :firstname, :lastname, :street, :postal, :city, :phone, :email);"
			);

			$statement->execute([
			":user_id"     => $user_id['id'],
			":firstname"     => $firstname,
			":lastname"     => $lastname,
			":street"     => $street,
			":postal"     => $postal,
			":city"     => $city,
			":phone"     => $phone,
			":email"     => $email,
			]);
			
			header('Location: ?success');
		}		
	}
}

?>