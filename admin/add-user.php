<?php
    session_start();
    include '../conn.php';

    // check if user is logged in
    if (!isset($_SESSION['loggedin']) || !$_SESSION['loggedin']) {
        //user is not logged in, redirect to login page
        header("Location: ../login.php");
        exit();
    }

    if (isset($_SESSION['role']) && $_SESSION['role'] == 2) {
        //user has role 2, redirect to userprofile.php
        header("Location: ../userprofile.php");
        exit();
    }

    
    $role = $firstname = $lastname = $email = $bday = $phone = $password = $repassword = "";
    $role_err = $firstname_err = $lastname_err = $email_err =  $bday_err = $phone_err = $password_err = $repassword_err = "";

    if($_SERVER["REQUEST_METHOD"] == "POST"){
      
      //not working pa | need mag-agree sa terms
      if (empty($_POST['terms'])) {
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
      } else{
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

      $role = $_POST["role"];

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
          $sql = "INSERT INTO info_accts (firstname, lastname, username, phone, birthday, password, role) VALUES (?, ?, ?, ?, ?, ?, ?)";
          
           
          if($stmt = mysqli_prepare($conn, $sql)){
              // Bind variables to the prepared statement as parameters
              mysqli_stmt_bind_param($stmt, "sssssss", $param_firstname, $param_lastname, $param_email, $param_phone, $param_birthday, $param_password, $param_role);
              
              // Set parameters
              $param_firstname = $firstname;
              $param_lastname = $lastname;
              $param_email = $email;
              $param_phone = $phone;
              $param_birthday = $bday;
              $param_email1 = $email;
              $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
              $param_role = $role;
                    
            if(mysqli_stmt_execute($stmt)){
                header("location: users.php");
            } else {
                  echo "Oops! Something went wrong. Please try again later.";
            }

            mysqli_stmt_close($stmt);
          }

    }
      // Close connection
      mysqli_close($conn);
  }
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Ultimate Shoe Battle | Admin</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="icon" type="image/png" sizes="16x16" href="../img/logo.png">
    <link rel="stylesheet" href="./css/customerstyle.css">
    <link href="../css/style.min.css" rel="stylesheet">
    <link href="../css/pagestyles.css" rel="stylesheet">
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>

    <style>
        @import url('https://fonts.googleapis.com/css?family=Inter');
        @import url('https://fonts.googleapis.com/css?family=Readex Pro');

        body {font: 14px sans-serif; background-color: #e7e7e7; color: #141C07;}
        .wrapper { width: 360px; padding: 20px;}
        /*changed wrapper*/
        .wrapper {
        width: 600px;
        margin: 0 auto;
        }

        .edituserblock {
        background-color: #fff;
        border-radius: 10px;
        padding: 20px;
        /*changed width*/
        width: 600px;
        margin-top: 30px;
        box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.15);
        }

        .back-icon img {
        width: 40px;
        height: 40px;
        top: 60px;
        /*changed left*/
        left: calc(50% - 700px/2);
        position: absolute;
        }

        .btn-style {
        margin-bottom: 0px;
        font-family: 'Inter';
        font-weight: 600;
        /*margin-left added*/
        margin-left:413px;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="top-line"></div>    
        <div class="back-icon">
            <a href="../admin/users.php">
                <img src="../img/backicon.png">
            </a>
        </div>
        <div class="edituserblock">
            <h2>Add User</h2>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <div class="row">
                    <div class="col-sm">
                        <div class="form-group">
                            <label>First Name</label>
                            <input type="text" name="firstname" class="form-control <?php echo (!empty($firstname_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $firstname; ?>">
                            <span class="invalid-feedback"><?php echo $firstname_err; ?></span>
                         </div>
                    </div>

                    <div class="col-sm">                                                      
                        <div class="form-group">
                            <label>Last Name</label>
                            <input type="text" name="lastname" class="form-control <?php echo (!empty($lastname_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $lastname; ?>">
                            <span class="invalid-feedback"><?php echo $lastname_err; ?></span>
                        </div>    
                    </div>
                                                
                </div>
                <div class="row">
                    <div class="col-sm">
                        <div class="form-group">
                            <label>Username</label>
                            <input type="text" name="email" class="form-control <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $email; ?>">
                            <span class="invalid-feedback"><?php echo $email_err; ?></span>
                        </div>    
                    </div>

                    <div class="col-sm">                            
                        <div class="form-group">
                            <label for="role">Role</label>
                            <select name ="role" class="form-select form-select-sm mb-3" aria-label=".form-select-sm example">
                                <option value=1>Admin</option>
                                <option value=2>User</option>
                            </select> 
                        </div> 
                    </div>
                        
                </div>
                 <div class="row">
                    <div class="col-sm">
                        <div class="form-group">
                            <label>Birthday</label>
                            <input type="date" name="bday" class="form-control <?php echo (!empty($bday_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $bday; ?>">
                            <span class="invalid-feedback"><?php echo $bday_err; ?></span>
                        </div>                                                           
                    </div>

                    <div class="col-sm">                                                                                
                        <div class="form-group">
                            <label>Contact Number</label>
                            <input type="tel" name="phone" class="form-control <?php echo (!empty($phone_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $phone; ?>">
                            <span class="invalid-feedback"><?php echo $phone_err; ?></span>
                        </div>
                    </div>                        
                </div>
                <div class="row">
                    <div class="col-sm">                                                      
                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" name="password" class="form-control showhide-password <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $password; ?>">
                            <span class="invalid-feedback"><?php echo $password_err; ?></span>
                            <input type="checkbox" class="showPassword"><span class="show-pw"> Show Password</span>
                        </div>
                    </div>   
                    <div class="col-sm">                                                                                
                        <div class="form-group">
                            <label>Confirm Password</label>
                            <input type="password" name="repassword" class="form-control showhide-password <?php echo (!empty($repassword_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $repassword; ?>">
                            <span class="invalid-feedback"><?php echo $repassword_err; ?></span>                            
                        </div>
                    </div>                      
                </div>                    
                    
                <!--<div class="form-group buttonsalign">-->
                    <input type="submit" class="btn btn-primary btn-style" value="Submit">
                    <input type="reset" class="btn btn-secondary ml-2 btn-style-2" value="Reset">
                <!--</div>-->
            </form>
        </div>             
    </div>
    <script src="../showpw.js"></script>    
</body>
</html>
