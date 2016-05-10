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
        <div class="col-md-6  col-md-offset-3">
            <div class="well well-lg">
              <div class="row">
                <div class="col-md-12">
                  <div class="row">
                    <div class="col-md-4">
                      <h5>
                        Primary Guest
                      </h5>
                      <span class="text-primary"> {{$reservation->customer->first_name . ' ' . $reservation->customer->last_name}} </span>
                    </div>
                    <div class="col-md-4">
                      <h5>
                        Date
                      </h5>
                      <span class="text-primary"> {{$reservation->schedule->date}} </span>
                    </div>
                    <div class="col-md-4">
                      <h5>
                        Time
                      </h5>
                      <span class="text-primary"> {{$reservation->schedule->time->name}} </span>
                    </div>
                    <div class="col-md-12">
                    </br>
                    </div>
                    <div class="col-md-4">
                      <span> {{$reservation->customer->email}} </span>
                    </div>
                    <div class="col-md-4">
                      <span> {{$reservation->customer->phone}} </span>
                    </div>
                    <div class="col-md-4">
                      <span> {{$reservation->customer->address}} </span>
                    </div>
                    <div class="col-md-12">
                      <h5>
                        Tour Group
                      </h5>
                      <ul class="list-group" id="tour-group">
                        @for ($i = 0; $i < count($reservation->group->pivot); $i++)
                          <li class="list-group-item">
                            <h6 class="text-primary">{{$reservation->group->pivot[$i]->customer->first_name . ' ' . $reservation->group->pivot[$i]->customer->last_name}}</h6>
                            <h6>{{$reservation->group->pivot[$i]->customer->email}} </h6>
                          </li>
                        @endfor
                      </ul>
                    </div>
                    <div class="col-md-12">

                    </div>
                    <div class="col-md-12">

                    </div>
                  </div>
                </div>
              </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script style="text/javascript">
var tourGroup = []
var group = {!! $reservation['group']['group'] !!}
for(i in group) {
  var paid   = '<span class="text-danger glyphicon glyphicon-remove pull-right"></span>'
  var agreed = '<span class="text-danger glyphicon glyphicon-remove pull-right"></span>'
  if (group[i].customer.status == 1 ) {
    paid = '<span class="text-success glyphicon glyphicon-ok pull-right"></span>'
  }
  if (group[i].customer.waiverStatus == 1 ) {
    greed = '<span class="text-success glyphicon glyphicon-ok pull-right"></span>'
  }
  $('<li class="list-group-item" style="font-weight: bold;">' + group[i].customer.first_name + ' ' + group[i].customer.last_name + ' ' + paid + ' ' + agreed + '<br> <span class="text-primary" style="font-weight: 200;">' + group[i].customer.email + ' </span> </li>').appendTo('#tour-group');
  tourGroup.push(group[i])
}
console.log("tourGroup", tourGroup);
</script>
@endsection
