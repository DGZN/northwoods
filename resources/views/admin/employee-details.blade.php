@extends('admin.layouts.master')

@section('title', 'North Woods Admin Dashboard')

@section('navbar')
@endsection

@section('content')
    <div class="row">
        <div class="col-md-6  col-md-offset-3">
            <div class="well well-lg">
              <div class="row">
                <div class="col-md-12">
                  <div class="row">
                    <div class="col-md-4">
                      <h5>
                        Full Name
                      </h5>
                      <span class="text"> {{$employee->name . ' ' . $employee->last_name}} </span>
                    </div>
                    <div class="col-md-4">
                      <h5>
                        Phone
                      </h5>
                      <span class="text"> {{$employee->phone}} </span>
                    </div>
                    <div class="col-md-4">
                      <h5>
                        Email
                      </h5>
                      <span class="text"> {{$employee->email}} </span>
                    </div>
                    <div class="col-md-12">
                      <h5>
                        Role
                      </h5>
                      <div class="small well">
                          {{$employee->role}}
                      </div>
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
</script>
@endsection
