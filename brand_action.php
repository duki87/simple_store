<?php
  include('db/db_con.php');
  $output = array();
  if(isset($_POST["brand_name"]) && $_POST["brand_name"] != '') {
      $query = "
      INSERT INTO brand (category_id, brand_name, brand_status, logo, brand_description)
      VALUES (:category_id, :brand_name, :brand_status, :logo, :brand_description)
      ";
      $statement = $connect->prepare($query);
      $statement->execute(
        array(
          ':category_id'        =>  $_POST["category_id"],
          ':brand_name'         =>  $_POST["brand_name"],
          ':brand_status'       =>  'active',
          ':logo'               =>  $_POST['logo_location'],
          ':brand_description'  =>  $_POST['brand_description']
        )
      );
      $result = $statement->fetchAll();
      if(isset($result)) {
        echo 'New brand added.';
      }
    }

  if(isset($_POST['brand_new_name'])) {
      $query = "UPDATE brand
      SET brand_name = '".$_POST['brand_new_name']."',
      category_id = '".$_POST['category_new_id']."',
      logo = '".$_POST['logo_location_edit']."',
      brand_description = '".$_POST['brand_description_edit']."' WHERE brand_id = '".$_POST['edit_brand_id']."'";
    $statement = $connect->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    if(isset($result)) {
      echo 'Brand details updated.';
    }
  }

  if(isset($_POST['delete_brand']) && $_POST['delete_brand'] == 'delete_brand') {
    $status = 'active';
    if($_POST['status'] == 'active') {
      $status = 'inactive';
    }
    $query = "UPDATE brand SET brand_status = :brand_status WHERE brand_id = :brand_id";
    $statement = $connect->prepare($query);
    $statement->execute(
      array(
        ':brand_status'  =>  $status,
        ':brand_id'      =>  $_POST['brand_id']
      )
    );
    $result = $statement->fetchAll();
    if(isset($result)) {
      echo 'Brand status changed to '.$status;
    }
  }

?>
