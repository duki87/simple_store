<?php
include('../../db/db_con.php');
$message = '';
//Delete product from cart
  if($_POST['action'] == 'remove') {
    foreach ($_SESSION['shopping-cart'] as $keys => $values) {
      if($values['product_id'] == $_POST['product_id']) {
        unset($_SESSION['shopping-cart'][$keys]);
        $message = 'Proizvod izbacen iz korpe.';
      }
    }
    echo $message;
  }
?>
