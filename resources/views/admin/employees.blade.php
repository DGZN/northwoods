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
              <table class="table table-hover">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Name</th>
                      <th>Email</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    @for ($i = 0; $i < count($employees); $i++)
                      <tr id="{{ 'row'.$i }}">
                          <th scope="row">{{$i}}</th>
                          <td>{{$employees[$i]->name}}</td>
                          <td>{{$employees[$i]->email}}</td>
                          <td>
                              <i class="remove-icon"
                                 onclick="removeItem(this)"
                                 data-row="{{'row'.$i}}"
                                 data-id="{{$employees[$i]->id}}"
                                 data-resource="employees"></i>
                          </td>
                      </tr>
                    @endfor
                  </tbody>
              </table>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script style="text/javascript">
function removeItem(item){
  var id = item.getAttribute("data-id")
  var row = item.getAttribute("data-row")
  var resource = item.getAttribute("data-resource")
  $.ajax({
    url: url + '/api/v1/' + resource + '/' + id,
    type: 'post',
    data: {_method: 'delete'},
    success: function(data){
      console.log("Success DAta", data);
      $('#'+row).remove()
    }
  })
}
</script>
@endsection
