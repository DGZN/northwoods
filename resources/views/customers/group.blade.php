@extends('customers.layouts.master')

@section('title', 'North Woods Admin Dashboard')

@section('navbar')

@endsection

@section('content')
  <div class="col-md-6 col-md-offset-3">
    <div class="well">
      <div class="row">
        <div class="col-md-12">
          <form id="addGroupList" data-resource="customers" method="post">
            <h4 class="text-primary"> Welcome {{$customer['first_name']}} {{$customer['last_name']}}</h4>
            <div class="col-md-12">
              <h5>Enter the names of your guests</h5>
                <li class="list-group-item">
                  <h5>{{$customer['first_name']}} {{$customer['last_name']}}</h5>
                  <h6 class="text-primary">{{$customer['email']}}</h6>
                </li>
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
  $('#addGuest').on('click', function(){
    var name  = $('#name').val()
    var email = $('#email').val()
    console.log("I was clicked", 'with', name, email);
    $('<li class="list-group-item">       \
        <h5>'+name+'</h5>                         \
        <h6 class="text-primary">'+email+'</h6>    \
      </li>').insertBefore('#new-customer-item')
  })
  $("#addGroupList").on( "submit", function( event ) {
    event.preventDefault();
    var resource = this.getAttribute("data-resource")
    var params = {};
    $.each($(this).serializeArray(), function(_, key) {
      params[key.name] = key.value;
    });
    return console.log("Params", params);
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
})
</script>
@endsection
