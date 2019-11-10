<?php

  //slider
  function get_logos_for_slider($connect) {

    $query = "SELECT * FROM brand";

    $statement = $connect->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    $output = '';

    foreach ($result as $row) {
      $output .= '<a href="brands.php?brand_id='.$row['brand_id'].'"><img src="../'.$row['logo'].'" alt="" class="img-responsive" width="200px" height="auto"></a>';
    }
    return $output;
  }

  //for strar rating system
  function count_rating($product_id,$connect) {
    $output = 0;
    $query = "SELECT AVG(rating) as rating FROM rating WHERE product_id = '$product_id'";
    $statement = $connect->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    $total_row = $statement->rowCount();
    if($total_row > 0) {
      foreach ($result as $row) {
        $output = round($row['rating']);
      }
    }
    return $output;
  }
?>
