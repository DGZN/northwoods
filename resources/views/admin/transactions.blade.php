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
                          <td>{{$transactions[$i]->created_at}}</td>
                          <td>${{$transactions[$i]->total}}</td>
                          <td>{{$transactions[$i]->employee->name . ' '.  $transactions[$i]->employee->last_name}}</td>
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

</script>
@endsection
