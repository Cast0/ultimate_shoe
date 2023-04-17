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

    include "conn.php";

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
            header("Location: myAddresses.php");
        }
      }
?>

<!DOCTYPE html>
<html lang="en" class="scroller">
  <head>
    <meta charset="utf-8" />
    <title>KADS | My Addresses</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <!-- bootstrap -->
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65"
      crossorigin="anonymous"
    />
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
    <!-- css -->
    <link rel="stylesheet" href="css/header-responsive.css" /> 
    <link rel="stylesheet" href="css/user.css" />
    <link rel="stylesheet" href="css/footer.css" />   
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

     <div class="content-container container d-flex justify-content-center">          
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
                    <button type="button" class="side-links side-links-active">
                      My Addresses                  
                    </button>
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
                      <button type="button" class="side-links">Order History</button>
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
            <div class="col right-content">
              <h1 class="container-title text-center">My Addresses</h1>
              <div class="title-line"></div>

          <form class="form-style" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">

          <input type="hidden" name="id" value="<?php echo $id; ?>">

            <div class="row">
              <div class="col">
                <label for="address">Delivery Address</label>
                <input
                  type="text"
                  class="form-control <?php echo (!empty($house_err)) ? 'is-invalid' : ''; ?>"
                  id="address"
                  name="house"
                    value="<?php echo $res['house']; ?>"
                    placeholder="111 Somewhere Street"
                />
                <span class="invalid-feedback"><?php echo $house_err; ?></span>
              </div>
            </div>

            <div class="row">
              <div class="col">
                <label for="city">City</label>
                <select type="text" class="form-control" id="city" name="city">
                  <option value="<?php echo $row['city']; ?>"><?php echo $row['city']; ?></option>
                  <option value="Caloocan">Caloocan</option>
                  <option value="Las Piñas">Las Piñas</option>
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
                  <option value="Quezon City">Quezon City</option>
                  <option value="San Juan">San Juan</option>
                  <option value="Taguig">Taguig</option>
                  <option value="Valenzuela">Valenzuela</option>
                </select>
              </div>
              <div class="col">
                <label for="province">Province</label>
                <select id="province" name="province" class="form-control">
                  <option value="Metro Manila">Metro Manila</option>
                </select>
              </div>
            </div>

            <div class="row">                  
              <div class="col">
                <label for="zip">ZIP Code</label>
                <input type="text" class="form-control <?php echo (!empty($zip_err)) ? 'is-invalid' : ''; ?>" id="zip" name="zip" 
                  placeholder="ZIP" 
                  pattern="[0-9]{4}" 
                  maxlength="4"
                    value="<?php echo $res['zip']; ?>">
                  <span class="invalid-feedback"><?php echo $zip_err; ?></span>
              </div>

            </div>  

            <div class="row" style="margin-bottom: 20px;">
              <!--<div class="col">
                <input type="checkbox" id="same" name="same" value="same" />
                <label for="same">
                  My billing and shipping address are the same</label
                ><br />
              </div>-->
            </div>

            <button type="submit" class="btn btn-save">Save</button>
          </form>

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
     <!-- input mask for phone number -->
     <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.6/jquery.inputmask.min.js"></script>
      <script>
        $(document).ready(function() {
            $("#pnumber").inputmask('99999999999');
            $("#zip").inputmask('9999');
        }); 
      </script>
    <!-- bootstrap -->
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4"
      crossorigin="anonymous"
    ></script>
  </body>
</html>