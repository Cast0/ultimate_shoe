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

    $emptyCart = "";

    $order = "SELECT order_number FROM user_orders ORDER BY order_number DESC LIMIT 1";
    $result = mysqli_query($conn, $order);
    $current_order_number = mysqli_fetch_assoc($result)['order_number'];
    $next_order_number = $current_order_number + 1;

    if($_SERVER["REQUEST_METHOD"] == "POST") {
        $check = "SELECT status FROM user_orders WHERE user_id = '$id' AND (status = 1 OR status = 2)";
        $row=mysqli_query($conn,$check);
        if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
            if(mysqli_num_rows($row) > 0) {
                $emptyCart = "Complete your on-going order before proceeding.";
                unset($_SESSION['cart']);
            } else {
                $cart = $_SESSION['cart'];
                foreach ($cart as $product_id => $product_info) {
                    // insert the order into the database
                    $query = "INSERT INTO user_orders (order_number, product_id, quantity,  date, status, user_id) VALUES ($next_order_number, $product_id, $product_info[qty], NOW() , 1 ,'$id')";
                    mysqli_query($conn, $query);
                    unset($_SESSION['cart']);
                    header('location:placeorder.php');
                }
            } 
        } else {
            $emptyCart = "Your cart is empty.";
        } 
    } 

?>

<!DOCTYPE html>
<html lang="en" class="scroller">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>KADS | Cart</title>
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
    <link rel="stylesheet" href="css/cart.css" />
    <!-- favicon -->
    <link rel="icon" type="image/x-icon" href="favicon.ico" />
    <!-- fontawesome -->
    <script src="https://kit.fontawesome.com/03977197ef.js" crossorigin="anonymous"></script>
</head>

<body>
    <?php
        include 'header-user.php';
    ?>
    
    <form class="form-style" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <!-- cart and order summary page -->    
        <div class="container-fluid main-container">
        <div class="row">
            <div class="col-lg-6 col-12 left-col left-side justify-content-center">
                <p>My Cart</p>
                    <a href="userFunctions/emptycart.php"> Empty Cart </a>
                    <?php
                    $total = 0;
                    $fTotal = 0;
                    if(!empty($_SESSION['cart'])) {
                        foreach($_SESSION['cart'] as $cart) {
                    ?>
                    <!-- item -->  
                    <div class="d-flex">
                        <div class="food-item-1 w-100">
                            <div class="d-flex align-items-center">
                                <div class="food-img flex-shrink-0">
                                    <img src="img/menu/<?php echo $cart['product_image'] ?>" alt="food image">
                                </div>

                                <div class="food-content flex-grow-1 ms-3">
                                    <h2 class="food-name"><?php echo $cart['product_name'] ?></h2>
                                    <!-- price should add up everytime the quantity goes up. 
                                    for example, the original price of cucumber roll is 100
                                    but the user ordered 2 of it. the total price of cucumber 
                                    roll should reflect on the food price-->
                                    <h3 class="food-price" value="<?php echo $cart['product_price']; ?>">₱<?php echo $cart['product_price'] * $cart['qty']; ?></h3>
                                    <div class="quantity">
                                        <span class="decrement" onclick="decrement(<?php echo $cart['product_id']; ?>)"> - </span>
                                        <span class="intnum" id="quantity-<?php echo $cart['product_id']; ?>"><?php echo $cart['qty']; ?></span>
                                        <span class="increment" onclick="increment(<?php echo $cart['product_id']; ?>)"> + </span>
                                    </div>
                                    <?php $total += ($cart['product_price'] * $cart['qty']); ?>
                                </div>
                            </div>
                        </div>                
                        <div class="p-2 flex-shrink-1">                    
                            <div class="d-flex align-content-center flex-wrap h-100">
                                <button class="del-btn h-100">
                                    <a href="userFunctions/removeitem.php?id=<?= $cart['product_id']; ?>" class="x-unicode">&#128937;</a>
                                </button>        
                            </div>    
                        </div>
                    </div>                
                    <!-- end of item -->
                    <?php
                        } $fTotal = $total+60;
                    } else {
                        echo "<h2>". $emptyCart ." </h2>";
                    }
                    ?>               
            </div>   
        
            <div class="col-vline d-none d-lg-block">
                <div class="vline"></div>    
            </div>        
               
            <div class="col-lg-5 col-12 right-col right-side justify-content-center align-self-stretch">
                <p>Order Summary</p>
                <div class="subtotal">
                    <h2 class="subtotal-label">Subtotal</h2>
                    <span class="subtotal-price">₱<?php echo $total; ?></span>
                </div>
                <div class="df">
                    <h2 class="df-label">Delivery Fee</h2>
                    <span class="df-price">₱60.00</span>
                </div>

                <div class="hline"></div>

                <div class="total">
                    <h2 class="total-label">Total</h2>
                    <span class="total-price">₱<?php echo $fTotal; ?></span>
                </div>

                <div class="hline"></div>

                <div class="checkout-btn">
                        <button type="submit" class="checkout">Checkout</button>
                </div>
            </div>
        </div>      
        </div>
    </form>    
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

    <script>
    function increment(productId) {
        var intnum = document.querySelector('#quantity-'+productId);
        var currentQuantity = parseInt(intnum.innerHTML);
        intnum.innerHTML = currentQuantity + 1;
        updateCart(productId, currentQuantity+1);
    }

    function decrement(productId) {
        var intnum = document.querySelector('#quantity-'+productId);
        var currentQuantity = parseInt(intnum.innerHTML);
        if(currentQuantity > 0){
            intnum.innerHTML = currentQuantity - 1;
            updateCart(productId, currentQuantity-1);
        }
    }

    function updateCart(productId, quantity) {
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "userFunctions/updatecart.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                var data = JSON.parse(xhr.responseText);
                    if(data.status) {
                        location.reload();
                    } else {
                console.log(data.message);
                }
            }
        };
        xhr.send("product_id="+productId+"&quantity="+quantity);
        location.reload();
    }
</script>

    
</body>

</html>
