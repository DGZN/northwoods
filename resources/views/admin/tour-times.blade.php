@extends('admin.layouts.master')

@section('title', 'North Woods Admin Dashboard')

@section('navbar')

@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="well well-lg">
              <span
                aria-hidden="true"
                onclick="addItem()"
                class="glyphicon glyphicon glyphicon-plus pull-right add-item">
              </span>
              <table class="table table-hover">
                  <thead>
                    <tr>
                      <th>Product Type</th>
                      <th>Time Group</th>
                      <th>Start Time</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    @for ($i = 0; $i < count($times); $i++)
                      <tr id="{{ 'row'.$i }}">
                          <td>{{$times[$i]->type->name}}</td>
                          <td>{{$times[$i]->tier->name}}</td>
                          <td>{{$times[$i]->name}}</td>
                          <td>
                              <i class="remove-icon"
                                 onclick="removeItem(this)"
                                 data-row="{{'row'.$i}}"
                                 data-id="{{$times[$i]->id}}"
                                 data-resource="tour-times"></i>
                          </td>
                      </tr>
                    @endfor
                  </tbody>
              </table>
            </div>
        </div>
    </div>

    <div class="modal fade" id="addItemModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel">Add New Tour Time</h4>
          </div>
          <form id="addItemForm" data-resource="tour-times">
            <input type="hidden" name="employeeID" value="{{ Auth::user()->id }}" />
            <div class="modal-body">
              <div class="form-group col-md-6">
                <label for="typeID">Type</label>
                <select class="form-control" id="typeID" name="typeID">
                  <option value="" selected="" disabled="">-- Product Type --</option>
                  @for ($i = 0; $i < count($types); $i++)
                    <option value="{{$types[$i]->id}}">{{$types[$i]->name}}</option>
                  @endfor
                </select>
              </div>
              <div class="form-group col-md-6">
                <label for="time">Time Group</label>
                <select name="tierID" class="form-control">
                  <option value="1">Morning</option>
                  <option value="2">Mid-day</option>
                  <option value="3">Afternoon</option>
                  <option value="4">Admin Tier</option>
                </select>
              </div>
              <div class="form-group col-md-6">
                <label for="cost">Start Time </label>
                <div class="form-group">
                  <input type="text" class="form-control" name="name" aria-label="...">
                </div>
              </div>
              <div class="form-group col-md-2 col-md-offset-4">
                <br/>
                <br/>
                <button type="submit" class="btn btn-primary">Create</button>
              </div>
            </div>
            <div class="modal-footer">
            </div>
          </form>
        </div>
      </div>
    </div>

@endsection

@section('scripts')
<script style="text/javascript">
var unitPrice = 80;
var times = {!! $times !!};
</script>
@endsection
