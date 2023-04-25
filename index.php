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



* {
    margin: 0;
    padding: 0;
    font-family: 'Poppins', sans-serif;
}
.container {
    height: 100vh;
    width: 100%;
    background-image: url(images/bg.png);
    background-position: center;
    background-size: cover;
    padding-right: 5%;
    padding-left: 3%;
    box-sizing: border-box;
    position: relative;
}
.navbar {
    width: 100%;
    height: 15vh;
    margin: auto;
    display: flex;
    align-items: center;
}
.logo {
    width: 180px;
    margin-top: 10px;
    cursor: pointer;
}
nav {
    flex: 1;
    padding-left: 420px;
}
nav ul li {
    display: inline-block;
    list-style: none;
    margin: 0 15px;
}
nav ul li a {
    text-decoration: none;
    color: #1b1b1b;
    text-transform: uppercase;
    font-size: 15px;
    font-weight: 600;
}
a .cart {
    font-size: 60px;
    color: #1b1b1b;
}
a .cart:hover {
    transform: scale(1.1);
    color: rgb(111,167,29);
    transition: all .5s;
}
.content {
    position: relative;
}
h1 {
    text-transform: uppercase;
    font-weight: 800;
    margin-top: 100px;
    letter-spacing: .1em;
    font-size: 70px;
    color: #1b1b1b;
}
h1 .style {
    color: greenyellow;
    font-size: 80px;
    font-weight: 800;
    font-family: 'Lobster', cursive;
}
p {
    font-size: 15px;
    font-weight: 600;
    letter-spacing: .1em;
    margin-top: 35px;
    color: #1b1b1b;
}
.text {
    position: relative;
    display: flex;
    align-items: center;
}
.btn {
    background-color: greenyellow;
    margin-top: 80px;
    padding: 15px 45px;
    text-align: center;
    border: none;
    outline: none;
    transition: .5s;
    text-transform: uppercase;
    color: #1b1b1b;
    cursor: pointer;
    font-weight: 700;
    font-size: 24px;
    display: block;
    border-radius: 30px;
    background-size: 200% auto;
    box-shadow: 3px 8px 22px rgba(22,21,21,.15);
}
.btn:hover {
    transform: scale(1.1);
    transition: all .5s;
}
.social-media {
    font-family: 'Poppins', sans-serif;
    margin-top: 80px;
    margin-left: 50px;
    text-decoration: none;
    font-size: 27px;
 }
 .icons {
    color: greenyellow;
    padding: 12px 12px 10px 12px;
    border-radius: 50%;
    margin-left: 10px;
    width: 27px;
    text-align: center;
    height: 27px;
    background-color: #fff;
    box-shadow: 3px 8px 22px rgba(22, 21, 21, 0.15);
 }
 .icons:hover {
    transform: scale(1.1);
    color: #fff;
    background-color: greenyellow;
    transition: all .5s;
 }
.image {
    position: absolute;
    width: 47%;
    height: 47%;
    bottom: 0;
    margin-bottom: 170px;
    margin-left: 530px;
    transform: rotate(-35deg);
}

    
  

    <div class="content-3">
      <div class="d-flex justify-content-center text-center">
        <div class="p-2 text-center"><h2 class="howto text-center">Shoes</h2></div>
      </div>
      <div class="d-flex justify-content-center text-center">
        <div class="p-2 text-center"><p class="follow text-center">description of shoes</p></div>
      </div>     
    </div>

    <div class="content-4">
      <div class="d-flex justify-content-start">
        <div class="text-left ohayo-group">
          <h2 class="ohayo-title">&#128075; PAK U</h2>
          <p class="ohayo-text">
            Description of shoes
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
            echo "    No best seller products found.";
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
                  <a href="shoes.php"><button class="button card-btn">View</button></a>
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

    


    <!---------------------JS-------------------->      
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
    <script src="script.js"></script><!--carousel script-->
    <script src="backtotop.js"></script>
  
    <!-- bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
  </body>
</html>
