
<?php
include('../db/db_con.php');

  if(isset($_POST['index']) && isset($_POST['product_id'])) {
    $user_id = $_SESSION['user_id'];
    $product_id = $_POST['product_id'];
    $index = $_POST['index'];
    $query = '';
    $search = "SELECT * FROM rating WHERE product_id = '$product_id' AND user_id = '$user_id'";
    $statement = $connect->prepare($search);
    $statement->execute();
    $filtered_rows = $statement->rowCount();
    if($filtered_rows > 0) {
      $query = "UPDATE rating SET rating = '$index' WHERE product_id = '$product_id' AND user_id = '$user_id'";
      $statement = $connect->prepare($query);
      $statement->execute();
      $result = $statement->fetchAll();
      if(isset($result)) {
        echo 'new_rating';
      }
    } else {
      $query = "
       INSERT INTO rating(product_id, user_id, rating)
       VALUES (:product_id, :user_id, :rating)
       ";
       $statement = $connect->prepare($query);
       $statement->execute(
        array(
         ':product_id'  => $product_id,
         ':user_id'     =>  $user_id,
         ':rating'   => $index
        )
       );
       $result = $statement->fetchAll();
       if(isset($result)) {
        echo 'product_rated';
       }
    }
  }
?>
