<div id="brandEditModal" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form class="" method="post" id="brand_form_edit">
        <div class="modal-header">
          <h4 class="modal-title"><i class="fa fa-pencil-square-o"></i> Edit Brand</h4>
          <button type="button" name="close" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="form-group col-md-7">
              <label>Edit Brand Name</label>
              <input type="text" name="brand_new_name" id="brand_new_name" class="form-control" required value="">
            </div>
            <div class="form-group col-md-5">
              <label>Category of Products</label>
              <select class="form-control" name="category_new_id" id="category_new_id" required>
                <option value="">Select Category</option>
                <?php echo get_category_list($connect);?>
              </select>
            </div>
            <div class="form-group col-md-5">
              <label>Brand Logo</label><span style="color:green;margin-left:10%" id="uploaded_image_edit"></span>
              <input type="file" name="image_file_edit" id="image_file_edit" value="" class="form-control"><br>
              <input type="hidden" name="logo_location_edit" id="logo_location_edit" value="" class="form-control">
              <div class="" id="image_preview_edit" style="width=100%; height=auto"></div>
            </div>
            <div class="form-group col-md-7">
              <label>Brand Description</label>
              <textarea class="form-control" name="brand_description_edit" id="brand_description_edit"></textarea>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <input type="hidden" name="edit_brand_id" id="edit_brand_id" value="">
          <input type="submit" name="edit_brand" id="edit_brand" value="Edit" class="btn btn-info">
          <button type="button" id="close_modal" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </form>
    </div>
  </div>
</div>
