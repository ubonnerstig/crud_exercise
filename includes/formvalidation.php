<?php

if(isset($_SERVER)){
	
	function test_input($data) {
	  $data = trim($data);
	  $data = stripslashes($data);
	  $data = htmlspecialchars($data);
	  return $data;
	}
	
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
			if (!preg_match("/^[a-zA-Z0-9]*$/",$password)) {
		  	$passwordErr = "Only letters numbers"; 
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
		
		if (empty($usernameErr) && empty($passwordErr) && empty($verifypasswordErr) && empty($firstnameErr) && empty($lastnameErr) && empty($streetErr) && empty($postalErr) && empty($cityErr) && empty($phoneErr) && empty($emailErr)){
			
			//include 'database.php';

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
			
			//header('Location: ../index.php');
		}
		
	}
}

?>