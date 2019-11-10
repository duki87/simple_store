<?php
  include('db/db_con.php');
  $output = array();
  if(isset($_POST["btn_action"]) && $_POST['btn_action'] == 'Add') {
      $email = $_POST["user_email"];
      $emailCheck = "SELECT user_id FROM user_details WHERE user_email = '$email'";
      $pre_stmt = $connect->prepare($emailCheck);
      $pre_stmt->execute();
      $emailResult = $pre_stmt->rowCount();
      if($emailResult > 0) {
        echo 'Email already exist. Please try another one.';
      } else {
      $query = "
      INSERT INTO user_details (user_email, user_password, user_name, user_type, user_status)
      VALUES (:user_email, :user_password, :user_name, :user_type, :user_status)
      ";
      $statement = $connect->prepare($query);
      $statement->execute(
        array(
          ':user_email'     =>  $_POST["user_email"],
          ':user_password'  =>  password_hash($_POST["user_password"], PASSWORD_DEFAULT),
          ':user_name'      =>  $_POST["user_name"],
          ':user_type'      =>  'user',
          ':user_status'    =>  'active'
        )
      );
      $result = $statement->fetchAll();
      if(isset($result)) {
        echo 'New user added.';
      }
    }
  }
  if(isset($_POST['btn_action']) && $_POST['btn_action'] == 'fetch_single') {
    $query = "SELECT * FROM user_details WHERE user_id = :user_id";
    $statement = $connect->prepare($query);
    $statement->execute(
      array(
        ':user_id' =>  $_POST["user_id"]
      )
    );
    $result = $statement->fetchAll();
    foreach ($result as $row) {
      $output['user_email'] = $row['user_email'];
      $output['user_name'] = $row['user_name'];
    }
    echo json_encode($output);
  }
  if(isset($_POST['btn_action']) && $_POST['btn_action'] == 'Edit') {
    if($_POST['user_password'] != '') {
      $query = "UPDATE user_details
      SET user_name = '".$_POST['user_name']."',
      user_email = '".$_POST['user_email']."',
      user_password = '".password_hash($_POST['user_password'], PASSWORD_DEFAULT)."'
      WHERE user_id = '".$_POST['user_id']."'
      ";
    } else {
      $query = "UPDATE user_details
      SET user_name = '".$_POST['user_name']."',
      user_email = '".$_POST['user_email']."' WHERE user_id = '".$_POST['user_id']."'";
    }
    $statement = $connect->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    if(isset($result)) {
      echo 'User details updated';
    }
  }

?>
