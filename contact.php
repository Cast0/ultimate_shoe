<?php
session_start();
if (isset($_SESSION['role']) && $_SESSION['role'] == 1) {
  //user has role 2, redirect to userprofile.php
  header("Location: admin/dashboard.php");
  exit();
}

  include "conn.php";

  $name = $email = $message = "";
  $name_err = $email_err = $message_err = "";

  if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Validate Name
    if(empty(trim($_POST["name"]))){
      $name_err = "Please enter your Name.";     
    } elseif(!preg_match('/^[a-zA-Z ]+$/', trim($_POST["name"]))){
      $name_err = "Name can only contain letters.";
    } else { 
      $name = trim($_POST["name"]);
    }

    if(empty(trim($_POST["email"]))){
      $email_err = "Please enter your Email.";     
    } else { 
      $email = trim($_POST["email"]);
    }

    if(empty(trim($_POST["message"]))){
      $message_err = "Please enter your message, concerns, feedback, etc.";     
    } else { 
      $message = trim($_POST["message"]);
    }

    if(empty($name_err) && empty($email_err) && empty($message_err)) {
        $sql = "INSERT INTO feedbacks (name, email, message) VALUES('$name', '$email', '$message')";
        mysqli_query($conn, $sql);
        header("Location: contact.php");
    }

  }
?>

<!DOCTYPE html>
<html lang="en" class="scroller">

<head>
  <meta charset="utf-8" />
  <title>KADS | Contact Us</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <!-- bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous" />
  <!-- css -->
  <link rel="stylesheet" href="css/contactus.css" />
  <link rel="stylesheet" href="css/header-responsive.css" />     
    <link rel="stylesheet" href="css/footer.css" />  
    <link rel="icon" type="image/x-icon" href="favicon.ico" />
    <!-- fontawesome -->
    <script src="https://kit.fontawesome.com/03977197ef.js" crossorigin="anonymous"></script>
</head>

<body>
<?php
      if(!isset($_SESSION['loggedin'])) {
        include 'header-guest.html';
      } else {
        $username = $_SESSION['username'];
        $id = $_SESSION['id'];
        include 'header-user.php';
      }
    ?>

  <!-- body -->
  <div class="subheader">
    <h1 class="title">GET IN TOUCH</h1>
    <div class="line">
      <img src="images/line.png">
    </div>
  </div>


  <div class="Row">

    <div class="col1">
      <p class="intro">Leave us a message!</p>
      <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div class="textinputs">
          <div class="namebox">
            <input type="text" name="name" class="form-control <?php echo (!empty($name_err)) ? 'is-invalid' : ''; ?>" placeholder="Name" />
            <span class="invalid-feedback"><?php echo $name_err; ?></span>
          </div> <br>
          <div class="emailbox">
            <input type="text" class="form-control <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>" name="email" placeholder="Email Address" />
            <span class="invalid-feedback"><?php echo $email_err; ?></span> 
          </div> <br>
          <div class="textareabox">
            <textarea class="form-control <?php echo (!empty($message_err)) ? 'is-invalid' : ''; ?>" rows="8" cols="40" name="message"
              placeholder="Send us your concerns, feedbacks, etc."></textarea>
              <span class="invalid-feedback"><?php echo $message_err; ?></span>
          </div><br>
          <button type="submit" class="btn btn-send">Send</button>
        </div>
    </form>
    </div>

    <div class="col2ctn">
      <div class="col2">
        <div class="col2col2">
          <br>
          <br>
          <br>

          <p class="Address">Address: General Luna, corner Muralla Intramuros, Manila, 1002 Metro Manila</p>
          <p class="Phone">Phone: (02) 8643 2500 </p>
          <p class="Email">Email: hello@info.com.ph</p>
        </div>
        <div class="col2col1"><img class="mail" src="images/mail.png" alt="Mail Logo"></div>
      </div>
      <iframe
        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3861.219490039281!2d120.97547591435675!3d14.586565289811443!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3397ca236ab3fd23%3A0x35a633afe84acfc6!2sMuralla%20St%20%26%20General%20Luna%20St%2C%20Intramuros%2C%20Manila%2C%201002%20Metro%20Manila!5e0!3m2!1sen!2sph!4v1672138793694!5m2!1sen!2sph"
        class="h-100 w-100 map" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
      <!--<img class="map" src="images/map.png" alt="Map" />-->
    </div>
  </div>

  <!-- body -->

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
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4"
    crossorigin="anonymous"></script>
</body>

</html>