<?php
  session_start();

  // check if user is logged in
if (!isset($_SESSION['loggedin']) || !$_SESSION['loggedin']) {
  //user is not logged in, redirect to login page
  header("Location: login.php");
  exit();
}

if (isset($_SESSION['role']) && $_SESSION['role'] == 2) {
  //user has role 2, redirect to userprofile.php
  header("Location: ../userprofile.php");
  exit();
}

    include "../conn.php";

    $username = $_SESSION['username'];
    $id = $_SESSION['id'];

    $query="SELECT * FROM info_accts WHERE id = '$id'";
    $result=mysqli_query($conn,$query);
    $row = mysqli_fetch_assoc($result);

    $oldpass = $newpass = $confirmpass = "";
    $oldpass_err = $newpass_err = $confirmpass_err = "";

    if($_SERVER["REQUEST_METHOD"] == "POST"){

      if(!password_verify($_POST['oldpass'], $row['password'])) {
        $oldpass_err = "Current password is incorrect.";
      } else {
        $oldpass = trim($_POST['oldpass']);
      }

      if(empty(trim($_POST["newpass"]))){
        $newpass_err = "Please enter your new password.";     
      } elseif(strlen(trim($_POST["newpass"])) < 8){
        $newpass_err = "Password must have atleast 8 characters.";
      } else{
        $newpass = trim($_POST["newpass"]);
        if($newpass == $oldpass) {
          $newpass_err = "New password must not be the same as your current password.";
          }
      }

      if(empty(trim($_POST["confirmpass"]))){
        $confirmpass_err = "Please confirm password.";     
      } else {
          $confirmpass = trim($_POST["confirmpass"]);
            if($newpass != $confirmpass){
              $confirmpass_err = "Password did not match.";
            } else{
              $confirmpass = trim($_POST["confirmpass"]);
            }
      } 

      if(empty($oldpass_err) && empty($newpass_err) && empty($confirmpass_err)) {
        $newpassword = password_hash($newpass, PASSWORD_DEFAULT);
        mysqli_query($conn, "UPDATE info_accts SET password='$newpassword' WHERE id='$id'");
        header("Location: AdminchangePass.php");
      }
    }
?>

<!DOCTYPE html>
<html lang="en" class="scroller">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Ultimate Shoe Battle | Admin</title>
    <link rel="icon" type="image/png" sizes="16x16" href="../img/logo.png">
    <!--<link href="../plugins/bower_components/chartist/dist/chartist.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../plugins/bower_components/chartist-plugin-tooltips/dist/chartist-plugin-tooltip.css"> -->
    <link href="../css/style.min.css" rel="stylesheet">
    <link href="../css/pagestyles.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/header-responsive.css" />
    <link rel="stylesheet" href="../css/footer.css" />
    <link rel="stylesheet" href="../css/user.css" />
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
    <style>    
        /* Style The Dropdown Button */
        *{
            font-family: "Readex Pro";
        }
        .dropbtn {
        background-color: #4CAF50;
        color: white;
        padding: 16px;
        font-size: 16px;
        font-family: "Readex Pro";
        border: none;
        cursor: pointer;
        }

        .dropdown {
        position: relative;
        display: inline-block;
        }

        .dropdown-content {
        display: none;
        position: absolute;
        background-color: #f9f9f9;
        min-width: 160px;
        box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
        z-index: 1;
        }

        /* Links inside the dropdown */
        .dropdown-content a {
        color: black;
        padding: 12px 16px;
        text-decoration: none;
        display: block;
        }

        /* Change color of dropdown links on hover */
        .dropdown-content a:hover {background-color: #f1f1f1}

        /* Show the dropdown menu on hover */
        .dropdown:hover .dropdown-content {
        display: block;
        }

        /* Change the background color of the dropdown button when the dropdown content is shown */
        .dropdown:hover .dropbtn {
        background-color: #3e8e41;
        }

    </style>
  </head>
  <body>
  <header class="topbar" data-navbarbg="skin5">
            <nav class="navbar top-navbar navbar-expand-md navbar-dark">
                <div class="navbar-header" data-logobg="skin6">

                <!-- ============================================================== -->
                <!-- Logo | Uncomment na lang kapag meron na -->
                <!-- ============================================================== -->

                   <!-- <a class="navbar-brand" href="dashboard.php">
                        <b class="logo-icon">
                            <img src="../plugins/images/logo-icon.png" alt="homepage" />
                        </b>
                        <span class="logo-text">
                            <img src="../plugins/images/logo-text.png" alt="homepage" />
                        </span>
                    </a> -->
                    <!-- ============================================================== -->
                    <!-- End Logo -->
                    <!-- ============================================================== -->
                    <!-- ============================================================== -->
                    <!-- toggle and nav items -->
                    <!-- ============================================================== -->
                </div>
                <!-- ============================================================== -->
                <!-- End Logo -->
                <!-- ============================================================== -->
                <div class="navbar-collapse collapse" id="navbarSupportedContent" data-navbarbg="skin5">
                   
                    <!-- ============================================================== -->
                    <!-- Right side toggle and nav items -->
                    <!-- ============================================================== -->
                    <ul class="navbar-nav ms-auto d-flex align-items-center">


                        <!-- ============================================================== -->
                        <!-- User profile and search -->
                        <!-- ============================================================== -->
                        <li>
                            <a class="profile-pic" href="#">
                            <div class="dropdown">
                            <img src="../img/logo.png" alt="user-img" width="36"
                                class="img-circle"><span class="font-medium" style="color:#2c2a3a;"><?php echo $username ?></span></a>
                                <div class="dropdown-content">
                                    <a href="profile.php">Profile</a>
                                    <a href="../logout.php">Logout</a>
                                </div>
                            </div>
                        </li>
                        <!-- ============================================================== -->
                        <!-- User profile and search -->
                        <!-- ============================================================== -->
                    </ul>
                </div>
            </nav>
        </header>

    <!-------------- content start --------------->
    <div class="back-icon3">
        <a href="../admin/dashboard.php">
            <img src="../img/backicon.png">
        </a>
    </div>

    <div class="content-container container d-flex justify-content-center">          
          <div class="row content-wrapper">
            <div class="col-4 left-content">
              <div class="container">
                <div class="row links-title-top">My Account</div>      
                <div class="row">
                  <div class="col-1"></div>
                  <div class="col-11">
                    <a href="profile.php">
                      <button type="button" class="side-links">My Profile</button>                    
                    </a>
                  </div>                  
                </div>
                
                <div class="row">
                  <div class="col-1"></div>
                  <div class="col-11">
                    <a href="AdminchangePass.php">
                      <button type="button" class="side-links side-links-active">
                        Change Password
                      </button>
                    </a>
                  </div>                  
                </div>                
                                     
              </div>

            </div>
            <div class="col right-content">
              <h1 class="container-title text-center">Password</h1>
              <div class="title-line"></div>

              <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <div class="row">
                  <div class="col">
                    <label for="password">Current Password</label>
                    <input
                      type="password"
                      class="form-control showhide-password <?php echo (!empty($oldpass_err)) ? 'is-invalid' : ''; ?>"
                      id="password"
                      name="oldpass"
                      placeholder="********"
                      require
                    />
                    <span class="invalid-feedback"><?php echo $oldpass_err; ?></span>  
                  </div>
                </div>

                <div class="row">
                  <div class="col">
                    <label for="newpass">New Password</label>
                    <input
                      type="password"
                      class="form-control showhide-password <?php echo (!empty($newpass_err)) ? 'is-invalid' : ''; ?>"
                      id="newpass"
                      name="newpass"
                      placeholder="********"
                      require
                    />      
                    <span class="invalid-feedback"><?php echo $newpass_err; ?></span>                
                  </div>
                </div>

                <div class="row" style="margin-bottom: 20px;">
                  <div class="col">
                    <label for="confirmpass">Confirm Password</label>
                    <input
                      type="password"
                      class="form-control showhide-password <?php echo (!empty($confirmpass_err)) ? 'is-invalid' : ''; ?>"
                      id="confirmpass"
                      name="confirmpass"
                      placeholder="********"
                      require
                    />
                    <span class="invalid-feedback"><?php echo $confirmpass_err; ?></span>   
                    <input type="checkbox" class="showPassword"><span class="show-pw">Show Password</span>
                  </div>
                </div>

                <button type="submit" class="btn btn-save">Change Password</button>
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
    
    <!---------------------JS-------------------->        
    <script src="backtotop.js"></script>
    <script src="../showpw.js"></script>
    <!-- bootstrap -->
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4"
      crossorigin="anonymous"
    ></script>
  </body>
</html>
