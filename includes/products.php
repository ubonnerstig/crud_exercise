<?php

//Getting products from database

$statement = $pdo->prepare("SELECT id, name, price, description, image FROM products");
$statement->execute();
$products = $statement->fetchAll(PDO::FETCH_ASSOC);

//Getting cart from database
$statement = $pdo->prepare("SELECT product_id, name, price, image, quantity FROM cart");
$statement->execute();
$cart = $statement->fetchAll(PDO::FETCH_ASSOC);

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

