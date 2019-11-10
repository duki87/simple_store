<div id="checkOutModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" >
      <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title"><i class="fa fa-plus"></i> Podaci o kartici za placanje</h4>
            <button type="button" name="close" class="close" data-dismiss="modal">&times;</button>
          </div>
          <div class="modal-body">
            <form action="/charge" method="post" id="payment-form">
              <div class="form-row">
                <div class="form-group col-md-12">
                  <label for="name">
                    Ime na kartici
                  </label>
                  <input type="text" class="form-control" name="card-name" data-stripe="card-name" value="" id="card-name">
                </div>
                <div class="form-group col-md-4">
                  <label for="exp-month">
                    Istice (mesec)
                  </label>
                  <input type="text" name="exp-month" class="form-control" data-stripe="exp-month" value="" id="exp-month">
                </div>
                <div class="form-group col-md-4">
                  <label for="exp-year">
                    Istice (godina)
                  </label>
                  <input type="text" name="exp-year" class="form-control" data-stripe="exp-year" value="" id="exp-year">
                </div>
                <div class="form-group col-md-4">
                  <label for="cvc">
                    Kod
                  </label>
                  <input type="text" name="cvc" class="form-control" data-stripe="cvc" value="" id="cvc">
                </div>
              </div>
            </div>
          <div class="modal-footer">
            <input type="submit" class="submit btn btn-success" name="submit" data-stripe="" value="Naplati" id="submit">
            <button type="button" id="close_modal" class="btn btn-info" data-dismiss="modal">Nazad</button>
          </div>
        </div>
      </form>
    </div>
  </div>
