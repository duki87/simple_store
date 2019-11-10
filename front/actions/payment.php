<?php
  include('../../db/db_con.php');
  if($_POST['action'] == 'payment') {
    if(isset($_POST['customer_name']) && $_POST['customer_name'] != '') {
      $query = "INSERT INTO inventory_order (user_id, inventory_order_total, inventory_order_date, inventory_order_name, inventory_order_address, payment_status, inventory_order_status, inventory_order_created_date)
      VALUES (:user_id, :inventory_order_total, :inventory_order_date, :inventory_order_name, :inventory_order_address, :payment_status, :inventory_order_status, :inventory_order_created_date)";
      $statement = $connect->prepare($query);
      $statement->execute(
        array(
          ':user_id'                      => $_SESSION['user_id'],
          ':inventory_order_total'        => $_POST['payment_total'],
          ':inventory_order_date'         => date('Y-m-d'),
          ':inventory_order_name'         => $_POST['customer_name'],
          ':inventory_order_address'      => $_POST['customer_address'],
          ':payment_status'               => $_POST['payment_method'],
          ':inventory_order_status'       => 'pending',
          ':inventory_order_created_date' => date('Y-m-d')
        )
      );
      $result = $statement->fetchAll();
      $get_id = "SELECT LAST_INSERT_ID()";
      $idQuery = $connect->prepare($get_id);
      $idQuery->execute();
      $inventory_order_id = $idQuery->fetchColumn();
      if(isset($inventory_order_id)) {
        foreach ($_SESSION['shopping-cart'] as $keys => $values) {
          $orderDetailsQuery = "INSERT INTO inventory_order_product (inventory_order_id, product_id, quantity, price) VALUES (:inventory_order_id, :product_id, :quantity, :price)";
          $orderDetails = $connect->prepare($orderDetailsQuery);
          $orderDetails->execute(
            array(
              ':inventory_order_id'  => $inventory_order_id,
              ':product_id'          => $values['product_id'],
              ':quantity'            => $values['product_quantity'],
              ':price'               => $values['product_price']
            )
          );
          $orderDetailsResult = $orderDetails->fetchAll();
        }
      }

      if(isset($result) && isset($orderDetailsResult)) {
        if($_POST['payment_method'] == 'cash') {
          echo 'Uspesno ste narucili proizvode. Placate pouzecem.';
          unset($_SESSION['shopping-cart']);
        } else {
          echo 'Placate kreditnom karticom';
        }
      }
    }
  }
?>
