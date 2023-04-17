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
    
    $terms = $firstname = $lastname = $email = $bday = $phone = $password = $repassword = "";
    $terms_err = $firstname_err = $lastname_err = $email_err =  $bday_err = $phone_err = $password_err = $repassword_err = "";

    if($_SERVER["REQUEST_METHOD"] == "POST"){
      
      if(empty($_POST['terms']) || $_POST['terms'] !== 'on') {
        $terms_err = "You have to agree to our terms and conditions.";
      }

      // Validate firstname
      if(empty(trim($_POST["firstname"]))){
        $firstname_err = "Please enter your First Name.";     
      } elseif(!preg_match('/^[a-zA-Z ]+$/', trim($_POST["firstname"]))){
        $firstname_err = "Name can only contain letters.";
      } else { 
        $firstname = trim($_POST["firstname"]);
      }

      // Validate lastname
      if(empty(trim($_POST["lastname"]))){
        $lastname_err = "Please enter your Last Name.";     
      } elseif(!preg_match('/^[a-zA-Z ]+$/', trim($_POST["lastname"]))){
        $lastname_err = "Name can only contain letters.";
      } else {
        $lastname = trim($_POST["lastname"]);
      }

      // Validate email
      if(empty(trim($_POST["email"]))){
          $email_err = "Please enter email.";
      } else {
        $sql = "SELECT id FROM info_accts WHERE username = ? && role = 2";
        
        if($stmt = mysqli_prepare($conn, $sql)){
            mysqli_stmt_bind_param($stmt, "s", $param_email);
            
            $param_email = trim($_POST["email"]);
            
            if(mysqli_stmt_execute($stmt)){
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $email_err = "This email is already taken.";
                } else{
                    $email = trim($_POST["email"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            mysqli_stmt_close($stmt);
          }
      }

      // Validate birthday
      if(empty(trim($_POST["bday"]))){
        $bday_err = "Please enter your Birthday.";     
      } else {
        $bday = trim($_POST["bday"]);
      }

      // Validate phone
      if(empty(trim($_POST["phone"]))){
        $phone_err = "Please enter your Contact Number.";     
      } else {
        $phone = trim($_POST["phone"]);
      }
      
      // Validate password
      if(empty(trim($_POST["password"]))){
          $password_err = "Please enter a password.";     
      } elseif(strlen(trim($_POST["password"])) < 8){
          $password_err = "Password must have atleast 8 characters.";
      } else{
          $password = trim($_POST["password"]);
      }
      
      if(empty(trim($_POST["repassword"]))){
        $repassword_err = "Please confirm password.";     
      } else {
          $repassword = trim($_POST["password"]);
          if($password != $repassword){
              $repassword_err = "Password did not match.";
          } else{
              $repassword = trim($_POST["repassword"]);
          }
      }  

      // Check input errors before inserting in database
      if(empty($firstname_err) && empty($lastname_err) && empty($email_err) && empty($bday_err) && empty($phone_err) && empty($password_err) && empty($repassword_err)){
          
          // Prepare an insert statement
          $sql = "INSERT INTO info_accts (firstname, lastname, username, phone , birthday, password, role) VALUES (?, ?, ?, ?, ?, ?, ?)";
          
           
          if($stmt = mysqli_prepare($conn, $sql)){
              // Bind variables to the prepared statement as parameters
              mysqli_stmt_bind_param($stmt, "sssssss", $param_firstname, $param_lastname, $param_email, $param_phone, $param_birthday, $param_password, $param_role);
              
              // Set parameters
              $param_firstname = $firstname;
              $param_lastname = $lastname;
              $param_email = $email;
              $param_phone = $phone;
              $param_birthday = $bday;
              $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
              $param_role = 2;
              
              // Attempt to execute the prepared statement
              if(mysqli_stmt_execute($stmt)){
                 header("location: login.php");
              } else {
                  echo "Oops! Something went wrong. Please try again later.";
            }
            // Close statement
            mysqli_stmt_close($stmt);
          }

      }
      // Close connection
      mysqli_close($conn);
  }
    
?>

<!DOCTYPE html>
<html lang="en" class="scroller">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/registration.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KADS | Register</title>
    <!-- bootstrap -->
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
      <div class="right-container col">
        <div class="title">Sign Up</div>
        <div class="subcontent">Tell us more about you so we can give you a better delivery experience.</div>
        <div class="content">
          
          <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="wrapper">
              <div class="row">
                <h6 class="input-lbl">Name</h6>
                <div class="col-6">
                  <input type="text" class="form-control <?php echo (!empty($firstname_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $firstname; ?>" name="firstname" id="firstname" placeholder="First Name" require>
                  <span class="invalid-feedback"><?php echo $firstname_err; ?></span>  
                </div>
                <div class="col-6">
                  <input type="text" class="form-control <?php echo (!empty($lastname_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $lastname; ?>" name="lastname" id="lastname" placeholder="Last Name" require>
                  <span class="invalid-feedback"><?php echo $lastname_err; ?></span>  
                </div> 
              </div>
              
              <div class="row"> 
                <h6 class="input-lbl">Email Address</h6>
                <div class="col">
                  <input type="email" class="form-control <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $email; ?>" name="email" id="email" placeholder="abc@gmail.com" require>
                  <span class="invalid-feedback"><?php echo $email_err; ?></span>  
                </div>
              </div>

              <div class="row">
                <div class="col-6">
                  <h6 class="input-lbl">Birthday</h6>
                  <input type="date" class="form-control <?php echo (!empty($bday_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $bday; ?>" name="bday" id="bday" placeholder="mm/dd/yyyy" require>
                  <span class="invalid-feedback"><?php echo $bday_err; ?></span>  
                </div>
                <div class="col-6">
                  <h6 class="input-lbl">Contact Number</h6>
                  <input type="tel" class="form-control <?php echo (!empty($phone_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $phone; ?>" name="phone" id="phone" placeholder="09*********" require>
                  <span class="invalid-feedback"><?php echo $phone_err; ?></span>  
                </div> 
              </div>

              <div class="row"> 
                <h6 class="input-lbl">Password</h6>
                <div class="col">
                  <input type="password" class="form-control showhide-password <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $password; ?>" name="password" id="password" placeholder="********" require>
                  <span class="invalid-feedback"><?php echo $password_err; ?></span>  
                </div>
              </div>

              <div class="row"> 
                <h6 class="input-lbl">Re-enter Password</h6>
                <div class="col">
                  <input type="password" class="form-control showhide-password <?php echo (!empty($repassword_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $repassword; ?>" name="repassword" id="repassword" placeholder="********" require>
                  <input type="checkbox" class="showPassword"><span class="show-pw">Show Password</span>
                  <span class="invalid-feedback"><?php echo $repassword_err; ?></span>  
                </div>
              </div>

              <div class="row">
                <div class="col input-chckbx">
                  <input type="checkbox" id="terms" name="terms" required> I have read and agreed to the <a href="terms.php" style="color: #C70800">terms and conditions</a>. </input>
                  <span class="invalid-feedback"><?php echo $terms_err; ?></span>  
                </div>
              </div>

              <div class="row">
                <div class="col">
                  <button id="btn-arrow" class="btn-arrow btn" style=""><i class="fas fa-arrow-right"></i></button>                                                 
                </div>
              </div>

              <div class="row" style="margin-bottom: 40px;">
                <div class="col">
                  Already have an account? 
                  <a class="link-style" href="login.php">Sign in.</a>
                </div>
              </div>
            </div>
          </form>

        </div>
      </div>
      <div class="left-container col-5 align-self-center">
        <div class="crop-img">
          <img src="images/sushi-login.png" alt="dummy image">
        </div>
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
  <!-- bootstrap -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>
</html>