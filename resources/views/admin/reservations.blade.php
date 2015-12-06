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
                      <th>Time</th>
                      <th>Guests</th>
                      <th>Costs</th>
                      <th>Primary Guest ID</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    @for ($i = 0; $i < count($reservations); $i++)
                      <tr id="{{ 'row'.$i }}">
                          <th scope="row">{{$reservations[$i]->id}}</th>
                          <td>{{$reservations[$i]->time}}</td>
                          <td>{{$reservations[$i]->guests}}</td>
                          <td>{{$reservations[$i]->cost}}</td>
                          <td>{{$reservations[$i]->primaryGuestID}}</td>
                          <td>
                              <i class="remove-icon"
                                 onclick="removeItem(this)"
                                 data-row="{{'row'.$i}}"
                                 data-id="{{$reservations[$i]->id}}"
                                 data-resource="reservations"></i>
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
            <h4 class="modal-title" id="myModalLabel">Add New Reservation</h4>
          </div>
          <form id="addItemForm" data-resource="reservations">
            <input type="hidden" name="productID" value="1" />
            <div class="modal-body">
              <div class="form-group col-md-6">
                <label for="time">Time</label>
                <input type="text" class="form-control" id="time" name="time" placeholder="Time">
              </div>
              <div class="form-group col-md-6">
                <label for="guests">Guests</label>
                <input type="text" class="form-control" id="guests" name="guests" placeholder="Guests">
              </div>
              <div class="form-group col-md-6">
                <label for="cost">Cost</label>
                <input type="cost" class="form-control" id="cost" name="cost" placeholder="Cost">
              </div>
              <div class="form-group col-md-6">
                <label for="primaryGuestID">Primary Guest</label>
                <input type="primaryGuestID" class="form-control" id="primaryGuestID" name="primaryGuestID" data-provide="typeahead" placeholder="Primary Guest">
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
var customers = {!! $customers !!}.map(function(customer){
  return {
    id: customer.id
  , name: customer.first_name + ' ' + customer.last_name
  }
})
$(function(){
  $("#primaryGuestID").typeahead({ source: customers, autoSelect: true });
  var $input = $("#primaryGuestID");
  $input.change(function() {
    var current = $input.typeahead("getActive");
    $input.val(current.id)
  });
})
</script>
@endsection
