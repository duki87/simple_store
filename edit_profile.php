<?php
  include('db/db_con.php');
  $query = '';
  if(isset($_POST['user_name']))
  {
    if($_POST['user_new_password'] != '')
    {
      if($_POST['user_new_password'] == $_POST['user_re_new_password'])
      {
      $query = "UPDATE user_details SET
        user_name = '".$_POST["user_name"]."',
        user_email = '".$_POST["user_email"]."',
        user_password = '".password_hash($_POST["user_new_password"], PASSWORD_DEFAULT)."'
        WHERE user_id = '".$_SESSION["user_id"]."'
      ";
      }
    }
    else
    {
      $query = "UPDATE user_details SET
        user_name = '".$_POST["user_name"]."',
        user_email = '".$_POST["user_email"]."'
        WHERE user_id = '".$_SESSION["user_id"]."'
      ";
    }
    $statement = $connect->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    if(isset($result))
    {
      echo 'SUCCESS';
    }
  }
?>
