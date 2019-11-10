<?php
  include('db/db_con.php');
  include('functions/functions.php');
  if(!isset($_SESSION['type'])) {
    header('location:login.php');
  }
  if($_SESSION['type'] != 'master') {
    header("location:index.php");
  }
  include('includes/header.php');
?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/css/bootstrap-datepicker.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/js/bootstrap-datepicker.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/css/bootstrap-datepicker.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/css/bootstrap-select.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/js/bootstrap-select.min.js"></script>
<script>
  $(document).ready(function() {
    $('#inventory_order_date').datepicker({
      format: "dd-mm-yyyy",
      autoclose: true
    });
  });
</script>

<br>
<div class="container">
  <div id="alert_action" class=""></div>
  <div class="row">
    <div class="col-lg-12">
      <div class="panel panel-default">
        <div class="panel-heading">
          <div class="row">
            <div class="col-lg-10 col-md-10 col-sm-8 col-xs-6">
              <h3 class="panel-title">Order List</h3>
            </div>
          <div class="col-lg-2 col-md-2 col-sm-4 col-xs-6" align="right">
            <button type="button" name="add" id="add_button" data-toggle="modal" data-target="#orderModal" class="btn btn-success btn-xs">Add New Order</button>
          </div>
        </div>
        </div>
        <div class="clear:both"></div>
        <div class="panel-body">
          <div class="row"><div class="col-sm-12 table-responsive">
            <table id="order_data" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>Order Id</th>
                  <th>Cutomer Name</th>
                  <th>Total Amount</th>
                  <th>Payment Status</th>
                  <th>Order Status</th>
                  <th>Order Date</th>
                  <?php if($_SESSION['type'] == 'master') { ?>
                    <?php echo '<th>Created By:</th>'; ?>
                  <?php } ?>
                  <th></th>
                  <th></th>
                  <th></th>
                </tr>
              </thead>
            </table>
          </div>

          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?php include('templates/orderModal.php'); ?>
<?php include('templates/orderEditModal.php'); ?>

<script>
  $(document).ready(function() {
    var orderDataTable = $('#order_data').DataTable({
      "processing"  : true,
      "serverSide"  : true,
      "order" : [],
      "ajax"  : {
        url : "order_fetch.php",
        type :  "POST"
      },
      "columnDefs"  : [
        {
          "target"  : [7,8,9],
          "orderable" : false
        }
      ],
      "pageLength"  : 10
    });

    $('#add_button').click(function() {
      $('#order_form')[0].reset();
      $('#btn_action').val('Add');
      $('#span_products_details').html('');
      add_product_row();
    });

    function add_product_row(count = '') {
      var html = '';
      html += '<span id="row'+count+'"><div class="row">';
      html += '<div class="col-md-8">';
      html += '<select class="form-control selectpicker" data-live-search="true" name="product_id[]" id="product_id'+count+'" required>';
      html += '<?php echo fill_product_list($connect); ?>';
      html += '</select><input type="hidden" name="hidden_product_id[]" id="hidden_product_id'+count+'">';
      html += '</div>';
      html += '<div class="col-md-3">';
      html += '<input type="number" name="quantity[]" id="quantity" class="form-control" required>';
      html += '</div>';
      html += '<div class="col-md-1">';
      if(count == '') {
        html += '<button type="button" name="add_more" id="add_more" class="btn btn-primary btn-xs">+</button>';
      } else {
        html += '<button type="button" name="remove" id="'+count+'" class="btn btn-danger btn-xs remove">-</button>';
      }
      html += '</div>';
      html += '</div></div><br></span>';
      $('#span_products_details').append(html);
      $('.selectpicker').selectpicker();
    }

    var count = 0;
    $(document).on('click', '#add_more', function() {
      count = count + 1;
      add_product_row(count);
    });
    $(document).on('click', '.remove', function() {
      var row_no = $(this).attr('id');
      $('#row'+row_no).remove();
    });

    $(document).on('submit', '#order_form', function(event) {
      event.preventDefault();
      $('#add_order').attr('disabled','disabled');
      var form_data = $(this).serialize();
      $.ajax({
        url:  'order_action.php',
        method: 'POST',
        data: form_data,
        success: function(data) {
          if(data == 'Order successfully created!') {
          $('#order_form')[0].reset();
          $('#orderModal').modal('hide');
          $('#add_order').attr('disabled',false);
          $('#alert_action').addClass('alert alert-success');
          $('#alert_action').html(data);
          $('#alert_action').delay(3000).fadeOut('slow');
          remClass();
          orderDataTable.ajax.reload();
        } else {
          $('#alert_action').addClass('alert alert-danger');
          $('#alert_action').html(data);
          $('#alert_action').delay(3000).fadeOut('slow');
          orderDataTable.ajax.reload();
          remClass();
        }
      }
    });
  });

  $(document).on('click', '.update', function() {
    var inventory_order_id = $(this).attr('id');
    $('#inventory_order_edit_id').val(inventory_order_id);
    var inventory_order_edit_id = $('#inventory_order_edit_id').val();
    $.ajax({
      url:  'order_action.php',
      method: "POST",
      data: {inventory_order_edit_id:inventory_order_edit_id},
      dataType: "json",
      success: function(data) {
        $('#inventory_order_new_name').val(data.inventory_order_name);
        $('#inventory_order_new_address').val(data.inventory_order_address);
        $('#inventory_order_new_date').val(data.inventory_order_date);
        $('#span_products_new_details').html(data.product_details);
        $('#payment_new_status').val(data.payment_status);
      }
    });
  });

    function remClass() {
      var className = $('#alert_action').attr('class');
      setTimeout(function() {
        $('#alert_action').removeClass(className);
        $('#alert_action').text('');
      }, 3000);
      setTimeout(function() {
        $('#alert_action').attr("style", "display:block");
      },4000);
    }

});
</script>
