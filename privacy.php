<?php
session_start();

if (isset($_SESSION['role']) && $_SESSION['role'] == 1) {
  //user has role 2, redirect to userprofile.php
  header("Location: admin/dashboard.php");
  exit();
}


  include "conn.php";
?>

<!doctype html>
<html lang="en" class="scroller">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>KADS | Privacy Policy</title>
        <!-- bootstrap -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
        <!-- css -->   
        <link rel="stylesheet" href="css/header-responsive.css" />             
        <link rel="stylesheet" href="css/footer.css" />
        <!-- favicon -->
        <link rel="icon" type="image/x-icon" href="favicon.ico" />
        <!-- fontawesome -->
        <script src="https://kit.fontawesome.com/03977197ef.js" crossorigin="anonymous"></script>
    </head>
    <style>
      .content-container{padding: 3vw 10vw 5vw 10vw;text-align: justify;text-justify: inter-word;}
      body{font-family: Inter;}
      h2,h3{font-family: Readex Pro;}
      h3{margin-top:4vw}
      a{color:#C70800}
      a:hover,a:focus{color:#8e0001}
    </style>
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
        <!-------------- content start --------------->
        <div class="content-container">
            
          <h2><strong>Privacy Policy for KADS</strong></h2>

          <p>At KADS, accessible from http://localhost/KADS/, one of our main priorities is the privacy of our visitors. This Privacy Policy document contains types of information that is collected and recorded by KADS and how we use it.</p>

          <p>If you have additional questions or require more information about our Privacy Policy, do not hesitate to contact us.</p>

          <h3><strong>Log Files</strong></h3>

          <p>KADS follows a standard procedure of using log files. These files log visitors when they visit websites. All hosting companies do this and a part of hosting services' analytics. The information collected by log files include internet protocol (IP) addresses, browser type, Internet Service Provider (ISP), date and time stamp, referring/exit pages, and possibly the number of clicks. These are not linked to any information that is personally identifiable. The purpose of the information is for analyzing trends, administering the site, tracking users' movement on the website, and gathering demographic information. Our Privacy Policy was created with the help of the <a href="https://www.privacypolicygenerator.org">Privacy Policy Generator</a>.</p>

          <h3><strong>Privacy Policies</strong></h3>

          <P>You may consult this list to find the Privacy Policy for each of the advertising partners of KADS.</p>

          <p>Third-party ad servers or ad networks uses technologies like cookies, JavaScript, or Web Beacons that are used in their respective advertisements and links that appear on KADS, which are sent directly to users' browser. They automatically receive your IP address when this occurs. These technologies are used to measure the effectiveness of their advertising campaigns and/or to personalize the advertising content that you see on websites that you visit.</p>

          <p>Note that KADS has no access to or control over these cookies that are used by third-party advertisers.</p>

          <h3><strong>Third Party Privacy Policies</strong></h3>

          <p>KADS's Privacy Policy does not apply to other advertisers or websites. Thus, we are advising you to consult the respective Privacy Policies of these third-party ad servers for more detailed information. It may include their practices and instructions about how to opt-out of certain options. </p>

          <p>You can choose to disable cookies through your individual browser options. To know more detailed information about cookie management with specific web browsers, it can be found at the browsers' respective websites.</p>

          <h3><strong>Children's Information</strong></h3>

          <p>Another part of our priority is adding protection for children while using the internet. We encourage parents and guardians to observe, participate in, and/or monitor and guide their online activity.</p>

          <p>KADS does not knowingly collect any Personal Identifiable Information from children under the age of 13. If you think that your child provided this kind of information on our website, we strongly encourage you to contact us immediately and we will do our best efforts to promptly remove such information from our records.</p>

          <h3><strong>Online Privacy Policy Only</strong></h3>

          <p>This Privacy Policy applies only to our online activities and is valid for visitors to our website with regards to the information that they shared and/or collect in KADS. This policy is not applicable to any information collected offline or via channels other than this website.</p>

          <h3><strong>Consent</strong></h3>

          <p>By using our website, you hereby consent to our Privacy Policy and agree to its <a href="terms.php">Terms and Conditions</a>.</p>									
                    
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
