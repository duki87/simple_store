<?php
  include('includes/header.php');
  include('functions/functions.php');
  include('../db/db_con.php');
?>
<script type="text/javascript" src="js/jquery.waterwheelCarousel.js"></script>
<script type="text/javascript" src="js/wheelSlider.js"></script>

<div class="container"><br>
  <div class="row">
    <div class="col-md-1 fa-3x" style="display: block;margin-top:auto; margin-bottom:auto">
      <i id="prev" class="fa fa-chevron-left" style="cursor:pointer"></i>
    </div>
    <div class="col-md-10">
      <div class="wheelSlider" style="display:block;width:100%;height:200px;padding-bottom:20px;">
      <?php
        $query = "SELECT * FROM brand WHERE logo != ''";
        $statement = $connect->prepare($query);
        $statement->execute();
        $result = $statement->fetchAll();
        foreach ($result as $row) {
      ?>
      <div class="single_brand" name="single_brand" id="<?=$row['brand_id']?>" style="cursor:pointer"><img src="../<?=$row['logo'];?>" alt="" width="200" height="auto"></div>
      <?php } ?>
      </div>
    </div>
    <div class="col-md-1" style="display: block;margin-top:auto; margin-bottom:auto">
      <i id="next" class="fa fa-chevron-right fa-3x" style="cursor:pointer"></i>
    </div>
  </div>

  <div class="row">
    <div class="col-md-12">
      <h2>Brendovi</h2>
      <hr>
      <h5>Lista brendova piva zastupljenih na nasem sajtu <i>(kliknite na logo piva za vise informacija)</i></h5>
    </div>
    <div class="col-md-12">
      <h3 class="brand_name" style="font-weight:bold"></h3>
      <hr>
      <p class="brand_description"></p>
    </div>

  </div>
</div>

<script>
  $(document).ready(function() {
    $(document).on('click', '.single_brand', function(){
     var brand_id = $(this).attr('id');
     $.ajax({
      url:"actions/single_brand.php",
      method:"POST",
      data: {brand_id},
      dataType: 'json',
      success:function(data) {
        $('.brand_name').text(data.brand_name);
        $('.brand_description').text(data.brand_description);
      }
   });
  });
});
</script>
