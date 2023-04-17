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

$id = $catname = "";
$catname_err ="";

if(isset($_GET["edit"])){
    $id = $_GET['edit'];
    $sql1 = (mysqli_query($conn, "SELECT * FROM categories WHERE c_id = '$id'"));
        $pro = mysqli_fetch_array($sql1); 
        $catname  = $pro["categoryName"];       
}

if($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $catname  = $_POST["catname"];

    $sql = "SELECT c_id FROM categories WHERE categoryName = ?";
        
    if($stmt = mysqli_prepare($conn, $sql)){
        mysqli_stmt_bind_param($stmt, "s", $param_catname);
        
        $param_catname = trim($_POST["catname"]);
        
        if(mysqli_stmt_execute($stmt)){
            mysqli_stmt_store_result($stmt);
            
            if(mysqli_stmt_num_rows($stmt) == 1){
                $catname_err = "This category already exists.";
            } else{
                $catname = trim($_POST["catname"]);
            }
        } else{
            echo "Oops! Something went wrong. Please try again later.";
        }

        mysqli_stmt_close($stmt);
    }

    mysqli_query($conn, "UPDATE categories SET categoryName = '$catname' WHERE c_id = '$id'");
    header("Location: category.php");
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>KADS | Admin</title>
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
        .wrapper{
            width: 600px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="top-line"></div>  
        <div class="back-icon">
            <a href="../admin/category.php">
                <img src="../img/backicon.png">
            </a>
        </div>   
        <div class="edituserblock" style="margin-left:100px;">
            <h2>Edit Category</h2> 
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo $id; ?>">
                <div class="form-group">
                    <label>Category Name</label>
                    <input type="text" name="catname" class="form-control <?php echo (!empty($catname_err)) ? 'is-invalid' : ''; ?>" value=" <?php echo $catname?>">
                    <span class="invalid-feedback"><?php echo $catname_err; ?></span>
                </div>
                
                <input type="submit" class="btn btn-primary btn-style" style="margin-left:204px;" value="Update">
                <a href="category.php" class="btn btn-secondary ml-2 btn-style2">Cancel</a>
            </form>
        </div>             
    </div>                          
</body>
</html>


<!--style="margin-left:195px;-->