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
                      <th>Employee ID</th>
                      <th>Reservation ID</th>
                      <th>Guests</th>
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
                          <td>{{$transactions[$i]->employeeID}}</td>
                          <td>{{$transactions[$i]->reservationID}}</td>
                          <td>{{$transactions[$i]->guests}}</td>
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
                <label for="productID">Product ID</label>
                <input type="text" class="form-control" id="productID" name="productID" placeholder="Product ID">
              </div>
              <div class="form-group col-md-6">
                <label for="reservationID">Reservation ID</label>
                <input type="reservationID" class="form-control" id="reservationID" name="cost" placeholder="Reservation ID">
              </div>
              <div class="form-group col-md-6">
                <label for="guests">Guests</label>
                <input type="guests" class="form-control" id="guests" name="primaryGuestID" placeholder="Guests">
              </div>
              <div class="form-group col-md-6">
                <label for="total">Total</label>
                <input type="total" class="form-control" id="total" name="primaryGuestID" placeholder="Total">
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
