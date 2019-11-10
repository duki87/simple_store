<?php
  include('db/db_con.php');
  $output = array();
  if(isset($_POST["category_name"]) && $_POST["category_name"] != '') {
      $query = "
      INSERT INTO category (category_name, category_status)
      VALUES (:category_name, :category_status)
      ";
      $statement = $connect->prepare($query);
      $statement->execute(
        array(
          ':category_name'     =>  $_POST["category_name"],
          ':category_status'    =>  'active'
        )
      );
      $result = $statement->fetchAll();
      if(isset($result)) {
        echo 'New category added.';
      }
    }

  if(isset($_POST['category_new_name'])) {
    $query = "UPDATE category SET category_name = '".$_POST['category_new_name']."' WHERE category_id = '".$_POST['edit_category_id']."'";
    $statement = $connect->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    if(isset($result)) {
      echo 'Category name updated.';
    }
  }

  if(isset($_POST['delete_category']) && $_POST['delete_category'] == 'delete_category') {
    $status = 'active';
    if($_POST['status'] == 'active') {
      $status = 'inactive';
    }
    $query = "UPDATE category SET category_status = :category_status WHERE category_id = :category_id";
    $statement = $connect->prepare($query);
    $statement->execute(
      array(
        ':category_status'  =>  $status,
        ':category_id'      =>  $_POST['category_id']
      )
    );
    $result = $statement->fetchAll();
    if(isset($result)) {
      echo 'Category status changed to '.$status;
    }
  }

?>
