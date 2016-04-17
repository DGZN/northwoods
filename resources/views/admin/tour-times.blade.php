@extends('admin.layouts.master')

@section('title', 'North Woods Admin Dashboard')

@section('navbar')
<div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <a class="navbar-brand" href="#">North Woods Admin</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
        <ul class="nav navbar-nav navbar-left api-routes">
          <li><a href="/admin/customers">Customers</a></li>
          <li><a href="/admin/employees">Employees</a></li>
          <li><a href="/admin/reservations">Reservations</a></li>
          <li><a href="/admin/transactions">Transactions</a></li>
          <li><a href="/admin/products">Products</a></li>
          <li><a href="/admin/product-groups">Product Groups</a></li>
          <li><a href="/admin/product-types">Product Types</a></li>
        </ul>
        <ul class="nav navbar-nav navbar-right">
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Account <span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li><a href="/admin/logout">Logout</a></li>
              </ul>
            </li>
        </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
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
                      <th>#</th>
                      <th>Tier</th>
                      <th>Start Time</th>
                      <th>End Time</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    @for ($i = 0; $i < count($times); $i++)
                      <tr id="{{ 'row'.$i }}">
                          <th scope="row">{{$times[$i]->id}}</th>
                          <td>{{$times[$i]->time}}</td>
                          <td style="text-align: center;">
                            {{$times[$i]->guests}}
                          </td>
                          <td>${{$times[$i]->cost}}</td>
                          <td>
                            {{
                              $times[$i]['customerName'] or
                              $times[$i]->primaryGuestID
                            }}
                          </td>
                          <td>
                              <i class="remove-icon"
                                 onclick="removeItem(this)"
                                 data-row="{{'row'.$i}}"
                                 data-id="{{$times[$i]->id}}"
                                 data-resource="reservations"></i>
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
            <input type="hidden" name="productID" value="1" />
            <input type="hidden" name="employeeID" value="{{ Auth::user()->id }}" />
            <div class="modal-body">
              <div class="form-group col-md-6">
                <label for="cost">Start Time </label>
                <div class="input-group">
                  <input type="text" class="form-control" aria-label="...">
                  <div class="input-group-btn">
                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">AM <span class="caret"></span></button>
                    <ul class="dropdown-menu dropdown-menu-right">
                      <li><a href="#">AM</a></li>
                      <li><a href="#">PM</a></li>
                    </ul>
                  </div>
                </div>
              </div>
              <div class="form-group col-md-6">
                <label for="cost">End Time </label>
                <div class="input-group">
                  <input type="text" class="form-control" aria-label="...">
                  <div class="input-group-btn">
                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">AM <span class="caret"></span></button>
                    <ul class="dropdown-menu dropdown-menu-right">
                      <li><a href="#">AM</a></li>
                      <li><a href="#">PM</a></li>
                    </ul>
                  </div>
                </div>
              </div>
              <div class="form-group col-md-6">
                <label for="time">Time Tier</label>
                <select id="timeSelect" name="time" class="form-control">
                  <option value="1">1</option>
                  <option value="2">2</option>
                  <option value="3">3</option>
                  <option value="4">4</option>
                  <option value="5">5</option>
                </select>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary">Create</button>
            </div>
          </form>
        </div>
      </div>
    </div>

@endsection

@section('scripts')
<script style="text/javascript">
var unitPrice = 150;
$(function(){
  $("#primaryGuestID").typeahead({ source: customers, autoSelect: true });
  var $input = $("#primaryGuestID");
  $input.change(function() {
    var current = $input.typeahead("getActive");
    $input.val(current.id)
  });
  $('#timeSelect').change(function() {
    if($(this).val() == 'custom'){
      $('#timeSelect').fadeOut(500, function(){
        $(this).css('display', 'none')
        $('#timeInput').fadeIn(500, function(){
          $(this).css('display', 'block')
        })
      })
    }
  });
  $(document).on('input', '#guests',  function() {
    var cost = parseInt($(this).val()) * unitPrice
    $('#cost').val(cost)
  });
})
</script>
@endsection
