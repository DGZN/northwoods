@extends('customers.layouts.master')

@section('title', 'North Woods Admin Dashboard')

@section('navbar')

@endsection

@section('content')
  <div class="col-md-6 col-md-offset-3">
    <div class="well">
      <div class="row">
        <div class="col-md-12">
          <form id="addGroupList" data-resource="groups" method="post">
            <h4 class="text-primary"> Welcome {{$customer['first_name']}} {{$customer['last_name']}}</h4>
            <div class="col-md-12">
              <h5>Enter the names of guests that will be going on the tour.</h5>
              <ul>
                <li id="new-customer-item" class="list-group-item">
                    <div class="col-md-5">
                      <input type="text" class="form-control" name="name" id="name" placeholder="Full Name">
                    </div>
                    <div class="col-md-5">
                      <input type="email" class="form-control" name="email" id="email" placeholder="Email">
                    </div>
                    <div class="col-md-2">
                      <button id="addGuest" type="button" class="btn btn-success pull-right">Add</button>
                    </div>
                    <br/><br/>
                </li>
              </ul>
              <br/>
            </div>
            <div class="form-group col-md-12">
              <button type="submit" class="btn btn-primary pull-right">Next</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('scripts')
<script>
const UUID      = "{!! $uuid !!}"
var primary     = {!! $customer !!}
var groupID     = {!! $group['id'] !!}
var group       = {!! $group->pivot !!}
var tourDate    = '{!! $group['date'] !!}'
var tourTimeID  = {!! $group['tourTimeID'] !!}
var guests = []
var cost = {!! $group->type->cost !!}
var numGuests = {!! $group->numGuests !!}
$(document).ready(function(){

  group.map((data, i) => {
    if (i == 0) return;
    var customer = data.customer
    guests.push({
        name: customer.first_name + ' ' + customer.last_name
     ,  email: customer.email
    })
    $('<li class="list-group-item">       \
        <h5>'+customer.first_name + ' ' + customer.last_name+'</h5>                         \
        <h6 class="text-primary">'+customer.email+'</h6>    \
      </li>').insertBefore('#new-customer-item')
  })


  $('#addGuest').on('click', function(){
    if (guests.length >= numGuests)
      return;
    var name  = $('#name').val()
    var email = $('#email').val()
    $('<li class="list-group-item">       \
        <h5>'+name+'</h5>                         \
        <h6 class="text-primary">'+email+'</h6>    \
      </li>').insertBefore('#new-customer-item')
    guests.push({
      name: name
    , email: email
    })
    $('#name').val('')
    $('#email').val('')
    $.ajax({
      url: url + '/api/v1/groups/' + UUID,
      type: 'PUT',
      data:  {
          "full_name": name
        , "email": email
      },
      success: function(data){
        if (guests.length == numGuests) {
          $('#name').prop('disabled', true)
          $('#email').prop('disabled', true)
          $('#addGuest').prop('disabled', true)
        }
      }
    })
  })
  $("#addGroupList").on( "submit", function( event ) {
    event.preventDefault();
    $.ajax({
      url: url + '/api/v1/reservations',
      type: 'POST',
      data:  {
          "guests": guests.length
        , "cost": cost * guests.length
        , "primaryGuestID": primary.id
        , "groupID": groupID
        , "tourTimeID": tourTimeID
        , "date": tourDate
      },
      success: function(data){
        window.location.href = '/order/reservations/' + UUID + '/checkout'
      }
    })
  });
})
</script>
@endsection
