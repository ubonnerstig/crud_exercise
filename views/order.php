<?php
session_start();
require '../includes/database.php'; 

if(empty($_POST)){
    header("Location: checkout.php?");
} else {

   highlight_string("<?php =\n" . var_export($_POST, true) . ";\n?>");
    //Get the highest ordernumber from database and then increase it with 1 to generate next ordernumber. 
   $statement = $pdo->prepare("SELECT MAX(order_id) AS max_id FROM orders");
   $statement->execute();
   $last_order = $statement->fetchAll(PDO::FETCH_ASSOC);

   $_SESSION['order_id'] = $last_order[0]['max_id'] + 1;

    for($i=0;$i<$_POST['number_of_products']; $i++){

    $statement = $pdo->prepare(
        "INSERT INTO orders (order_id, user_id, product_id, product_name, price, quantity)
        VALUES (:order_id, :user_id, :product_id, :product_name, :price, :quantity);
        
        DELETE FROM cart WHERE user_id = :user_id;"
        );

        $statement->execute([
        ":order_id"     => $_SESSION['order_id'],
        ":user_id"     => $_POST["user_id"],
        ":product_id"     => $_POST["$i" . "product_id"],
        ":product_name"     => $_POST["$i" . "product_name"],
        ":price"     => $_POST["$i" . "price"],
        ":quantity"     => $_POST["$i" . "quantity"]
        ]);	
    }
    header("Location: confirm.php?");
}


?>