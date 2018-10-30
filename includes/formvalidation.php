<?php

if(isset($_SERVER)){
	
	function test_input($data) {
	  $data = trim($data);
	  $data = stripslashes($data);
	  $data = htmlspecialchars($data);
	  return $data;
	}
	
	/* Giving variables below an empty string as value
	Later in if statements first checks if variable is empty (which it is if user havent filled out the entire form).
	Assigns $_POST[value] to a new variable, then goes on to check if the variable contains anything else than the characters given for specific variable.
	So if it contains anythingelse than the preg_match values, there will be an error, that prints out by given field in the form. 
	*/
	$username = $password = $verifypassword = $firstname = $lastname = $street = $postal = $city = $phone = $email = "";
	$usernameErr = $passwordErr = $verifypasswordErr = $firstnameErr = $lastnameErr = $streetErr = $postalErr = $cityErr = $phoneErr = $emailErr = "";

	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		
		if (empty($_POST["username"])) {
			$usernameErr = "*";
		} else {
			$username = test_input($_POST["username"]);
			if (!preg_match("/^[a-zA-Z]*$/",$username)) {
		  	$usernameErr = "Only letters and white space allowed"; 
			}
		}
		
		if (empty($_POST["password"])) {
			$passwordErr = "*";
		} else {
			$password = test_input($_POST["password"]);
			// Was supposed to check stringlength with preg_match but couldn't make it work
			if (strlen($password) < 8) {
			$passwordErr = "Password is too short"; 
			}
			if (!preg_match("/^[a-zA-Z0-9!@#$%]*$/",$password)) {
		  	$passwordErr = "Only letters or numbers"; 
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
		
		//If all error variables are empty
		if (empty($usernameErr) && empty($passwordErr) && empty($verifypasswordErr) && empty($firstnameErr) && empty($lastnameErr) && empty($streetErr) && empty($postalErr) && empty($cityErr) && empty($phoneErr) && empty($emailErr)){

		// Gets email and username from database to check if there already is a user with the username and/or email the new user is trying to register with
			$statement = $pdo->prepare("SELECT username, email FROM users");
			$statement->execute();
			$users = $statement->fetchAll(PDO::FETCH_ASSOC);

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
						
			$hashed_password = password_hash($password, PASSWORD_DEFAULT);
			
			$statement = $pdo->prepare(
			"INSERT INTO users (username, email, password)
			VALUES (:username, :email, :password);"
			);

			$statement->execute([
			":username"     => $username,
			":email"     => $email,
			":password"     => $hashed_password,
			]);

			$statement = $pdo->prepare(
			"SELECT id FROM users
			WHERE username = :username;"
			);

			$statement->execute([
			":username"     => $username,
			]);

			$user_id = $statement->fetch();

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