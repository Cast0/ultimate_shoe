<?php

require "../conn.php";
session_start();

// check if user is logged in
if (!isset($_SESSION['loggedin']) || !$_SESSION['loggedin']) {
    //user is not logged in, redirect to login page
    header("Location: ../login.php");
    exit();
}

if (isset($_SESSION['role']) && $_SESSION['role'] == 2) {
    //user has role 2, redirect to userprofile.php
    header("Location: ../userprofile.php");
    exit();
}

// get the order ID and new status
$order_id = $_POST['order_id'];
$status = $_POST['status'];

// update the status in the database
$sql = "UPDATE user_orders SET status=? WHERE order_number=?";
if($stmt = mysqli_prepare($conn, $sql)){
    mysqli_stmt_bind_param($stmt, "ii", $status, $order_id);
    if(mysqli_stmt_execute($stmt)){
        echo "Successfully updated status";
        header('location: order-history.php');
    } else {
        echo "Error updating status";
    }
    mysqli_stmt_close($stmt);
}
mysqli_close($conn);
?>