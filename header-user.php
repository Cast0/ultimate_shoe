<?php
  $query="SELECT * FROM info_accts WHERE id = '$id'";
  $result=mysqli_query($conn,$query);
  $row = mysqli_fetch_assoc($result);
?>
      <!-- header -->
       <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container-fluid navbar-content">
            <a class="navbar-brand" href="/KADS">
                <img src="kineme pic" alt="" height="85" id="headerlogo">
            </a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarText">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
              <li class="nav-item">
                <a class="nav-link" aria-current="page" href="index.php" >Home</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="shoes.php">Shoes</a>
              </li>
          </div>
        </div>
    </nav>   
