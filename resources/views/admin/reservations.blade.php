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
              <h4>Todays Reservation</h4>
              <span
                aria-hidden="true"
                onclick="addItem()"
                class="glyphicon glyphicon glyphicon-plus pull-right add-item">
              </span>
              <table class="table table-hover">
                  <thead>
                    <tr>
                      <th>Today's Resrvations {{Date('M d, Y')}}</th>
                      <th>Time</th>
                      <th style="text-align: center;">Guests</th>
                      <th>Cost</th>
                      <th>Primary Customer</th>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody>
                    @for ($i = 0; $i < count($today); $i++)
                      <tr id="{{ 'row'.$i }}" data-reservationID="{{$today[$i]->id}}">
                          <th scope="row"><a href="/admin/reservations/{{$today[$i]->id}}">
                            {{$today[$i]->date}}
                          </a></th>
                          <td>{{$today[$i]->time}}</td>
                          <td style="text-align: center;">
                            {{$today[$i]->guests}}
                          </td>
                          <td>${{$today[$i]->cost}}</td>
                          <td>
                            {{
                              $today[$i]['customer']['first_name'] . ' ' . $today[$i]['customer']['last_name']
                            }}
                          </td>
                          <td>
                          </td>
                      </tr>
                    @endfor
                  </tbody>
              </table>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="well well-lg">
              <h4>Upcoming Reservation</h4>
              <div class="input-group pull-right">
                <input type="text" class="form-control" id="reservationDate" name="reservationDate" value="{{Date('Y-m-d')}}" placeholder="Past/Future Date"/>
              </div>
              <span
                aria-hidden="true"
                onclick="addItem()"
                class="glyphicon glyphicon glyphicon-plus pull-right add-item">
              </span>
              <table class="table table-hover">
                  <thead>
                    <tr>
                      <th>Tomorrow's Resrvations </th>
                      <th>Time</th>
                      <th style="text-align: center;">Guests</th>
                      <th>Cost</th>
                      <th>Primary Customer</th>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody id="upcoming-reservations">
                    @for ($i = 0; $i < count($reservations); $i++)
                      <tr id="{{ 'row'.$i }}" data-reservationID="{{$reservations[$i]->id}}">
                          <th scope="row">
                            <a href="/admin/reservations/{{$reservations[$i]->id}}">
                              {{$reservations[$i]->date}}
                            </a>
                          </th>
                          <td>{{$reservations[$i]->time}}</td>
                          <td style="text-align: center;">
                            {{$reservations[$i]->guests}}
                          </td>
                          <td>${{$reservations[$i]->cost}}</td>
                          <td>
                            {{
                              $reservations[$i]['customer']['first_name'] . ' ' . $reservations[$i]['customer']['last_name']
                            }}
                          </td>
                          <td>
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
            <input type="hidden" name="employeeID" value="{{ Auth::user()->id }}" />
            <div class="modal-body">
              <div class="form-group col-md-6">
                <label for="time">Time</label>
                <select id="timeSelect" name="time" class="form-control">
                  <option disabled selected>-- Reservation Time --</option>
                @for ($i = 0; $i < count($times); $i++)
                  <option value="{{$times[$i]['name']}}">(Tier-{{ $times[$i]['tierID']}}) {{$times[$i]['name']}}</option>
                @endfor
                </select>
                <!-- <input type="text" class="form-control" id="timeInput" name="time" placeholder="Custom Time" style="display: none;"> -->
              </div>
              <div class="form-group col-md-6">
                <label for="guests">Guests</label>
                <input type="text" class="form-control" id="guests" name="guests" placeholder="Guests">
              </div>
              <div class="form-group col-md-6">
                <label for="cost">Cost </label>
                <div class="input-group">
                  <span class="input-group-addon">$</span>
                  <input type="number" class="form-control" id="cost" name="cost" placeholder="Cost" aria-label="Amount (to the nearest dollar)">
                  <span class="input-group-addon">.00</span>
                </div>
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
var unitPrice = 80;
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
  $('#timeSelect').change(function() {
    if($(this).val() == 'custom'){
      $('#timeSelect').fadeOut(500, function(){
        $(this).css('display', 'none')
        $('#timeInput').fadeIn(500, function(){
          $(this).css('display', 'block')
        })
      })
    }
  });
  var picker = new Pikaday({
    field: document.getElementById('reservationDate')
  , format: 'YYYY-MM-DD'
  })
  $('#reservationDate').change(function(){
    var date = $(this).val()
    $.ajax({
      url: url + '/api/v1/reservations/date/' + $(this).val(),
      type: 'get',
      success: function(data){
        populateReservations(data)
      }
    })
  })

  function populateReservations(data) {
    console.log(data);
    $('#upcoming-reservations').html('')
    data.forEach((reservation) => {
      console.log("reservation", reservation);
      var primry = reservation.customer;
      $('#upcoming-reservations').append('<tr>                        \
        <th scope="row">                                              \
          <a href="/admin/reservations/'+reservation.id+'">           \
            '+reservation.date+'                                      \
          </a>                                                        \
        </th>                                                         \
        <td>'+reservation.time+'</td>                                 \
        <td style="text-align: center;">'+reservation.guests+'</td>   \
        <td>'+reservation.cost+'</td>                                 \
        <td>'+primry.first_name + primry.last_name+'</td>             \
        <td></td>                                                     \
      </tr>')
    })
  }
})
</script>
@endsection
