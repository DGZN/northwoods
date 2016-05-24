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
                      <th>Name</th>
                      <th>Email</th>
                      <th>Phone</th>
                      <th>Role</th>
                    </tr>
                  </thead>
                  <tbody>
                    @for ($i = 0; $i < count($employees); $i++)
                      <tr id="{{ 'row'.$i }}">
                          <td>
                              <a href="employees/{{$employees[$i]->id}}">
                                  {{$employees[$i]->name}} {{$employees[$i]->last_name}}
                              </a>
                          </td>
                          <td>{{$employees[$i]->email}}</td>
                          <td>{{$employees[$i]->phone}}</td>
                          <td>{{$employees[$i]->role}}</td>
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
                <h4 class="modal-title" id="myModalLabel">Add New Employee</h4>
              </div>
              <form id="addItemForm" data-resource="employees">
                <div class="modal-body">
                  <div class="form-group col-md-6">
                    <label for="name">First Name</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="First name">
                  </div>
                  <div class="form-group col-md-6">
                    <label for="last_name">Last Name</label>
                    <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Last name">
                  </div>
                  <div class="form-group col-md-6">
                    <label for="role">Role</label>
                    <select id="role" name="role" class="form-control">
                      <option value="Employee">Employee</option>
                      <option value="Manager">Manager</option>
                      <option value="Administrator">Administrator</option>
                    </select>
                  </div>
                  <div class="form-group col-md-6">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Email">
                  </div>
                  <div class="form-group col-md-6">
                    <label for="phone">Phone</label>
                    <input type="phone" class="form-control" id="phone" name="phone" placeholder="Phone">
                  </div>
                  <div class="form-group col-md-6">
                      <label for="pin">PIN</label>
                      <input type="password" class="form-control" id="pin" name="pin" placeholder="PIN">
                  </div>
                  <div class="form-group col-md-6">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Password">
                  </div>
                  <div class="form-group col-md-6">
                    <label for="offsiteAccess">Allow Offsite Access?</label>
                    <input type="checkbox" class="form-control" id="offsiteAccess" name="offsiteAccess" >
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
