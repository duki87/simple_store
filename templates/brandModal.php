<div id="brandModal" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form class="" method="post" id="brand_form" enctype="multipart/form-data">
        <div class="modal-header">
          <h4 class="modal-title"><i class="fa fa-plus"></i> Add User</h4>
          <button type="button" name="close" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="form-group col-md-7">
              <label>Enter Brand Name</label>
              <input type="text" name="brand_name" id="brand_name" class="form-control" required placeholder="For example: Roto" value="">
            </div>
            <div class="form-group col-md-5">
              <label>Category of Products</label>
              <select class="form-control" name="category_id" id="category_id" required>
                <option value="">Select Category</option>
                <?php echo get_category_list($connect);?>
              </select>
            </div>
            <div class="form-group col-md-5">
              <label>Brand Logo</label><span style="color:green;margin-left:10%" id="uploaded_image"></span>
              <input type="file" name="image_file" id="image_file" value="" class="form-control"><br>
              <input type="hidden" name="logo_location" id="logo_location" value="" class="form-control">
              <div class="" id="image_preview" style="width=100%; height=auto"></div>
            </div>
            <div class="form-group col-md-7">
              <label>Brand Description</label>
              <textarea class="form-control" name="brand_description" id="brand_description"></textarea>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <input type="hidden" name="delete_brand" id="delete_brand" value="">
          <input type="submit" name="add_brand" id="add_brand" value="Add" class="btn btn-info">
          <button type="button" id="close_modal" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </form>
    </div>
  </div>
</div>
