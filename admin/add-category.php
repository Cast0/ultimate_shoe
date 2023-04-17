<?php
session_start();

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
    include "../conn.php";

    $username = $_SESSION['username'];

    $catname = "";
    $catname_err = "";

    $query = "SELECT * FROM categories";
    $result = mysqli_query($conn, $query);

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        if (empty(trim($_POST["catname"]))) {
            $catname_err = "Please enter a category name.";
        } else {
            $sql = "SELECT c_id FROM categories WHERE categoryName = ?";

            if ($stmt = mysqli_prepare($conn, $sql)) {
                mysqli_stmt_bind_param($stmt, "s", $param_catname);

                $param_catname = trim($_POST["catname"]);

                if (mysqli_stmt_execute($stmt)) {
                    mysqli_stmt_store_result($stmt);

                    if (mysqli_stmt_num_rows($stmt) == 1) {
                        $catname_err = "This category already exists.";
                    } else {
                        $catname = trim($_POST["catname"]);
                    }
                } else {
                    echo "Oops! Something went wrong. Please try again later.";
                }

                mysqli_stmt_close($stmt);
            }
        }

        if (empty(trim($_POST["catname"]))) {
            $catname_err = "Please enter a first name.";
        } elseif (!preg_match('/^[a-zA-Z ]+$/', trim($_POST["catname"]))) {
            $catname_err = "Name can only contain letters.";
        } else {
            $catname = trim($_POST["catname"]);
        }
        
        $sql = "INSERT INTO categories (categoryName) VALUES('$catname')";
        mysqli_query($conn, $sql);
        header("Location: category.php");
    }


?>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KADS | Admin</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="icon" type="image/png" sizes="16x16" href="../img/logo.png">
    <link rel="stylesheet" href="./css/customerstyle.css">
    <link href="../css/style.min.css" rel="stylesheet">
    <link href="../css/pagestyles.css" rel="stylesheet">
</head>
<style>
    @import url('https://fonts.googleapis.com/css?family=Inter');
    @import url('https://fonts.googleapis.com/css?family=Readex Pro');

    body {font: 14px sans-serif; background-color: #e7e7e7; color: #141C07;}

    .btn-style {
    margin-bottom: 0px;
    font-family: 'Inter';
    font-weight: 600;
    /*margin-left added*/
    margin-left:309px;
    }
</style>

<body>
    <div class="wrapper">
        <div class="top-line"></div>
        <div class="back-icon">
            <a href="../admin/category.php">
                <img src="../img/backicon.png">
            </a>
        </div>
        <div class="edituserblock">
            <h2>Add Category</h2>
            <?php if (isset($_GET['error'])): ?>
                <p><?php echo $_GET['error']; ?></p>
                <?php endif ?>

            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST"
                enctype="multipart/form-data">
                <div class="form-group">
                    <label>Category Name</label>
                    <input type="text" name="catname"
                        class="form-control <?php echo (!empty($catname_err)) ? 'is-invalid' : ''; ?>"
                        value="<?php echo $catname; ?>">
                    <span class="invalid-feedback">
                        <?php echo $catname_err; ?>
                    </span>
                </div>
                <input class="btn btn-primary btn-style" type="submit" name="submit" value="Add">
                
            </form>
        </div>
    </div>



</body>

</html>