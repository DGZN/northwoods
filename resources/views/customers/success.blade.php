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
                <h4 class="text-success text-center">Success :)</h4>
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
var primary  = {!! $customer !!}
var transaction  = {!! $transaction !!}
$(document).ready(function(){

})
</script>
@endsection
