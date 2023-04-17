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
?>

<!doctype html>
<html lang="en" class="scroller">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>KADS | Order History</title>
        <!-- bootstrap -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
        <!-- css -->
        <link rel="stylesheet" href="css/header-responsive.css" />
        <link rel="stylesheet" href="css/footer.css" />
        <link rel="stylesheet" href="css/user.css" />
        <link rel="stylesheet" href="css/orderhistory.css" />
        <!-- favicon -->
        <link rel="icon" type="image/x-icon" href="favicon.ico" />
        <!-- fontawesome -->
        <script src="https://kit.fontawesome.com/03977197ef.js" crossorigin="anonymous"></script>
    </head>
    <body>
      <?php
      $username = $_SESSION['username'];
      $id = $_SESSION['id'];
        include 'header-user.php';
      ?>
        <!-------------- content start --------------->

        <div class="order-content-container container d-flex justify-content-center">          
          <div class="row content-wrapper">
            <div class="col-4 left-content">
              <div class="container">
                <div class="row links-title-top">My Account</div>      
                <div class="row">
                  <div class="col-1"></div>
                  <div class="col-11">
                    <a href="userprofile.php">
                      <button type="button" class="side-links">My Profile</button>                    
                    </a>
                  </div>                  
                </div>
                <div class="row">
                  <div class="col-1"></div>
                  <div class="col-11">
                    <a href="myAddresses.php">
                      <button type="button" class="side-links">My Addresses</button>
                    </a>
                  </div>                  
                </div>
                <div class="row">
                  <div class="col-1"></div>
                  <div class="col-11">
                    <a href="changePass.php">
                      <button type="button" class="side-links">Change Password</button>
                    </a>
                  </div>                  
                </div>                
                <div class="row links-title">My Orders</div>
                <div class="row">
                  <div class="col-1"></div>
                  <div class="col-11">
                    <a href="ongoingorder.php">
                      <button type="button" class="side-links">Ongoing Order</button>
                    </a>                    
                  </div>                  
                </div>   
                <div class="row">
                  <div class="col-1"></div>
                  <div class="col-11">
                    <a href="orderhistory.php">
                      <button type="button" class="side-links side-links-active">Order History</button>
                    </a>                    
                  </div>                  
                </div>     
                <div class="row align-bottom logout-group">
                  <a href="logout.php">
                    <span class="fa-solid fa-power-off">
                      <span class="logout-label">Logout</span>
                    </span>
                  </a>
                </div>                 
              </div>
            </div>


            <div class="col right-content-2">
              <h2 class="section-title">My Orders</h2>

              <?php 
                $query="SELECT * FROM user_orders INNER JOIN products ON user_orders.product_id = products.p_id WHERE user_id = '$id' ORDER BY date DESC" ;
                $result=mysqli_query($conn,$query);
                $order_by_date = array();
                while ($row = mysqli_fetch_assoc($result)) {
                  $date = date('Y-m-d H:i:s', strtotime($row['date']));
                  if (!isset($order_by_date[$date])) {
                      $order_by_date[$date] = array();
                      $order_by_date[$date]['total'] = 0;
                      $order_by_date[$date]['status'] = $row['status'];
                  }
                  $order_by_date[$date]['total'] += $row['price'] * $row['quantity'];
                  array_push($order_by_date[$date], $row);
                }
                
              foreach ($order_by_date as $date => $orders) {
              ?>

              <div class="order-container">
                <div class="container">
                  <div class="row d-flex align-items-center">
                    <div class="col order-header"><?php echo $date; ?></div>
                    <?php
                        if ($orders['status'] == 1) { 
                            echo "<div class='order-progress p-processing'>Preparing</div>";
                        } elseif($orders['status'] == 2) {
                            echo "<div class='order-progress p-delivery'>Out for Delivery</div>";
                        } elseif($orders['status'] == 3){
                          echo "<div class='order-progress p-completed'>Completed</div>";
                        } 
                      
                     ?>

                  </div>
                </div>                
                <div class="container order-group">
                  <div class="row">
                    <div class="col-auto">
                      <img src="images/order-icon.png" class="order-icon">
                    </div>
                    <div class="col">
                      <?php 
                        foreach ($orders as $row) {
                          if (is_array($row)) {
                      ?> 
                      <div class="row order-item">                        
                        <div class="col"><b><?php echo $row['quantity']?>x</b></div>
                        <div class="col-8"><?php echo $row['productName']?></div>
                        <div class="col order-price">P<?php echo $row['price']?></div>
                      </div>
                      <?php 
                        } 
                      }?>
                      <div class="row">                        
                        <div class="col"></div>
                        <div class="col-8 total-text"><b>Total</b></div>
                        <div class="col order-total order-price"><b>P<?php echo $order_by_date[$date]['total'] + 60; ?></b></div>
                      </div>
                    </div>
                    
                  </div>                  
                </div>
              </div>

              <?php } ?>

                    
                  </div>                  
                </div>
              </div>

            </div>
          </div>                    
        </div>
        
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
        <!-- bootstrap -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    </body>
</html>
