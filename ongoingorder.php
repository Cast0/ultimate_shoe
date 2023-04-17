<?php
session_start();

// check if user is logged in
if (!isset($_SESSION['loggedin']) || !$_SESSION['loggedin']) {
    //user is not logged in, redirect to login page
    header("Location: login.php");
    exit();
}

if (isset($_SESSION['role']) && $_SESSION['role'] == 1) {
    //user has role 2, redirect to userprofile.php
    header("Location: admin/dashboard.php");
    exit();
}

    include 'conn.php';
    $username = $_SESSION['username'];
    $id = $_SESSION['id'];

?>
<!DOCTYPE html>
<html lang="en" class="scroller">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>KADS | Ongoing Order</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4"
        crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <!-- css -->
    <link rel="stylesheet" href="css/header-responsive.css" />
    <link rel="stylesheet" href="css/footer.css" />
    <link rel="stylesheet" href="css/ongoingorder.css" />
    <!-- favicon -->
    <link rel="icon" type="image/x-icon" href="favicon.ico" />
    <!-- fontawesome -->
    <script src="https://kit.fontawesome.com/03977197ef.js" crossorigin="anonymous"></script>
</head>

<body>
    <?php
        include 'header-user.php';
    ?>
    
    <!-- cart and order summary page -->    
    <div class="container-fluid main-container">
      <div class="row"> 
        <div class="col-back">
            <div class="back-icon">
                <a href="../KADS/orderhistory.php">
                    <img src="img/backicon.png">
                </a>
            </div>   
        </div>                  
        <div class="col-lg col left-col left-side justify-content-center"> 
            <p>Ongoing Order</p>
                <div class="status">
                    <h2 class="status-label">Status</h2>
                <?php
                    $query="SELECT * FROM user_orders INNER JOIN products ON products.p_id = user_orders.product_id WHERE user_orders.user_id = '$id' AND (user_orders.status=1 OR user_orders.status=2)";
                    $result=mysqli_query($conn,$query);
                    $row = mysqli_fetch_assoc($result);
                    if(mysqli_num_rows($result) < 1) {
                        echo "<div class='order-progress p-none'>No ongoing order</div>";
                        exit();
                    } else {
                    if ($row['status'] == 1) { 
                           echo "<div class='order-progress p-preparing'>Preparing</div>";
                        } elseif($row['status'] == 2) {
                           echo "<div class='order-progress p-delivery'>Out for Delivery</div>";
                        }
                    }
                    ?>
                </div>
                <div class="hline"></div>
                <?php
                $query="SELECT * FROM user_orders INNER JOIN products ON products.p_id = user_orders.product_id WHERE user_orders.user_id = '$id' AND (user_orders.status=1 OR user_orders.status=2)";
                $result=mysqli_query($conn,$query);
                $subTotal = 0;
                if(mysqli_num_rows($result) < 1) {
                    echo "<div class='order-progress p-none'>No ongoing order</div>";
                    exit();
                } else {
                while($row = mysqli_fetch_assoc($result)) {
                ?>
                <!-- item -->  
                <div class="d-flex">
                    <div class="food-item-1 w-100">
                        <div class="d-flex align-items-center">
                            <div class="food-img flex-shrink-0">
                                <img src="img/menu/<?php echo $row['image'] ?>" alt="food image">
                            </div>
                            <div class="food-content flex-grow-1 ms-3">
                                <div class="fn">
                                    <h2 class="food-name"><?php echo $row['productName'] ?></h2>
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
                } 
            }?>
        </div>   
        
        <div class="col-vline d-none d-lg-block"></div>        
               
        <div class="col-lg-4 col-12 right-col right-side justify-content-center align-self-stretch">
            <p>Order Summary</p>
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
                <span class="total-price">₱<?php echo $subTotal + 60; ?></span>
            </div>


            <div class="hline"></div>    
            
            <p>Delivery Address</p>
            <div class="delivery-details">
                <?php 
                $query1 = "SELECT * FROM info_accts WHERE id = '$id'";
                $delivery=mysqli_query($conn,$query1);
                $res = mysqli_fetch_assoc($delivery); { ?>
                <h2 class="delivery-label"><?php echo $res['firstname'] .' '. $res['lastname'] ?></h2>
                <h4 class="delivery-number"><?php echo $res['phone'] ?></h4>
                <h4 class="delivery-address"><?php echo $res['house'] .' '. $res['city'] .' '. $res['province'] ?></h4>
                <?php } ?>
            </div>            
        </div>
      </div>      
    </div>    
    <!-- end of cart and order summary page -->

    <!-- back to top button -->
    <button
        type="button"
        class="btn btn-danger btn-floating btn-lg"
        id="btn-back-to-top"
        >
        <i class="fas fa-arrow-up"></i>
    </button>
    <!-- back to top button end --> 

    <?php
        include 'footer.html';
    ?>

    <!---------------------JS-------------------->          
    <script src="backtotop.js"></script>    
</body>

</html>
