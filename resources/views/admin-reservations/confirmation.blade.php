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
            <h4 class="text-primary"> Welcome</h4>
            <div class="col-md-12">
              <h5>You are paying for</h5>
              <div class="list-group">
                <li id="new-customer-item" class="list-group-item">
                </li>
              </div>
              <br/>
            </div>
            <div class="well">
              <div class="row">
                <div class="col-md-12">
                  <form id="addGroupList" data-resource="groups" method="post">
                    <div class="col-md-12">
                      <h5 class="pull-right">
                        Price:
                        <span class="text-success">${{$transaction['total']}}.00 </span>
                      </h5>
                    </div>
                    <div class="col-md-12">
                      <h5 class="pull-right">
                        Taxes:
                        <span class="text-success">${{$transaction['total'] / 10}}.00 </span>
                      </h5>
                    </div>
                    <div class="col-md-12">
                      <h4 class="pull-right">
                        Total:
                        <span class="text-success">${{$transaction['total'] + $transaction['total'] / 10}}.00 </span>
                      </h4>
                    </div>
                  </form>
                </div>
              </div>
            </div>
            <div class="well">
              <div class="row">
                <div class="col-md-12">
                  <form id="paymentForm" method="post">
                    <input type="hidden" id="transactionID" name="transactionID" value="{{$transaction['id']}}">
                    <input type="hidden" id="total" name="total" value="{{$transaction['total']}}">
                    <div class="form-group col-md-6">
                      <input type="text" class="form-control" id="first_name" name="first_name" placeholder="First Name" value="{{$customer['first_name']}}">
                    </div>
                    <div class="form-group col-md-6">
                      <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Last Name" value="{{$customer['last_name']}}">
                    </div>
                    <div class="form-group col-md-6">
                      <input type="text" class="form-control" id="phone" name="phone" placeholder="Phone">
                    </div>
                    <div class="form-group col-md-6">
                      <input type="text" class="form-control" id="email" name="email" placeholder="Email" value="{{$customer['email']}}">
                    </div>
                    <div class="form-group col-md-12">
                      <textarea id="address" class="form-control" name="address" rows="3"></textarea>
                    </div>
                    <div class="form-group col-md-6">
                      <input type="text" class="form-control" id="city" name="city" placeholder="City">
                    </div>
                    <div class="form-group col-md-6">
                      <input type="text" class="form-control" id="state" name="state" placeholder="State">
                    </div>
                    <div class="form-group col-md-6">
                      <input type="text" class="form-control" id="zip" name="zip" placeholder="Zip">
                    </div>
                    <div class="form-group col-md-6">
                      <input type="text" class="form-control" id="country" name="country" placeholder="Country">
                    </div>
                    <div class="form-group col-md-6">
                      <input type="text" class="form-control" id="card_number" name="card_number" value="4111111111111111">
                    </div>
                    <div class="form-group col-md-6">
                      <input type="text" class="form-control" id="exp_date" name="exp_date" value="2038-12">
                    </div>
                    <div class="form-group col-md-12">
                      <button type="submit" class="btn btn-success pull-right" data-dismiss="modal">Pay Now</button>
                    </div>

                  </form>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  <div class="payment modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
      <div class="modal-dialog modal-sm">
        <div class="modal-content">
          <h5 class="text-primary text-center"> Processing your transaction... </h5>
        </div>
      </div>
    </div>
@endsection

@section('scripts')
<script>
var primary  = {!! $customer !!}
var transaction  = {!! $transaction !!}
var group  = {!! $group->pivot !!}
$(document).ready(function(){
  var guests = []
  group.map((pivot) => {
    guests.push({
        name: pivot.customer.first_name + ' ' + pivot.customer.last_name
     ,  email: pivot.customer.email
    })
    $('<a class="list-group-item">                                            \
        <div class="input-group">                                             \
          <span class="input-group">                                          \
            <h5>'+pivot.customer.first_name + ' ' + pivot.customer.last_name + '</h5>        \
            <h6 class="text-primary">'+pivot.customer.email+'</h6>                  \
          </span>                                                             \
        </div>                                                                \
      </a>').insertBefore('#new-customer-item')
  })


  $("#paymentForm").on( "submit", function( event ) {
    event.preventDefault();
    $('.bs-example-modal-sm').modal({backdrop: 'static', keyboard: false})
    var params = {};
    $.each($(this).serializeArray(), function(_, kv) {
      params[kv.name] = kv.value;
    });
    var card_number = $('#card_number').val()
    var exp_date = $('#exp_date').val()
    $.ajax({
      url: url + '/api/v1/customers/' + group[0].customerID,
      type: 'put',
      data:  params,
      success: function(data){
        if (data.status && data.status == 1)
          window.location.href = transaction.id + '/success'
        if (data[0].error) {
          var fields = data[0].error
          for (field in fields) {
            var _field = $('#'+field)
            var message = fields[field].toString()
            _field.parent().addClass('has-error')
            _field.prop('placeholder', message)
          }
          $('.bs-example-modal-sm').modal('hide')
        }
      }
    })
  });
})
</script>
@endsection
