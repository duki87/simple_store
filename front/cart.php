<?php
  include('includes/header.php');
  include('../db/db_con.php');
?>
  <div class="container">
    <br>
    <div id="alert_action" class=""></div>
    <br>
    <h2>Proizvodi u korpi</h2><hr>
    <div class="table-cart">
      <table class="table table-bordered table-hover" id="cartTable">
        <tr class="table table-primary">
          <th width="40%">Naziv proizvoda</th>
          <th width="10%">Kolicina</th>
          <th width="20%">Cena</th>
          <th width="15%">Ukupno</th>
          <th width="5%">Izmeni</th>
        </tr>
        <?php if(!empty($_SESSION['shopping-cart'])) {
            $total = 0;
            foreach ($_SESSION['shopping-cart'] as $keys => $values) {
        ?>
        <tr>
          <td><?=$values['product_name'];?></td>
          <td><input type="number" name="quantity[]" id="'quantity'.<?=$values['product_id'];?>" data-product_id="<?=$values['product_id'];?>" value="<?=$values['product_quantity'];?>" class="form-control quantity"></td>
          <td><?=$values['product_price'];?> din</td>
          <td><?=number_format($values['product_quantity'] * $values['product_price']);?> din</td>
          <td><button class="btn btn-danger delete" name="delete" id="<?=$values['product_id'];?>" type="button" name="button">Izbaci</button></td>
        </tr>
      <?php
        $total = $total + ($values['product_quantity'] * $values['product_price']);
        }
      ?>
      <tr class="table-success">
        <td colspan="3"><b>Za naplatu</b></td>
        <td><b><?=number_format($total,2);?> din</b></td>
        <input id="payment_total" type="hidden" name="" value="<?=$total;?>">
        <td><button class="btn btn-success" name="cart-payment" id="cart-payment" type="button" name="button" data-toggle="modal" data-target="#payModal">Naplati</button></td>
      </tr>
      <?php
        }
      ?>
    </table>
    </div>
  </div>
<?php
  include('templates/payModal.php');
  include('templates/checkOutModal.php');
  include('includes/footer.php');
?>
