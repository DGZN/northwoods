@extends('admin.layouts.master')

@section('title', 'North Woods Admin Dashboard')

@section('navbar')

@endsection

@section('content')
    <div class="row">
        <div class="col-md-7">
            <div class="well well-lg">
              <span
                aria-hidden="true"
                onclick="addItem()"
                class="glyphicon glyphicon glyphicon-plus pull-right add-item">
              </span>

                      <div class="modal-content">
                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                          <h4 class="modal-title" id="myModalLabel">Add New Sale</h4>
                        </div>
                        <form id="billForm" data-resource="transactions">
                          <div class="modal-body">
                            <div class="form-group col-md-6">
                              <label for="productID">Product</label>
                              <select class="form-control" id="productID" name="productID">
                                  <option selected="" disabled>-- Select a Product --</option>
                                @for ($i = 0; $i < count($products); $i++)
                                   @if ($products[$i]->parentID == 0)
                                      <option value="{{$products[$i]->id}}" data-subs="{{$products[$i]->subs}}">{{$products[$i]->name}}</option>
                                   @endif
                                @endfor
                              </select>
                            </div>
                            <div class="form-group col-md-6">
                              <label for="optionID">Option</label>
                              <select name="optionID" id="optionID" class="form-control">
                                <option disabled="" selected value="0">-- Product Option --</option>
                              </select>
                            </div>
                            <div class="form-group col-md-6">
                              <label id="qty-label" for="qty">Quantity</label>
                              <input type="text" id="qty" class="form-control" value="1" disabled />
                            </div>
                            <div id="total-field" class="form-group col-md-6">
                              <label for="total">Total</label>
                              <input type="total" class="form-control" id="total" name="total" placeholder="Total" disabled>
                            </div>
                            <div id="total-field" class="form-group col-md-2 col-md-offset-10">
                              <input id="addSubProduct" type="button" class="form-control btn btn-success" value="Add" />
                            </div>
                            <div class="form-group col-md-12">
                              <div class="small well" id="bill-fields">
                                <ul class="list-group" id="sub-products" data-subProducts=[] >

                                </ul>
                                <div class="small well">
                                    <div class="row form-group">
                                        <div class="col-md-12">
                                            <h5 class="pull-right">Total: <span id="bill-total" class="total">$0.00</span> </h5>
                                        </div>
                                        <div class="col-md-12">
                                            <h5 class="pull-right">TAX: <span id="tax" class="tax">$0.00</span> </h5>
                                        </div>
                                        <div class="col-md-12">
                                            <h4 class="pull-right">Grand Total: <span id="grand-total" class="grand-total">$0.00</span> </h4>
                                        </div>
                                    </div>
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="modal-footer">
                          </div>
                        </form>
                      </div>

            </div>
        </div>
        <div class="col-md-5">
            <div class="well well-lg" style="height: 120px;">
              <label for="transactionAmount">Transaction Amount</label>
              <input type="text" id="transactionAmount" name="transactionAmount" class="form-control" placeholder="" value="">
            </div>
            <div class="well well-lg">
              <div class="modal-content">
                <form id="addSaleForm" data-resource="transactions">
                  <input type="hidden" id="employeeID" name="employeeID" value="{{ Auth::user()->id }}" />
                  <div class="modal-body">
                    <div class="form-group col-md-12">
                      <label for="type">Transaction Type</label>
                      <select name="type" id="type" class="form-control" style="cursor: pointer;">
                        <option disabled="" selected="">-- Transaction Type --</option>
                        <option value="charge">Charge</option>
                        <option value="cash">Cash</option>
                        <option value="cardOnFile">Card on File</option>
                        <option value="check">Check</option>
                        <option value="certificate">Gift Certificate</option>
                        <option value="corporate">Corporate Account</option>
                        <option value="discount">Discount</option>
                        <option value="void">Void</option>
                      </select>
                    </div>
                    <div id="cash-payment-form" class="hidden-fields">
                      <div id="cash-given-form" class="form-group col-md-6">
                        <label for="cash-given">Cash given</label>
                        <input type="cash-given" class="form-control" id="cash-given" name="cash-given" placeholder="-- Cash Given --">
                      </div>
                      <div id="change-due-form" class="form-group col-md-6">
                        <label id="change-due-label" for="change-due">Change due</label>
                        <input type="change-due" class="form-control" id="change-due" name="change-due" placeholder="-- Change Due --" disabled="">
                      </div>
                    </div>
                    <div id="customer-form" class="form-group col-md-12 hidden-fields">
                      <label for="customerName">Customer</label>
                      <input type="text" class="form-control" id="customerName" name="customerName" placeholder="Customer">
                      <input type="hidden" class="form-control" id="customerID" name="customerID">
                    </div>
                    <div id="credit-card-form" class="form-group col-md-12 hidden-fields">
                      <div class="small well" style="min-height: 500px;">
                        <div class="form-group col-md-6">
                          <label for="first_name">First Name</label>
                          <input type="text" class="form-control" id="first_name" name="first_name" placeholder="First Name">
                        </div>
                        <div class="form-group col-md-6">
                          <label for="last_name">Last Name</label>
                          <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Last Name">
                        </div>
                        <div class="form-group col-md-12">
                          <label for="phone">Phone</label>
                          <input type="text" class="form-control" id="phone" name="phone" placeholder="Phone">
                        </div>
                        <div class="form-group col-md-6" style="display: none;">
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
                          <select name="country" id="country" class="form-control" style="cursor: pointer;">
                              <option value="AF">Afghanistan
                              <option value="AX">Åland Islands</option>
                              <option value="AL">Albania</option>
                              <option value="DZ">Algeria</option>
                              <option value="AS">American Samoa</option>
                              <option value="AD">Andorra</option>
                              <option value="AO">Angola</option>
                              <option value="AI">Anguilla</option>
                              <option value="AQ">Antarctica</option>
                              <option value="AG">Antigua and Barbuda</option>
                              <option value="AR">Argentina</option>
                              <option value="AM">Armenia</option>
                              <option value="AW">Aruba</option>
                              <option value="AU">Australia</option>
                              <option value="AT">Austria</option>
                              <option value="AZ">Azerbaijan</option>
                              <option value="BS">Bahamas</option>
                              <option value="BH">Bahrain</option>
                              <option value="BD">Bangladesh</option>
                              <option value="BB">Barbados</option>
                              <option value="BY">Belarus</option>
                              <option value="BE">Belgium</option>
                              <option value="BZ">Belize</option>
                              <option value="BJ">Benin</option>
                              <option value="BM">Bermuda</option>
                              <option value="BT">Bhutan</option>
                              <option value="BO">Bolivia, Plurinational State of</option>
                              <option value="BQ">Bonaire, Sint Eustatius and Saba</option>
                              <option value="BA">Bosnia and Herzegovina</option>
                              <option value="BW">Botswana</option>
                              <option value="BV">Bouvet Island</option>
                              <option value="BR">Brazil</option>
                              <option value="IO">British Indian Ocean Territory</option>
                              <option value="BN">Brunei Darussalam</option>
                              <option value="BG">Bulgaria</option>
                              <option value="BF">Burkina Faso</option>
                              <option value="BI">Burundi</option>
                              <option value="KH">Cambodia</option>
                              <option value="CM">Cameroon</option>
                              <option value="CA">Canada</option>
                              <option value="CV">Cape Verde</option>
                              <option value="KY">Cayman Islands</option>
                              <option value="CF">Central African Republic</option>
                              <option value="TD">Chad</option>
                              <option value="CL">Chile</option>
                              <option value="CN">China</option>
                              <option value="CX">Christmas Island</option>
                              <option value="CC">Cocos (Keeling) Islands</option>
                              <option value="CO">Colombia</option>
                              <option value="KM">Comoros</option>
                              <option value="CG">Congo</option>
                              <option value="CD">Congo, the Democratic Republic of the</option>
                              <option value="CK">Cook Islands</option>
                              <option value="CR">Costa Rica</option>
                              <option value="CI">Côte d'Ivoire</option>
                              <option value="HR">Croatia</option>
                              <option value="CU">Cuba</option>
                              <option value="CW">Curaçao</option>
                              <option value="CY">Cyprus</option>
                              <option value="CZ">Czech Republic</option>
                              <option value="DK">Denmark</option>
                              <option value="DJ">Djibouti</option>
                              <option value="DM">Dominica</option>
                              <option value="DO">Dominican Republic</option>
                              <option value="EC">Ecuador</option>
                              <option value="EG">Egypt</option>
                              <option value="SV">El Salvador</option>
                              <option value="GQ">Equatorial Guinea</option>
                              <option value="ER">Eritrea</option>
                              <option value="EE">Estonia</option>
                              <option value="ET">Ethiopia</option>
                              <option value="FK">Falkland Islands (Malvinas)</option>
                              <option value="FO">Faroe Islands</option>
                              <option value="FJ">Fiji</option>
                              <option value="FI">Finland</option>
                              <option value="FR">France</option>
                              <option value="GF">French Guiana</option>
                              <option value="PF">French Polynesia</option>
                              <option value="TF">French Southern Territories</option>
                              <option value="GA">Gabon</option>
                              <option value="GM">Gambia</option>
                              <option value="GE">Georgia</option>
                              <option value="DE">Germany</option>
                              <option value="GH">Ghana</option>
                              <option value="GI">Gibraltar</option>
                              <option value="GR">Greece</option>
                              <option value="GL">Greenland</option>
                              <option value="GD">Grenada</option>
                              <option value="GP">Guadeloupe</option>
                              <option value="GU">Guam</option>
                              <option value="GT">Guatemala</option>
                              <option value="GG">Guernsey</option>
                              <option value="GN">Guinea</option>
                              <option value="GW">Guinea-Bissau</option>
                              <option value="GY">Guyana</option>
                              <option value="HT">Haiti</option>
                              <option value="HM">Heard Island and McDonald Islands</option>
                              <option value="VA">Holy See (Vatican City State)</option>
                              <option value="HN">Honduras</option>
                              <option value="HK">Hong Kong</option>
                              <option value="HU">Hungary</option>
                              <option value="IS">Iceland</option>
                              <option value="IN">India</option>
                              <option value="ID">Indonesia</option>
                              <option value="IR">Iran, Islamic Republic of</option>
                              <option value="IQ">Iraq</option>
                              <option value="IE">Ireland</option>
                              <option value="IM">Isle of Man</option>
                              <option value="IL">Israel</option>
                              <option value="IT">Italy</option>
                              <option value="JM">Jamaica</option>
                              <option value="JP">Japan</option>
                              <option value="JE">Jersey</option>
                              <option value="JO">Jordan</option>
                              <option value="KZ">Kazakhstan</option>
                              <option value="KE">Kenya</option>
                              <option value="KI">Kiribati</option>
                              <option value="KP">Korea, Democratic People's Republic of</option>
                              <option value="KR">Korea, Republic of</option>
                              <option value="KW">Kuwait</option>
                              <option value="KG">Kyrgyzstan</option>
                              <option value="LA">Lao People's Democratic Republic</option>
                              <option value="LV">Latvia</option>
                              <option value="LB">Lebanon</option>
                              <option value="LS">Lesotho</option>
                              <option value="LR">Liberia</option>
                              <option value="LY">Libya</option>
                              <option value="LI">Liechtenstein</option>
                              <option value="LT">Lithuania</option>
                              <option value="LU">Luxembourg</option>
                              <option value="MO">Macao</option>
                              <option value="MK">Macedonia, the former Yugoslav Republic of</option>
                              <option value="MG">Madagascar</option>
                              <option value="MW">Malawi</option>
                              <option value="MY">Malaysia</option>
                              <option value="MV">Maldives</option>
                              <option value="ML">Mali</option>
                              <option value="MT">Malta</option>
                              <option value="MH">Marshall Islands</option>
                              <option value="MQ">Martinique</option>
                              <option value="MR">Mauritania</option>
                              <option value="MU">Mauritius</option>
                              <option value="YT">Mayotte</option>
                              <option value="MX">Mexico</option>
                              <option value="FM">Micronesia, Federated States of</option>
                              <option value="MD">Moldova, Republic of</option>
                              <option value="MC">Monaco</option>
                              <option value="MN">Mongolia</option>
                              <option value="ME">Montenegro</option>
                              <option value="MS">Montserrat</option>
                              <option value="MA">Morocco</option>
                              <option value="MZ">Mozambique</option>
                              <option value="MM">Myanmar</option>
                              <option value="NA">Namibia</option>
                              <option value="NR">Nauru</option>
                              <option value="NP">Nepal</option>
                              <option value="NL">Netherlands</option>
                              <option value="NC">New Caledonia</option>
                              <option value="NZ">New Zealand</option>
                              <option value="NI">Nicaragua</option>
                              <option value="NE">Niger</option>
                              <option value="NG">Nigeria</option>
                              <option value="NU">Niue</option>
                              <option value="NF">Norfolk Island</option>
                              <option value="MP">Northern Mariana Islands</option>
                              <option value="NO">Norway</option>
                              <option value="OM">Oman</option>
                              <option value="PK">Pakistan</option>
                              <option value="PW">Palau</option>
                              <option value="PS">Palestinian Territory, Occupied</option>
                              <option value="PA">Panama</option>
                              <option value="PG">Papua New Guinea</option>
                              <option value="PY">Paraguay</option>
                              <option value="PE">Peru</option>
                              <option value="PH">Philippines</option>
                              <option value="PN">Pitcairn</option>
                              <option value="PL">Poland</option>
                              <option value="PT">Portugal</option>
                              <option value="PR">Puerto Rico</option>
                              <option value="QA">Qatar</option>
                              <option value="RE">Réunion</option>
                              <option value="RO">Romania</option>
                              <option value="RU">Russian Federation</option>
                              <option value="RW">Rwanda</option>
                              <option value="BL">Saint Barthélemy</option>
                              <option value="SH">Saint Helena, Ascension and Tristan da Cunha</option>
                              <option value="KN">Saint Kitts and Nevis</option>
                              <option value="LC">Saint Lucia</option>
                              <option value="MF">Saint Martin (French part)</option>
                              <option value="PM">Saint Pierre and Miquelon</option>
                              <option value="VC">Saint Vincent and the Grenadines</option>
                              <option value="WS">Samoa</option>
                              <option value="SM">San Marino</option>
                              <option value="ST">Sao Tome and Principe</option>
                              <option value="SA">Saudi Arabia</option>
                              <option value="SN">Senegal</option>
                              <option value="RS">Serbia</option>
                              <option value="SC">Seychelles</option>
                              <option value="SL">Sierra Leone</option>
                              <option value="SG">Singapore</option>
                              <option value="SX">Sint Maarten (Dutch part)</option>
                              <option value="SK">Slovakia</option>
                              <option value="SI">Slovenia</option>
                              <option value="SB">Solomon Islands</option>
                              <option value="SO">Somalia</option>
                              <option value="ZA">South Africa</option>
                              <option value="GS">South Georgia and the South Sandwich Islands</option>
                              <option value="SS">South Sudan</option>
                              <option value="ES">Spain</option>
                              <option value="LK">Sri Lanka</option>
                              <option value="SD">Sudan</option>
                              <option value="SR">Suriname</option>
                              <option value="SJ">Svalbard and Jan Mayen</option>
                              <option value="SZ">Swaziland</option>
                              <option value="SE">Sweden</option>
                              <option value="CH">Switzerland</option>
                              <option value="SY">Syrian Arab Republic</option>
                              <option value="TW">Taiwan</option>
                              <option value="TJ">Tajikistan</option>
                              <option value="TZ">Tanzania, United Republic of</option>
                              <option value="TH">Thailand</option>
                              <option value="TL">Timor-Leste</option>
                              <option value="TG">Togo</option>
                              <option value="TK">Tokelau</option>
                              <option value="TO">Tonga</option>
                              <option value="TT">Trinidad and Tobago</option>
                              <option value="TN">Tunisia</option>
                              <option value="TR">Turkey</option>
                              <option value="TM">Turkmenistan</option>
                              <option value="TC">Turks and Caicos Islands</option>
                              <option value="TV">Tuvalu</option>
                              <option value="UG">Uganda</option>
                              <option value="UA">Ukraine</option>
                              <option value="AE">United Arab Emirates</option>
                              <option value="GB">United Kingdom</option>
                              <option value="US" selected>United States of America</option>
                              <option value="UM">United States Minor Outlying Islands</option>
                              <option value="UY">Uruguay</option>
                              <option value="UZ">Uzbekistan</option>
                              <option value="VU">Vanuatu</option>
                              <option value="VE">Venezuela, Bolivarian Republic of</option>
                              <option value="VN">Viet Nam</option>
                              <option value="VG">Virgin Islands, British</option>
                              <option value="VI">Virgin Islands, U.S.</option>
                              <option value="WF">Wallis and Futuna</option>
                              <option value="EH">Western Sahara</option>
                              <option value="YE">Yemen</option>
                              <option value="ZM">Zambia</option>
                              <option value="ZW">Zimbabwe</option>
                          </select>
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
                    </div>
                    <div id="check-payment-form" class="form-group col-md-12 hidden-fields">
                      <label for="referenceID">Check #</label>
                      <input type="referenceID" class="form-control" id="referenceID" name="referenceID" placeholder="-- Check Number --">
                    </div>
                    <div id="certificate-payment-form" class="form-group col-md-12 hidden-fields">
                      <label for="certificateID">Gift Certificate #</label>
                      <input type="certificateID" class="form-control" id="certificateID" name="certificateID" placeholder="-- Gift Certificate Number --" disabled>
                    </div>
                    <div id="corporate-payment-form" class="form-group col-md-12 hidden-fields">
                      <label for="corporateID">Corporate Account #</label>
                      <select class="form-control" id="corporateID" name="corporateID">
                          <option selected disabled>-- Select an Account --</option>
                        @for ($i = 0; $i < count($accounts); $i++)
                          <option value="{{$accounts[$i]->id}}">{{$accounts[$i]->organization }}</option>
                        @endfor
                      </select>
                    </div>
                    <div id="discount-form" class="hidden-fields">
                      <div class="form-group col-md-6">
                        <label for="discount">Discount Amount</label>
                        <input type="discount" class="form-control" id="discount" name="discount" placeholder="-- Discount Amount --">
                      </div>
                      <div id="discount-change-due-form" class="form-group col-md-6">
                        <label id="discount-change-due-label" for="change-due">Change due</label>
                        <input type="text" class="form-control" id="discount-change-due" name="discount-change-due" placeholder="-- Change Due --" disabled="">
                      </div>
                    </div>
                    <div id="notes-form" class="form-group col-md-12 hidden-fields">
                      <label for="notes">Notes</label>
                      <textarea id="notes" class="form-control" name="notes" rows="3"></textarea>
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Charge</button>
                  </div>
                </form>
              </div>
            </div>
    </div>

@endsection

@section('scripts')
<script style="text/javascript">

const saleTax = .{{$settings->state_tax}}

var products     = {!! json_encode($products) !!}
var customers    = {!! json_encode($customers) !!}
var accounts     = {!! json_encode($accounts) !!}
var reservations = {!! json_encode($reservations) !!}

var customers = customers.map(function(data){
  return {
    id: data.customer.id
  , name: data.customer.first_name + ' ' + data.customer.last_name
  }
})

var transactedAmount = 0;

var currentProduct = {};

var forms = [
    '#cash-payment-form'
  , '#customer-form'
  , '#credit-card-form'
  , '#check-payment-form'
  , '#certificate-payment-form'
  , '#corporate-payment-form'
  , '#discount-form'
  , '#notes-form'
]

function toggleForm(show){
  forms.map((id) => {
    if ( show.indexOf(id) >= 0 ) {
      $(id).removeClass('hidden-fields')
    } else {
      $(id).addClass('hidden-fields')
    }
  })
}

$(function(){

  $('#type').change(function(){
    switch ($(this).val()) {
      case 'charge':
        toggleForm('#credit-card-form')
        break;
      case 'cardOnFile':
        toggleForm('#customer-form')
        $("#customerName").typeahead({ source: customers });
        var $customer = $("#customerName");
        $customer.change(function() {
          var current = $customer.typeahead("getActive");
          if (current) {
            $customer.val(current.name).data('id', current.id)
            $('#customerID').val(current.id)
          }
        });
        break;
      case 'cash':
        toggleForm('#cash-payment-form')
        $('#cash-given').on('keydown', function(){
          calculateChangeDue()
        })
        break;
      case 'check':
        toggleForm('#check-payment-form')
        break;
      case 'certificate':
        toggleForm('#certificate-payment-form')
        break;
      case 'corporate':
        toggleForm('#corporate-payment-form')
        break;
      case 'discount':
        toggleForm(['#discount-form', '#notes-form'])
        $('#discount').on('keydown', function(){
          calculateDiscountChangeDue()
        })
        break;
      case 'void':
        toggleForm('#notes-form')
        break;
    }
  })

  $('#productID').change(function(){
    var selectedID = $(this).val();
    var subProducts = $(this).find(':selected').data('subs')
    $('#optionID').html('<option disabled="" selected>-- Product Option --</option>')
    subProducts.map((sub) => {
      $('#optionID').append($('<option/>', {
        value: sub.id
      , 'data-product': JSON.stringify(sub)
      , text: sub.name
      }))
    })
    if (selectedID > 1) {
      $('#qty').prop('disabled', false)
      $('#qty-label').html('Quantity')
      $('#qty').prop('disabled', false)
    } else {
      $('#qty').prop('disabled', false)
      $('#qty-label').html('Guests')
    }

    $('#type').prop('disabled', false)

    products.map(function(product){
      if (product.id == selectedID) {
        currentProduct = product
        if ( $('#qty').val() > 0 ) {
          var price = product.price * $('#qty').val()
          var price = Math.round(price * 100) / 100
          $('#total').val(price)
        } else {
          var price = Math.round(product.price * 100) / 100
          $('#total').val(price)
        }
      }
    })
  })

  $('#optionID').change(function(){
    var product = $(this).find(':selected').data('product')
    var price = Math.round(product.price * 100) / 100
    $('#total').val(price)
  })

  $('#qty').on('keyup', function(){
    if ( ! isNaN($(this).val()) ) {
      var price = currentProduct.price * $(this).val()
      var price = Math.round(price * 100) / 100
      $('#total').val(price)
    }
  })

  $('#addSubProduct').click(() => {
    var option = ''
    if ($('#optionID').val() > 0)
      var option = ' (' + $('#optionID').find(':selected').text() + ')'
    var name = $('#productID').find(':selected').text() + option
    var price = $('#total').val()
    var qty = $('#qty').val()
    subProducts = $('#sub-products').data('subProducts') || [];
    subProducts.push({
        name:  name
      , productID: $('#optionID').val()
      , total: $('#total').val()
      , qty: $('#qty').val()
    })
    var i = $('<i/>', {
      class: 'icon-danger glyphicon glyphicon-remove pull-right'
    , 'data-index': (subProducts.length-1)
    , css: {
        color: 'red'
      , cursor: 'pointer'
      }
    }).click((e) => {
      var index = $(e.target).data('index')
      delete subProducts[index]
      $(e.target).parent().fadeOut(2500).delay(100).remove()
      calculateBill()
    })
    var li = $('<li/>', {
      class: 'list-group-item'
    , html: name + ' - $' +  price + ' x ' + qty + ''
    }).append(i)
    $('#sub-products').append(li)
    $('#sub-products').data('subProducts', subProducts)
    calculateBill()
  })

  saleID = 0;

  $("#addSaleForm").on( "submit", function( event ) {
    event.preventDefault();
    if ( ! grandPrice || grandPrice <= 0)
        return;
    if ($('#type').val() == 'cash') {
        var given = parseFloat($('#cash-given').val()).toFixed(2);
        if (parseFloat(given) < parseFloat(grandPrice))
        return;
    }
    if (saleID < 1) {
      var resource = this.getAttribute("data-resource")
      var params = {};
      $.each($(this).serializeArray(), function(_, kv) {
        params[kv.name] = kv.value;
      });
      $.ajax({
        url: url + '/api/v1/sales',
        type: 'post',
        data:  {
          total: totalCost
          , tax: totalTax
          , grand: grandPrice
          , employeeID: params.employeeID
          , corporateID: $('#corporateID').val()
          , notes: $('#notes').val()
        },
        success: function(data){
          console.log("sale data", data);
          if (data.id) {
            saleID = data.id
            processTransaction()
            console.log("saleID set", saleID);
          }
        },
        error: function(data){
          var fields = data.responseJSON
          for (field in fields) {
            var _field = $('#'+field)
            var message = fields[field].toString().replace('i d', 'ID')
            _field.parent().addClass('has-error')
            _field.prop('placeholder', message)
          }
        }
      })
    } else {
      processTransaction()
    }
  });


  function calculateBill(){
    var cost = 0;
    var tax = 0;
    var total = 0;
    subProducts.forEach((product) => {
      cost += parseFloat(product.total)
    })
    tax = cost * saleTax
    var total = (parseFloat(cost) + parseFloat(tax));
    $('#bill-total').html('$' + parseFloat(cost).toFixed(2))
    $('#tax').html('$' + parseFloat(tax).toFixed(2))
    $('#grand-total').html('$' + parseFloat(total).toFixed(2))
    $('#transactionAmount').val(parseFloat(total).toFixed(2))
    totalCost = parseFloat(cost).toFixed(2);
    totalTax = parseFloat(tax).toFixed(2);
    grandPrice = parseFloat(total).toFixed(2);
    calculateChangeDue()
  }

  function updateBill(){
      var due = parseFloat((parseFloat(grandPrice) - parseFloat(transactedAmount))).toFixed(2)
    $('#grand-total').html('$' + due)
    $('#transactionAmount').val('').css({ "border": '#FF0000 1px solid'});
    $('#addSaleForm')[0].reset();
    if (parseFloat(transactedAmount) >= parseFloat(grandPrice)) {
      completeSale()
    }
  }

  function calculateChangeDue(){
    var self = $('#cash-given');
    setTimeout(function(){
      if ( ! isNaN(self.val() ) ) {
        var given = self.val()
        var price = $('#transactionAmount').val();
        if (given > price) {
          $('#change-due').css({
            "font-weight": '300'
          , "color": "#555"
          }).val(parseFloat((given - price)).toFixed(2))
          $('#cash-given').css({
            "font-weight": '300'
          , "color": "#555"
          })
          $('#change-due-label').css({
            "color": "#333"
          })
          $('#change-due-label').html('Change due')
        } else {
          $('#cash-given').css({
            "font-weight": 'bold'
          , "color": "red"
          })
          $('#change-due-label').css({
            "color": "red"
          })
          $('#change-due-label').html('CASH OWED')
          $('#change-due').css({
            "font-weight": 'bold'
          , "color": "red"
      }).val(parseFloat((price - given)).toFixed(2))
        }
        if (given === price) {
          $('#change-due').css({
            "font-weight": '300'
          , "color": "#555"
          }).val(parseFloat((given - price)).toFixed(2))
          $('#cash-given').css({
            "font-weight": '300'
          , "color": "#555"
          })
          $('#change-due-label').css({
            "color": "#333"
          })
        }
      }
    }, 500)
  }

  function calculateDiscountChangeDue(){
    var self = $('#discount');
    setTimeout(function(){
      if ( ! isNaN(self.val() ) ) {
        var given = self.val()
        var price = parseFloat($('#transactionAmount').val());
        if (given > price) {
          $('#discount-change-due').css({
            "font-weight": '300'
          , "color": "#555"
          }).val(given - price)
          $('#cash-given').css({
            "font-weight": '300'
          , "color": "#555"
          })
          $('#discount-change-due-label').css({
            "color": "#333"
          })
          $('#discount-change-due-label').html('Change due')
        } else {
          $('#discount').css({
            "font-weight": 'bold'
          , "color": "red"
          })
          $('#discount-change-due-label').css({
            "color": "red"
          })
          $('#discount-change-due-label').html('CASH OWED')
          $('#discount-change-due').css({
            "font-weight": 'bold'
          , "color": "red"
          }).val(parseFloat((price - given)).toFixed(2))
        }
        if (given === price) {
          $('#discount-change-due').css({
            "font-weight": '300'
          , "color": "#555"
          }).val(parseFloat((given - price)).toFixed(2))
          $('#discount').css({
            "font-weight": '300'
          , "color": "#555"
          })
          $('#discount-change-due-label').css({
            "color": "#333"
          })
        }
      }
    }, 500)
  }

  function processTransaction(){
    var transaction = {
      type: $('#type').val()
      , total: $('#transactionAmount').val()
      , saleID: saleID
    }
    if ((parseFloat(transactedAmount) + parseFloat(transaction.total)) <= grandPrice) {
      console.log("processing transaction", transaction);
      transactedAmount = parseFloat(transaction.total) + transactedAmount;
        $.ajax({
          url: url + '/api/v1/transactions',
          type: 'post',
          data:  transaction,
          success: function(data){
            console.log("sale data", data);
            updateBill()
          },
          error: function(data){
            var fields = data.responseJSON
            for (field in fields) {
              var _field = $('#'+field)
              var message = fields[field].toString().replace('i d', 'ID')
              _field.parent().addClass('has-error')
              _field.prop('placeholder', message)
            }
          }
        })
    } else {
      console.log("over spending");
    }
  }

  function completeSale(){
    console.log("completing sale");
    subProducts.map((product) => {
      console.log('Product', product)
      product.saleID = saleID
      $.ajax({
        url: url + '/api/v1/sold-products',
        type: 'post',
        data:  product,
        success: function(data){
          console.log("sale data", data);
          location.reload()
        },
        error: function(data){
          var fields = data.responseJSON
          for (field in fields) {
            var _field = $('#'+field)
            var message = fields[field].toString().replace('i d', 'ID')
            _field.parent().addClass('has-error')
            _field.prop('placeholder', message)
          }
        }
      })
    })
  }

})




</script>
@endsection
