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
                      <th>ID</th>
                      <th>First Name</th>
                      <th>Last Name</th>
                      <th>Phone</th>
                      <th>Email</th>
                      <th>Address</th>
                      <th>City</th>
                      <th>State</th>
                      <th>Zip</th>
                      <th>Country</th>
                      <th>Profile ID</th>
                      <th>PaymentID</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    @for ($i = 0; $i < count($customers); $i++)
                      <tr id="{{ 'row'.$i }}">
                          <th scope="row">{{$customers[$i]->id}}</th>
                          <td>{{$customers[$i]->first_name}}</td>
                          <td>{{$customers[$i]->last_name}}</td>
                          <td>{{$customers[$i]->phone}}</td>
                          <td>{{$customers[$i]->email}}</td>
                          <td>{{$customers[$i]->address}}</td>
                          <td>{{$customers[$i]->city}}</td>
                          <td>{{$customers[$i]->state}}</td>
                          <td>{{$customers[$i]->zip}}</td>
                          <td>{{$customers[$i]->country}}</td>
                          <td>{{$customers[$i]->profileID}}</td>
                          <td>{{$customers[$i]->paymentID}}</td>
                          <td>
                              <i class="remove-icon"
                                 onclick="removeItem(this)"
                                 data-row="{{'row'.$i}}"
                                 data-id="{{$customers[$i]->id}}"
                                 data-resource="customers"></i>
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
            <h4 class="modal-title" id="myModalLabel">Add New Customer</h4>
          </div>
          <form id="addItemForm" data-resource="customers">
            <div class="modal-body">
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
