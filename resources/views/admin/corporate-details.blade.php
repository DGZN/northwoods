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
                        Organization
                      </h5>
                      <span class="text"> {{$account->organization}} </span>
                    </div>
                    <div class="col-md-4">
                      <h5>
                        Phone
                      </h5>
                      <span class="text"> {{$account->phone}} </span>
                    </div>
                    <div class="col-md-4">
                      <h5>
                        Email
                      </h5>
                      <span class="text"> {{$account->email}} </span>
                    </div>
                    <div class="col-md-4">
                      <h5>
                        Primary Contact
                      </h5>
                      <span class="text"> {{$account->first_name}} {{$account->last_name}} </span>
                    </div>
                    <div class="col-md-12">
                      <h5>
                        Address
                      </h5>
                      <div class="small well">
                          {{$account->address}}
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
    <div class="row">
        <div class="col-md-12">
            <div class="well well-lg">
              <table class="table table-hover">
                  <thead>
                    <tr>
                      <th>Transaction #</th>
                      <th>Time</th>
                      <th>Amount</th>
                      <th>Employee</th>
                    </tr>
                  </thead>
                  <tbody>
                    @for ($i = 0; $i < count($account->sales); $i++)
                      <tr id="{{ 'row'.$i }}" class="bg-success">
                          <td scope="row">
                              <a href="/admin/sales-history/{{$account->sales[$i]->id}}">
                                {{$account->sales[$i]['transactionCode']}}
                              </a>
                          </td>
                          <td>{{$account->sales[$i]->created_at}}</td>
                          <td>${{$account->sales[$i]->grand}}</td>
                          <td>{{$account->sales[$i]->employee->name . ' '.  $account->sales[$i]->employee->last_name}}</td>
                      </tr>
                    @endfor
                  </tbody>
              </table>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
<script style="text/javascript">
</script>
@endsection
