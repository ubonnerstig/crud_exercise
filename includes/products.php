<?php

//Getting products from database

$statement = $pdo->prepare("SELECT id, name, price, description, image FROM products");
$statement->execute();
$products = $statement->fetchAll(PDO::FETCH_ASSOC);

if(empty($_SESSION['username'])){
    $_SESSION['id'] = 0;
}

//Getting cart from database

$statement = $pdo->prepare(
"SELECT cart.product_id, cart.user_id, cart.name, cart.price, cart.quantity, products.image AS image
FROM cart
JOIN products
ON products.id = cart.product_id
WHERE user_id = :user_id");

$statement->execute([
":user_id"     => $_SESSION["id"]
]);

$cart = $statement->fetchAll(PDO::FETCH_ASSOC);


//Getting user information from database if user is logged in
if(isset($_SESSION["username"])){
    $statement = $pdo->prepare(
    "SELECT firstname, lastname, street, postal, city, phone, email  
    FROM user_info 
    WHERE user_id = :user_id");
    $statement->execute([
    ":user_id"     => $_SESSION["id"]
    ]);

    $user_info = $statement->fetchAll(PDO::FETCH_ASSOC);
}

if(isset($_SESSION['order_id'])){
    $statement = $pdo->prepare(
    "SELECT orders.order_id, orders.user_id, orders.product_id, orders.product_name, orders.price, orders.quantity, products.image AS image
    FROM orders
    JOIN products
    ON products.id = orders.product_id
    WHERE order_id = :order_id");

    $statement->execute([
    ":order_id"     => $_SESSION['order_id']
    ]);

    $order = $statement->fetchAll(PDO::FETCH_ASSOC);
}

/*



//Getting cart from database
if(isset($_SESSION["username"])){
    $statement = $pdo->prepare(
    "SELECT product_id, name, price, image, quantity 
    FROM cart 
    WHERE user_id = :user_id");
    $statement->execute([
    ":user_id"     => $_SESSION["id"]
    ]);

    $cart = $statement->fetchAll(PDO::FETCH_ASSOC);
} else {
    $statement = $pdo->prepare("SELECT product_id, name, price, image, quantity FROM cart WHERE user_id = 0");
    $statement->execute();
    $cart = $statement->fetchAll(PDO::FETCH_ASSOC);  
}






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

