$(document).ready(function(data) {
  $('.add_to_cart').click(function() {
    var product_id = $(this).attr('id');
    var product_name = $('#name'+product_id).val();
    var product_price = $('#price'+product_id).val();
    var product_quantity = $('#quantity'+product_id).val();
    var action = 'add';
    if(product_quantity > 0) {
      $.ajax({
        url:  'actions/cart_actions.php',
        method: 'POST',
        dataType: 'json',
        data: {
          product_id:product_id,
          product_name:product_name,
          product_price:product_price,
          product_quantity:product_quantity,
          action:action
        },
        success: function(data) {
          $('#count-cart').text(data.cart_item);
        }
      });
    } else {
      alert('Unesite kolicinu proizvoda.');
    }
  });

  $(document).on('click', '.delete', function() {
    var cartTable = $('#cartTable');
    var product_id = $(this).attr('id');
    var action = 'remove';
    if(confirm('Da li zelite da izbacite ovaj proizvod iz korpe?')) {
      $.ajax({
        url:  'actions/remove_from_cart.php',
        method: 'POST',
        data: {
          product_id:product_id,
          action:action
        },
        success: function(data) {
          $('#alert_action').addClass('alert alert-success');
          $('#alert_action').html(data);
          $('#alert_action').delay(3000).fadeOut('slow');
          $("#cartTable").load(" #cartTable");
          remClass();
        }
      });
    } else {
      return false;
    }
  });

  $(document).on('change', '.quantity', function() {
    var cartTable = $('#cartTable');
    var product_id = $(this).data('product_id');
    var quantity = $(this).val();
    var action = 'quantity_change';
    if(quantity != '') {
      $.ajax({
        url:  'actions/update_cart.php',
        method: 'POST',
        data: {
          product_id:product_id,
          quantity:quantity,
          action:action
        },
        success: function(data) {
          $('#alert_action').addClass('alert alert-success');
          $('#alert_action').html(data);
          $('#alert_action').delay(3000).fadeOut('slow');
          $("#cartTable").load(" #cartTable");
          remClass();
        }
      });
    } else {
      return false;
    }
  });

  $('#pay_form').on('submit', function(event) {
    event.preventDefault();
    var customer_name = $('#customer_name').val();
    var customer_address = $('#customer_address').val();
    var payment_method = $('#payment_method').val();
    var payment_total = $('#payment_total').val();
    var action = 'payment';
      $.ajax({
        method: 'POST',
        url:  'actions/payment.php',
        data: {
          customer_name:customer_name,
          customer_address:customer_address,
          payment_method:payment_method,
          payment_total:payment_total,
          action:action
        },
        success: function(data) {
          if(data == 'Uspesno ste narucili proizvode. Placate pouzecem.') {
            $('#payModal').modal('toggle');
            $('#alert_action').addClass('alert alert-success');
            $('#alert_action').html(data);
            $('#alert_action').delay(3000).fadeOut('slow');
            $("#cartTable").load(" #cartTable");
            remClass();
          } else {
            $('#payModal').modal('toggle');
            $('#checkOutModal').modal('toggle');
          }
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
