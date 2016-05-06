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
                    <div class="col-md-12">
                      <h6>
                        Products
                      </h6>
                      <ul class="list-group" id="tour-group">
                          @for ($i = 0; $i < count($sale->transactions); $i++)
                            <li class="list-group-item">{{$sale->transactions[$i]->product->name}} x{{$sale->transactions[$i]->qty}}    ${{$sale->transactions[$i]->total}} {{$sale->transactions[$i]->type}}</li>
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
