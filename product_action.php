<?php
  include('db/db_con.php');
  include('functions/functions.php');
  $output = array();

  // if() {
  //   if($_FILES['image_file']['name'] != '') {
  //     $path = '';
  //     $extension = end(explode(".", $_FILES['image_file']['name']));
  //     $allowedType = array("jpg","jpeg","png","gif");
  //     if(in_array($extension,$allowedType)) {
  //       $newName = "image" . mt_rand(10,10000) . "." . $extension;
  //       $path = "images/" . $newName;
  //       if(move_uploaded_file($_FILES['image_file']['tmp_name'], $path)) {
  //         '<img src="'.$path.'" class="form-control img-responsive" alt="" width="100%" height="auto">
  //          <div class="">
  //           <button type="button" data-path="'.$path.'" id="remove_button" class="">X</button>
  //          </div>';
  //       }
  //     } else {
  //       echo "This image extension is not allowed!";
  //     }
  //   }
  // }

  if(isset($_POST["product_name"]) && $_POST["product_name"] != '') {
      $query = "INSERT INTO product (category_id, brand_id, product_name, product_description, image, product_quantity, product_unit, product_base_price, product_tax, product_enter_by, product_status, product_date)
      VALUES (:category_id,:brand_id,:product_name,:product_description, :image_location, :product_quantity,:product_unit, :product_base_price,:product_tax,:product_enter_by,:product_status,:product_date)";

      $statement = $connect->prepare($query);
      $statement->execute(
        array(
          ':category_id'          =>  $_POST['category_id'],
          ':brand_id'             =>  $_POST['brand_id'],
          ':product_name'         =>  $_POST['product_name'],
          ':product_description'  =>  $_POST['product_description'],
          ':image_location'       =>  $_POST['image_location'],
          ':product_quantity'     =>  $_POST['product_quantity'],
          ':product_unit'         =>  $_POST['product_unit'],
          ':product_base_price'   =>  $_POST['product_base_price'],
          ':product_tax'          =>  $_POST['product_tax'],
          ':product_enter_by'     =>  $_SESSION['user_id'],
          ':product_status'       =>  'active',
          ':product_date'         =>  date('Y-m-d')
        )
      );

      $result = $statement->fetchAll();
      if(isset($result)) {
        echo 'New product added.';
      }
    }

    if(isset($_POST['btn_action']) && $_POST['btn_action'] == 'load_brand') {
      echo get_brands_from_categories($connect, $_POST['category_id']);
    }

    if(isset($_POST['btn_action']) && $_POST['btn_action'] == 'product_details') {
      $query = "SELECT * FROM product
        INNER JOIN category ON category.category_id = product.category_id
        INNER JOIN brand ON brand.brand_id = product.brand_id
        INNER JOIN user_details ON user_details.user_id = product.product_enter_by
        WHERE product_id = '".$_POST['product_id']."'
      ";

      $statement = $connect->prepare($query);
      $statement->execute();
      $result = $statement->fetchAll();
      $output = '
  		<div class="table-responsive">
  			<table class="table table-boredered">
  		';
      foreach ($result as $row) {
        $status = '';
        if($row['product_status'] == 'active') {
          $status = '<span class="badge badge-success">Active</span>';
        } else {
          $status = '<span class="badge badge-danger">Inactive</span>';
        }
        $output .= '
        <tr>
          <td>Product Name:</td>
          <td>'.$row["product_name"].'</td>
        </tr>
        <tr>
          <td>Product Description:</td>
          <td>'.$row["product_description"].'</td>
        </tr>
        <tr>
          <td>Category:</td>
          <td>'.$row["category_name"].'</td>
        </tr>
        <tr>
          <td>Brand:</td>
          <td>'.$row["brand_name"].'</td>
        </tr>
        <tr>
          <td>Available Quantity:</td>
          <td>'.$row["product_quantity"].' '.$row["product_unit"].'</td>
        </tr>
        <tr>
          <td>Base Price:</td>
          <td>'.$row["product_base_price"].'</td>
        </tr>
        <tr>
          <td>Tax(%):</td>
          <td>'.$row["product_tax"].'</td>
        </tr>
        <tr>
          <td>Enter By:</td>
          <td>'.$row["user_name"].'</td>
        </tr>
        <tr>
          <td>Product Status:</td>
          <td>'.$status.'</td>
        </tr>
        ';
    }
    $output .= '
      </table>
    </div>
    ';
    echo $output;
  }

  if(isset($_POST['product_new_name'])) {
    $query = "UPDATE product SET
    product_name = '".$_POST['product_new_name']."',
    product_quantity = '".$_POST['product_new_quantity']."',
    product_unit = '".$_POST['product_new_unit']."',
    product_base_price = '".$_POST['product_base_price_new']."',
    product_tax = '".$_POST['product_new_tax']."',
    category_id = '".$_POST['category_id_new']."',
    brand_id = '".$_POST['brand_id_new']."',
    product_description = '".$_POST['product_new_description']."'

    WHERE product_id = '".$_POST['edit_product_id']."'";
    $statement = $connect->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    if(isset($result)) {
      echo 'Product updated.';
    }
  }

  if(isset($_POST['delete_product']) && $_POST['delete_product'] == 'delete_product') {
    $status = 'active';
    if($_POST['status'] == 'active') {
      $status = 'inactive';
    }
    $query = "UPDATE product SET product_status = :product_status WHERE product_id = :product_id";
    $statement = $connect->prepare($query);
    $statement->execute(
      array(
        ':product_status'  =>  $status,
        ':product_id'      =>  $_POST['product_id']
      )
    );
    $result = $statement->fetchAll();
    if(isset($result)) {
      echo 'Product status changed to '.$status;
    }
  }
?>
