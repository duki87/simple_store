<?php
  include('../../db/db_con.php');
  $output = '';
  $last_id = $_POST['last_fact_id'];
  $query = "SELECT * FROM funfacts WHERE id > '$last_id' LIMIT 2";
  $statement = $connect->prepare($query);
  $statement->execute();
  $result = $statement->fetchAll();
  if($statement->rowCount() > 0) {
    foreach ($result as $row) {
      $fact_id = $row['id'];
      $output .= '
      <tbody>
        <tr class="table-warning">
          <td>'.$row['title'].'</td>
        </tr>
      </tbody>';
    }
    $output .= '
          <tbody>
            <tr id="remove_row">
              <td><button type="button" name="btn_more" id="btn_more" data-factid="'.$fact_id.'" class="btn btn-success form-control">Ucitaj jos</button></td>
            </tr>
          </tbody>';
    echo $output;
  }
?>
