<div id="orderModal" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg" >
    <div class="modal-content">
      <form class="" method="post" id="order_form">
        <div class="modal-header">
          <h4 class="modal-title"><i class="fa fa-plus"></i> Add New Order</h4>
          <button type="button" name="close" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <div class="form-row">
              <div class="form-group col-md-5">
                <label>Enter Customer Name</label>
                <input type="text" name="inventory_order_name" id="inventory_order_name" class="form-control" required placeholder="For example: Miki" value="">
            </div>
            <div class="form-group col-md-5">
              <label>Customer Address</label>
              <input type="text" name="inventory_order_address" id="inventory_order_address" class="form-control" required value="">
            </div>
            <div class="form-group col-md-2">
              <label>Date</label>
              <input type="text" name="inventory_order_date" id="inventory_order_date" class="form-control" required value="">
            </div>
            <div class="form-group col-md-12">
              <label>Product Details</label>
              <span id="span_products_details"></span>
              <hr>
            </div>
            <div class="form-group col-md-4">
              <label>Payment Status</label>
              <select name="payment_status" id="payment_status" class="form-control" required value="">
                <option>Select Payment Status</option>
                <option value="cash">Cash</option>
                <option value="credit">Credit</option>
              </select>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <input type="hidden" name="inventory_order_id" id="inventory_order_id" value="">
          <input type="hidden" name="btn_action" id="btn_action" value="">
          <input type="submit" name="add_order" id="add_order" value="Add" class="btn btn-info">
          <button type="button" id="close_modal" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </form>
    </div>
  </div>
</div>
