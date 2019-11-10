<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Inventory || WELCOME</title>
    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="js/script.js"></script>
    <script src="js/datatables.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/datatables.min.css">
    <link rel="stylesheet" href="css/dataTables.bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  </head>
  <body>
      <h2 align="center">Inventory</h2>
      <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="collapse navbar-collapse">
          <div class="navbar-header">
            <a href="index.php" class="navbar-brand">Home</a>
          </div>
          <ul class="navbar-nav">
            <?php
              if($_SESSION["type"] == 'master')
              {
              ?>
                <li class="nav-item"><a class="nav-link" href="user.php">User</a></li>
                <li class="nav-item"><a class="nav-link" href="category.php">Category</a></li>
                <li class="nav-item"><a class="nav-link" href="brand.php">Brand</a></li>
                <li class="nav-item"><a class="nav-link" href="product.php">Product</a></li>
              <?php
              }
            ?>
                <li class="nav-item"><a class="nav-link" href="order.php">Order</a></li>
                <li class="nav-item"><a class="nav-link" href="front/index.php">Go Front</a></li>
          </ul>
          <ul class="navbar-nav flex-row ml-md-auto d-none d-md-flex">
           <li class="dropdown">
             <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#"><span class="label label-pill label-danger count"></span> <?=$_SESSION["user_name"];?></a>
             <div class="dropdown-menu">
               <a class="dropdown-item" href="profile.php">Profile</a>
               <a class="dropdown-item" href="logout.php">Logout</a>
             </div>
           </li>
          </ul>
        </div>
      </nav>
