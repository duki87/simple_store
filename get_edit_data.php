<?php
  include('db/db_con.php');
  include('functions/functions.php');
  //Get user data for editing
  if(isset($_POST['edit_id'])) {
    $query = "SELECT * FROM user_details WHERE user_id = :edit_id";
    $statement = $connect->prepare($query);
    $statement->execute(
      array(
        ':edit_id' =>  $_POST["edit_id"]
      )
    );
    $result = $statement->fetchAll();
    foreach ($result as $row) {
      $output['user_email'] = $row['user_email'];
      $output['user_name'] = $row['user_name'];
    }
    echo json_encode($output);
  }

  //Get brand data for editing
  if(isset($_POST['edit_brand_id'])) {
    $query = "SELECT * FROM brand WHERE brand_id = :brand_id";
    $statement = $connect->prepare($query);
    $statement->execute(
      array(
        ':brand_id' =>  $_POST["edit_brand_id"]
      )
    );
    $result = $statement->fetchAll();
    foreach ($result as $row) {
      $output['category_id'] = $row['category_id'];
      $output['brand_name'] = $row['brand_name'];
      $output['brand_description'] = $row['brand_description'];
      $output['logo'] = $row['logo'];
    }
    echo json_encode($output);
  }

  //Get category data for editing
  if(isset($_POST['edit_category_id'])) {
    $query = "SELECT * FROM category WHERE category_id = :category_id";
    $statement = $connect->prepare($query);
    $statement->execute(
      array(
        ':category_id' =>  $_POST["edit_category_id"]
      )
    );
    $result = $statement->fetchAll();
    foreach ($result as $row) {
      $output['category_name'] = $row['category_name'];
    }
    echo json_encode($output);
  }

  //Get product data for editing
  if(isset($_POST['edit_product_id'])) {
    $query = "SELECT * FROM product WHERE product_id = :product_id";
    $statement = $connect->prepare($query);
    $statement->execute(
      array(
        ':product_id' =>  $_POST["edit_product_id"]
      )
    );
    $result = $statement->fetchAll();
    foreach ($result as $row) {
      $output['product_name'] = $row['product_name'];
      $output['product_quantity'] = $row['product_quantity'];
      $output['product_unit'] = $row['product_unit'];
      $output['product_base_price'] = $row['product_base_price'];
      $output['product_tax'] = $row['product_tax'];
      $output['category_id'] = $row['category_id'];
      $output['brand_id'] = $row['brand_id'];
      $output['product_description'] = $row['product_description'];
    }
    echo json_encode($output);
  }

?>
