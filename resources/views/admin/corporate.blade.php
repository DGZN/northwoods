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
                      <th>ID</th>
                      <th>Account Name</th>
                      <th>Phone</th>
                      <th>Email</th>
                      <th>Address</th>
                      <th>City</th>
                      <th>State</th>
                      <th>Zip</th>
                      <th>Country</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    @for ($i = 0; $i < count($accounts); $i++)
                      <tr id="{{ 'row'.$i }}">
                          <th scope="row">{{$accounts[$i]->id}}</th>
                          <td>{{$accounts[$i]->last_name}}</td>
                          <td>{{$accounts[$i]->phone}}</td>
                          <td>{{$accounts[$i]->email}}</td>
                          <td>{{$accounts[$i]->address}}</td>
                          <td>{{$accounts[$i]->city}}</td>
                          <td>{{$accounts[$i]->state}}</td>
                          <td>{{$accounts[$i]->zip}}</td>
                          <td>{{$accounts[$i]->country}}</td>
                          <td>{{$accounts[$i]->profileID}}</td>
                          <td>{{$accounts[$i]->paymentID}}</td>
                          <td>
                              <i class="remove-icon"
                                 onclick="removeItem(this)"
                                 data-row="{{'row'.$i}}"
                                 data-id="{{$accounts[$i]->id}}"
                                 data-resource="customers"></i>
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
            <h4 class="modal-title" id="myModalLabel">Add New Corporate Account</h4>
          </div>
          <form id="addItemForm" data-resource="customers">
            <div class="modal-body">
              <div class="form-group col-md-6">
                <label for="account-name">Account Name</label>
                <input type="text" class="form-control" id="account-name" name="account-name" placeholder="Account Name">
              </div>
              <div class="form-group col-md-6">
                <label for="phone">Phone</label>
                <input type="text" class="form-control" id="phone" name="phone" placeholder="Phone">
              </div>
              <div class="form-group col-md-12">
                <label for="email">Email</label>
                <input type="text" class="form-control" id="email" name="email" placeholder="Email">
              </div>
              <div class="form-group col-md-12">
                <label for="address">Address</label>
                <textarea id="address" class="form-control" name="address" rows="3"></textarea>
              </div>
              <div class="form-group col-md-6">
                <label for="city">City</label>
                <input type="text" class="form-control" id="city" name="city" placeholder="City">
              </div>
              <div class="form-group col-md-6">
                <label for="state">State</label>
                <input type="text" class="form-control" id="state" name="state" placeholder="State">
              </div>
              <div class="form-group col-md-6">
                <label for="zip">Zip</label>
                <input type="text" class="form-control" id="zip" name="zip" placeholder="Zip">
              </div>
              <div class="form-group col-md-6">
                <label for="country">Country</label>
                <input type="text" class="form-control" id="country" name="country" placeholder="Country">
              </div>
              <div class="form-group col-md-6">
                <label for="card_number">Credit Card Number</label>
                <input type="text" class="form-control" id="card_number" name="card_number" value="4111111111111111">
              </div>
              <div class="form-group col-md-6">
                <label for="exp_date">Expiration date</label>
                <input type="text" class="form-control" id="exp_date" name="exp_date" value="2038-12">
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary">Create Account</button>
            </div>
          </form>
        </div>
      </div>
    </div>

@endsection

@section('scripts')
<script style="text/javascript">

</script>
@endsection
