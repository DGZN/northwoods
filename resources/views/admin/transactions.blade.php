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
                <li><a href="/admin/logout">Logout</a></li>
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
              <table class="table table-hover">
                  <thead>
                    <tr>
                      <th>Transaction #</th>
                      <th>Time</th>
                      <th>Amount</th>
                      <th>Employee</th>
                    </tr>
                  </thead>
                  <tbody>
                    @for ($i = 0; $i < count($transactions); $i++)
                      <tr id="{{ 'row'.$i }}" class="bg-success">
                          <td scope="row">{{$transactions[$i]->transactionID}}</td>
                          <td>{{$transactions[$i]['created_at']}}</td>
                          <td>${{number_format($transactions[$i]['total'], 2)}}</td>
                          <td>{{$transactions[$i]['employee']['name']}}</td>
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
          <form id="addItemForm" data-resource="transactions">
            <input type="hidden" name="employeeID" value="{{ Auth::user()->id }}" />
            <div class="modal-body">
              <div class="form-group col-md-6">
                <label for="productID">Transaction Type</label>
                <select name="type" id="type" class="form-control">
        					<option selected disabled>-- Transaction Type --</option>
                  <option value="card-on-file">Card on File</option>
        					<option value="cash">Cash</option>
        					<option value="check">Check</option>
        					<option value="certificate">Gift Certificate</option>
        					<option value="corporate">Corporate Account</option>
        					<option value="discount">Discount</option>
        					<option value="void">Void</option>
        				</select>
              </div>
              <div class="form-group col-md-6">
                <label for="productID">Sale Recipient</label>
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
                  <label for="reservationID">Reservation Primary</label>
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

</script>
@endsection
