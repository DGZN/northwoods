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
              <span
                aria-hidden="true"
                onclick="addItem()"
                class="glyphicon glyphicon glyphicon-plus pull-right add-item">
              </span>
              <table class="table table-hover">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Tier</th>
                      <th>Time</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    @for ($i = 0; $i < count($times); $i++)
                      <tr id="{{ 'row'.$i }}">
                          <th scope="row">{{$times[$i]->id}}</th>
                          <td>{{$times[$i]->tier['name']}}</td>
                          <td>{{$times[$i]->name}}</td>
                          <td>
                              <i class="remove-icon"
                                 onclick="removeItem(this)"
                                 data-row="{{'row'.$i}}"
                                 data-id="{{$times[$i]->id}}"
                                 data-resource="tour-times"></i>
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
            <h4 class="modal-title" id="myModalLabel">Add New Tour Time</h4>
          </div>
          <form id="addItemForm" data-resource="tour-times">
            <input type="hidden" name="employeeID" value="{{ Auth::user()->id }}" />
            <div class="modal-body">
              <div class="form-group col-md-6">
                <label for="cost">Start Time </label>
                <div class="form-group">
                  <input type="text" class="form-control" name="start-time" aria-label="...">
                </div>
              </div>
              <div class="form-group col-md-6">
                <label for="cost">End Time </label>
                <div class="form-group">
                  <input type="text" class="form-control" name="end-time" aria-label="...">
                </div>
              </div>
              <div class="form-group col-md-6">
                <label for="time">Time Tier</label>
                <select name="tierID" class="form-control">
                  <option value="1">Morning</option>
                  <option value="2">Mid-day</option>
                  <option value="3">Afternoon</option>
                  <option value="4">Admin Tier</option>
                </select>
              </div>
              <div class="form-group col-md-2 col-md-offset-4">
                <br/>
                <button type="submit" class="btn btn-primary">Create</button>
              </div>
            </div>
            <div class="modal-footer">
            </div>
          </form>
        </div>
      </div>
    </div>

@endsection

@section('scripts')
<script style="text/javascript">
var unitPrice = 80;
var times = {!! $times !!};
</script>
@endsection
