<?php
  include('includes/header.php');
  include('functions/functions.php');
  include('../db/db_con.php');
  $product_id = '';
  if(isset($_GET['product_id'])) {
    $product_id = $_GET['product_id'];
  }
?>
<div class="container"><br>
    <?php
      $query = "SELECT * FROM product WHERE product_id = '$product_id'";
      $statement = $connect->prepare($query);
      $statement->execute();
      $result = $statement->fetchAll();
      foreach($result as $row) {
    ?>
      <div class="row">
        <div class="col-md-6">
          <h2><b><?=$row['product_name'];?></b></h2>
        </div>
        <div class="col-md-4">
          <h4>Oceni pivo:</h4>
        </div>
        <div class="col-md-2">
          <input type="hidden" id="product_id" value="<?=$row['product_id'];?>">
          <span id="star_rating"></span>
        </div>
        <div class="col-md-4">
          <img src="../<?=$row['image'];?>" alt="" width="80%" height="auto">
        </div>
        <div class="col-md-6">
          <p><?=$row['product_description'];?></p>
        </div>
        <div class="col-md-12">
          <br>
        </div>
        <div class="row col-md-12">
          <div class="col-md-2">
            <button id="<?=$row['product_id'];?>" class="btn btn-success add_to_cart" name="add_to_cart"><i class="fa fa-shopping-cart"></i> Kupi pivo</button>
          </div>
          <div class="col-md-2">
            <input type="number" name="quantity" id="quantity<?=$row['product_id'];?>" class="form-control" value="1" style="width:100px">
            <input type="hidden" name="hidden_name" id="name<?=$row['product_id'];?>" value="<?=$row['product_name'];?>">
            <input type="hidden" name="hidden_price" id="price<?=$row['product_id'];?>" value="<?=$row['product_base_price'];?>">
            <input type="hidden" name="" id="cart-table-data" value="">
          </div>
        </div>
      </div>
    <?php } ?>

<br>
<div class="comments">
  <div class="row">
    <div class="col-md-12">
      <h3>Komentari za ovo pivo</h3><hr>
    </div>
    <?php
      if(isset($_SESSION['user_id'])) {
    ?>
    <div class="col-md-12">
      <div class="add_comment">
        <div class="col-md-12">
          <h4>Unesi komentar</h4><hr>
          <div id="comment_message"></div>
        </div>
        <div class="col-md-12">
          <form class="" id="comment_form">
            <div class="col-md-12">
              <div class="form-group">
                <textarea id="comment" name="comment" class="form-control" rows="2" cols="30" required></textarea>
              </div>
            </div>
            <div class="col-md-2 ">
              <div class="form-group">
                <input type="submit" class="btn btn-primary form-control" name="" value="Dodaj komentar">
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
    <?php }?>

    <div class="col-md-12">
      <ul class="list-unstyled" id="list_comments" style="width:95%; margin:auto;display:block">

      </ul>
    </div>
  </div>

  </div> <!--end of comments -->
</div>
<script>
  $(document).ready(function() {

    load_rating_data();
    load_comment();

    function load_rating_data() {
      var product_id = $('#product_id').val();
      $.ajax({
       url: "star_fetch.php",
       method: "POST",
       data: {product_id:product_id},
       success: function(data)
       {
        $('#star_rating').html(data);
       }
      });
     }

    function load_comment() {
      var product_id = $('#product_id').val();
      $.ajax({
       url: "actions/fetch_comments.php",
       method: "POST",
       data: {product_id:product_id},
       dataType: 'json',
       success: function(data)
       {
         $('#list_comments').html(data);
       }
      });
    }

  $(document).on('mouseenter', '.rating', function(){
    var index = $(this).data('index');
    var product_id = $(this).data('product_id');
    remove_background(product_id);
    for(var count = 1; count<=index; count++) {
     $('#'+product_id+'-'+count).css('color', '#ffcc00');
    }
   });

   function remove_background(product_id) {
    for(var count = 1; count <= 5; count++) {
     $('#'+product_id+'-'+count).css('color', '#ccc');
    }
   }

   $(document).on('mouseleave', '.rating', function(){
     var index = $(this).data('index');
     var product_id = $(this).data('product_id');
     var rating = $(this).data('rating');
     remove_background(product_id);
     //alert(rating);
     for(var count = 1; count<=rating; count++) {
      $('#'+product_id+'-'+count).css('color', '#ffcc00');
     }
    });

    $(document).on('click', '.rating', function(){
     var index = $(this).data('index');
     var product_id = $(this).data('product_id');
     $.ajax({
      url:"star_insert.php",
      method:"POST",
      data:{index:index, product_id:product_id},
      success:function(data) {
       if(data.trim() == 'new_rating') {
        load_rating_data();
        alert("Uneli ste novu ocenu za ovo pivo: "+index +" od 5");
      } else if(data.trim() == 'product_rated'){
        alert("Ocenili ste ovo pivo ocenom "+index +" od 5");
        }
        else {
        alert("Nesto se iskundacilo!");
        }
      }
   });
  });

  $(document).on('submit', '#comment_form', function(event) {
    event.preventDefault();
    var product_id = $('#product_id').val();
    var comment = $('#comment').val();
    $.ajax({
      url: "actions/comments.php",
      method:"POST",
      data:{product_id:product_id, comment:comment},
      success:function(data) {
        if(data == 'comment_added') {
          $('#comment_form')[0].reset();
          $('#comment_message').addClass('alert alert-success');
          $('#comment_message').html('Komentar je dodat!');
          $('#comment_message').delay(3000).fadeOut('slow');
          load_comment();
          remClass();
        }
      }
    });
  });

  $(document).on('click', '.delete_comment', function(event) {
    event.preventDefault();
    var comment_id = $(this).data('comment_id');
    if(confirm("Da li ste sigurni?")) {
      $.ajax({
        url: "actions/delete_comment.php",
        method:"POST",
        data:{comment_id:comment_id},
        success:function(data) {
          if(data == 'comment_deleted') {
            $('#comment_message').addClass('alert alert-success');
            $('#comment_message').html('Komentar je obrisan!');
            $('#comment_message').delay(3000).fadeOut('slow');
            load_comment();
            remClass();
          }
        }
      });
    } else {
      return false;
    }
  });

  function remClass() {
    var className = $('#alert_action').attr('class');
    setTimeout(function() {
      $('#alert_action').removeClass(className);
      $('#alert_action').text('');
    }, 3000);
    setTimeout(function() {
      $('#alert_action').attr("style", "display:block");
    },4000);
  }

  $(function() {
    $('[data-toggle="tooltip"]').tooltip();
  });
});

</script>
