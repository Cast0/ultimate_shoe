<?php
session_start();
require_once '../conn.php';

if(isset($_POST['product_id']) && isset($_POST['quantity'])){
    $product_id = $_POST['product_id'];
    $quantity = $_POST['quantity'];
    // update the cart session
    $_SESSION['cart'][$product_id]['qty'] = $quantity;
}

header('location: ../cart.php');
?>