@extends('customers.layouts.master')

@section('title', 'North Woods Admin Dashboard')

@section('navbar')

@endsection

@section('content')
  <div class="col-md-6 col-md-offset-3">
    <div class="well">
      <div class="row">
        <div class="col-md-12">
          <form id="addGroup" data-resource="customers" method="post">
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
              <input type="number" class="form-control" name="num-guests" id="num-guests" placeholder="Number of guests">
            </div>
            <div class="form-group col-md-6">
              <input type="text" class="form-control" name="phone" id="datepicker" placeholder="Date">
            </div>
            <div class="form-group col-md-6">
              <select class="form-control" id="tour-time">
                <option selected="" disabled>-- Tour Time --</option>
                <option> 8:00AM - 11:00AM</option>
                <option>11:30AM - 2:30PM</option>
                <option> 3:00PM -  6:00PM</option>
                <option disabled>-- Secondary Times --</option>
                <option> 9:30AM - 12:30PM</option>
                <option> 1:00PM -  4:00PM</option>
                <option disabled>-- Additional Times --</option>
                <option> 8:45AM - 11:45AM</option>
                <option>12:15AM - 3:15PM</option>
                <option> 3:45PM -  6:45PM</option>
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
$(document).ready(function(){
  var picker = new Pikaday({
    field: document.getElementById('datepicker')
  , onSelect: function(date) {
     console.log("data", picker.toString());
     $('#datepicker').val(picker.toString())
    }
  });
})
$("#addGroup").on( "submit", function( event ) {
  event.preventDefault();
  var resource = this.getAttribute("data-resource")
  var params = {};
  $.each($(this).serializeArray(), function(_, kv) {
    params[kv.name] = kv.value;
  });
  $.ajax({
    url: url + '/api/v1/' + resource,
    type: 'post',
    data:  params,
    success: function(data){
      window.location.href = 'reservations/group/' + data.id
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
</script>
@endsection
