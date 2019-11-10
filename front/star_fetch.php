<?php
  include('functions/functions.php');
  include('../db/db_con.php');

  if(isset($_POST['product_id'])) {
    $product_id = $_POST['product_id'];
    $color = '';
    $output = '';
    $rating = count_rating($product_id,$connect);
    $output .= '
      <ul class="list-inline" data-rating="'.$rating.'" title="Prosecna ocena - '.$rating.'">
    ';
    for ($count=1; $count <= 5; $count++) {
      if($count <= $rating) {
        $color = 'color:#ffcc00;';
      } else {
        $color = 'color:#ccc;';
      }
      $output .= '<li title="'.$count.'" id="'.$product_id.'-'.$count.'" data-index="'.$count.'" data-product_id="'.$product_id.'" data-rating="'.$rating.'" class="rating list-inline-item" style="cursor:pointer; '.$color.' font-size:20px">&#9733;</li>';
    }
    $output .= '
      </ul>
    ';
    echo $output;
  }

?>
