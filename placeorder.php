<?php
session_start();

if (!isset($_SESSION["loggedin"]) && !isset($_SESSION['role'])){
  header("location: login.php");
  exit;
} else if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true && $_SESSION["role"] === 1) {
  header("location: admin/dashboard.php");
  exit;
} else {
    include 'conn.php';
    $username = $_SESSION['username'];
    $id = $_SESSION['id'];

      $query="SELECT * FROM info_accts WHERE id = '$id'";
      $result=mysqli_query($conn,$query);
      $res = mysqli_fetch_assoc($result);

      $house = $city = $province = $zip = "";
      $house_err = $city_err = $province_err = $zip_err = "";

      if($_SERVER["REQUEST_METHOD"] == "POST") {
          $id = $_POST['id'];

         if(empty(trim($_POST['house']))) {
          $house_err = "Please enter your Delivery Address";
         } else {
          $house = trim($_POST['house']);
         }
         
         if(empty(trim($_POST['city']))) {
          $city_err = "Please select your City";
         } else {
          $city = trim($_POST['city']);
         }

         if(empty(trim($_POST['province']))) {
          $province_err = "Please select your Province";
         } else {
          $province = trim($_POST['province']);
         }
        
         if(empty(trim($_POST['zip']))) {
          $zip_err = "Please enter your Zip code";
         } else {
          $zip = trim($_POST['zip']);
         }


        if(empty($house_err) && empty($city_err) && empty($province_err) && empty($zip_err)) {
            mysqli_query($conn, "UPDATE info_accts SET house = '$house', city = '$city', province = '$province', zip = '$zip' WHERE id = '$id'");
            header("Location: ongoingorder.php");
        }
      }

?>


<!doctype html>
<html lang="en" class="scroller">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>KADS | Place Order</title>
    <!-- bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
    <!-- css -->   
    <link rel="stylesheet" href="css/header-responsive.css" />             
    <link rel="stylesheet" href="css/footer.css" />
    <link rel="stylesheet" href="css/placeorder.css" />
    <!-- favicon -->
    <link rel="icon" type="image/x-icon" href="favicon.ico" />
    <!-- fontawesome -->
    <script src="https://kit.fontawesome.com/03977197ef.js" crossorigin="anonymous"></script>
  </head>
  <body>      
    <?php
      include 'header-user.php';
    ?>
    <!-------------- content start --------------->
  <form class="form-style" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">

    <input type="hidden" name="id" value="<?php echo $id; ?>">

    <div class="content-container">
      <div class="content-wrapper container-fluid">
        <h1 class="content-title">Place Order</h1>
        <div class="title-line"></div>
        <form>
          <div class="row">
            <div class="col">
              <label for="firstname">First Name</label>
              <input type="text" class="form-control" id="firstname" value="<?php echo $res['firstname'] ?>" placeholder="First name">
            </div>

            <div class="col">
              <label for="lastname">Last Name</label>
              <input type="text" class="form-control" id="lastname" value="<?php echo $res['lastname'] ?>" placeholder="Last name">
            </div>
          </div>
          
          <div class="row">                  
            <div class="col">
              <label for="email">Email Address</label>
              <input type="email" class="form-control" id="email" value="<?php echo $res['username'] ?>" placeholder="name@example.com">                    
            </div>
          </div>     

          <div class="form-group">
            <label for="address">Delivery Address</label>
            <input type="text" class="form-control" name="house" value="<?php echo $res['house'] ?>" placeholder="1234 Main St">
          </div>  
          
          <div class="row">
            <div class="col">
              <label for="city">City</label>
              <select type="text" class="form-control" name="city">
              <option value="Caloocan" value="<?php echo $res['city'] ?>"><?php echo $res['city'] ?></option>
                <option value="Caloocan">Caloocan</option>
                <option value="LasPiñas">Las Piñas</option>
                <option value="Makati">Makati</option>
                <option value="Malabon">Malabon</option>
                <option value="Mandaluyong">Mandaluyong</option>
                <option value="Manila">Manila</option>
                <option value="Marikina">Marikina</option>
                <option value="Muntinlupa">Muntinlupa</option>
                <option value="Navotas">Navotas</option>
                <option value="Parañaque">Parañaque</option>
                <option value="Pasay">Pasay</option>
                <option value="Pasig">Pasig</option>
                <option value="Pateros">Pateros</option>
                <option value="QuezonCity">Quezon City</option>
                <option value="SanJuan">San Juan</option>
                <option value="Taguig">Taguig</option>
                <option value="Valenzuela">Valenzuela</option>
              </select>
            </div>
            <div class="col">
              <label for="province">Province</label>
              <select id="province" name="province" class="form-control">
                <option value="<?php echo $res['province'] ?>">Metro Manila</option>
              </select>
            </div>
          </div>

          <div class="row">                  
            <div class="col lblstyle">
              <label for="zip">ZIP Code</label>
              <input type="text" class="form-control" name="zip" 
                placeholder="ZIP" 
                pattern="[0-9]{4}"
                value="<?php echo $res['zip'] ?>"
                maxlength="4">
            </div>

            <div class="col lblstyle">
              <label for="pnumber">Phone</label>
              <input type="text" class="form-control" id="pnumber"
                placeholder="09*********"
                pattern="[0-9]{4}[0-9]{3}[0-9]{4}"
                value="<?php echo $res['phone'] ?>"
                minlength="11"
                maxlength="11">
            </div>
          </div>    
      
          <!--<div class="form-check">
            <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
            <label class="form-check-label" for="defaultCheck1">
              My billing and delivery address are the same</label>
          </div>-->
          
            <button type="submit" class="btn-submit">Place Order</button>            
        </form>
      </div>                 
    </div>
    </form>

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
    <!-- input mask for phone number -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.6/jquery.inputmask.min.js"></script>
    <script>
      $(document).ready(function() {
          $("#pnumber").inputmask('99999999999');
          $("#zip").inputmask('9999');
      }); 
    </script>
    <!-- bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
  </body>
</html>


<?php } ?>