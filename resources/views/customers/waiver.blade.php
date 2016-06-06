@extends('customers.layouts.master')

@section('title', 'North Woods Admin Dashboard')

@section('navbar')

@endsection

@section('content')
  <div class="col-md-10 col-md-offset-1">
    <div class="well">
      <div class="row">
        <div class="col-md-12">
          <div class="well">
            <div class="row">
              <form method="put" name="waiver-form">
                <input name="_method" type="hidden" value="PUT">
                <div class="col-md-12">
                  <h4 class="text-primary text-center">Tour Wavier Confirmation</h4>
                  <h6>
                    Before going on your tour you must agree to the waiver below.
                    Click or tap <b> "I Agree" </b> to accept.
                  </h6>
                  <div class="small well">
                    {!! $settings->waiver !!}
                  </div>
                  <h5>
                    <input id="agree" type="button" class="btn-success form-control" value="agree" name="agree" title="I Agree" />
                  </h5>
                </div>
              </form>
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
var guest  = {!! $guest !!}
$(document).ready(function(){
  console.log("Waiver Guest", guest);
  $('#agree').click(() => {
    $.ajax({
      url: url + '/api/v1/groups/' + UUID + '/waiver/' + guest.id
    , type: 'post'
    , data: {
      _method: 'put'
    , waiverStatus: 1
    }
    , success: function(result, status){
        console.log("result", result, 'satus', status);
      }
    })
  })
})
</script>
@endsection
