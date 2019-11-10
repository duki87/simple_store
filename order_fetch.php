<?php
  include('db/db_con.php');
  include('functions/functions.php');
  $query = "";
  $output = array();
  $query .= "SELECT * FROM inventory_order WHERE ";

  if($_SESSION['type'] == 'user') {
    $query .= 'user_id = "'.$_SESSION['user_id'].'" AND ';
  }

  if(isset($_POST["search"]["value"])) {
    $query .= '(inventory_order_id LIKE "%'.$_POST["search"]["value"].'%" ';
    $query .= 'OR inventory_order_name LIKE "%'.$_POST["search"]["value"].'%" ';
    $query .= 'OR inventory_order_total LIKE "%'.$_POST["search"]["value"].'%" ';
    $query .= 'OR inventory_order_status LIKE "%'.$_POST["search"]["value"].'%" ';
    $query .= 'OR inventory_order_date LIKE "%'.$_POST["search"]["value"].'%") ';
  }

  if(isset($_POST["order"])) {
    $query .= 'ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
  } else {
    $query .= 'ORDER BY inventory_order_id DESC ';
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
    $payment_status = '';

  if($row['payment_status'] == 'cash') {
    $payment_status = '<h4 style="text-align:center"><span class="badge badge-primary">Cash</span></h4>';
  } else {
    $payment_status = '<h4 style="text-align:center"><span class="badge badge-info">Credit</span></h4>';
  }
  $status = '';
  if($row['inventory_order_status'] == 'active') {
    $status = '<h4 style="text-align:center"><span class="badge badge-success">Active</span></h4>';
  } else {
    $payment_status = '<h4 style="text-align:center"><span class="badge badge-danger">Inactive</span></h4>';
  }
  $sub_array = array();
  $sub_array[] = $row['inventory_order_id'];
  $sub_array[] = $row['inventory_order_name'];
  $sub_array[] = $row['inventory_order_total'];
  $sub_array[] = $payment_status;
  $sub_array[] = $status;
  $sub_array[] = $row['inventory_order_date'];
  if($_SESSION['type'] == 'master') {
    $sub_array[] = get_user_name($connect,$row['user_id']);
  }
  $sub_array[] = '<a href="view_order.php?pdf=1&order_id='.$row["inventory_order_id"].'" class="btn btn-warning">View PDF</a>';
  $sub_array[] = '<button type="button" name="update" id="'.$row["inventory_order_id"].'" class="btn btn-success update" data-toggle="modal" data-target="#orderEditModal">Update</button>';
  $sub_array[] = '<button type="button" name="delete" id="'.$row["inventory_order_id"].'" data-status="'.$row["inventory_order_status"].'" class="btn btn-danger delete">Delete</button>';

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
    $statement = $connect->prepare("SELECT * FROM inventory_order");
    $statement->execute();
    return $statement->rowCount();
  }
?>
