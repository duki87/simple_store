<?php
  include('db/db_con.php');
  include('functions/functions.php');
  $query = '';

  if(isset($_POST['inventory_order_name'])) {
    $query = "INSERT INTO inventory_order (user_id, inventory_order_total, inventory_order_date, inventory_order_name, inventory_order_address, payment_status, inventory_order_status, inventory_order_created_date)
    VALUES (:user_id, :inventory_order_total, :inventory_order_date, :inventory_order_name, :inventory_order_address, :payment_status, :inventory_order_status, :inventory_order_created_date)";
    $statement = $connect->prepare($query);
    $statement->execute(
      array(
        ':user_id'                      => $_SESSION['user_id'],
        ':inventory_order_total'        => 0,
        ':inventory_order_date'         => $_POST['inventory_order_date'],
        ':inventory_order_name'         => $_POST['inventory_order_name'],
        ':inventory_order_address'      => $_POST['inventory_order_address'],
        ':payment_status'               => $_POST['payment_status'],
        ':inventory_order_status'       => 'active',
        ':inventory_order_created_date' => date('d-m-Y')
      )
    );
    $result = $statement->fetchAll();
    $get_id = "SELECT LAST_INSERT_ID()";
    $statement = $connect->prepare($get_id);
    $statement->execute();
    $inventory_order_id = $statement->fetchColumn();
    if(isset($inventory_order_id)) {
      $total_amount = 0;
    for($count = 0; $count<count($_POST['product_id']); $count++) {
      $product_details = fetch_product_details($_POST['product_id'][$count],$connect);
      $sub_query = "INSERT INTO inventory_order_product (inventory_order_id, product_id, quantity, price, tax) VALUES (:inventory_order_id, :product_id, :quantity, :price, :tax)";
      $statement = $connect->prepare($sub_query);
      $statement->execute(
        array(
          ':inventory_order_id'  => $inventory_order_id,
          ':product_id'          => $_POST['product_id'][$count],
          ':quantity'            => $_POST['quantity'][$count],
          ':price'               => $product_details['price'],
          ':tax'                 => $product_details['tax']
        )
      );
      $base_price = $product_details['price'] * $_POST['quantity'][$count];
      $tax = ($base_price*$product_details['tax'])/100;
      $total_amount += $base_price + $tax;
    }
    $update_query = "UPDATE inventory_order SET inventory_order_total = '$total_amount' WHERE inventory_order_id = '$inventory_order_id'";
    $statement = $connect->prepare($update_query);
    $statement->execute();
    $result = $statement->fetchAll();
    if(isset($result)) {
      echo 'Order successfully created!';
    }
   }
  }

  if(isset($_POST['inventory_order_edit_id'])) {
    $query = "SELECT * FROM inventory_order WHERE inventory_order_id = '".$_POST["inventory_order_edit_id"]."'";
    $statement = $connect->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    $output = array();
    foreach ($result as $row) {
      $output['inventory_order_name'] = $row['inventory_order_name'];
      $output['inventory_order_date'] = $row['inventory_order_date'];
      $output['inventory_order_address'] = $row['inventory_order_address'];
      $output['payment_status'] = $row['payment_status'];
    }
    $sub_query = "SELECT * FROM inventory_order_product WHERE inventory_order_id = '".$_POST["inventory_order_edit_id"]."'";
    $statement = $connect->prepare($sub_query);
    $statement->execute();
    $sub_result = $statement->fetchAll();
    $product_details = '';
    $count = 0;
    foreach ($sub_result as $sub_row) {
      $product_details .= '
      <script>
        $(document).ready(function(){
          $("#product_id_new'.$count.'").attr("value","'.$sub_row["product_id"].'");
        });
      </script>
      <span id="row'.$count.'">
        <div class="row">
          <div class="form-group col-md-8" id="selectProduct">
            <select name="product_id_new[]" id="product_id_new'.$count.'" class="form-control" value="" required>
              '.fill_product_list($connect).'
            </select>
          </div>
            <input type="hidden" name="hidden_product_id[]" id="hidden_product_id'.$count.'" value="'.$sub_row["product_id"].'" />
          <div class="form-group col-md-3">
            <input type="text" name="quantity[]" class="form-control" value="'.$sub_row["quantity"].'" required />
          </div>
          <div class="form-group col-md-1">
      ';

      if($count == 0)
      {
        $product_details .= '<button type="button" name="add_more" id="add_more" class="btn btn-primary btn-xs">+</button>';
      }
      else
      {
        $product_details .= '<button type="button" name="remove" id="'.$count.'" class="btn btn-danger btn-xs remove">-</button>';
      }
      $product_details .= '

            </div>
          </div>
      </span>
      ';
      $count = $count + 1;
    }

    $output["product_details"] = $product_details;
    echo json_encode($output);
  }
?>
