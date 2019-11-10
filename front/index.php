<?php
  include('includes/header.php');
  include('../db/db_con.php');
?>
  <div class="container">
    <br>
    <h2>Aktuelni proizvodi</h2><hr>
    <div class="">
      <input type="range" min="20" max="500" step="5" name="" value="20" id="min_price" name="min_price">
      <span id="price_range"></span>
      <br><br>
      <div id="product_loading_results" class="row" style="background:#f0f0f0"></div><br>
      <div id="product_loading" class="row"></div>
    </div><br><br>
    <div class="row">
        <?php
          $query = "SELECT * FROM product WHERE product_status='active'";
          $statement = $connect->prepare($query);
          $statement->execute();
          $result = $statement->fetchAll();
          foreach ($result as $row) {
        ?>
        <div class="col-md-4">
          <div class="card">
            <img class="card-img-top" src="<?='../'.$row['image'];?>"  alt="slika proizvoda">
            <div class="card-body">
              <h5 class="card-title"><?=$row['product_name'];?> <span><b> <?=$row['product_base_price'];?> din</b></span></h5>
              <p class="card-text"><?=substr($row['product_description'],0,200).'<a href="product.php?product_id='.$row['product_id'].'">Nastavi čitanje</a>';?> </p>
              <div class="row">
                <div class="col-md-4">
                  <a href="product.php?product_id=<?=$row['product_id']?>" class="btn btn-info">Detalji</a>
                </div>
                <div class="col-md-4">
                  <button id="<?=$row['product_id'];?>" class="btn btn-success add_to_cart" name="add_to_cart"><i class="fa fa-shopping-cart"></i> Kupi</button>
                </div>
                <div class="col-md-4">
                  <input type="number" name="quantity" id="quantity<?=$row['product_id'];?>" class="form-control" value="1" style="width:100px">
                </div>
                <input type="hidden" name="hidden_name" id="name<?=$row['product_id'];?>" value="<?=$row['product_name'];?>">
                <input type="hidden" name="hidden_price" id="price<?=$row['product_id'];?>" value="<?=$row['product_base_price'];?>">
                <input type="hidden" name="" id="cart-table-data" value="">
              </div>
            </div>
          </div><br>
        </div>
        <?php
          }
        ?>
    </div>
  </div>

<?php
  include('includes/footer.php');
?>

<script>
  $(document).ready(function() {
    $('#min_price').change(function() {
      var price = $(this).val();
      $('#price_range').text('Rezultati ispod ' + price + ' din.');
      $('#product_loading_results').html('<h4>Rezultati pretrage:</h4>');
      $.ajax({
        url:  'actions/price_slider.php',
        method: 'POST',
        data: {price:price},
        success: function(data) {
          $('#product_loading').fadeIn(500).html(data);
        }
      });
    });
  });
</script>
