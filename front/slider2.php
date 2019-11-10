<?php
  include('includes/header.php');
  include('functions/functions.php');
  include('../db/db_con.php');
?>

<link href="css/thumbnail-slider.css" rel="stylesheet" type="text/css" />
<script src="js/thumbnail-slider.js" type="text/javascript"></script>


<!--start-->
<div style="padding:120px 0;">
    <div id="thumbnail-slider">
        <div class="inner">
            <ul>
              <?php
                $query = "SELECT * FROM brand WHERE logo != ''";

                $statement = $connect->prepare($query);
                $statement->execute();
                $result = $statement->fetchAll();
                foreach ($result as $row) {
              ?>
                <li>
                    <a class="thumb" href="../<?=$row['logo'];?>"></a>
                </li>
              <?php } ?>
            </ul>
        </div>
    </div>
</div>
<!--end-->
