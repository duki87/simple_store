<?php
  include('includes/header.php');
  include('functions/functions.php');
  include('../db/db_con.php');
  $query = "SELECT * FROM funfacts LIMIT 2";
  $statement = $connect->prepare($query);
  $statement->execute();
  $result = $statement->fetchAll();
  $fact_id = '';
?>
<div class="container"><br>
  <div class="table-responsive">
    <h2 align="center">Zanimljivosti o pivu</h2>
    <table class="table table-striped" id="load_table_data">
      <?php
        foreach($result as $row) {
      ?>
      <tr class="table-warning">
        <td><?=$row['title'];?></td>
      </tr>
      <?php
        $fact_id = $row['id'];
      }
      ?>
      <tr id="remove_row">
        <td><button type="button" name="btn_more" id="btn_more" data-factid="<?=$fact_id;?>" class="btn btn-success form-control">Ucitaj jos</button></td>
      </tr>
    </table>
  </div>
</div>
<script>
  $(document).ready(function() {
    $(document).on('click', '#btn_more', function() {
      var last_fact_id = $(this).data('factid');
      $('#btn_more').html('Ucitavanje...');
      $.ajax({
        url:  'actions/load_more_facts.php',
        method: 'POST',
        data: {last_fact_id:last_fact_id},
        dataType: 'text',
        success: function(data) {
          if(data != '') {
            $('#remove_row').remove();
            $('#load_table_data').append(data);
          } else {
            $('#btn_more').html('To bi bilo sve!');
          }
        }
      });
    });
  });
</script>
