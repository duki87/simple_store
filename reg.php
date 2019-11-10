<?php
//login.php

include('db/db_con.php');

if(isset($_POST["reg"])) {
  $email = $_POST["email"];
  $password = password_hash($_POST["password"], PASSWORD_DEFAULT);
  $username = $_POST["username"];
  $status = $_POST["status"];
  $type = $_POST["type"];
  $sql = "INSERT INTO `user_details`(`user_email`, `user_password`, `user_name`, `user_type`, `user_status`) VALUES ('$email','$password','$username','$type','$status')";
  $statement = $connect->prepare($sql);
  $statement->execute();
}

?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
    <form method="post">
      <div class="form-group">
        <label>User Email</label>
        <input type="text" name="email" class="form-control" required />
      </div>
      <div class="form-group">
        <label>Password</label>
        <input type="password" name="password" class="form-control" required />
      </div>
      <div class="form-group">
        <label>User name</label>
        <input type="text" name="username" class="form-control" required />
      </div>
      <div class="form-group">
        <label>Status</label>
        <select class="" name="status" required>
          <option value="active">Active</option>
          <option value="inactive">Inactive</option>
        </select>
      </div>
      <div class="form-group">
        <label>Type</label>
        <select class="" name="type" required>
          <option value="master">Master</option>
          <option value="user">User</option>
        </select>
      </div>
      <div class="form-group">
        <input type="submit" name="reg" value="Register" class="btn btn-info" />
      </div>
    </form>
  </body>
</html>
