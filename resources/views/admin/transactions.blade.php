@extends('admin.layouts.master')

@section('title', 'North Woods Admin Dashboard')

@section('navbar')
<div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <a class="navbar-brand" href="#">North Woods Admin</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
        <ul class="nav navbar-nav navbar-left api-routes">
          <li><a href="/admin/customers">Customers</a></li>
          <li><a href="/admin/employees">Employees</a></li>
          <li><a href="/admin/reservations">Reservations</a></li>
          <li><a href="/admin/transactions">Transactions</a></li>
          <li><a href="/admin/products">Products</a></li>
          <li><a href="/admin/product-groups">Product Groups</a></li>
          <li><a href="/admin/product-types">Product Types</a></li>
        </ul>
        <ul class="nav navbar-nav navbar-right">
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Account <span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li><a href="#">Logout</a></li>
              </ul>
            </li>
        </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
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
                      <th>Product ID</th>
                      <th>Reference #</th>
                      <th>Employee ID</th>
                      <th>Reservation ID</th>
                      <th>Customer ID</th>
                      <th>Total</th>
                      <th>Status</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    @for ($i = 0; $i < count($transactions); $i++)
                      <tr id="{{ 'row'.$i }}">
                          <th scope="row">{{$transactions[$i]->id}}</th>
                          <td>{{$transactions[$i]->productID}}</td>
                          <td>{{$transactions[$i]->referenceID}}</td>
                          <td>{{$transactions[$i]->employeeID}}</td>
                          <td>{{$transactions[$i]->reservationID}}</td>
                          <td>{{$transactions[$i]->customerID}}</td>
                          <td>${{$transactions[$i]->total}}</td>
                          <td>
                            {{
                              $transactions[$i]->status > 0
                                ? 'Successful'
                                : 'Pending'
                            }}
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
            <h4 class="modal-title" id="myModalLabel">Add New Transaction</h4>
          </div>
          <form id="addItemForm" data-resource="transactions">
            <div class="modal-body">
              <div class="form-group col-md-6">
                <label for="productID">Transaction Type</label>
                <select name="transaction_type" id="transaction_type" class="form-control">
        					<option selected disabled>-- Transaction Type --</option>
        					<option value="swipe">Swipe</option>
        					<option value="cash">Cash</option>
        					<option value="check">Check</option>
        					<option value="certificate">Gift Certificate</option>
        					<option value="corporate">Corporate Account</option>
        					<option value="discount">Discount</option>
        					<option value="void">Void</option>
        				</select>
              </div>
              <div class="form-group col-md-6">
                <label for="productID">Transaction Recipient</label>
                <select name="billTo" id="bill_to" class="form-control">
        					<option selected disabled>-- Reservation or Customer --</option>
        					<option value="reservation">Reservartion Group</option>
        					<option value="customer">Customer</option>
        				</select>
              </div>
              <div class="form-group col-md-6">
                <label for="productID">Product</label>
                <select class="form-control" id="productID" name="productID">
                    <option selected disabled>-- Select a Product --</option>
                  @for ($i = 0; $i < count($products); $i++)
                    <option value="{{$products[$i]->id}}">{{$products[$i]->name}}</option>
                  @endfor
                </select>
              </div>
              <div class="form-group col-md-6">
                <div id="reservationID-field" >
                  <label for="reservationID">Reservation ID</label>
                  <input type="reservationID" class="form-control" id="reservationID" name="reservationID" placeholder="Reservation ID">
                </div>
                <div id="customerID-field" style="display: none;">
                  <label for="customerID">Customer</label>
                  <input type="customerID" class="form-control" id="customerID" name="customerID" placeholder="Customer">
                </div>
              </div>
              <div class="form-group col-md-6" >
                <div id="guests-field" >
                  <label for="guests">Guests</label>
                  <input type="guests" class="form-control" id="guests" name="primaryGuestID" placeholder="Guests">
                </div>
                <div id="referenceID-field" style="display: none;">
                  <label id="referenceIDLabel" for="referenceID">Reference #</label>
                  <input type="referenceID" class="form-control" id="referenceID" name="referenceID" placeholder="Reference #">
                </div>
              </div>
              <div id="total-field" class="form-group col-md-6">
                <label for="total">Total</label>
                <input type="total" class="form-control" id="total" name="total" placeholder="Total">
              </div>
              <div id="notes-field" class="form-group col-md-12" style="display: none">
                <label for="notes">Notes</label>
                <textarea id="notes" class="form-control" name="notes" rows="3"></textarea>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary">Create</button>
            </div>
          </form>
        </div>
      </div>
    </div>

@endsection

@section('scripts')
<script style="text/javascript">
var products  = {!! $products !!}
var customers = {!! $customers !!}
var customers = customers.map(function(customer){
  return {
    id: customer.id
  , name: customer.first_name + ' ' + customer.last_name
  }
})
var reservations = {!! $reservations !!}
var reservations = reservations.map(function(reservation){
  var customer = reservation.customer
  return {
    id: reservation.id
  , name: customer['first_name'] + customer['last_name']
  }
})

$(function(){
  $("#customerID").typeahead({ source: customers, autoSelect: true });
  var $customer = $("#customerID");
  $customer.change(function() {
    var current = $customer.typeahead("getActive");
    $customer.val(current.id)
  });
  $("#reservationID").typeahead({ source: reservations, autoSelect: true });
  var $reservation = $("#reservationID");
  $reservation.change(function() {
    var current = $reservation.typeahead("getActive");
    $reservation.val(current.id)
  });
  $('#transaction_type').change(function(){
    switch ($(this).val()) {
      case 'swipe':
          $('#guests-field').fadeOut(500, function(){
            $(this).css('display', 'none')
            $('#total-field').fadeIn(500, function(){
              $(this).css('display', 'block')
            })
            $('#referenceID-field').fadeIn(500, function(){
              $(this).css('display', 'block')
              $('#referenceIDLabel').html('Invoice Number')
              $('#referenceID').val('').prop('disabled', false).attr('placeholder', 'Invoice Number')
            })
            $('#notes-field').fadeIn(500, function(){
              $(this).css('display', 'block')
            })
          })
        break;
      case 'cash':
        $('#guests').val('').prop('disabled', true)
        $('#referenceID').val('').prop('disabled', true)
        $('#total-field').fadeIn(500, function(){
          $(this).css('display', 'block')
        })
        $('#notes-field').fadeIn(500, function(){
          $(this).css('display', 'block')
        })
        break;
      case 'check':
        $('#guests-field').fadeOut(500, function(){
          $(this).css('display', 'none')
          $('#total-field').fadeIn(500, function(){
            $(this).css('display', 'block')
          })
          $('#referenceID-field').fadeIn(500, function(){
            $(this).css('display', 'block')
            $('#referenceIDLabel').html('Check Number')
            $('#referenceID').val('').prop('disabled', false).attr('placeholder', 'Check Number')
          })
        })
        break;
      case 'certificate':
        $('#guests-field').fadeOut(500, function(){
          $(this).css('display', 'none')
          $('#total-field').fadeIn(500, function(){
            $(this).css('display', 'block')
          })
          $('#referenceID-field').fadeIn(500, function(){
            $(this).css('display', 'block')
            $('#referenceIDLabel').html('Certificate Code')
            $('#referenceID').val('').prop('disabled', false).attr('placeholder', 'Certificate Code')
          })
        })
        break;
      case 'corporate':
        $('#guests-field').fadeOut(500, function(){
          $(this).css('display', 'none')
          $('#total-field').fadeIn(500, function(){
            $(this).css('display', 'block')
          })
          $('#referenceID-field').fadeIn(500, function(){
            $(this).css('display', 'block')
            $('#referenceIDLabel').html('Account Number')
            $('#referenceID').val('').prop('disabled', false).attr('placeholder', 'Account Number')
          })
        })
        break;
      case 'discount':
        $('#guests-field').fadeOut(500, function(){
          $(this).css('display', 'none')
          $('#referenceID-field').fadeIn(500, function(){
            $(this).css('display', 'block')
            $('#referenceID').val('').prop('disabled', true)
          })
          $('#total-field').fadeIn(500, function(){
            $(this).css('display', 'block')
          })
          $('#notes-field').fadeIn(500, function(){
            $(this).css('display', 'block')
          })
        })
        break;
      case 'void':
        $('#guests-field').fadeOut(500, function(){
          $(this).css('display', 'none')
          $('#referenceID-field').val('').prop('disabled', true).fadeOut(500, function(){
            $(this).css('display', 'none')
          })
          $('#total-field').val('').prop('disabled', true).fadeOut(500, function(){
            $(this).css('display', 'none')
          })
          $('#notes-field').fadeOut(500, function(){
            $(this).css('display', 'none')
          })
        })
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
    products.map(function(product){
      if (product.id == selectedID)
        $('#total').val(product.price)
    })
  })
})
</script>
@endsection
