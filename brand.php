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
              <h3 class="panel-title">Brand List</h3>
            </div>
          <div class="col-lg-2 col-md-2 col-sm-4 col-xs-6" align="right">
            <button type="button" name="add" id="add_button" data-toggle="modal" data-target="#brandModal" class="btn btn-success btn-xs">Add New Brand</button>
          </div>
        </div>
        </div>
        <div class="clear:both"></div>
        <div class="panel-body">
          <div class="row"><div class="col-sm-12 table-responsive">
            <table id="brand_data" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>id</th>
                  <th>Brand</th>
                  <th>Category</th>
                  <th>Status</th>
                  <th>Edit</th>
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
<?php include('templates/brandModal.php'); ?>
<?php include('templates/editBrandModal.php'); ?>

<script type="text/javascript">
    $(document).ready(function() {
      var branddataTable = $('#brand_data').DataTable({
        "processing"  : true,
        "serverSide"  : true,
        "order" : [],
        "ajax"  : {
          url : "brand_fetch.php",
          type :  "POST"
        },
        "columnDefs"  : [
          {
            "target"  : [4,5],
            "orderable" : false
          }
        ],
        "pageLength"  : 10
      });

      //Get image for upload
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
            url:  'logo_preview.php',
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
              var logo_location = $('#remove_button').data('location');
              $('#logo_location').val(logo_location);
            }
          });
        }
      });

      //Get image for edit modal
      $(document).on('change', '#image_file_edit', function() {
        var property = document.getElementById('image_file_edit').files[0];
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
          form_data.append('image_file_edit', property);
          $.ajax({
            url:  'logo_preview.php',
            method: 'POST',
            data: form_data,
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function() {
              $('#uploaded_image').text('Image uploading...');
            },
            success: function(data) {
              $('#image_preview_edit').html(data);
              $('#uploaded_image_edit').text('Image uploaded!');
              var logo_location_edit = $('#brand_logo_edit').attr('src');
              $('#logo_location_edit').val(logo_location_edit);
            }
          });
        }
      });

      //Remove logo
      $(document).on('click', '#remove_button', function() {
        if(confirm("Are you sure you want to delete this logo?")) {
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

      //Remove logo in edit modal
      $(document).on('click', '#remove_button_edit', function() {
        if(confirm("Are you sure you want to delete this logo?")) {
          var locationEdit = $('#brand_logo_edit').attr('src');
          $.ajax({
            url:  "logo_preview.php",
            method: "POST",
            data: {locationEdit:locationEdit},
            success: function(data) {
              if(data != '') {
                $('#image_preview_edit').html('');
                $('#uploaded_image_edit').text('');
              }
            }

          });
        } else {
          return false;
        }
      });


    //Add new user modal
    $(document).on('submit', '#brand_form', function(event) {
      event.preventDefault();
      $('#add_brand').attr('disabled','disabled');
      var form_data = $(this).serialize();
      $.ajax({
        url:  "brand_action.php",
        method: "POST",
        data: form_data,
        success: function(data) {
          if(data == 'New brand added.') {
            $('#brand_form')[0].reset();
            $('#brandModal').modal('hide');
            $('#alert_action').addClass('alert alert-success');
            $('#alert_action').html(data);
            $('#add_brand').attr('disabled',false);
            $('#alert_action').delay(3000).fadeOut('slow');
            remClass();
            branddataTable.ajax.reload();
            } else {
              $('#alert_action').addClass('alert alert-danger');
              $('#alert_action').html(data);
              $('#alert_action').delay(3000).fadeOut('slow');
              $('#action').attr('disabled',false);
              $('#brandModal').modal('hide');
              remClass();
          }
        }
      });
  });

  $(document).on('click', '.update', function(event) {
    var edit_brand_id = $(this).attr("id");
    var editor = 'edit';
    $('#edit_brand_id').val(edit_brand_id);
    $.ajax({
      url:  "get_edit_data.php",
      method: "POST",
      data: {edit_brand_id:edit_brand_id},
      dataType: "json",
      success: function(data) {
        $('#brand_new_name').val(data.brand_name);
        $('#category_new_id').val(data.category_id);
        $('#image_preview_edit').html('<img src='+data.logo+' class="form-control img-responsive">');
        $('#brand_description_edit').val(data.brand_description);
        remClass();
      }
    });
  });

  $(document).on('submit', '#brand_form_edit', function(event) {
    event.preventDefault();
    var form_edit_data = $(this).serialize();
    $('#edit_brand').attr('disabled','disabled');
    $.ajax({
      url:  "brand_action.php",
      method: "POST",
      data: form_edit_data,
      success: function(data) {
        if(data == 'Brand details updated.') {
          $('#brand_form_edit')[0].reset();
          $('#brandEditModal').modal('hide');
          $('#alert_action').addClass('alert alert-success');
          $('#alert_action').html(data);
          $('#edit_brand').attr('disabled',false);
          $('#alert_action').delay(3000).fadeOut('slow');
          remClass();
          branddataTable.ajax.reload();
          } else {
            $('#brandEditModal').modal('hide');
            $('#alert_action').addClass('alert alert-danger');
            $('#alert_action').html("Something went wrong.");
            $('#alert_action').delay(3000).fadeOut('slow');
            $('#add_brand').attr('disabled',false);
            remClass();
        }
      }
    });
  });

  $(document).on('click', '.delete', function() {
    var brand_id = $(this).attr('id');
    var status = $(this).data('status');
    var delete_brand = 'delete_brand';
    if(confirm("Are you sure you want to change this brand status?")) {
      $.ajax({
        url:  "brand_action.php",
        method: "POST",
        data: {brand_id:brand_id,status:status,delete_brand:delete_brand},
        success: function(data) {
          if(data == 'User status changed to active') {
            $('#alert_action').addClass('alert alert-success');
            $('#alert_action').html(data);
            $('#alert_action').delay(3000).fadeOut('slow');
            remClass();
            branddataTable.ajax.reload();
          } else {
            $('#alert_action').addClass('alert alert-success');
            $('#alert_action').html(data);
            $('#alert_action').delay(3000).fadeOut('slow');
            branddataTable.ajax.reload();
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
