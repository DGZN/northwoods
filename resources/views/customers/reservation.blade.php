@extends('customers.layouts.master')

@section('title', 'North Woods Admin Dashboard')

@section('navbar')

@endsection

@section('content')
  <div class="col-md-6 col-md-offset-3">
    <div class="well">
      <div class="row">
        <div class="col-md-12">
          <form id="addGroup" data-resource="groups" method="post">
            <div class="form-group col-md-12">
              <select class="form-control" id="tourTypeID" name="tourTypeID">
                  <option selected disabled>-- Select Tour Type --</option>
                  @for ($i = 0; $i < count($types); $i++)
                    <option value="{{$types[$i]['id']}}">{{$types[$i]['name']}}</option>
                  @endfor
              </select>
            </div>
            <div class="form-group col-md-6">
              <input type="text" class="form-control" name="first_name" id="first_name" placeholder="First name">
            </div>
            <div class="form-group col-md-6">
              <input type="text" class="form-control" name="last_name" id="last_name" placeholder="Last name">
            </div>
            <div class="form-group col-md-12">
              <input type="email" class="form-control" name="email" id="email" placeholder="Email">
            </div>
            <div class="form-group col-md-6">
              <input type="number" class="form-control" name="phone" id="phone" placeholder="Phone">
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
  </div>
@endsection

@section('scripts')
<script>
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
    groupSize = $('#num-guests').val();
    $('#tour-time').prop('disabled', false)
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
        window.location.href = '/order/reservations/' + data.uuid
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
