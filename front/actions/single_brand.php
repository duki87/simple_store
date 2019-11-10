<?php
  include('../../db/db_con.php');
  if(isset($_POST['brand_id'])) {
    $brand_id = $_POST['brand_id'];
    $query = "SELECT * FROM brand WHERE brand_id = '$brand_id'";
    $statement = $connect->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    foreach ($result as $row) {
      $output['category_id'] = $row['category_id'];
      $output['brand_name'] = $row['brand_name'];
      $output['brand_description'] = $row['brand_description'];
      $output['logo'] = $row['logo'];
    }
    echo json_encode($output);
  }
?>
