<?php
  include('../../db/db_con.php');
  $message = '';
  //Delete product from cart
    if($_POST['action'] == 'quantity_change') {
      foreach ($_SESSION['shopping-cart'] as $keys => $values) {
        if($_SESSION['shopping-cart'][$keys]['product_id'] == $_POST['product_id']) {
          $_SESSION['shopping-cart'][$keys]['product_quantity'] = $_POST['quantity'];
          $message = 'Promenjena kolicina proizvoda.';
        }
      }
      echo $message;
    }
?>
