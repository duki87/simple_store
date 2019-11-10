<?php
  include('../../db/db_con.php');

  if(isset($_POST['product_id'])) {
    $product_id = $_POST['product_id'];
    $subArray = array();
    $html = array();
    $delete_comment = '';
    $query = "SELECT * FROM comments WHERE product_id = '$product_id' ORDER BY comment_id DESC";
    $statement = $connect->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    foreach ($result as $row) {
        $user_id = $row['user_id'];
      $comment_id = $row['comment_id'];
      if(isset($_SESSION['user_id']) && $_SESSION['user_id'] == $user_id) {
        $delete_comment = '<button type="button" name="delete_comment" class="btn btn-danger btn-sm delete_comment" data-comment_id="'.$comment_id.'" id="delete_comment" data-toggle="tooltip" data-placement="top" title="Obrisi ovaj komentar">&times;</button>';
      } else {
        $delete_comment = '';
      }
      $date = $row['date'];
      $userQuery = "SELECT user_name FROM user_details WHERE user_id = '$user_id'";
      $statement = $connect->prepare($userQuery);
      $statement->execute();
      $userResult = $statement->fetchAll();
      foreach ($userResult as $name) {
        $subArray['user_name'] = $name['user_name'];
      }
      $subArray['comment'] = $row['comment'];
      $subArray['comment_id'] = $row['comment_id'];
      $subArray['delete_comment'] = $delete_comment;
      $html[] = '<li class="media border border-primary single_comment" id="single_comment" style="background-color:skyblue;border-radius:5px;padding:3px">
                <img class="mr-3" src="..." alt="user_image">
                <div class="media-body">
                  <h5 class="mt-0 mb-1 user_name"><b>'.$subArray['user_name'].'</b> <small>'.$date.'</small></h5>
                  <p class="user_comment">'.$subArray['comment'].'</p>'.$subArray['delete_comment'].'
                </div>
              </li><br>';
    }
      echo json_encode($html);
    }
?>
