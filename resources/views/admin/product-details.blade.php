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
                      <h6>Name</h6>
                      <span style="font-weight: bold;">{{$product->name}}</span>
                    </div>
                    <div class="col-md-4">
                      <h6>Group</h6>
                      <span style="font-weight: bold;">{{$product->group->name}}</span>
                    </div>
                    <div class="col-md-4">
                      <h6>Type</h6>
                      <span style="font-weight: bold;">{{$product->type->name}}</span>
                    </div>
                    <div class="col-md-12">
                      <h6>
                        Sub Products
                      </h6>
                      <ul class="list-group" id="tour-group">
                          @for ($i = 0; $i < count($product->subs); $i++)
                            <li class="list-group-item">
                              <h5>{{$product->subs[$i]->name}} ${{$product->subs[$i]->price}}</h5>
                              <h6>Stock: {{$product->subs[$i]->stock}}</h6>
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
@endsection
