<div id="payModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" >
      <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title"><i class="fa fa-plus"></i> Podaci o kupcu</h4>
            <button type="button" name="close" class="close" data-dismiss="modal">&times;</button>
          </div>
          <div class="modal-body">
            <form class="" id="pay_form">
              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="customer_name">Ime i prezime</label>
                  <input type="text" name="customer_name" id="customer_name" value="" class="form-control" required>
                </div>
                <div class="form-group col-md-6">
                  <label for="customer_address">Adresa</label>
                  <input type="text" name="customer_address" id="customer_address" value="" class="form-control" required>
                </div>
                <div class="form-group col-md-6">
                  <label for="payment_method">Nacin placanja</label>
                  <select class="form-control" name="payment_method" id="payment_method" required>
                    <option value="">Izaberite</option>
                    <option value="cash">Gotovina (pouzecem)</option>
                    <option value="credit">Kartica</option>
                  </select>
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <input type="submit" name="pay_proceed" id="pay_proceed" value="Dalje" class="btn btn-success">
              <button type="button" id="close_modal" class="btn btn-info" data-dismiss="modal">Nazad</button>
            </div>
        </form>
    </div>
  </div>
</div>
