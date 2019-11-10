<?php
  include('db/db_con.php');
  $query = "";
  $output = array();
  $query .= "SELECT * FROM user_details WHERE user_type = 'user' AND ";

  if(isset($_POST["search"]["value"])) {
    $query .= '(user_email LIKE "%'.$_POST["search"]["value"].'%"';
    $query .= 'OR user_name LIKE "%'.$_POST["search"]["value"].'%"';
    $query .= 'OR user_status LIKE "%'.$_POST["search"]["value"].'%")';
  }

  if(isset($_POST["order"])) {
    $query .= 'ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
  } else {
    $query .= 'ORDER BY user_id DESC ';
  }

  if($_POST["length"] != -1) {
    $query .= 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
  }

  $statement = $connect->prepare($query);
  $statement->execute();
  $result = $statement->fetchAll();

  $data = array();

  $filtered_rows = $statement->rowCount();
  foreach ($result as $row) {
    $status = '';
    if($row['user_status'] == 'active') {
      $status = '<button class="btn btn-success mx-auto" style="display:block; cursor:context-menu">Active</button>';
      $statusClass = 'btn btn-danger btn-xs delete mx-auto';
      $statusText = 'Disable';
    } else {
      $status = '<button class="btn btn-danger mx-auto" style="display:block; cursor:context-menu">Inactive</button>';
      $statusClass = 'btn btn-info btn-xs delete mx-auto';
      $statusText = 'Enable';
    }
    $sub_array = array();
    $sub_array[] = $row['user_id'];
    $sub_array[] = $row['user_email'];
    $sub_array[] = $row['user_name'];
    $sub_array[] = $status;
    $sub_array[] = '<button type="button" name="update" id="'.$row["user_id"].'" class="btn btn-info btn-xs update mx-auto" style="display:block" data-toggle="modal" data-target="#userEditModal">Update</button>';
    $sub_array[] = '<button type="button" name="delete" id="'.$row["user_id"].'" data-status="'.$row["user_status"].'" class="'.$statusClass.'" style="display:block">'.$statusText.'</button>';
    $data[] = $sub_array;
  }

  $output = array(
    "draw"            =>  intval($_POST["draw"]),
    "recordsTotal"    =>  $filtered_rows,
    "recordsFiltered" =>  get_total_all_records($connect),
    "data"            =>  $data
  );

  echo json_encode($output);

  function get_total_all_records($connect) {
    $statement = $connect->prepare("SELECT * FROM user_details WHERE user_type ='user'");
    $statement->execute();
    return $statement->rowCount();
  }
?>
