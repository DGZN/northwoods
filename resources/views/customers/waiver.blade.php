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
                <div class="col-md-12">
                  <h4 class="text-primary text-center">Tour Wavier Confirmation</h4>
                  <h6>
                    Before going on your tour you must agree to the waiver below.
                    Click or tap <b> "I Agree" </b> to accept.
                  </h6>
                  <div class="small well">
                    <h4> Waiver PDF Text Here </h4>
                  </div>
                  <h5>
                    <input type="submit" class="btn-success form-control" value="I Agree" name="agree" title="I Agree" />
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
})
</script>
@endsection
