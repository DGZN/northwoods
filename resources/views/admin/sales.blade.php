@extends('admin.layouts.master')

@section('title', 'North Woods Admin Dashboard')

@section('navbar')

@endsection

@section('content')
    <div class="row">
        <div class="col-md-7">
            <div class="well well-lg">
              <span
                aria-hidden="true"
                onclick="addItem()"
                class="glyphicon glyphicon glyphicon-plus pull-right add-item">
              </span>

                      <div class="modal-content">
                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                          <h4 class="modal-title" id="myModalLabel">Add New Sale</h4>
                        </div>
                        <form id="billForm" data-resource="transactions">
                          <div class="modal-body">
                            <div class="form-group col-md-6">
                              <label for="productID">Product</label>
                              <select class="form-control" id="productID" name="productID">
                                  <option selected="" disabled>-- Select a Product --</option>
                                @for ($i = 0; $i < count($products); $i++)
                                   @if ($products[$i]->parentID == 0)
                                      <option value="{{$products[$i]->id}}" data-subs="{{$products[$i]->subs}}">{{$products[$i]->name}}</option>
                                   @endif
                                @endfor
                              </select>
                            </div>
                            <div class="form-group col-md-6">
                              <label for="optionID">Option</label>
                              <select name="optionID" id="optionID" class="form-control">
                                <option disabled="" selected value="0">-- Product Option --</option>
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
                            <div id="total-field" class="form-group col-md-2 col-md-offset-10">
                              <input id="addSubProduct" type="button" class="form-control btn btn-success" value="Add" />
                            </div>
                            <div class="form-group col-md-12">
                              <div class="small well" id="bill-fields">
                                <ul class="list-group" id="sub-products" data-subProducts=[] >

                                </ul>
                                <div class="small well">
                                    <div class="row form-group">
                                        <div class="col-md-12">
                                            <h5 class="pull-right">Total: <span id="bill-total" class="total">$0.00</span> </h5>
                                        </div>
                                        <div class="col-md-12">
                                            <h5 class="pull-right">TAX: <span id="tax" class="tax">$0.00</span> </h5>
                                        </div>
                                        <div class="col-md-12">
                                            <h4 class="pull-right">Grand Total: <span id="grand-total" class="grand-total">$0.00</span> </h4>
                                        </div>
                                    </div>
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="modal-footer">
                          </div>
                        </form>
                      </div>

            </div>
        </div>
        <div class="col-md-5">
            <div class="well well-lg">
              <div class="modal-content">
                <form id="addSaleForm" data-resource="transactions">
                  <input type="hidden" id="employeeID" name="employeeID" value="{{ Auth::user()->id }}" />
                  <div class="modal-body">
                    <div class="form-group col-md-12">
                      <label for="type">Transaction Type</label>
                      <select name="type" id="type" class="form-control" style="cursor: pointer;">
                        <option disabled="" selected>-- Transaction Type --</option>
                        <option value="cash">Cash</option>
                        <option value="charge">Charge</option>
                        <option value="cardOnFile">Card on File</option>
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
                      <input type="customerID" class="form-control" id="customerID" name="customerID" placeholder="Customer" disabled="">
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
                        <div class="form-group col-md-12">
                          <label for="phone">Phone</label>
                          <input type="text" class="form-control" id="phone" name="phone" placeholder="Phone">
                        </div>
                        <div class="form-group col-md-6" style="display: none;">
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


  $('#type').change(function(){
    switch ($(this).val()) {
      case 'charge':
        toggleForm('#credit-card-form')
        break;
      case 'card-on-file':

        // toggleForm('#customer-form')
        // $("#customerID").typeahead({ source: customers });
        // var $customer = $("#customerID");
        // $customer.change(function() {
        //   var current = $customer.typeahead("getActive");
        //   if (current)
        //     $customer.val(current.first_name + ' ' + current.last_name).data('id', current.id)
        // });
        break;
      case 'cash':
        toggleForm('#cash-payment-form')
        $('#cash-given').on('keydown', function(){
          calculateChangeDue()
        })
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
    $('#productID').change(function(){
      var selectedID = $(this).val();
      var subProducts = $(this).find(':selected').data('subs')
      console.log("subs", subProducts)
      $('#optionID').html('<option disabled="" selected>-- Product Option --</option>')
      subProducts.map((sub) => {
        $('#optionID').append($('<option/>', {
          value: sub.id
        , 'data-product': sub
        , text: sub.name
        }))
      })
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
            var price = product.price * $('#qty').val()
            var price = Math.round(price * 100) / 100
            $('#total').val(price)
          } else {
            var price = Math.round(product.price * 100) / 100
            $('#total').val(price)
          }
        }
      })
    })
    $('#qty').on('keyup', function(){
      if ( ! isNaN($(this).val()) ) {
        var price = currentProduct.price * $(this).val()
        var price = Math.round(price * 100) / 100
        $('#total').val(price)
      }
    })
    $('#addSubProduct').click(() => {
      var option = ''
      if ($('#optionID').val() > 0)
        var option = ' (' + $('#optionID').find(':selected').text() + ')'
      var name = $('#productID').find(':selected').text() + option
      var price = $('#total').val()
      var qty = $('#qty').val()
      subProducts = $('#sub-products').data('subProducts') || [];
      subProducts.push({
          name:  name
        , productID: $('#optionID').val()
        , total: $('#total').val()
        , qty: $('#qty').val()
      })
      var i = $('<i/>', {
        class: 'icon-danger glyphicon glyphicon-remove pull-right'
      , 'data-index': (subProducts.length-1)
      , css: {
          color: 'red'
        , cursor: 'pointer'
        }
      }).click((e) => {
        var index = $(e.target).data('index')
        delete subProducts[index]
        $(e.target).parent().fadeOut(2500).delay(100).remove()
        calculateBill()
      })
      var li = $('<li/>', {
        class: 'list-group-item'
      , html: name + ' - $' +  price + ' x ' + qty + ''
      }).append(i)
      $('#sub-products').append(li)
      $('#sub-products').data('subProducts', subProducts)
      calculateBill()
    })
    $("#addSaleForm").on( "submit", function( event ) {
      event.preventDefault();
      var resource = this.getAttribute("data-resource")
      var params = {};
      $.each($(this).serializeArray(), function(_, kv) {
        params[kv.name] = kv.value;
      });
      subProducts.map((product) => {
        product['type'] = params.type
        if (params.type == 'cash') {
          product['status'] = 1;
        }
        product['employeeID'] = params.employeeID
        $.ajax({
          url: url + '/api/v1/' + resource,
          type: 'post',
          data:  product,
          success: function(data){
            console.log("sale data", data);
            //location.reload()
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
      })
      return console.log("Submitting sale", params, 'subproducts', subProducts);
    });

    function calculateBill(){
      var cost = 0;
      var tax = 0;
      var total = 0;
      subProducts.forEach((product) => {
        cost += parseInt(product.total)
      })
      var tax = cost / 10
      var total = (parseInt(cost) + parseInt(tax));
      $('#bill-total').html('$' + cost)
      $('#tax').html('$' + tax)
      $('#grand-total').html('$' + total)
      grandPrice = total
      calculateChangeDue()
    }

    function calculateChangeDue(){
      var self = $('#cash-given');
      setTimeout(function(){
        if ( ! isNaN(self.val() ) ) {
          var given = self.val()
          var price = grandPrice;
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
    }
})




</script>
@endsection
