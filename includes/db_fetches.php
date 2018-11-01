<?php
//If a user isnt logged in session id = 0
if(empty($_SESSION['username'])){
    $_SESSION['id'] = 0;
}

//Fetching products from database
$statement = $pdo->prepare("SELECT id, name, price, description, image FROM products");
$statement->execute();
$products = $statement->fetchAll(PDO::FETCH_ASSOC);

//Fetching cart from database
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

//Fetching user information from database if user is logged in
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

// If an order id is set, fetch it from database
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

?>

