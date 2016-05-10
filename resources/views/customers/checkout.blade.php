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
            <div class="col-md-12">
              <h5>Select the guests you would like to pay for</h5>
              <div class="list-group">
                <li id="new-customer-item" class="list-group-item">
                </li>
              </div>
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
const UUID  = '{!! $uuid !!}'
var primary  = {!! $customer !!}
var reservation  = {!! $group['reservation'] !!}
var groupID = {!! $group['id'] !!}
var group  = {!! $group->pivot !!}
var guests = [{
  id: primary.id
, name: primary.first_name + ' ' + primary.last_name
, email: primary.email
}]
$(document).ready(function(){

  group.map((data, i) => {
    if (data.customer.status == 1)
        return;
    var customer = data.customer
    guests.push({
       id: customer.id
     , name: customer.first_name + ' ' + customer.last_name
     , email: customer.email
     , status: customer.status
    })
    var disabled = ''
    if (i == 0) {
        disabled = ' checked disabled'
    }
    $('<a class="list-group-item">                                                                                        \
        <div class="input-group">                                                                                         \
          <span class="input-group">                                                                                      \
            <input type="checkbox" aria-label="..." class="customer-check" data-id="' + customer.id + '" '+disabled+'>    \
            <h5>'+customer.first_name + ' ' + customer.last_name+'</h5>                                                   \
            <h6 class="text-primary">'+customer.email+'</h6>                                                              \
          </span>                                                                                                         \
        </div>                                                                                                            \
      </a>').insertBefore('#new-customer-item')
  })
  $("#addGroupList").on( "submit", function( event ) {
    event.preventDefault();
    var payingGuests = [];
    $('.customer-check').each((i, checkbox) => {
      if ($(checkbox).prop("checked")) {
        var id = $(checkbox).data('id')
        var name = $(checkbox).next().text()
        var email = $(checkbox).next().next().text()
        payingGuests.push({
          id: id
        , name: name
        , email: email
        })
      }
    })
    $.ajax({
      url: url + '/api/v1/transactions',
      type: 'POST',
      data:  {
        "groupID": groupID,
        "productID": 1,
        "employeeID": 0,
        "reservationID": reservation.id,
        "customerID": guests[0].id,
        "total": 80 * payingGuests.length,
        "notes": JSON.stringify(payingGuests)
      },
      success: function(data){
        window.location.href = 'checkout/' + data.id
      }
    })
  });
})
</script>
@endsection
