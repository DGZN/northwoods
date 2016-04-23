@extends('admin.layouts.master')

@section('title', 'North Woods Admin Dashboard')

@section('navbar')

@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="well well-lg">
              <span
                aria-hidden="true"
                onclick="addItem()"
                class="glyphicon glyphicon glyphicon-plus pull-right add-item">
              </span>
              <table class="table table-hover">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Type</th>
                      <th>Product</th>
                      <th>Reference #</th>
                      <th>Employee</th>
                      <th>Reservation Primary</th>
                      <th>Customer</th>
                      <th>Total</th>
                      <th>Status</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    @for ($i = 0; $i < count($transactions); $i++)
                      <tr id="{{ 'row'.$i }}" class="bg-success">
                          <th scope="row">{{$transactions[$i]->id}}</th>
                          <td>{{$transactions[$i]['type'] or ''}}</td>
                          <td>
                            {{
                              $transactions[$i]['product']['name'] or
                              $transactions[$i]->productID
                            }}
                          </td>
                          <td>{{$transactions[$i]->referenceID}}</td>
                          <td>
                            {{
                              $transactions[$i]['employee']['name'] or
                              $transactions[$i]->employeeID
                            }}
                          </td>
                          <td>{{$transactions[$i]->reservationName}}</td>
                          <td>{{$transactions[$i]->customerName}}</td>
                          <td>${{$transactions[$i]->total}}</td>
                          <td>
                            <span style="font-weight: bold;">
                              {{
                                $transactions[$i]->status > 0
                                  ? 'Charged'
                                  : 'Charged'
                              }}
                            </span>
                          </td>
                          <td>
                              <i class="remove-icon"
                                 onclick="removeItem(this)"
                                 data-row="{{'row'.$i}}"
                                 data-id="{{$transactions[$i]->id}}"
                                 data-resource="transactions"></i>
                              <!-- <i class="glyphicon glyphicon-usd" aria-hidden="true"></i> -->

                          </td>
                      </tr>
                    @endfor
                  </tbody>
              </table>
            </div>
        </div>
    </div>

    <div class="modal fade" id="addItemModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel">Add New Sale</h4>
          </div>
          <form id="addSaleForm" data-resource="transactions">
            <input type="hidden" name="employeeID" value="{{ Auth::user()->id }}" />
            <div class="modal-body">
              <div class="form-group col-md-12">
                <label for="productID">Product</label>
                <select class="form-control" id="productID" name="productID">
                    <option selected disabled>-- Select a Product --</option>
                  @for ($i = 0; $i < count($products); $i++)
                    <option value="{{$products[$i]->id}}">{{$products[$i]->name}}</option>
                  @endfor
                </select>
              </div>
              <div class="form-group col-md-6">
                <label id="qty-label" for="qty">Quantity</label>
                <input type="text" id="qty" class="form-control" value="1" disabled />
              </div>
              <div id="total-field" class="form-group col-md-6">
                <label for="total">Total</label>
                <input type="total" class="form-control" id="total" name="total" placeholder="Total" disabled>
              </div>
              <div class="form-group col-md-12">
                <label for="productID">Transaction Type</label>
                <select name="type" id="type" class="form-control" disabled>
        					<option selected disabled>-- Transaction Type --</option>
                  <option value="charge">Charge</option>
                  <option value="card-on-file">Card on File</option>
        					<option value="cash">Cash</option>
        					<option value="check">Check</option>
        					<option value="certificate">Gift Certificate</option>
        					<option value="corporate">Corporate Account</option>
        					<option value="discount">Discount</option>
        					<option value="void">Void</option>
        				</select>
              </div>
              <div id="cash-payment-form" class="hidden-fields">
                <div id="cash-given-form" class="form-group col-md-6">
                  <label for="cash-given">Cash given</label>
                  <input type="cash-given" class="form-control" id="cash-given" name="cash-given" placeholder="-- Cash Given --">
                </div>
                <div id="change-due-form" class="form-group col-md-6">
                  <label id="change-due-label" for="change-due">Change due</label>
                  <input type="change-due" class="form-control" id="change-due" name="change-due" placeholder="-- Change Due --" disabled="">
                </div>
              </div>
              <div id="customer-form" class="form-group col-md-12 hidden-fields">
                <label for="customerID">Customer</label>
                <input type="customerID" class="form-control" id="customerID" name="customerID" placeholder="Customer">
              </div>
              <div id="credit-card-form" class="form-group col-md-12 hidden-fields">
                <div class="small well" style="min-height: 500px;">
                  <div class="form-group col-md-6">
                    <label for="first_name">First Name</label>
                    <input type="text" class="form-control" id="first_name" name="first_name" placeholder="First Name">
                  </div>
                  <div class="form-group col-md-6">
                    <label for="last_name">Last Name</label>
                    <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Last Name">
                  </div>
                  <div class="form-group col-md-6">
                    <label for="phone">Phone</label>
                    <input type="text" class="form-control" id="phone" name="phone" placeholder="Phone">
                  </div>
                  <div class="form-group col-md-6">
                    <label for="email">Email</label>
                    <input type="text" class="form-control" id="email" name="email" placeholder="Email">
                  </div>
                  <div class="form-group col-md-12">
                    <label for="address">Address</label>
                    <textarea id="address" class="form-control" name="address" rows="3"></textarea>
                  </div>
                  <div class="form-group col-md-6">
                    <label for="city">City</label>
                    <input type="text" class="form-control" id="city" name="city" placeholder="City">
                  </div>
                  <div class="form-group col-md-6">
                    <label for="state">State</label>
                    <input type="text" class="form-control" id="state" name="state" placeholder="State">
                  </div>
                  <div class="form-group col-md-6">
                    <label for="zip">Zip</label>
                    <input type="text" class="form-control" id="zip" name="zip" placeholder="Zip">
                  </div>
                  <div class="form-group col-md-6">
                    <label for="country">Country</label>
                    <input type="text" class="form-control" id="country" name="country" placeholder="Country">
                  </div>
                  <div class="form-group col-md-6">
                    <label for="card_number">Credit Card Number</label>
                    <input type="text" class="form-control" id="card_number" name="card_number" value="4111111111111111">
                  </div>
                  <div class="form-group col-md-6">
                    <label for="exp_date">Expiration date</label>
                    <input type="text" class="form-control" id="exp_date" name="exp_date" value="2038-12">
                  </div>
                </div>
              </div>
              <div id="check-payment-form" class="form-group col-md-12 hidden-fields">
                <label for="referenceID">Check #</label>
                <input type="referenceID" class="form-control" id="referenceID" name="referenceID" placeholder="-- Check Number --">
              </div>
              <div id="certificate-payment-form" class="form-group col-md-12 hidden-fields">
                <label for="certificateID">Gift Certificate #</label>
                <input type="certificateID" class="form-control" id="certificateID" name="certificateID" placeholder="-- Gift Certificate Number --" disabled>
              </div>
              <div id="corporate-payment-form" class="form-group col-md-12 hidden-fields">
                <label for="corporateID">Corporate Account #</label>
                <select class="form-control" id="corporateID" name="corporateID">
                    <option selected disabled>-- Select an Account --</option>
                  @for ($i = 0; $i < count($accounts); $i++)
                    <option value="{{$accounts[$i]->id}}">{{$accounts[$i]->account . ' ' . $accounts[$i]->first_name  . ' ' . $accounts[$i]->last_name }}</option>
                  @endfor
                </select>
              </div>
              <div id="discount-form" class="form-group col-md-12 hidden-fields">
                <label for="discount">Discount Amount</label>
                <input type="discount" class="form-control" id="discount" name="discount" placeholder="-- Discount Amount --">
              </div>
              <div id="notes-form" class="form-group col-md-12 hidden-fields">
                <label for="notes">Notes</label>
                <textarea id="notes" class="form-control" name="notes" rows="3"></textarea>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary">Charge</button>
            </div>
          </form>
        </div>
      </div>
    </div>

@endsection

@section('scripts')
<script style="text/javascript">
var products     = {!! json_encode($products) !!}
var customers    = {!! json_encode($customers) !!}
var accounts     = {!! json_encode($accounts) !!}
var reservations = {!! json_encode($reservations) !!}

var customers = customers.map(function(customer){
  return {
    id: customer.id
  , name: customer.first_name + ' ' + customer.last_name
  }
})
var accounts = accounts.map(function(account){
  return {
    id: account.id
  , account: account.account
  , name: account.first_name + ' ' + account.last_name
  }
})
var reservations = reservations.map(function(reservation){
  var customer = reservation.customer
  return {
    id: reservation.id
  , name: customer['first_name'] + customer['last_name']
  }
})

var currentProduct = {};

var forms = [
  '#cash-payment-form'
, '#customer-form'
, '#credit-card-form'
, '#check-payment-form'
, '#certificate-payment-form'
, '#corporate-payment-form'
, '#discount-form'
, '#notes-form'
]

function toggleForm(show){
  forms.map((id) => {
    if ( show.indexOf(id) >= 0 ) {
      $(id).removeClass('hidden-fields')
    } else {
      $(id).addClass('hidden-fields')
    }
  })
}

$(function(){
  $("#customerID").typeahead({ source: customers, autoSelect: true });
  $("#corporateID").typeahead({ source: accounts, autoSelect: true });
  var $customer = $("#customerID");
  var $accounts = $("#corporateID");
  $customer.change(function() {
    var current = $customer.typeahead("getActive");
    $customer.val(current.name).data('id', current.id)
  });
  $accounts.change(function() {
    var current = $accounts.typeahead("getActive");
    $accounts.val(current.account).data('id', current.id)
  });
  $("#reservationID").typeahead({ source: reservations, autoSelect: true });
  var $reservation = $("#reservationID");
  $reservation.change(function() {
    var current = $reservation.typeahead("getActive");
    $reservation.val(current.id)
  });

  $('#type').change(function(){
    switch ($(this).val()) {
      case 'charge':
        toggleForm('#credit-card-form')
        break;
      case 'card-on-file':
        toggleForm('#customer-form')
        break;
      case 'cash':
        toggleForm('#cash-payment-form')
        $('#cash-given').on('keydown', function(){
          var self = $(this)
          setTimeout(function(){
            if ( ! isNaN(self.val() ) ) {
              var given = self.val()
              var price = $('#total').val()
              if (given > price) {
                $('#change-due').css({
                  "font-weight": '300'
                , "color": "#555"
                }).val(given - price)
                $('#cash-given').css({
                  "font-weight": '300'
                , "color": "#555"
                })
                $('#change-due-label').css({
                  "color": "#333"
                })
                $('#change-due-label').html('Change due')
              } else {
                $('#cash-given').css({
                  "font-weight": 'bold'
                , "color": "red"
                })
                $('#change-due-label').css({
                  "color": "red"
                })
                $('#change-due-label').html('CASH OWED')
                $('#change-due').css({
                  "font-weight": 'bold'
                , "color": "red"
                }).val(price - given)
              }
              if (given === price) {
                $('#change-due').css({
                  "font-weight": '300'
                , "color": "#555"
                }).val(given - price)
                $('#cash-given').css({
                  "font-weight": '300'
                , "color": "#555"
                })
                $('#change-due-label').css({
                  "color": "#333"
                })
              }
            }
          }, 500)
        })
        // $('#guests').val('').prop('disabled', true)
        // $('#referenceID').val('').prop('disabled', true)
        // $('#total-field').fadeIn(500, function(){
        //   $(this).css('display', 'block')
        // })
        // $('#notes-field').fadeIn(500, function(){
        //   $(this).css('display', 'block')
        // })
        break;
      case 'check':
        toggleForm('#check-payment-form')
        break;
      case 'certificate':
        toggleForm('#certificate-payment-form')
        break;
      case 'corporate':
        toggleForm('#corporate-payment-form')
        break;
      case 'discount':
        toggleForm(['#discount-form', '#notes-form'])
        break;
      case 'void':
        toggleForm('#notes-form')
        break;
    }
  })
  $('#bill_to').change(function(){
    switch ($(this).val()) {
      case 'reservation':
          $('#customerID-field').fadeOut(500, function(){
            $(this).css('display', 'none')
            $('#reservationID-field').fadeIn(500, function(){
              $(this).css('display', 'block')
            })
          })
        break;
      case 'customer':
        $('#reservationID-field').fadeOut(500, function(){
          $(this).css('display', 'none')
          $('#customerID-field').fadeIn(500, function(){
            $(this).css('display', 'block')
          })
        })
        break;
    }
  })
  $('#productID').change(function(){
    var selectedID = $(this).val();
    if (selectedID > 1) {
      $('#qty').prop('disabled', false)
      $('#qty-label').html('Quantity')
      $('#qty').prop('disabled', false)
    } else {
      $('#qty').prop('disabled', false)
      $('#qty-label').html('Guests')
    }
    $('#type').prop('disabled', false)
    products.map(function(product){
      if (product.id == selectedID) {
        currentProduct = product
        if ( $('#qty').val() > 0 ) {
          $('#total').val(product.price * $('#qty').val())
        } else {
          $('#total').val(product.price)
        }
      }
    })
  })
  $('#qty').on('keyup', function(){
    if ( ! isNaN($(this).val()) ) {
      $('#total').val(currentProduct.price * $(this).val())
    }
  })
})

$("#addSaleForm").on( "submit", function( event ) {
  event.preventDefault();
  var resource = this.getAttribute("data-resource")
  var params = {};
  $.each($(this).serializeArray(), function(_, kv) {
    params[kv.name] = kv.value;
  });
  console.log("creating new sale with", params);
  return;
  $.ajax({
    url: url + '/api/v1/' + resource,
    type: 'post',
    data:  params,
    success: function(data){
      location.reload()
    },
    error: function(data){
      var fields = data.responseJSON
      for (field in fields) {
        var _field = $('#'+field)
        var message = fields[field].toString().replace('i d', 'ID')
        _field.parent().addClass('has-error')
        _field.prop('placeholder', message)
      }
    }
  })
});

</script>
@endsection
