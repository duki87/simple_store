<div id="categoryEditModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <form class="" method="post" id="category_form_edit">
        <div class="modal-header">
          <h4 class="modal-title"><i class="fa fa-pencil-square-o"></i> Edit Category</h4>
          <button type="button" name="close" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label>Edit Category Name</label>
            <input type="text" name="category_new_name" id="category_new_name" class="form-control" required value="">
          </div>
        </div>
        <div class="modal-footer">
          <input type="hidden" name="edit_category_id" id="edit_category_id" value="">
          <input type="submit" name="edit_category" id="edit_category" value="Edit" class="btn btn-info">
          <button type="button" id="close_modal" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </form>
    </div>
  </div>
</div>
