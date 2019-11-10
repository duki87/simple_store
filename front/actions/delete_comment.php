<?php
  include('../../db/db_con.php');

  if(isset($_POST['comment_id'])) {
    $comment_id = $_POST['comment_id'];
    $query = "DELETE FROM comments WHERE comment_id = '$comment_id'";
    $statement = $connect->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    if(isset($result)) {
     echo 'comment_deleted';
    }
  }
?>
