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
                      <h6>Date / Time</h6>
                      <span style="font-weight: bold;">{{$sale->created_at}}</span>
                    </div>
                    <div class="col-md-4">
                      <h6>TAX</h6>
                      <span style="font-weight: bold;">${{$sale->tax}}</span>
                    </div>
                    <div class="col-md-4">
                      <h6>Grand Total</h6>
                      <span style="font-weight: bold;">${{$sale->grand}}</span>
                    </div>
                    <div class="col-md-6">
                      <h6>
                        Products Sold
                      </h6>
                      <ul class="list-group" id="tour-group">
                          @for ($i = 0; $i < count($sale->pivot); $i++)
                            <li class="list-group-item">{{$sale->pivot[$i]->name}} <span class="bold">x{{$sale->pivot[$i]->qty}}</span></li>
                          @endfor
                      </ul>
                    </div>
                    <div class="col-md-6">
                      <h6>
                        Transactions
                      </h6>
                      <ul class="list-group" id="tour-group">
                          @for ($i = 0; $i < count($sale->transactions); $i++)
                            <li class="list-group-item">{{ucfirst($sale->transactions[$i]['type'])}} <span class="bold">${{$sale->transactions[$i]['total']}}</span>  </li>
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
@endsection
