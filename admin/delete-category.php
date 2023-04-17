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

// Process delete operation after confirmation
if (isset($_POST["id"]) && !empty($_POST["id"])) {
    // Include config file
    require_once "../conn.php";

    // Prepare a delete statement
    $sql = "DELETE FROM categories WHERE c_id = ?";

    if ($stmt = mysqli_prepare($conn, $sql)) {
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "i", $param_id);

        // Set parameters
        $param_id = trim($_POST["id"]);

        // Attempt to execute the prepared statement
        if (mysqli_stmt_execute($stmt)) {
            // Records deleted successfully. Redirect to landing page
            header("location: category.php");
            exit();
        } else {
            echo "Oops! Something went wrong. Please try again later.";
        }
    }

    // Close statement
    mysqli_stmt_close($stmt);

    // Close connection
    mysqli_close($conn);
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
        .wrapper {
            width: 600px;
            margin: 0 auto;
        }

        .btn-danger {
            color: #fff;
            margin-bottom: 0px;
            margin-right: 10px;
            border-radius: 5px;
            width: 70px;
            background-color: #C70800;
            /*border added*/
            border: none;
        }

        .btn-secondary {
            background-color: #fff;
            color: #2C2A3A;
            border: 1px solid #C70800;
            border-radius: 5px;
            /*margin-bottom added*/
            margin-bottom: 0px;
        }

        .btn-secondary:hover,
        .btn-secondary:focus,
        .btn-danger:hover,
        .btn-danger:focus {
            background-color: #8e0001;
            /*color added*/
            color: #fff;
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <div class="top-line"></div>
        <div class="back-icon2">
            <a href="../admin/category.php">
                <img src="../img/backicon.png">
            </a>
        </div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="alert alert-danger">
                            <h2>Delete Category</h2>
                            <input type="hidden" name="id" value="<?php echo trim($_GET["id"]); ?>" />
                            <p>Are you sure you want to delete this category?</p>
                            <p class="buttonsalign2">
                                <input type="submit" value="Yes" class="btn btn-danger btn-style">
                                <a href="category.php" class="btn btn-secondary btn-style2">No</a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>