<?php
    require 'conn.php';

    session_start();

    if (isset($_SESSION['role']) && $_SESSION['role'] == 1) {
      //user has role 2, redirect to userprofile.php
      header("Location: admin/dashboard.php");
      exit();
    }

    if (isset($_SESSION['role']) && $_SESSION['role'] == 2) {
      //user has role 2, redirect to userprofile.php
      header("Location: userprofile.php");
      exit();
    }
    
    $email = $password =  "";
    $email_err = $password_err = $login_err = "";

    if (isset($_REQUEST['email'])) {
      
      // Check if email is empty
      if(empty(trim($_POST["email"]))){
        $email_err = "Please enter email.";
      } else{
        $email = trim($_POST["email"]);
      }
    
      // Check if password is empty
      if(empty(trim($_POST["password"]))){
        $password_err = "Please enter your password.";
      } else{
        $password = trim($_POST["password"]);
      }

      if(empty($email_err) && empty($password_err)) {
        $sql = "SELECT * FROM info_accts WHERE username = '$email'";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) === 1) {
          $row = mysqli_fetch_assoc($result);
          $verifypassword = password_verify($password, $row['password']);
            if($email === $row['username'] && $verifypassword) {
              if($row['role'] == 1) {
                $_SESSION['username'] = $row['username'];
                $_SESSION['loggedin'] = true;
                $_SESSION['role'] = $row['role'];
                $_SESSION['id'] = $row['id'];
                header("Location: admin/dashboard.php");
                exit();
                }
              else if ($row['role'] == 2) {
                $_SESSION['username'] = $row['username'];
                $_SESSION['loggedin'] = true;
                $_SESSION['role'] = $row['role'];
                $_SESSION['id'] = $row['id'];
                header("Location: userprofile.php");
                exit();
                }
            } else {
              $login_err = "Incorrect credentials.";
              }
        } else {
          $login_err = "Incorrect credentials.";
        }
      }
    }
    
?>

<!DOCTYPE html>
<html lang="en" class="scroller">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/login.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ultimate Shoe Battle | Sign In</title>
    <!-- bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4"
        crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
    <!-- css -->    
    <link rel="stylesheet" href="css/footer.css" />
    <link rel="stylesheet" href="css/header-responsive.css" />      
    <!-- favicon -->
    <link rel="icon" type="image/x-icon" href="favicon.ico" />
    <!-- fontawesome -->
    <script src="https://kit.fontawesome.com/03977197ef.js" crossorigin="anonymous"></script>    
</head>
<body>
  <?php
    include 'header-guest.html';
  ?>

<div class="d-flex flex-wrap container">
    <div class="row w-100 content-style">
      <div class="left-container col-5">
        <div class="crop-img">
          <img src="images/sushi-login1.jpg" alt="dummy image">
        </div>
      </div>
      <div class="right-container col align-self-center">
        <div class="title">Sign In</div>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">

          <?php 
            if(!empty($login_err)){
              echo '<div class="alert alert-danger">' . $login_err . '</div>';
            }        
          ?>

          <div class="col">
            <h6 class="input-lbl">Email</h6>
            <input type="text" class="form-control <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $email; ?>" name="email" id="email" placeholder="abc@gmail.com" require>
            <span class="invalid-feedback"><?php echo $email_err; ?></span> 
          </div>

          <div class="col">
            <h6 class="input-lbl">Password</h6>
            <input type="password" class="form-control showhide-password <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $password; ?>" name="password" id="password" placeholder="********" require>        
            <input type="checkbox" class="showPassword"><span class="show-pw">Show Password</span>
            <span class="invalid-feedback"><?php echo $password_err; ?></span> 
            <!-- show/hide pw toggle icon -->
            <!--
            <span class="input-group-text align-self-stretch align-items-center" onclick="password_show_hide();">
              <i class="fas fa-eye" id="show_eye"></i>
              <i class="fas fa-eye-slash d-none" id="hide_eye"></i>                
            </span>  
            -->
          </div>          

          <div class="row">
            <div class="col">
              <button class="btn-arrow btn" id="btn-arrow"><i class='fas fa-arrow-right'></i></button>                                                 
            </div>
          </div>

          <div class="row" style="margin-bottom: 40px;">
            <div class="col">
              Don't have an account yet? 
              <a class="link-style" href="registration.php">Sign up.</a>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- back to top button -->
  <button style="height: 46px; width: 46px;"
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
<script src="showpw.js"></script>
</body>
</html>
