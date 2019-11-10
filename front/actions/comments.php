<?php
  include('../../db/db_con.php');

  if(isset($_POST['product_id']) && $_POST['comment'] != '') {
    $product_id = $_POST['product_id'];
    $comment = $_POST['comment'];
    $user_id = $_SESSION['user_id'];

    $query = "
     INSERT INTO comments(product_id, user_id, comment,date)
     VALUES (:product_id, :user_id, :comment,:date)
     ";
     $statement = $connect->prepare($query);
     $statement->execute(
      array(
       ':product_id'  =>  $product_id,
       ':user_id'     =>  $user_id,
       ':comment'     =>  $comment,
       ':date'        =>  date('Y-m-d h:i:s')
      )
     );
     $result = $statement->fetchAll();
     if(isset($result)) {
      echo 'comment_added';
     }
  }
?>
