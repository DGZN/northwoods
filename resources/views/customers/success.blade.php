@extends('customers.layouts.master')

@section('title', 'North Woods Admin Dashboard')

@section('navbar')

@endsection

@section('content')
  <div class="col-md-6 col-md-offset-3">
    <div class="well">
      <div class="row">
        <div class="col-md-12">
          <div class="well">
            <div class="row">
              <div class="col-md-12">
                <h5 class="text-success text-center">Congratulations!</h5>
                <span class="text-medium">
                  Your reservation has been confirmed and an order confirmation has been sent to you. <br>
                  Please share the following link with any members of your tour who have not already paid.
                </span>
                <h4>
                  <a id="waiver-link" target="_blank" href="/order/reservations/{{$uuid}}/waiver/">Tour Waiver Confirmation</a>
                </h4>
                <h5>
                  <a target="_blank" href="http://localhost:8000/order/reservations/{{$uuid}}/checkout">Reservation Confirmation</a>
                </h5>
                <h6>Note: A copy of this link will be sent to all members of your tour</h6>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('scripts')
<script>
const UUID  = "{!! $uuid !!}"
var transaction  = {!! $transaction !!}
$(document).ready(function(){
  var customerID = JSON.parse(transaction.notes)[0].id
  var link = $('#waiver-link').attr('href') + customerID
  $('#waiver-link').attr('href', link)
  console.log("set link to", link);
})
</script>
@endsection
