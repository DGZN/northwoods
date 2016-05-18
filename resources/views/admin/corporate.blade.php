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
                      <th>Account #</th>
                      <th>Organization</th>
                      <th>Contact</th>
                      <th>Phone</th>
                      <th>Email</th>
                    </tr>
                  </thead>
                  <tbody>
                    @for ($i = 0; $i < count($accounts); $i++)
                      <tr id="{{ 'row'.$i }}">
                          <th scope="row">
                            <a href="corporate-accounts/{{$accounts[$i]->id}}">
                              {{$accounts[$i]->account}}
                            </a>
                          </th>
                          <td>{{$accounts[$i]->organization}}</td>
                          <td>{{$accounts[$i]->first_name}} {{$accounts[$i]->last_name}}</td>
                          <td>{{$accounts[$i]->phone}}</td>
                          <td>{{$accounts[$i]->email}}</td>
                      </tr>
                    @endfor
                  </tbody>
              </table>
            </div>
        </div>
    </div>

    <div class="large modal fade" id="addItemModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel">Add New Corporate Account</h4>
          </div>
          <form id="addItemForm" data-resource="corporate-accounts">
            <div class="modal-body">
              <div class="form-group col-md-12">
                <label for="organization">Organization</label>
                <input type="text" class="form-control" id="organization" name="organization" placeholder="Organization">
              </div>
              <div class="form-group col-md-12">
                <label for="paymentTerms">Payment Terms</label>
                <select class="form-control" id="paymentTerms" name="paymentTerms">
                  <option value="" selected="" disabled="">-- Payment Terms --</option>
                  <option value="invoice">Invoice</option>
                  <option value="card-on-file">Card on File</option>
                </select>
              </div>
              <div class="credit-card-form hidden-fields">
                  <div class="form-group col-md-6">
                    <label for="first_name">First Name</label>
                    <input type="text" class="form-control" id="first_name" name="first_name" placeholder="First Name">
                  </div>
                  <div class="form-group col-md-6">
                    <label for="last_name">Last Name</label>
                    <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Last Name">
                  </div>
                  <div class="form-group col-md-6">
                    <label for="phone">Phone</label>
                    <input type="text" class="form-control" id="phone" name="phone" placeholder="Phone">
                  </div>
                  <div class="form-group col-md-6">
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
              <div class="form-group col-md-12">
                <label for="notes">Notes</label>
                <textarea class="form-control" id="notes" name="notes" ></textarea>
              </div>
              <div class="form-group col-md-6">
                <label for="taxExempt">Tax Exempt?</label>
                <input type="checkbox" class="form-control" id="taxExempt" name="taxExempt" value="1"/>
              </div>
              <div class="form-group col-md-6">
                <label for="validOn">Valid  Date</label>
                <input type="text" class="form-control" id="validOn" name="validOn" />
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
$(document).ready(function(){
var picker = new Pikaday({
  field: document.getElementById('validOn')
, minDate: moment().add('days', 1).toDate()
, format: 'YYYY-MM-DD'
})
$('#paymentTerms').change(function(){
    if ($(this).val() == 'card-on-file') {
      $('.credit-card-form').fadeIn(250)
    } else {
      $('.credit-card-form').fadeOut(250)
    }
})
})
</script>
@endsection
