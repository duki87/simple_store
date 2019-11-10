<?php
  include('db/db_con.php');
  include('functions/functions.php');
  if(!isset($_SESSION['type'])) {
    header('location:login.php');
  }
  if($_SESSION['type'] != 'master') {
    header("location:index.php");
  }
  include('includes/header.php');
?>
  <br>

<div class="container">
  <div id="alert_action" class=""></div>
  <div class="row">
    <div class="col-lg-12">
      <div class="panel panel-default">
        <div class="panel-heading">
          <div class="row">
            <div class="col-lg-10 col-md-10 col-sm-8 col-xs-6">
              <h3 class="panel-title">Product List</h3>
            </div>
          <div class="col-lg-2 col-md-2 col-sm-4 col-xs-6" align="right">
            <button type="button" name="add" id="add_button" data-toggle="modal" data-target="#productModal" class="btn btn-success btn-xs">Add New Product</button>
          </div>
        </div>
        </div>
        <div class="clear:both"></div>
        <div class="panel-body">
          <div class="row">
            <div class="col-sm-12 table-responsive">
              <table id="product_data" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>id</th>
                    <th>Category</th>
                    <th>Brand</th>
                    <th>Product</th>
                    <th>Quantity</th>
                    <th>Enter By</th>
                    <th>Status</th>
                    <th></th>
                    <th></th>
                    <th style="max-width:100px">Enable/Disable</th>
                  </tr>
                </thead>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php include('templates/productModal.php');
      include('templates/productView.php');
      include('templates/editProductModal.php');
?>

<script type="text/javascript">
    $(document).ready(function() {
      var productdataTable = $('#product_data').DataTable({
        "processing"  : true,
        "serverSide"  : true,
        "order" : [],
        "ajax"  : {
          url : "product_fetch.php",
          type :  "POST"
        },
        "columnDefs"  : [
          {
            "target"  : [7,8,9],
            "orderable" : false
          }
        ],
        "pageLength"  : 10
      });


    //Add new product modal
    $(document).on('submit', '#product_form', function(event) {
      event.preventDefault();
      $('#add_product').attr('disabled','disabled');
      var form_data = $(this).serialize();
      $.ajax({
        url:  "product_action.php",
        method: "POST",
        data: form_data,
        success: function(data) {
          if(data == 'New product added.') {
            $('#product_form')[0].reset();
            $('#productModal').modal('hide');
            $('#alert_action').addClass('alert alert-success');
            $('#alert_action').html(data);
            $('#add_product').attr('disabled',false);
            $('#alert_action').delay(3000).fadeOut('slow');
            remClass();
            productdataTable.ajax.reload();
            } else {
              $('#alert_action').addClass('alert alert-danger');
              $('#alert_action').html(data);
              $('#alert_action').delay(3000).fadeOut('slow');
              $('#add_product').attr('disabled',false);
              $('#productModal').modal('hide');
              remClass();
          }
        }
      });
    });

      $('#category_id').change(function(){
        var category_id = $('#category_id').val();
        var btn_action = 'load_brand';
        $.ajax({
            url:"product_action.php",
            method:"POST",
            data:{category_id:category_id, btn_action:btn_action},
            success:function(data){
                $('#brand_id').html(data);
              }
          });
      });

      $(document).on('click', '.view', function() {
        var product_id = $(this).attr('id');
        var btn_action = 'product_details';
        $.ajax({
          url:"product_action.php",
          method:"POST",
          data:{product_id:product_id, btn_action:btn_action},
          success: function(data){
            $('#product_details').html(data);
          }
        });
      });

      $(document).on('click', '.update', function(event) {
        var edit_product_id = $(this).attr("id");
        var editor = 'edit';
        $('#edit_product_id').val(edit_product_id);
        $.ajax({
          url:  "get_edit_data.php",
          method: "POST",
          data: {edit_product_id:edit_product_id},
          dataType: "json",
          success: function(data) {
            $('#product_new_name').val(data.product_name);
            $('#product_new_quantity').val(data.product_quantity);
            $('#product_new_unit').val(data.product_unit);
            $('#product_base_price_new').val(data.product_base_price);
            $('#product_new_tax').val(data.product_tax);
            $('#category_id_new').val(data.category_id);
            $('#brand_id_new').val(data.brand_id);
            $('#product_new_description').val(data.product_description);
            remClass();
          }
        });
      });

      $(document).on('change', '#image_file', function() {
        var property = document.getElementById('image_file').files[0];
        var image_name = property.name;
        var image_extension = image_name.split('.').pop().toLowerCase();
        if(jQuery.inArray(image_extension, ["jpg","jpeg","png","gif"]) == -1) {
          alert('That data type is not allowed!');
        }
        var image_size = property.size;
        if(image_size > 5000000) {
          alert('Image size too big!');
        } else {
          var form_data = new FormData();
          form_data.append('image_file', property);
          $.ajax({
            url:  'image_preview.php',
            method: 'POST',
            data: form_data,
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function() {
              $('#uploaded_image').text('Image uploading...');
            },
            success: function(data) {
              $('#image_preview').html(data);
              $('#uploaded_image').text('Image uploaded!');
              var image_location = $('#remove_button').data('location');
              $('#image_location').val(image_location);
            }
          });
        }
      });

      $(document).on('click', '#remove_button', function() {
        if(confirm("Are you sure you want to delete this image?")) {
          var location = $('#remove_button').data('location');
          $.ajax({
            url:  "image_preview.php",
            method: "POST",
            data: {location:location},
            success: function(data) {
              if(data != '') {
                $('#image_preview').html('');
                $('#uploaded_image').text('');
              }
            }

          });
        } else {
          return false;
        }
      });

      $(document).on('submit', '#product_form_edit', function(event) {
        event.preventDefault();
        var form_edit_data = $(this).serialize();
        $('#edit_product').attr('disabled','disabled');
        $.ajax({
          url:  "product_action.php",
          method: "POST",
          data: form_edit_data,
          success: function(data) {
            if(data == 'Product updated.') {
              $('#product_form_edit')[0].reset();
              $('#productEditModal').modal('hide');
              $('#alert_action').addClass('alert alert-success');
              $('#alert_action').html(data);
              $('#edit_product').attr('disabled',false);
              $('#alert_action').delay(3000).fadeOut('slow');
              remClass();
              productdataTable.ajax.reload();
              } else {
                $('#productEditModal').modal('hide');
                $('#alert_action').addClass('alert alert-danger');
                $('#alert_action').html("Something went wrong.");
                $('#alert_action').delay(3000).fadeOut('slow');
                $('#action').attr('disabled',false);
                remClass();
            }
          }
        });
      });

      $(document).on('click', '.delete', function() {
        var product_id = $(this).attr('id');
        var status = $(this).data('status');
        var delete_product = 'delete_product';
        if(confirm("Are you sure you want to change this product status?")) {
          $.ajax({
            url:  "product_action.php",
            method: "POST",
            data: {product_id:product_id,status:status,delete_product:delete_product},
            success: function(data) {
              if(data == 'Product status changed to active') {
                $('#alert_action').addClass('alert alert-success');
                $('#alert_action').html(data);
                $('#alert_action').delay(3000).fadeOut('slow');
                remClass();
                productdataTable.ajax.reload();
              } else {
                $('#alert_action').addClass('alert alert-success');
                $('#alert_action').html(data);
                $('#alert_action').delay(3000).fadeOut('slow');
                productdataTable.ajax.reload();
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
  });

  </script>
