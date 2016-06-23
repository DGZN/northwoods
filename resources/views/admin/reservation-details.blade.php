@extends('admin.layouts.master')

@section('title', 'North Woods Admin Dashboard')

@section('navbar')
@endsection

@section('content')
    <style>
    .reservation-status-icons {
      position: absolute;;
      top: 20px;
      right: 20px;
      float: right;
    }
    .reservation-status-icon {
      position: relative;
      font-size: 2rem;
      color: green;
      font-weight: bold;
    }

    .faded {
      opacity: 0.2;
      color: black;
    }
    </style>
    <div class="row">
        <div class="col-md-6  col-md-offset-3">
            <div class="well well-lg">
              <div class="row">
                <div class="col-md-12">
                  <div class="row">
                    <div class="col-md-6">
                      <h5>
                        Date
                      </h5>
                      <span class="text-primary"> {{$reservation->schedule->date}} </span>
                    </div>
                    <div class="col-md-6">
                      <h5>
                        Time
                      </h5>
                      <select class="form-control" id="tourTimeID" name="tourTimeID">
                        <option selected disabled>-- Select Tour Type --</option>
                        @for ($i = 0; $i < count($times); $i++)
                        <option value="{{$times[$i]['id']}}">{{$times[$i]['name']}} - {{$times[$i]['capacity']}} slots remaining</option>
                        @endfor
                      </select>
                    </div>
                  </div>
                  <div class="row">
                    <br>
                    <div class="col-md-6">
                      <h5>
                        Primary Contact
                      </h5>
                      <span class="text-primary">
                          {{$reservation->customer->first_name . ' ' . $reservation->customer->last_name}}
                      </span>
                      <h6> {{$reservation->customer->phone}} </h6>
                      <span> {{$reservation->customer->email}} </span>
                    </div>
                    <div class="col-md-6">
                      <span> {{$reservation->customer->address}} </span>
                    </div>
                    <div class="col-md-12">
                      <br>
                      <h5>
                        Tour Group
                      </h5>
                      <ul class="list-group" id="tour-group">
                        @for ($i = 0; $i < count($reservation->group->pivot); $i++)
                          <li class="list-group-item">
                            <h6 class="text-primary">
                              <a href="/order/reservations/{{$reservation->group->uuid}}/checkout/{{$reservation->transaction->id}}" target="_blank">
                                {{$reservation->group->pivot[$i]->customer->first_name . ' ' . $reservation->group->pivot[$i]->customer->last_name}}
                              </a>
                            </h6>
                            <h6>{{$reservation->group->pivot[$i]->customer->email}} </h6>
                            <div class="reservation-status-icons">
                              @if ($reservation->group->pivot[$i]->status == 1)
                                <span class="reservation-status-icon">$</span>
                              @else
                                <span class="reservation-status-icon faded">$</span>
                              @endif
                              @if ($reservation->group->pivot[$i]->termsStatus == 1)
                                <span class="reservation-status-icon">T</span>
                              @else
                                  <span class="reservation-status-icon faded">T</span>
                              @endif
                              @if ($reservation->group->pivot[$i]->waiverStatus == 1)
                                <span class="reservation-status-icon">W</span>
                              @else
                                  <span class="reservation-status-icon faded">W</span>
                              @endif
                            </div>
                          </li>
                        @endfor
                      </ul>
                    </div>
                    <div class="col-md-12">
                    @if (Auth::user()->role === 'Administrator')
                        <input id="cancelTour" type="button" class="btn-danger btn-xs pull-right" title="Cancel Tour" value="Cancel Tour" >
                    @endif
                    </div>
                    <div class="col-md-12">

                    </div>
                  </div>
                </div>
              </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script style="text/javascript">
var reservationID = {!! $reservation->id !!}
var tourTimeID = {!! $reservation->schedule->time->id !!}
$('#tourTimeID').val(tourTimeID).change(function(){
  console.log("currently selected", $(this).val());
  $.ajax({
    url: url + '/api/v1/reservations/' + reservationID,
    type: 'post',
    data:  {
      tourTimeID: $('#tourTimeID').val()
    , _method: 'put'
    },
    success: function(data){
      location.reload()
    }
  })
})
$('#cancelTour').click(function(){
  $.ajax({
    url: url + '/api/v1/reservations/' + reservationID,
    type: 'delete',
    data:  {
      _method: 'delete'
    },
    success: function(data){
      window.location.href = '/admin/reservations'
    }
  })
})
</script>
@endsection
