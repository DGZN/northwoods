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
        <div class="col-md-5 col-md-offset-4">
            <div class="well well-lg">
              <form id="settings-form">
                <div class="row">
                  <div class="col-md-12">
                    <div class="col-md-12">
                      <div class="form-group">
                        <label for="exampleInputEmail1">City Tax Rate</label>
                        <input type="text" class="form-control" id="cityTaxRate" placeholder="Base tax rate %" value="{{$settings->city_tax}}%">
                      </div>
                    </div>
                    <div class="col-md-12">
                      <div class="form-group">
                        <label for="exampleInputEmail1">State Tax Rate</label>
                        <input type="text" class="form-control" id="stateTaxRate" placeholder="Sales tax rate %" value="{{$settings->state_tax}}%">
                      </div>
                    </div>
                    <div class="col-md-12">
                      <label for="terms" />Terms of Service</label>
                      <textarea rows="6" class="form-control" id="terms">{{$settings->terms}}</textarea>
                    </div>
                    <div class="col-md-12">
                      <label for="waiver" />Tour Waiver</label>
                      <textarea rows="6" class="form-control" id="waiver">{{$settings->waiver}}</textarea>
                    </div>
                    <div class="col-md-12">
                      </br>
                      <button type="submit" class="btn btn-primary  pull-right">Save Settings</button>
                    </div>
                  </div>
                </div>
            </form>
            </div>
        </div>
    </div>


@endsection

@section('scripts')
<script style="text/javascript">
$("#settings-form").on( "submit", function( event ) {
  event.preventDefault()
  $.ajax({
    url: url + '/api/v1/settings/1',
    type: 'post',
    data: {
      "city_tax":  $('#cityTaxRate').val()
    , "state_tax": $('#stateTaxRate').val()
    , "terms":     $('#terms').val()
    , "waiver":   $('#waiver').val()
    , _method: 'put'
    }
    , success: function(data){
      location.reload()
    }
  })
})
</script>
@endsection
