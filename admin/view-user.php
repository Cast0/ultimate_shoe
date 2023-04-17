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
    $userID = $_GET['id'];
    
    $query="SELECT * FROM info_accts WHERE id = $userID";
    $result=mysqli_query($conn,$query);
    $row = mysqli_fetch_assoc($result)
?>

<!DOCTYPE html>
<html dir="ltr" lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title> Ultimate Shoe Battle | Admin</title>
    <link rel="icon" type="image/png" sizes="16x16" href="../img/logo.png">
    <!--<link href="../plugins/bower_components/chartist/dist/chartist.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../plugins/bower_components/chartist-plugin-tooltips/dist/chartist-plugin-tooltip.css"> -->
    <link href="../css/style.min.css" rel="stylesheet">
    <link href="../css/pagestyles.css" rel="stylesheet">

    <style>    
        @import url('https://fonts.googleapis.com/css?family=Inter');
        @import url('https://fonts.googleapis.com/css?family=Readex Pro');

        body {font: 14px sans-serif; background-color: #e7e7e7; color: #141C07;}
        .wrapper { width: 360px; padding: 20px;}
        /*changed wrapper*/
        .wrapper {
        width: 500px;
        margin: 0 auto;
        }

        .edituserblock {
        background-color: #fff;
        border-radius: 10px;
        padding: 20px;
        /*changed width*/
        width: 500px;
        margin-top: 30px;
        box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.15);
        }

        .back-icon img {
        width: 40px;
        height: 40px;
        top: 60px;
        /*changed left*/
        left: calc(50% - 600px/2);
        position: absolute;
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
            <h2>View User</h2> 
            <div class="container">
                <div class="row"style="border-bottom: 1px solid #ECEFD7;">
                    <p>
                    <div class="col p-1"><label>Name:</label></div>
                    <div class="col-8 p-1"><?php echo $row['firstname'] . '  '. $row['lastname'] ; ?></div> 
                    </p>                       
                </div>  

                <div class="row" style="border-bottom: 1px solid #ECEFD7;">
                    <p>
                    <div class="col p-1"><label>Username:</label></div>
                    <div class="col-8 p-1"><?php echo $row['username']; ?></div> 
                    </p>                       
                </div>
                        
                <div class="row" style="border-bottom: 1px solid #ECEFD7;">
                    <p>
                    <div class="col p-1"><label>Phone:</label></div>
                    <div class="col-8 p-1"><?php echo $row['phone']; ?></div> 
                    </p>                       
                </div>

                <div class="row" style="border-bottom: 1px solid #ECEFD7;">
                    <p>
                    <div class="col p-1"><label>Birthday:</label></div>
                    <div class="col-8 p-1"><?php echo $row['birthday']; ?></div> 
                    </p>                       
                </div>    
                
                <div class="row">
                    <p>
                    <div class="col p-1"><label>Role:</label></div>
                    <div class="col-8 p-1"><?php if ($row['role'] == 1){
                                                        echo "admin";
                                                    }else if ($row['role'] == 2) {
                                                        echo "user";
                                                    } ?></div> 
                    </p>                       
                </div>
                
            </div>  
        </div>
    </div>
</body>

</html>