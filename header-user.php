<?php
  $query="SELECT * FROM info_accts WHERE id = '$id'";
  $result=mysqli_query($conn,$query);
  $row = mysqli_fetch_assoc($result);
?>
      <!-- header -->
       <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container-fluid navbar-content">
            <a class="navbar-brand" href="/KADS">
                <img src="images/kads_logo_1.png" alt="" height="85" id="headerlogo">
            </a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarText">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
              <li class="nav-item">
                <a class="nav-link" aria-current="page" href="/KADS" >Home</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="menu.php">Menu</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="contact.php">Contact Us</a>
              </li>
            </ul>
            <ul class="navbar-nav">                  
                <li class="nav-item">                      
                  <span id="username">                                              
                    <table class="table-borderless">                           
                      <tbody>
                        <tr>
                          <td rowspan="2">
                            <a href="userprofile.php" class="useravatarfilter">
                              <img id="useravatar" src="images/avatar-1.jpg" width="50px" height="50px">                                                               
                            </a>
                          </td>
                          <td class="rowspace"></td>
                          <td><a href="userprofile.php" class="user-name">
                            <?php echo $row['firstname'] ." ". $row['lastname']; ?>
                          </a></td>
                          <td class="rowspace"></td> 
                          <td rowspan="2">
                            <a class="nav-link" href="cart.php">                              
                              <i class="fa-solid fa-cart-shopping"></i>
                            </a>
                          </td>
                        </tr>
                        <tr>     
                          <td class="rowspace"></td>                         
                          <td id="usertitle">Customer</td>
                          <td class="rowspace"></td>
                          <td></td>
                        </tr>                        
                      </tbody>                          
                    </table>
                  </span>                      
                </li>                              
                <li class="nav-responsive-padding-bottom"></li>                  
            </ul>
          </div>
        </div>
    </nav>   
