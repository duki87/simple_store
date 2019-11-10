<?php
  include('../../db/db_con.php');
  if(isset($_POST['price'])) {
    $output = '';
    $query = "SELECT * FROM product WHERE product_status='active' AND product_base_price <= ".$_POST['price']." ORDER BY product_base_price DESC";
    $statement = $connect->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    if($statement->rowCount() > 0) {
      foreach($result as $row) {
        $output .= '
          <div class="col-md-2" style="height:220px">
            <div class="card">
              <img class="card-img-top" src="'.'../'.$row["image"].'" style="width:100px;height:auto; margin:auto" alt="slika proizvoda">
              <div class="card-body">
                <h7 class="card-title">'.$row['product_name'].' <span><b> '.$row['product_base_price'].' din</b></span></h7>
                <p style="font-size:10px" class="card-text">'.$row['product_description'].' </p>
                <a href="#" class="btn btn-primary btn-sm"><i class="fa fa-shopping-cart"></i> Kupi</a>
              </div>
            </div><br>
          </div>
        ';
      }
    } else {
      $output .= 'Nema rezultata.';
    }
    echo $output;
  }
?>
