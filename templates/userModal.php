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
          <input type="hidden" name="delete_user" id="delete_user" value="">
          <input type="submit" name="add_user" id="add_user" value="Add" class="btn btn-info">
          <button type="button" id="close_modal" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </form>
    </div>
  </div>
</div>
