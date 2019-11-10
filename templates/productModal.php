<div id="productModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" >
      <div class="modal-content">
        <form class="" id="product_form" enctype="multipart/form-data">
          <div class="modal-header">
            <h4 class="modal-title"><i class="fa fa-plus"></i> Add Product</h4>
            <button type="button" name="close" class="close" data-dismiss="modal">&times;</button>
          </div>
          <div class="modal-body">
            <div class="form-row">
              <div class="form-group col-md-6">
                <label>Enter Product Name</label>
                <input type="text" name="product_name" id="product_name" class="form-control" required placeholder="For example: Paper" value="">
              </div>
              <div class="form-group col-md-3">
                <label>Enter Product Quantity</label>
                <input type="text" name="product_quantity" id="product_quantity" class="form-control" required value="">
              </div>
              <div class="form-group col-md-3">
                <label>Units</label>
                <select class="form-control" name="product_unit" id="product_unit" required>
                  <option value="">Select Unit</option>
                  <option value="kg">kg</option>
                  <option value="pieces">pieces</option>
                  <option value="liters">liters</option>
                  <option value="meters">meters</option>
                  <option value="box">box</option>
                </select>
              </div>
              <div class="form-group col-md-6">
                  <label>Enter Product Base Price</label>
                  <input type="text" name="product_base_price" id="product_base_price" class="form-control" required pattern="[+-]?([0-9]*[.])?[0-9]+" />
              </div>
              <div class="form-group col-md-6">
                  <label>Enter Product Tax (%)</label>
                  <input type="text" name="product_tax" id="product_tax" class="form-control" required pattern="[+-]?([0-9]*[.])?[0-9]+" />
              </div>
              <div class="form-group col-md-6">
                <label>Product Category</label>
                <select class="form-control" name="category_id" id="category_id" required>
                  <option value="">Select Category</option>
                  <?php echo get_category_list($connect);?>
                </select>
              </div>
              <div class="form-group col-md-6">
                <label>Product Brand</label>
                <select class="form-control" name="brand_id" id="brand_id" required>
                  <option value="">First Select Category</option>
                </select>
              </div>
              <div class="form-group col-md-7">
                <label>Product Description</label>
                <textarea class="form-control" name="product_description" id="product_description" cols="" rows="6"></textarea>
              </div>
              <div class="form-group col-md-5">
                <label>Product Photo</label><span style="color:green;margin-left:10%" id="uploaded_image"></span>
                <input type="file" name="image_file" id="image_file" value="" class="form-control"><br>
                <input type="hidden" name="image_location" id="image_location" value="" class="form-control">
                <div class="" id="image_preview" style="width=100%; height=auto"></div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <input type="hidden" name="delete_product" id="delete_product" value="">
            <input type="hidden" name="btn_action" id="btn_action" value="">
            <input type="submit" name="add_product" id="add_product" value="Add" class="btn btn-info">
            <button type="button" id="close_modal" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
        </form>
    </div>
  </div>
</div>
