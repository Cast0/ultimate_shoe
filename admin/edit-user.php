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
$id = $firstname = $mname = $lastname = $birthday = $phone = $email = $role = "";
$username_err = "";


if(isset($_GET["edit"])){
    $id = $_GET['edit'];

    $sql1 = (mysqli_query($conn, "SELECT * FROM info_accts WHERE id = $id"));

        $user = mysqli_fetch_array($sql1); 
        $firstname   = $user["firstname"];
        $lastname    = $user["lastname"];
        $bday   = $user["birthday"];
        $phone   = $user["phone"];
        $email    = $user["username"];
        $role       = $user["role"];
    }

if($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $firstname = $_POST["firstname"];
    $lastname = $_POST["lastname"];
    $bday = $_POST["bday"];
    $phone = $_POST["phone"];
    $email = $_POST["email"];
    $role = trim($_POST["role"]);
    
    if(empty(trim($_POST["email"]))){
        $email_err = "Please enter a username.";
    } else{
        $sql = "SELECT id FROM info_accts WHERE username = ?";
        
        if($stmt = mysqli_prepare($conn, $sql)){
            mysqli_stmt_bind_param($stmt, "s", $param_email);
            
            $param_email = trim($_POST["email"]);
            
            if(mysqli_stmt_execute($stmt)){
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $email_err = "This username is already taken.";
                } else{
                    $email = trim($_POST["email"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            mysqli_stmt_close($stmt);
        }
    } 

    mysqli_query($conn, "UPDATE info_accts SET firstname = '$firstname',  lastname= '$lastname', username= '$email', phone = '$phone', birthday = '$bday', role = '$role' WHERE id= '$id'");
    header("Location: users.php");
}


?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Ultimate Shoe Battle | Admin</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="icon" type="image/png" sizes="16x16" href="../img/logo.png">
    <link rel="stylesheet" href="./css/customerstyle.css">
    <link href="../css/style.min.css" rel="stylesheet">
    <link href="../css/pagestyles.css" rel="stylesheet">

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
        /*margin-left added*/
        margin-left:412px;
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
                <div class="edituserblockcontent">
                    <h2>Edit User</h2>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                    
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
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
                                            <option value=<?php echo $role; ?>><?php 
                                                if ($role == 1) {
                                                    echo "Admin";
                                                } elseif ($role == 2) {
                                                    echo "User";
                                                }
                                                ?></option>
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

                        <div class="form-group buttonsalign">
                            <input type="submit" class="btn btn-primary btn-style" value="Submit" style="margin-left:489px;">
                        </div>

                    </form>
                </div>
            </div>  
        </div>

    </div>    
                        
</body>
</html>
