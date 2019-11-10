<div id="userEditModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <form class="" method="post" id="user_form_edit">
        <div class="modal-header">
          <h4 class="modal-title"><i class="fa fa-pencil-square-o"></i> Edit User</h4>
          <button type="button" name="close" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label>Enter User Name</label>
            <input type="text" name="user_new_name" id="user_new_name" class="form-control" required placeholder="For example: Milorad" value="">
          </div>
          <div class="form-group">
            <label>Enter Your Email</label>
            <input type="email" name="user_new_email" id="user_new_email" class="form-control" required placeholder="For example: milorad@gmail.com" value="">
          </div>
          <div class="form-group">
            <label>Enter Your Password</label>
            <input type="password" name="user_new_password" id="user_new_password" class="form-control" value="">
          </div>
        </div>
        <div class="modal-footer">
          <input type="hidden" name="edit_id" id="edit_id" value="">
          <input type="submit" name="edit_user" id="edit_user" value="Edit" class="btn btn-info">
          <button type="button" id="close_modal" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </form>
    </div>
  </div>
</div>
