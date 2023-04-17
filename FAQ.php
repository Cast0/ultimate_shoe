<?php
session_start();
  include "conn.php";

  if (isset($_SESSION['role']) && $_SESSION['role'] == 1) {
    //user has role 2, redirect to userprofile.php
    header("Location: admin/dashboard.php");
    exit();
  }
  
?>

<!DOCTYPE html>
<html lang="en" class="scroller">
  <head>
    <meta charset="utf-8" />
    <title>KADS | FAQs</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <!-- bootstrap -->
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65"
      crossorigin="anonymous"
    />
    <!-- css -->
    <link rel="stylesheet" href="css/header-responsive.css" /> 
    <link rel="stylesheet" href="css/footer.css" />     
    <link rel="stylesheet" href="css/FAQS.css" />
    <!-- favicon -->
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
  
  <section class="body-ctn">
    <div class = "subheader">
        <h1 class="faqs">Frequently Asked Questions</h1>
        <h2 class="description">KADS FAQ</h2>
    </div>
    <div class="container q-container">
      <div class="row">
        <div class="col-lg-6 col-12 left-col">
          <p class="q1">I forgot my password. How do I reset the password of my account?</p>
          <p class="q1ans">Select Sign In, and click on "Forgot Password". </p>
        </div>           
        <div class="col-lg-6 col-12 right-col">
          <p class="q2">Can I cancel my order or make changes to my order?</p>
          <p class="q2ans">We process and ship your orders as quickly as possible. Therefore, orders cannot be edited once they have been placed.</p>            
        </div>
      </div>       
      <div class="row">
        <div class="col-lg-6 col-12 left-col">
          <p class="q3">Will I receive a notification once my order arrives?</p>
          <p class="q3ans">Yes, once your oder has arrived it will automatically send you a notification through your provided phone number.</p>       
        </div>           
        <div class="col-lg-6 col-12 right-col">
          <p class="q4">What if the product that I am looking for is out of stock?</p>
          <p class="q4ans">If a product is out of stock, please refer to the contact us page.</p>
        </div>
      </div>  
      <div class="row">
        <div class="col-lg-6 col-12 left-col">
          <p class="q5">I am coming to celebrate my ____, what special thing can you do for me? (anniversary, birthday, promotion)</p>
          <p class="q5ans">KADS has no packages for such events yet.</p>
        </div>           
        <div class="col-lg-6 col-12 right-col">
          <p class="q6">How can I write a review about a KADS product that I purchased?</p>
          <p class="q6ans">To write a product or service review, head over to the contact us page.</p>
        </div>
      </div>             
    </div>
  </section>
    
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
  <script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4"
    crossorigin="anonymous"
  ></script>      
  
</body>
</html>
