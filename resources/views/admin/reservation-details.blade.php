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
                    <div class="col-md-4">
                      <h5>
                        Primary Guest
                      </h5>
                      <span class="text-primary"> {{$reservation->customer->first_name . ' ' . $reservation->customer->last_name}} </span>
                    </div>
                    <div class="col-md-4">
                      <h5>
                        Date
                      </h5>
                      <span class="text-primary"> {{$reservation->schedule->date}} </span>
                    </div>
                    <div class="col-md-4">
                      <h5>
                        Time
                      </h5>
                      <span class="text-primary"> {{$reservation->schedule->time->name}} </span>
                    </div>
                    <div class="col-md-12">
                    </br>
                    </div>
                    <div class="col-md-4">
                      <span> {{$reservation->customer->email}} </span>
                    </div>
                    <div class="col-md-4">
                      <span> {{$reservation->customer->phone}} </span>
                    </div>
                    <div class="col-md-4">
                      <span> {{$reservation->customer->address}} </span>
                    </div>
                    <div class="col-md-12">
                      <h5>
                        Tour Group
                      </h5>
                      <ul class="list-group" id="tour-group">
                        @for ($i = 0; $i < count($reservation->group->pivot); $i++)
                          <li class="list-group-item">
                            <h6 class="text-primary">{{$reservation->group->pivot[$i]->customer->first_name . ' ' . $reservation->group->pivot[$i]->customer->last_name}}</h6>
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
var tourGroup = []
var group = {!! $reservation['group']['group'] !!}
for(i in group) {
  var paid   = '<span class="text-danger glyphicon glyphicon-remove pull-right"></span>'
  var agreed = '<span class="text-danger glyphicon glyphicon-remove pull-right"></span>'
  if (group[i].customer.status == 1 ) {
    paid = '<span class="text-success glyphicon glyphicon-ok pull-right"></span>'
  }
  if (group[i].customer.waiverStatus == 1 ) {
    greed = '<span class="text-success glyphicon glyphicon-ok pull-right"></span>'
  }
  $('<li class="list-group-item" style="font-weight: bold;">' + group[i].customer.first_name + ' ' + group[i].customer.last_name + ' ' + paid + ' ' + agreed + '<br> <span class="text-primary" style="font-weight: 200;">' + group[i].customer.email + ' </span> </li>').appendTo('#tour-group');
  tourGroup.push(group[i])
}
console.log("tourGroup", tourGroup);
</script>
@endsection
