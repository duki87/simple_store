<div id="categoryModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <form class="" method="post" id="category_form">
        <div class="modal-header">
          <h4 class="modal-title"><i class="fa fa-plus"></i> Add Category</h4>
          <button type="button" name="close" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label>Enter Category Name</label>
            <input type="text" name="category_name" id="category_name" class="form-control" required placeholder="For example: Papers" value="">
          </div>
        </div>
        <div class="modal-footer">
          <input type="hidden" name="delete_category" id="delete_category" value="">
          <input type="submit" name="add_category" id="add_category" value="Add" class="btn btn-info">
          <button type="button" id="close_modal" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </form>
    </div>
  </div>
</div>
