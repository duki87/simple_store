<?php
  include('includes/header.php');
  include('functions/functions.php');
  include('../db/db_con.php');
?>

<!DOCTYPE html>
    <div class="container logo-slider">
    <div class="row">
      <?php
        $query = "SELECT * FROM brand WHERE logo != ''";

        $statement = $connect->prepare($query);
        $statement->execute();
        $result = $statement->fetchAll();
        foreach ($result as $row) {
      ?>
        <div class="col-md-3 border border-primary logo-slides">
          <img src="../<?=$row['logo'];?>" alt="" width="200" height="auto">
        </div>
      <?php } ?>
      </div>
    </div>

<script>
  $(document).ready(function() {
    // function loadImage() {
    //   var slides = $('.logo-slides');
    //   alert(slides.length);
    // }
    var slides = $('.logo-slides');
    
  });
</script>
