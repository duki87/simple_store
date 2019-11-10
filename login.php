<?php
  include('db/db_con.php');
  if(isset($_SESSION['type']))
  {
    header("location:index.php");
  }
  $message = '';
  if(isset($_POST["login"]))
  {
    $query = "SELECT * FROM user_details WHERE user_email = :user_email";
    $statement = $connect->prepare($query);
    $statement->execute(
      array(
          'user_email'  =>  $_POST["user_email"],
      )
    );
    $count = $statement->rowCount();
    if($count > 0)
    {
      $result = $statement->fetchAll();
      foreach ($result as $row)
      {
        if(password_verify($_POST["user_password"], $row["user_password"]))
        {
          if($row['user_status'] == 'active')
          {
            $_SESSION["type"] = $row["user_type"];
            $_SESSION["user_id"] = $row["user_id"];
            $_SESSION["user_name"] = $row["user_name"];
            header("location:index.php");
          }
          else
          {
            $message = "<label>Your account is disabled! Please contact Us.</label>";
          }
        }
        else
        {
          $message = "<label>Wrong Password!</label>";
        }
      }
    }
    else
    {
      $message = "<label>Wrong Email Address!</label>";
    }
  }
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Inventory || Login</title>
    <script type="text/javascript" src="js/jquery-3.3.1.min.js"></script>
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="css/bootstrap.min.css">
  </head>
  <body>
    <div class="container" style="width:50%">
      <br>
      <h2 align="center" class="card mx-auto" style="height:50px">Inventory Management System</h2>
      <br>
      <div class="card">
        <h5 class="card-header">Login</h5>
        <div class="card-body">
          <h5 class="card-title">Unesite svoje podatke</h5>
          <form class="" method="post">
            <div class="text-danger"><?=$message;?></div>
            <div class="form-group">
              <label for="">Vas Email</label>
              <input type="text" name="user_email" class="form-control" required value="">
            </div>
            <div class="form-group">
              <label for="">Vasa Lozinka</label>
              <input type="password" name="user_password" class="form-control" required value="">
            </div>
            <div class="form-group">
              <input type="submit" name="login" class="btn btn-success" value="Login">
            </div>
          </form>
        </div>
        <div class="card-footer">
          Nemate nalog? <a href="reg.php">Registrujte se</a>
        </div>
      </div>
    </div>
  </body>
</html>
