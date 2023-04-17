<?php
session_start();
// check if user is logged in
if (!isset($_SESSION['loggedin']) || !$_SESSION['loggedin']) {
    //user is not logged in, redirect to login page
    header("Location: login.php");
    exit();
}
if (isset($_GET['id'])) {
  $proid = $_GET['id'];
  unset($_SESSION['cart'][$proid]);
  header("location: ../cart.php");
}
;?>