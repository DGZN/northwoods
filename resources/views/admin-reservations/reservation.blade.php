@extends('customers.layouts.master')

@section('title', 'North Woods Admin Dashboard')

@section('navbar')

@endsection

@section('content')
  <div class="row">

    <div class="col-md-6 col-md-offset-3">
      <div class="well">
        <ol class="breadcrumb">
            <li><a href="/admin/reservations">Reservations</a></li>
            <li class="active">New Reservation</li>
        </ol>
        <div class="row">
          <div class="col-md-12">
            <form id="addGroup" data-resource="groups" method="post">
              <div class="form-group col-md-12">
                <select class="form-control" id="tourTypeID" name="tourTypeID">
                    <option selected disabled>-- Select Tour Type --</option>
                    @for ($i = 0; $i < count($types); $i++)
                      <option value="{{$types[$i]['id']}}" data-cost="{{$types[$i]['cost']}}">{{$types[$i]['name']}}</option>
                    @endfor
                </select>
              </div>
              <div class="form-group col-md-6">
                <input type="text" class="form-control" name="first_name" id="first_name" placeholder="Primary First name">
              </div>
              <div class="form-group col-md-6">
                <input type="text" class="form-control" name="last_name" id="last_name" placeholder="Primary Last name">
              </div>
              <div class="form-group col-md-12">
                <input type="email" class="form-control" name="email" id="email" placeholder="Primary Email">
              </div>
              <div class="form-group col-md-6">
                <input type="number" class="form-control" name="phone" id="phone" placeholder="Primary Phone">
              </div>
              <div class="form-group col-md-6">
                <select class="form-control" id="num-guests" name="num-guests">
                    <option selected disabled>-- Select number of guests --</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                    <option value="6">6</option>
                    <option value="7">7</option>
                    <option value="8">8</option>
                </select>
              </div>
              <div class="form-group col-md-6">
                <input type="text" class="form-control" name="date" id="datepicker" placeholder="Date">
              </div>
              <div class="form-group col-md-6">
                <select class="form-control" id="tour-time"  disabled="disabled">
                  <option selected="" disabled id="tour-time-placeholder">-- Tour Time --</option>
                </select>
              </div>
              <div class="form-group col-md-12">
                <button type="submit" class="btn btn-primary pull-right">Submit</button>
              </div>
            </form>
          </div>
        </div>
      </div>
      <div class="well">
        <div class="row">
          <div class="col-md-12">
            <form id="addGroupList" data-resource="groups" method="post">
              <div class="col-md-12">
                <h5 class="pull-right">
                  Price:
                  <span class="text-success" id="price">$0.00 </span>
                </h5>
              </div>
              <div class="col-md-12">
                <h5 class="pull-right">
                  Taxes:
                  <span class="text-success" id="taxes">$0.00 </span>
                </h5>
              </div>
              <div class="col-md-12">
                <h4 class="pull-right">
                  Total:
                  <span class="text-success" id="grand-total">$0.00 </span>
                </h4>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>

@endsection

@section('scripts')
<script>
const saleTax = {!! $settings->state_tax !!}
var tiers = [];
var availableTimes = [];
var tourDate = '';
$(document).ready(function(){

  var picker = new Pikaday({
    field: document.getElementById('datepicker')
  , minDate: moment().add('days', 1).toDate()
  , format: 'YYYY-MM-DD'
  , onSelect: function(date) {
     var date = this.getMoment().format('YYYY-MM-DD')
     $('#datepicker').val(date)
     $('#tour-time').prop('disabled', false)
     getTourTimes(date)
    }
  });

  $('#num-guests').on('change', function(){
    tourDate =  $('#datepicker').val();
    groupSize = $('#num-guests').val()
    var cost = $('#tourTypeID').find(':selected').data('cost')
    $('#tour-time').prop('disabled', false)
    calculateTourCost(cost, groupSize)
    getTourTimes(tourDate)
  })

  $("#addGroup").on( "submit", function( event ) {
    event.preventDefault();
    var resource = this.getAttribute("data-resource")
    var params = {};
    $.each($(this).serializeArray(), function(_, kv) {
      params[kv.name] = kv.value;
    });
    params['tourTimeID'] = $( "#tour-time option:selected" ).data('timeid');
    params['date'] = tourDate;
    params['numGuests'] = $('#num-guests').val();
    $.ajax({
      url: url + '/api/v1/' + resource,
      type: 'post',
      data:  params,
      success: function(data){
        window.location.href = '/admin/new/reservations/' + data.uuid
      },
      error: function(data){
        var fields = data.responseJSON
        for (field in fields) {
          var _field = $('#'+field)
          var message = fields[field].toString().replace('i d', 'ID')
          _field.parent().addClass('has-error')
          _field.prop('placeholder', message)
        }
      }
    })
  });

  function isNumberKey(evt){
      var charCode = (evt.which) ? evt.which : event.keyCode
      if (charCode > 31 && (charCode < 48 || charCode > 57))
          return false;
      return true;
  }

  function calculateTourCost(cost, guests) {
    var price = (parseInt(cost) * parseInt(guests));
    var tax = (parseInt(price) * saleTax / 100);
    var total = price + tax;
    $('#price').html('$'+parseFloat(price).toFixed(2))
    $('#taxes').html('$'+parseFloat(tax).toFixed(2))
    $('#grand-total').html('$'+parseFloat(total).toFixed(2))
  }

  function getTourTimes(date) {
    if ( ! date.length )
      return;
    tourDate = date;
    $.ajax({
      url: url + '/api/v1/tour-times/schedule',
      type: 'get',
      data:  {
        date: date
      , groupSize: $('#num-guests').val()
      },
      success: function(data){
        setTimeSlots(data)
      },
      error: function(data){
        var fields = data.responseJSON
        for (field in fields) {
          var _field = $('#'+field)
          var message = fields[field].toString().replace('i d', 'ID')
          _field.parent().addClass('has-error')
          _field.prop('placeholder', message)
        }
      }
    })
  }

  function setTimeSlots(times) {
    tiers = [];
    times.map((time) => {
      if ( ! tiers[time.tierID])
         tiers[time.tierID] = []
      tiers[time.tierID].push(time)
    })
    times = tiers.map((tier) => {
      return tier[0]
    })
    $('#tour-time').html(' ')
    for (var time in times) {
      $('<option data-timeID="' + times[time].id + '" data-tierID="' + times[time].tierID + '">' + times[time].name + '</option>').appendTo('#tour-time')
    }
  }

})

</script>
@endsection
