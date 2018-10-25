<?php

//Getting products from database

$statement = $pdo->prepare("SELECT id, name, price, description, image FROM products");
$statement->execute();
$products = $statement->fetchAll(PDO::FETCH_ASSOC);

//Getting cart from database
if(isset($_SESSION["id"])){
    $statement = $pdo->prepare(
    "SELECT product_id, name, price, image, quantity 
    FROM cart 
    WHERE user_id = :user_id");
    $statement->execute([
    ":user_id"     => $_SESSION["id"]
    ]);

    $cart = $statement->fetchAll(PDO::FETCH_ASSOC);
}else{
    $statement = $pdo->prepare("SELECT product_id, name, price, image, quantity FROM cart WHERE user_id = 0");
    $statement->execute();
    $cart = $statement->fetchAll(PDO::FETCH_ASSOC);  
}
/*
$products[$i]['name']

date("l");
for($i=0;$i<count($varor); $i++)

if(date("l") === "Monday"){
$old_price[$i] = $varor[$i]['price'];
$varor[$i]['price'] = number_format($varor[$i]['price']*0.5,2);

}

elseif(date("l") === "Wednesday"){
$old_price[$i] = $varor[$i]['price'];
$varor[$i]['price'] = number_format($varor[$i]['price']*1.1,2);
}

elseif(date("l") === "Friday" && $varor[$i]['price'] > 200){
$old_price[$i] = $varor[$i]['price'];
$varor[$i]['price'] = number_format($varor[$i]['price']-20,2);

}
*/

?>

