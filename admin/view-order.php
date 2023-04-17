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

$username = $_SESSION['username'];
?>
<!DOCTYPE html>
<html dir="ltr" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title> KADS | Admin</title>
    <link rel="icon" type="image/png" sizes="16x16" href="../img/logo.png">
    <!--<link href="../plugins/bower_components/chartist/dist/chartist.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../plugins/bower_components/chartist-plugin-tooltips/dist/chartist-plugin-tooltip.css"> -->
    <link href="../css/style.min.css" rel="stylesheet">
    <link href="../css/pagestyles.css" rel="stylesheet">

    <style>
        @import url('https://fonts.googleapis.com/css?family=Inter');
        @import url('https://fonts.googleapis.com/css?family=Readex Pro');

        body {font: 14px sans-serif; background-color: #e7e7e7; color: #141C07;}
        .wrapper { width: 360px; padding: 20px;}
        /*changed wrapper*/
        .wrapper {
        width: 500px;
        margin: 0 auto;
        }

        .edituserblock {
            background-color: #fff;
            border-radius: 10px;
            padding: 20px;
            /*changed width*/
            width: 500px;
            margin-top: 30px;
            box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.15);
        }

        .back-icon img {
            width: 40px;
            height: 40px;
            top: 60px;
            /*changed left*/
            left: calc(50% - 600px/2);
            position: absolute;
        }

        .status {
            padding-top: 15px;
            align-items: center;
            display: flex;
        }

        .status-label {
            font-family: 'Readex Pro';
            font-weight: 700;
            font-style: normal;
            margin-bottom: 0;
        }

        .order-progress {
            font-family: 'Inter';
            font-size: 20px;
            align-items: center;
            color: #C70800;
            font-weight: 600;
            font-style: normal;
            margin-left: auto;
            text-align: right;
        }

        .food-name {
            font-family: 'Readex Pro';
            font-weight: 700;
            margin-left: 20px;
        }

        .fn-quantity {
            font-family: 'Inter';
            font-size: 15px;
            font-weight: 500;
            margin-left: 20px;
        }

        .food-price {
            font-family: 'Inter';
            font-size: 15px;
            font-weight: 500;
            margin-left: 20px;
        }

        .subtotal {
            margin-top: 2rem;
            margin-bottom: 0.5rem;
            display: flex;
        }

        .subtotal-label {
            color: #000;
            font-family: 'Inter';
            font-style: normal;
            font-weight: 600;
            font-size: 20px;
        }

        .subtotal-price {
            color: #000;
            font-family: 'Inter';
            font-style: normal;
            font-weight: 300;
            font-size: 17px;
            padding: 0.4rem 0;
            text-align: right;
            margin-left: auto;
        }

        .df {
            margin-bottom: 0.5rem;
            display: flex;
        }

        .df-label {
            color: #000;
            font-family: 'Inter';
            font-style: normal;
            font-weight: 600;
            font-size: 20px;
        }

        .df-price {
            color: #000;
            font-family: 'Inter';
            font-style: normal;
            font-weight: 300;
            font-size: 17px;
            padding: 0.4rem 0;
            text-align: right;
            margin-left: auto;
        }

        .hline {
            margin-top: 25px;
            margin-bottom: 25px;
            border-bottom: 0.3px solid #c3c9d1;
            display: flex;
        }

        .total {
            margin-bottom: 0.5rem;
            display: flex;
        }

        .total-label {
            color: #000;
            font-family: 'Inter';
            font-style: normal;
            font-weight: 700;
            font-size: 20px;
        }

        .total-price {
            color: #C70800;
            font-family: 'Inter';
            font-style: normal;
            font-weight: 700;
            font-size: 17px;
            padding: 0.4rem 0;
            text-align: right;
            margin-left: auto;
        }
    </style>
</head>



<body>
    <div class="wrapper">
        <div class="top-line"></div>
        <div class="back-icon">
            <a href="../admin/order-history.php">
                <img src="../img/backicon.png">
            </a>
        </div>
        <div class="edituserblock">
            <h2>View Order</h2>
            <div class="container">
                <div class="status">
                    <h2 class="status-label">Status</h2>
                    <?php
                    $id = $_GET['o_id'];
                    $query = "SELECT * FROM user_orders JOIN products ON user_orders.product_id = products.p_id WHERE order_number = $id";
                    $result = mysqli_query($conn, $query);
                    $row = mysqli_fetch_assoc($result);
                    if ($row['status'] = 1) {
                        echo "<div class='order-progress p-preparing'>Preparing</div>";
                    } elseif ($row['status'] = 2) {
                        echo "<div class='order-progress p-delivery'>Out for Delivery</div>";
                    } else {
                        echo "<div class='order-progress p-none'>No ongoing order</div>";
                    }
                    ?>
                </div>
                <div class="hline"></div>
                <?php
                $query = "SELECT * FROM user_orders JOIN products ON user_orders.product_id = products.p_id WHERE order_number = $id";
                $result = mysqli_query($conn, $query);
                $subTotal = 0;
                while ($row = mysqli_fetch_assoc($result)) {
                    ?>
                    <!-- item -->
                    <div class="d-flex">
                        <div class="food-item-1 w-100">
                            <div class="d-flex align-items-center">
                                <div class="food-img flex-shrink-0">
                                    <img src="../img/menu/<?php echo $row['image'] ?>" alt="food image" width="170"
                                        height="170">
                                </div>
                                <div class="food-content flex-grow-1 ms-3">
                                    <div class="fn">
                                        <h2 class="food-name">
                                            <?php echo $row['productName'] ?>
                                        </h2>
                                        <span class="fn-quantity">x <?php echo $row['quantity'] ?></span>
                                    </div>
                                    <!-- price should add up everytime the quantity goes up. 
                                    for example, the original price of cucumber roll is 100
                                    but the user ordered 2 of it. the total price of cucumber 
                                    roll should reflect on the food price-->
                                    <span class="food-price">₱<?php echo $row['price'] ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end of item -->
                    <?php
                    $subTotal += $row['price'] * $row['quantity'];
                } ?>
                <div class="col-vline d-none d-lg-block"></div>
                <div class="hline"></div>
                <div>
                    <h2>Order Summary</h2>
                    <div class="subtotal">
                        <h2 class="subtotal-label">Subtotal</h2>
                        <span class="subtotal-price">₱<?php echo $subTotal; ?></span>
                    </div>
                    <div class="df">
                        <h2 class="df-label">Delivery Fee</h2>
                        <span class="df-price">₱60.00</span>
                    </div>

                    <div class="hline"></div>

                    <div class="total">
                        <h2 class="total-label">Total</h2>
                        <span class="total-price">₱<?php echo $subTotal+60; ?></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>

<?php
/*}*/
?>

