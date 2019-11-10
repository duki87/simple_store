<div id="productEditModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form class="" method="post" id="product_form_edit">
        <div class="modal-header">
          <h4 class="modal-title"><i class="fa fa-pencil-square-o"></i> Edit Product</h4>
          <button type="button" name="close" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <div class="form-row">
            <div class="form-group col-md-6">
              <label>Enter Product Name</label>
              <input type="text" name="product_new_name" id="product_new_name" class="form-control" required placeholder="For example: Paper" value="">
            </div>
            <div class="form-group col-md-3">
              <label>Enter Product Quantity</label>
              <input type="text" name="product_new_quantity" id="product_new_quantity" class="form-control" required value="">
            </div>
            <div class="form-group col-md-3">
              <label>Units</label>
              <select class="form-control" name="product_new_unit" id="product_new_unit" required>
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
                <input type="text" name="product_base_price_new" id="product_base_price_new" class="form-control" required pattern="[+-]?([0-9]*[.])?[0-9]+" />
            </div>
            <div class="form-group col-md-6">
                <label>Enter Product Tax (%)</label>
                <input type="text" name="product_new_tax" id="product_new_tax" class="form-control" required pattern="[+-]?([0-9]*[.])?[0-9]+" />
            </div>
            <div class="form-group col-md-6">
              <label>Product Category</label>
              <select class="form-control" name="category_id_new" id="category_id_new" required>
                <option value="">Select Category</option>
                <?php echo get_category_list($connect);?>
              </select>
            </div>
            <div class="form-group col-md-6">
              <label>Product Brand</label>
              <select class="form-control" name="brand_id_new" id="brand_id_new" required>
                <?php echo get_brand_list($connect);?>
              </select>
            </div>
            <div class="form-group col-md-4">
              <label>Product Description</label>
              <textarea name="product_new_description" id="product_new_description" rows="6" cols="84"></textarea>
            </div>
          </div>

        <div class="modal-footer">
          <input type="hidden" name="edit_product_id" id="edit_product_id" value="">
          <input type="submit" name="edit_product" id="edit_product" value="Edit" class="btn btn-info">
          <button type="button" id="close_modal" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </form>
    </div>
  </div>
</div>
