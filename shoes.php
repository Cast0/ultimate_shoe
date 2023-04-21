<?php
session_start();

if (isset($_SESSION['role']) && $_SESSION['role'] == 1) {
  //user has role 2, redirect to userprofile.php
  header("Location: admin/dashboard.php");
  exit();
}

  include "conn.php";

    if (isset($_GET['p_id'])) {
        $product_id = $_GET['p_id'];
        // If session cart is not empty
        if (!empty($_SESSION['cart'])) {
          // Using "array_column() function" we get the product id existing in session cart array
          $acol = array_column($_SESSION['cart'], $product_id);
          // now we compare whther id already exist with "in_array() function"
          if (in_array($product_id, $acol)) {
            // Updating quantity if item already exist
            $_SESSION['cart'][$product_id]['qty'] += 1;
          } else {
            // If item doesn't exist in session cart array, we add a new item
            $item = [
              'product_id' => $_GET['p_id'],
              'qty' => 1,
              'product_image' => $_GET['p_image'],
              'product_name' => $_GET['p_name'],
              'product_price' => $_GET['p_price']
            ];
            $_SESSION['cart'][$product_id] = $item;
          }
        } else {
          // If cart is completely empty, then store item in session cart
          $item = [
            'product_id' => $_GET['p_id'],
            'qty' => 1,
            'product_image' => $_GET['p_image'],
            'product_name' => $_GET['p_name'],
            'product_price' => $_GET['p_price']
          ];
          $_SESSION['cart'][$product_id] = $item;
        }
      }
?>

<!DOCTYPE html>
<html lang="en" class="scroller">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    
    <title>Ultimate Shoe Battle</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4"
        crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css">
    <!-- css -->
    <link rel="stylesheet" href="css/header-responsive.css" />
    <link rel="stylesheet" href="css/footer.css" />
    <link rel="stylesheet" href="css/shoe.css" />
    <!-- favicon -->
    <link rel="icon" type="image/x-icon" href="favicon.ico" />
    <!-- fontawesome -->
    <script src="https://kit.fontawesome.com/03977197ef.js" crossorigin="anonymous"></script>
</head>
<style>
  .user-name, td>a, .fa-cart-shopping, tr > #usertitle{color: #fff;}
  .user-name:hover, .fa-cart-shopping:hover {color: #2C293A;}  
  @media (max-width: 991.98px) {
    .user-name, td>a, .fa-cart-shopping, tr > #usertitle{color: #2C293A;}
    .fa-cart-shopping {color:#C70800;}
    .fa-cart-shopping:hover, .user-name:hover {color:#8e0000;}
    }
</style>
<body>
  <?php if(!isset($_SESSION['loggedin'])) {
          include 'header-guest.html';
        } else {
          $username = $_SESSION['username'];
          $id = $_SESSION['id'];
          include 'header-user.php';
        }
  ?>

    
    <!-- Shoe List -->
    <div class="menu_container">

        <div class="title">
            <h2>Shoe List</h2>
        </div>

        <!-- category buttons-->
        
        
        <div class="content">
            <div class="list">
                <li data-color=".All">All</li>
                <?php 
                $sql1 = "SELECT * FROM categories" ;
                $result = mysqli_query($conn, $sql1);
                if(mysqli_num_rows($result) > 0) {
                    while($row = mysqli_fetch_assoc($result)){
                        $getFirstWord = explode(" ", $row['categoryName']);
                        $sort = strtolower($getFirstWord[0]);
                ?>
                <li data-color=".<?php echo $sort; ?>"><?php echo $row['categoryName']; ?></li>
                <?php } 
                }?> 
            </div>
        </div>
              </div>
        
        <!-- end of category buttons-->

        <?php
        $sql2 = "SELECT * FROM products INNER JOIN categories ON products.category = categories.c_id" ;
        $result = mysqli_query($conn, $sql2);
        if(mysqli_num_rows($result) > 0) {
        ?>

        <!-- categories -->
        <form class="form-style" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
            <div class="menu_box">
                <?php 
                            while($row = mysqli_fetch_assoc($result)){
                                $getFirstWord = explode(" ", $row['categoryName']);
                                $sort = strtolower($getFirstWord[0]);
                ?>

                <div class="box All <?php echo $sort; ?>">
                    <div class="box_img">
                        <img src="img/menu/<?=$row['image']?>" alt="">
                    </div>
                    <div class="text">
                    <div class="text-info d-flex align-items-center justify-content-center">
                        <p class="align-middle"><?php echo $row['productName']; ?></p>                    
                    </div>
                    <section>₱<?php echo $row['price']; ?></section>
                        <a href="product-view.php?p_id=<?php echo $row['p_id']; ?>&
                        p_image=<?php echo $row['image']; ?>&
                        p_price=<?php echo $row['price']; ?>&
                        p_name=<?php echo $row['productName']; ?>"
                        class="btnAddToCart"> View Shoes </a>                    
                </div>
            </div>
            
        </form>
        <!-- end of categories -->

            <?php } 
                }?> 
                
         </div>
    
    <!-- end of menu-->

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
    <script src="backtotop.js"></script>
    
    <script>
        let list = document.querySelectorAll(".list li");
        let box = document.querySelectorAll(".box");

        list.forEach((el) => {
            el.addEventListener("click", (e) => {
                list.forEach((el1) => {
                    el1.style.background = "#2c293a";
                })
                e.target.style.background = "#495057"
                box.forEach((el2) => {
                    el2.style.display = "none";
                })
                document.querySelectorAll(e.target.dataset.color).forEach((el3) => {
                    el3.style.display = "grid";
                })
            })
        })
    </script>
</body>

</html>