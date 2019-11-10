<?php
  include('db/db_con.php');
  if(!isset($_SESSION["type"]))
  {
    header("location:login.php");
  }
  include('includes/header.php');
?>
