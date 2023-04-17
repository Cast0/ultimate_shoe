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
    $row = mysqli_fetch_assoc($result);

    $oldusername = $row['username']; 

    $firstname = $lastname = $email = $phone = $bday = "";
    $firstname_err = $lastname_err = $email_err = $phone_err =$bday_err = "";

    if($_SERVER["REQUEST_METHOD"] == "POST") {
     
      $id = $_POST['id'];
     
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
/*
      $sql1="SELECT * from info_accts where username='$oldusername'";
      $res=mysqli_query($conn,$sql1);
      if (mysqli_num_rows($res) > 0) {
        $row = mysqli_fetch_assoc($res);
        if($oldusername != $email){
          if($email==$row['username']) {
           $email_err[] ='Email alredy exists.';
          }
        } else {
          $email = trim($_POST["email"]);
        }
      }
*/
     // Validate email
    if(empty(trim($_POST["email"]))){
      $email_err = "Please enter email.";
    } else {
      $sql = "SELECT id FROM info_accts WHERE username = ? && role = 2 && NOT id = '$id' ";
    
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

      if(empty($firstname_err) && empty($lastname_err) && empty($email_err) && empty($bday_err) && empty($phone_err) ) {
        if ($email == $row['username']) {
          mysqli_query($conn, "UPDATE info_accts SET firstname = '$firstname', lastname = '$lastname', birthday = '$bday', phone = '$phone' WHERE id = '$id'");
          header("Location: userprofile.php");
        } else {
          mysqli_query($conn, "UPDATE info_accts SET firstname = '$firstname', lastname = '$lastname', username = '$email', birthday = '$bday', phone = '$phone' WHERE id = '$id'");
          header("Location: userprofile.php");
        }
      }
      
      
    }
?>


<!Doctype html>
<html lang="en" class="scroller">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>KADS | My Profile</title>
        <!-- bootstrap -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
        <!-- css -->
        <link rel="stylesheet" href="css/header-responsive.css" />
        <link rel="stylesheet" href="css/footer.css" />
        <link rel="stylesheet" href="css/user.css" />
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
                      <button type="button" class="side-links side-links-active">My Profile</button>                    
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
              <h1 class="container-title text-center">My Profile</h1>
              <div class="title-line"></div>

              <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">

                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">

                <div class="row">
                  <div class="col">
                    <label for="inputFirstName">First Name</label>
                    <input type="text" class="form-control <?php echo (!empty($firstname_err)) ? 'is-invalid' : ''; ?>" id="firstname" name="firstname" value="<?php echo $row['firstname']; ?>"/>
                    <span class ="invalid-feedback"><?php echo $firstname_err; ?></span>
                  </div>
                </div>

                <div class="row">                  
                  <div class="col">
                    <label for="inputLastName">Last Name</label>
                    <input type="text" class="form-control <?php echo (!empty($lastname_err)) ? 'is-invalid' : ''; ?>" name="lastname" id="lastname" value="<?php echo $row['lastname'];?>">
                    <span class="invalid-feedback"><?php echo $lastname_err; ?></span>  
                  </div>
                </div>

                <div class="row">                  
                  <div class="col">
                    <label for="inputEmail">Email Address</label>
                    <input type="email" class="form-control <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>" name="email" id="email" value="<?php echo $row['username'];?>">
                    <span class="invalid-feedback"><?php echo $email_err; ?></span>                      
                  </div>
                </div>   
                
                <div class="row">                  
                  <div class="col">
                    <label for="inputBday">Phone Number</label>
                    <input type="tel" class="form-control <?php echo (!empty($phone_err)) ? 'is-invalid' : ''; ?>" name="phone" id="phone" value="<?php echo $row['phone'];?>">
                    <span class="invalid-feedback"><?php echo $phone_err; ?></span>                     
                  </div>
                </div>

                <div class="row" style="margin-bottom: 20px;">                  
                  <div class="col">
                    <label for="inputBday">Date of birth</label>
                    <input type="date" class="form-control <?php echo (!empty($bday_err)) ? 'is-invalid' : ''; ?>" name="bday" id="bday" value="<?php echo $row['birthday'];?>">
                    <span class="invalid-feedback"><?php echo $bday_err; ?></span>                     
                  </div>
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
        <!-- bootstrap -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    </body>
</html>