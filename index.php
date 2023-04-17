<?php
session_start();

if (isset($_SESSION['role']) && $_SESSION['role'] == 1) {
  //user has role 2, redirect to userprofile.php
  header("Location: admin/dashboard.php");
  exit();
}

  include "conn.php";
?>

<!doctype html>
<html lang="en" class="scroller">
  <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <title>Ultimate Shoe Battle</title>
      <!-- bootstrap -->
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
      <!-- css -->   
      <link rel="stylesheet" href="css/header-responsive.css" />             
      <link rel="stylesheet" href="css/footer.css" />   
      <link rel="stylesheet" href="CSS/index.css" />     
      <!-- favicon -->
      <link rel="icon" type="image/x-icon" href="favicon.ico" />
      <!-- fontawesome -->
      <script src="https://kit.fontawesome.com/03977197ef.js" crossorigin="anonymous"></script>
  </head>
  <style>
    
  </style>
  <body>      
  <?php
      if(!isset($_SESSION['loggedin'])) {
        include 'header-guest.html';
      } else {
        $username = $_SESSION['username'];
        $id = $_SESSION['id'];
        include 'header-user.php';
      }
    ?>

    <!--- content start --->
    <div class="d-flex content-1">
      <div class="me-auto align-self-center ml-auto left1">
        <h1>This Is <br>How We <br>Roll!<span class="emoji1">&#x1F363&#x1F962</span></h1>
        <p class="text">
          We are KADS! A restaurant specializing in sushi. Every sushi is created by the best sushi chef around, 
          so what are you waiting for? Order now and enjoy your sushi from KADS!
        </p>
        <div class="cta">
          <a href="menu.php" class="btn">Order Now</a>
        </div>
      </div>
      <div class="image1 w-75">
        <img src="images/kads_landing_pic.png"  class="landing_pic img-fluid">
      </div>
    </div>

    <div class="d-flex content-2">
      <div class="image2 w-50 d-none d-sm-none d-md-none d-lg-block">
        <img src="IMAGES/left.png" alt="KADS" class="left-pic img-fluid" />
      </div>     
      <div class="ms-auto pt-100 right1 w-auto">
        <p class ="text2"> &#10024 Authentic Japanese Restaurant in the Philippines</p>
        <h2 class="about-kads">About KADS</h2>
        <p class="text1">
          All of our menu items are inspired by Japanese cuisine and have been created by our head chef, kads, after studying authentic Japanese cuisine in japan. 
          Not only do we have fresh flown-in seafood from the northeast, but we also have a variety of handcrafted cocktails, wine, and beer to choose from.         
        </p>
  
        <img src="images/sushi.png" alt="KADS" class="sushi_pic d-none d-sm-block" />            
      </div>
    </div>

    <div class="content-3">
      <div class="d-flex justify-content-center text-center">
        <div class="p-2 text-center"><h2 class="howto text-center">How To Order</h2></div>
      </div>
      <div class="d-flex justify-content-center text-center">
        <div class="p-2 text-center"><p class="follow text-center">Follow these steps to enjoy the best sushi in town!</p></div>
      </div>

      <div class="row steps-group d-flex justify-content-center text-center">
        <div class="col step-item">
          <h1>&#127843</h1>
          <p class="menutext"><b>Choose Menu</p></b>
          <p class="menutext1">Select the food or drink menu you want and add it to your shopping cart</p>
        </div>
        <div class="col step-item">
          <h1>&#128722</h1>
          <p class="menutext"><b>Checkout Order</p></b>
          <p class="menutext1">Once the orders are in your shopping cart, check out to process your order</p>
        </div>
        <div class="col step-item">
          <h1>&#128757</h1>
          <p class="menutext"><b>Wait for Delivery</p></b>
          <p class="menutext1">Your order will be prepared and delivered to you</p>
        </div>
      </div>      
    </div>

    <div class="content-4">
      <div class="d-flex justify-content-start">
        <div class="text-left ohayo-group">
          <h2 class="ohayo-title">&#128075; Ohayo!</h2>
          <p class="ohayo-text">
            Have a look in some of the items in our menu! Order now!
          </p>
        </div>    
      </div>

      <?php
        //retrieve the quantity sold of all products
        $query = "SELECT product_id, SUM(quantity) as total_sold FROM user_orders GROUP BY product_id";
        $result = mysqli_query($conn, $query);

          //check if there's no result from the query
          if(!$result) {
            echo "Error: " . mysqli_error($conn);
            exit();
          }
          if(mysqli_num_rows($result) < 1) {
            echo "No best seller products found.";
            exit();
          }

          //store the result in an associative array
          $sales = array();
          while ($row = mysqli_fetch_assoc($result)) {
            $sales[$row['product_id']] = $row['total_sold'];
          }

          //check the sales array if its empty or has less than 5 elements
          if(count($sales)<5) {
            echo "Not enough data to display best sellers.";
            exit();
          }

          //sort the associative array in descending order by value
          arsort($sales);

          //get the top 5 best seller products
          $best_seller_ids = array_keys(array_slice($sales, 0, 5, true));

          //retrieve the best seller products
          $best_seller_products = array();
          foreach($best_seller_ids as $id) {
            $query = "SELECT * FROM products WHERE p_id = $id";
            $result = mysqli_query($conn, $query);
            $best_seller_products[] = mysqli_fetch_assoc($result);
          }

      ?>
      <!--carousel start--->
      <div class="container" style="padding-bottom: 150px;">
        <div class="row">
          <div class="MultiCarousel" data-items="2,3,4,5" data-slide="1" id="MultiCarousel"  data-interval="1000">
            <div class="MultiCarousel-inner">
              <!--items start--->
              <?php foreach($best_seller_products as $product) { ?>
              <div class="item">
                <div class="pad15">
                  <div class="card-img">
                    <img src="img/menu/<?php echo $product['image']; ?>" class="d-block w-100" alt="<?php echo $product['productName']; ?>">
                  </div>
                  <h5 class="card-title" style="margin-bottom:10px;"><?php echo $product['productName']; ?></h5>                  
                  <a href="menu.php"><button class="button card-btn">Order Now</button></a>
                </div>
              </div>
              <?php } ?>
              <!--items end--->                
          </div>
          <!--<button class="btn btn-primary leftLst"><i class="fas fa-angle-left"></i></button>
          <button class="btn btn-primary rightLst"><i class="fas fa-angle-right"></i></button>-->
        </div>
      </div>
      <!--carousel end--->
    </div>
    <!--- content end --->   

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
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
    <script src="script.js"></script><!--carousel script-->
    <script src="backtotop.js"></script>
  
    <!-- bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
  </body>
</html>
