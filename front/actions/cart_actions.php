<?php
  include('../../db/db_con.php');

  //Add or update cart in $_session
  if(isset($_POST['product_id'])) {
    $order_table = '';
    $message = '';
    $output = array();
    if($_POST['action'] == 'add') {
      if(isset($_SESSION['shopping-cart'])) {
        $is_available = 0;
        foreach ($_SESSION['shopping-cart'] as $keys => $values) {
          if($_SESSION['shopping-cart'][$keys]['product_id'] == $_POST['product_id']) {
            $is_available++;
            $_SESSION['shopping-cart'][$keys]['product_quantity'] += $_POST['product_quantity'];
          }
        }
        if($is_available < 1) {
          $item_array = array(
            'product_id'        =>  $_POST['product_id'],
            'product_name'      =>  $_POST['product_name'],
            'product_quantity'  =>  $_POST['product_quantity'],
            'product_price'     =>  $_POST['product_price']
          );
          $_SESSION['shopping-cart'][] = $item_array;
        }
      } else {
      $item_array = array(
        'product_id'        =>  $_POST['product_id'],
        'product_name'      =>  $_POST['product_name'],
        'product_quantity'  =>  $_POST['product_quantity'],
        'product_price'     =>  $_POST['product_price']
      );
      $_SESSION['shopping-cart'][] = $item_array;
    }
  }


    $order_table .= '
    <table class="table table-bordered table-hover">
      <tr class="table table-primary">
        <th width="40%">Naziv proizvoda</th>
        <th width="10%">Kolicina</th>
        <th width="20%">Cena</th>
        <th width="15%">Ukupno</th>
        <th width="5%">Izmeni</th>
      </tr>
    ';
    if(!empty($_SESSION['shopping-cart'])) {
      $total = 0;
      foreach ($_SESSION['shopping-cart'] as $keys => $values) {
        $order_table .= '
          <tr>
            <td>'.$values['product_name'].'</td>
            <td><input type="number" name="quantity[]" id="quantity'.$values['product_id'].'" data-product_id="'.$values['product_id'].'" value="'.$values['product_quantity'].'" class="form-control quantity"></td>
            <td>'.$values['product_price'].' din</td>
            <td>'.number_format($values['product_quantity'] * $values['product_price']).'</td>
            <td><button class="btn btn-danger delete" name="delete" id="'.$values['product_id'].'" type="button" name="button">Izbaci</button></td>
          </tr>
        ';
        $total += $values['product_quantity'] * $values['product_price'];
      }
      $order_table .= '
          <tr class="table-success">
            <td colspan="3">Ukupno</td>
            <td>'.number_format($total,2).'</td>
            <td></td>
          </tr>';
      }
      $order_table .= '
        </table>
      ';
      $output['order_table'] = $order_table;
      $output['cart_item'] = count($_SESSION['shopping-cart']);
    echo json_encode($output);
}

?>
