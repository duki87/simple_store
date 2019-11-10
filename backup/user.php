<?php
  include('db/db_con.php');
  if(!isset($_SESSION['type'])) {
    header('location:login.php');
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
              <h3 class="panel-title">User List</h3>
            </div>
          <div class="col-lg-2 col-md-2 col-sm-4 col-xs-6" align="right">
            <button type="button" name="add" id="add_button" data-toggle="modal" data-target="#userModal" class="btn btn-success btn-xs">Add New User</button>
          </div>
        </div>
        </div>
        <div class="clear:both"></div>
        <div class="panel-body">
          <div class="row"><div class="col-sm-12 table-responsive">
            <table id="user_data" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>id</th>
                  <th>Email</th>
                  <th>Name</th>
                  <th>Status</th>
                  <th>Edit</th>
                  <th>Delete</th>
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
  <div id="userModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <form class="" method="post" id="user_form">
          <div class="modal-header">
            <h4 class="modal-title"><i class="fa fa-plus"></i> Add User</h4>
            <button type="button" name="close" class="close" data-dismiss="modal">&times;</button>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <label>Enter User Name</label>
              <input type="text" name="user_name" id="user_name" class="form-control" required placeholder="For example: Milorad" value="">
            </div>
            <div class="form-group">
              <label>Enter Your Email</label>
              <input type="email" name="user_email" id="user_email" class="form-control" required placeholder="For example: milorad@gmail.com" value="">
            </div>
            <div class="form-group">
              <label>Enter Your Password</label>
              <input type="password" name="user_password" id="user_password" class="form-control" required value="">
            </div>
          </div>
          <div class="modal-footer">
            <input type="hidden" name="user_id" id="user_id" value="">
            <input type="hidden" name="btn_action" id="btn_action" value="">
            <input type="submit" name="action" id="action" value="Add" class="btn btn-info">
            <button type="button" id="close_modal" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <script type="text/javascript">
    $(document).ready(function() {
      var userdataTable = $('#user_data').DataTable({
        "processing"  : true,
        "serverSide"  : true,
        "order" : [],
        "ajax"  : {
          url : "user_fetch.php",
          type :  "POST"
        },
        "columnDefs"  : [
          {
            "target"  : [4,5],
            "orderable" : false
          }
        ],
        "pageLength"  : 25
      });

    });
    //Add new user modal
    $(document).on('submit', '#user_form', function(event) {
      event.preventDefault();
      $('#action').attr('disabled','disabled');
      var form_data = $(this).serialize();
      $.ajax({
        url:  "user_action.php",
        method: "POST",
        data: form_data,
        success: function(data) {
          if(data == 'New user added.') {
            $('#btn_action').attr('value','Add');
            $('#user_form')[0].reset();
            $('#userModal').modal('hide');
            $('#alert_action').addClass('alert alert-success');
            $('#alert_action').html(data);
            $('#action').attr('disabled',false);
            $('#alert_action').delay(3000).fadeOut('slow');
            userdataTable.ajax.reload();
            } else {
              $('#alert_action').addClass('alert alert-danger');
              $('#alert_action').html(data);
              $('#alert_action').delay(3000).fadeOut('slow');
              $('#action').attr('disabled',false);
              $('#userModal').modal('hide');
          }
        }
      });
  });
    $(document).on('click', '.update', function() {
      var user_id = $(this).attr("id");
      var btn_action = 'fetch_single';
      $.ajax({
        url:  "user_action.php",
        method: "POST",
        data: {user_id:user_id, btn_action:btn_action},
        dataType: "json",
        success: function(data) {
          $('#userModal').modal('show');
          $('#user_name').val(data.user_name);
          $('#user_email').val(data.user_email);
          $('.modal-title').html('<i class="fa fa-pencil-square-o"></i> Edit User');
          $('#user_id').val(user_id);
          $('#action').val('Edit');
          $('#btn_action').val('Edit');
          $('#user_password').attr('required', false);
        }
      });
    });
  </script>
