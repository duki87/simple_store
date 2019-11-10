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
              <h3 class="panel-title">Category List</h3>
            </div>
          <div class="col-lg-2 col-md-2 col-sm-4 col-xs-6" align="right">
            <button type="button" name="add" id="add_button" data-toggle="modal" data-target="#categoryModal" class="btn btn-success btn-xs">Add New Brand</button>
          </div>
        </div>
        </div>
        <div class="clear:both"></div>
        <div class="panel-body">
          <div class="row"><div class="col-sm-12 table-responsive">
            <table id="category_data" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>id</th>
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
<?php include('templates/categoryModal.php'); ?>
<?php include('templates/editCategoryModal.php'); ?>

<script type="text/javascript">
    $(document).ready(function() {
      var categorydataTable = $('#category_data').DataTable({
        "processing"  : true,
        "serverSide"  : true,
        "order" : [],
        "ajax"  : {
          url : "category_fetch.php",
          type :  "POST"
        },
        "columnDefs"  : [
          {
            "target"  : [3,4],
            "orderable" : false
          }
        ],
        "pageLength"  : 10
      });


    //Add new user modal
    $(document).on('submit', '#category_form', function(event) {
      event.preventDefault();
      $('#add_category').attr('disabled','disabled');
      var form_data = $(this).serialize();
      $.ajax({
        url:  "category_action.php",
        method: "POST",
        data: form_data,
        success: function(data) {
          if(data == 'New category added.') {
            $('#category_form')[0].reset();
            $('#categoryModal').modal('hide');
            $('#alert_action').addClass('alert alert-success');
            $('#alert_action').html(data);
            $('#add_category').attr('disabled',false);
            $('#alert_action').delay(3000).fadeOut('slow');
            remClass();
            categorydataTable.ajax.reload();
            } else {
              $('#alert_action').addClass('alert alert-danger');
              $('#alert_action').html(data);
              $('#alert_action').delay(3000).fadeOut('slow');
              $('#add_category').attr('disabled',false);
              $('#categoryModal').modal('hide');
              remClass();
          }
        }
      });
  });

  $(document).on('click', '.update', function(event) {
    var edit_category_id = $(this).attr("id");
    var editor = 'edit';
    $('#edit_category_id').val(edit_category_id);
    $.ajax({
      url:  "get_edit_data.php",
      method: "POST",
      data: {edit_category_id:edit_category_id},
      dataType: "json",
      success: function(data) {
        $('#category_new_name').val(data.category_name);
        remClass();
      }
    });
  });

  $(document).on('submit', '#category_form_edit', function(event) {
    event.preventDefault();
    var form_edit_data = $(this).serialize();
    $('#edit_category').attr('disabled','disabled');
    $.ajax({
      url:  "category_action.php",
      method: "POST",
      data: form_edit_data,
      success: function(data) {
        if(data == 'Category name updated.') {
          $('#category_form_edit')[0].reset();
          $('#categoryEditModal').modal('hide');
          $('#alert_action').addClass('alert alert-success');
          $('#alert_action').html(data);
          $('#edit_category').attr('disabled',false);
          $('#alert_action').delay(3000).fadeOut('slow');
          remClass();
          categorydataTable.ajax.reload();
          } else {
            $('#categoryEditModal').modal('hide');
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
    var category_id = $(this).attr('id');
    var status = $(this).data('status');
    var delete_category = 'delete_category';
    if(confirm("Are you sure you want to change this category status?")) {
      $.ajax({
        url:  "category_action.php",
        method: "POST",
        data: {category_id:category_id,status:status,delete_category:delete_category},
        success: function(data) {
          if(data == 'Category status changed to active') {
            $('#alert_action').addClass('alert alert-success');
            $('#alert_action').html(data);
            $('#alert_action').delay(3000).fadeOut('slow');
            remClass();
            categorydataTable.ajax.reload();
          } else {
            $('#alert_action').addClass('alert alert-success');
            $('#alert_action').html(data);
            $('#alert_action').delay(3000).fadeOut('slow');
            categorydataTable.ajax.reload();
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
