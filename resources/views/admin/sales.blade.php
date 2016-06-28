@extends('admin.layouts.master')

@section('title', 'North Woods Admin Dashboard')

@section('navbar')

@endsection

@section('content')
    <style>
    #add-payment {
      position: relative;
      top: -10px;
      float: right;
      display: block;
      color: #5cb85c;
      font-size: 2.4rem;
      cursor: pointer;
    }
    </style>
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
          <div class="well well-lg">
            <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
              <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingOne">
                  <h4 class="panel-title">
                    <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                      New Sale
                    </a>
                  </h4>
                </div>
                <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                    <div class="panel-body">
                        <div class="modal-content">
                          <div class="modal-header">
                            <div class="row">
                              <div class="col-md-12">
                                <select class="form-control" id="groupID" name="groupID">
                                  <option value="" selected="" disabled="">-- Product Group --</option>
                                  @for ($i = 0; $i < count($groups); $i++)
                                  <option value="{{$groups[$i]->id}}" data-scheduled="{{$groups[$i]->scheduled}}" data-types="{{$groups[$i]->types}}">{{$groups[$i]->name}}</option>
                                  @endfor
                                </select>
                              </div>
                            </div>
                            </br>
                            <div class="row">
                              <div class="col-md-12">
                                <select class="form-control hidden-fields" id="typeID" name="typeID">
                                  <option value="" selected="" disabled="">-- Product Type --</option>
                                </select>
                              </div>
                            </div>
                            </br>
                            <div class="row">
                              <div class="col-md-12">
                                <select class="form-control hidden-fields" id="productID" name="productID">
                                  <option value="" selected="" disabled="">-- Product --</option>
                                </select>
                                </br>
                                </br>
                                <div class="small well hidden-fields" id="product-modifiers">

                                </div>
                              </div>
                            </div>
                            <div id="quanity-fields" class="row  hidden-fields">
                              <div class="col-md-6">
                                <label id="qty-label" for="qty">Quantity</label>
                                <input type="text" id="qty" class="form-control" value="1" />
                              </div>
                              <div class="col-md-6">
                                </br>
                                <input id="addSubProduct" type="button" class="form-control btn btn-success" value="Add" />
                              </div>
                            </div>
                          </div>
                        </div>
                    </div>
                  </div>
                </div>
                <div class="panel panel-default">
                  <div class="panel-heading" role="tab" id="headingTwo">
                    <h4 class="panel-title">
                      <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                        Bill
                      </a>
                    </h4>
                  </div>
                  <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                    <div class="panel-body">
                      <div class="form-group col-md-12">
                        <div class="small well" id="bill-fields">
                          <table class="table table-condensed">
                            <thead>
                              <tr>
                                <th>Item</th>
                                <th>Quantity</th>
                                <th>Options</th>
                                <th>Each</th>
                                <th>Line Total</th>
                                <th></th>
                              </tr>
                            </thead>
                            <tbody id="sub-products"  data-subProducts=[]>

                            </tbody>
                          </table>
                          <div class="small well">
                              <div class="row form-group">
                                  <div class="col-md-12">
                                      <h5 class="pull-right">Subtotal: <span id="bill-total" class="total">$0.00</span> </h5>
                                  </div>
                                  <div class="col-md-12">
                                      <h5 class="pull-right">Tax: <span id="tax" class="tax">$0.00</span> </h5>
                                  </div>
                                  <div class="col-md-12">
                                      <h4 class="pull-right">Total Due: <span id="grand-total" class="grand-total">$0.00</span> </h4>
                                  </div>
                              </div>
                          </div>
                          <div class="small well">
                              <div class="row form-group">
                                  <div class="col-md-12">
                                      <h5 class="pull-right">Payments <span id="add-payment" >+</span> </h5>
                                  </div>
                                  <div class="col-md-12">
                                      <hr>
                                      <div id="transactions">

                                      </div>
                                  </div>
                                  <div class="col-md-12">
                                      <h4 class="pull-right">Ballance: <span id="ballance" class="grand-total">$0.00</span> </h4>
                                  </div>
                              </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="panel panel-default">
                  <div class="panel-heading" role="tab" id="headingThree">
                    <h4 class="panel-title">
                      <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                        Payment
                      </a>
                    </h4>
                  </div>
                  <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
                    <div class="panel-body">
                      <div class="col-md-12">
                          <div class="well well-lg" style="height: 120px;">
                            <label for="transactionAmount">Transaction Amount</label>
                            <input type="text" id="transactionAmount" name="transactionAmount" class="form-control" placeholder="" value="0">
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
                                  <div id="notes-form" class="form-group col-md-12">
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
                    </div>
                  </div>
                </div>
              </div>
            </div>
        </div>

    </div>

@endsection

@section('scripts')
<script src="/js/sale.js"></script>
<script src="/js/product.js"></script>
<script style="text/javascript">

const employee = {!! json_encode(Auth::user()) !!}

const sale = new Sale(employee, {{$settings->state_tax}});

const product = new Product();

var customers = {!! json_encode($customers) !!}.map(function(data){
  return {
    id: data.customer.id
  , name: data.customer.first_name + ' ' + data.customer.last_name
  }
})

$(function(){

  const UUID = window.location.href.split('UUID=')

  if (UUID.length > 0) {

      $('#notes').val('Reservation ID: ' + UUID[1])

  }

  /* New Sale Tab */

  $('#groupID').change(() => {
    $('#typeID').html('<option value="" selected="" disabled="">-- Product Type --</option>')
    $(this).find(":selected").data('types').forEach((type) => {
      console.log("type", type);
      $('#typeID').append('<option value="'+type.id+'">'+type.name+'</option>')
    })
    $('#typeID').fadeIn(200)
  })

  $('#typeID').change(() => {
    $('#productID').html('<option value="" selected="" disabled="">-- Product --</option>')
    product.getProductsByType($('#typeID').val(), (products) => {
      products.forEach((product) => {
        $('#productID').append('<option value="'+product.id+'" data-price="'+product.price+'">'+product.name+'</option>')
      })
      $('#productID').fadeIn(200)
    })
  })

  $('#productID').change(() => {
    $('#product-modifiers').html('')
    product.byID($('#productID').val(), (modifiers) => {
      for (var modifier in modifiers) {
        $('#product-modifiers').append('<label for="modiferID">Option - '+modifier+'</label>         \
          <select class="form-control" id="'+modifier+'-modifiers" name="'+modifier+'-modifiers">  \
            </select></br>')

          for (type in modifiers[modifier]) {

            $('#'+modifier+'-modifiers').append('<option value="'+modifiers[modifier][type].id+'" data-price="'+modifiers[modifier][type].price+'">'+modifiers[modifier][type].name+'</option>')

          }

      }
      $('#product-modifiers').fadeIn(250)
      $('#quanity-fields').fadeIn(250)
    })
  })

  var modifiers = []

  $('#addSubProduct').click(() => {
    var modifiers = []
    var total = 0;
    var modifierPriceAdjustment = 0;
    var name = $('#productID').find(':selected').text()
    var price = $('#productID').find(':selected').data('price')
    var qty = $('#qty').val()
    $('#product-modifiers').find('select').each((i, select) => {
      var modifier = {
        id: $(select).val()
      , name: $(select).find(':selected').text()
      , price: $(select).find(':selected').data('price')
      }
      modifierPriceAdjustment += parseFloat($(select).find(':selected').data('price'))
      modifiers.push(modifier)
    })
    var unitPriceAdjustment = (modifierPriceAdjustment + price)
    var total = parseFloat((unitPriceAdjustment * qty)).toFixed(2)
    sale.setLineItem({
        name:  name
      , productID: $('#productID').val()
      , qty: qty
      , unitPrice: parseFloat(price).toFixed(2)
      , total: parseFloat(total).toFixed(2)
      , modifierPriceAdjustment: modifierPriceAdjustment
      , modifiers: modifiers
    })
    var tr = '<tr>                                                            \
               <th scope="row">'+name+'</th>                                  \
               <td>'+qty+'</td>                                               \
               <td>'+modifiers.map((m) => {return ' ' + m.name })+'</td>      \
               <td>$'+parseFloat(unitPriceAdjustment).toFixed(2)+'</td>                     \
               <td>$'+parseFloat(total).toFixed(2)+'</td>                     \
               <td><i class="remove-sub-product icon-danger glyphicon glyphicon-remove pull-right" data-index="'+(sale.lineItems.length - 1)+'"></i></td>\
             </tr>'
    $('#sub-products').append(tr)
    // $('#collapseOne').collapse('toggle')
    // $('#collapseTwo').collapse('toggle')
    $('#sub-products').off()
    $('#sub-products .remove-sub-product').click((e) => {
      var index = $(e.target).data('index')
      sale.removeLineItem(index)
      $(e.target).parent().parent().fadeOut(2500).delay(100).remove()
      sale.calculateBill((bill) => {
        updateTotalPanel(bill)
      })
    })
    sale.calculateBill((bill) => {
      updateTotalPanel(bill)
    })
  })

  var forms = [
      '#cash-payment-form'
    , '#customer-form'
    , '#credit-card-form'
    , '#check-payment-form'
    , '#certificate-payment-form'
    , '#corporate-payment-form'
    , '#discount-form'
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
        $('#cash-given').off().on('keydown', function(){
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
          sale.calculateDiscountChangeDue()
        })
        break;
      case 'void':
        toggleForm('#notes-form')
        break;
    }
  })

  /* Add Sale Form */

  function updateTotalPanel(bill) {
    $('#bill-total').html('$' + parseFloat(bill.cost).toFixed(2))
    $('#tax').html('$' + parseFloat(bill.tax).toFixed(2))
    $('#grand-total').html('$' + parseFloat(bill.grand).toFixed(2))
    $('#ballance').html('$' + parseFloat(bill.grand).toFixed(2))
    $('#transactionAmount').val(parseFloat(bill.grand).toFixed(2))
  }

  function updateBill(bill) {
    var grandTotal = parseFloat(bill.grand);
    var due = parseFloat((parseFloat(bill.grand) - parseFloat(bill.transactedAmount))).toFixed(2)
    $('#ballance').html('$' + due)
    $('#transactionAmount').val('').css({ "border": '#FF0000 1px solid'});
    $('#addSaleForm')[0].reset();
    if (parseFloat(bill.transactedAmount) == parseFloat(bill.grand)) {
      sale.completeSale((errors, sale) => {
        if (errors) {
          for (field in errors) {
            var _field = $('#'+field)
            var message = errors[field].toString().replace('i d', 'ID')
            _field.parent().addClass('has-error')
            _field.prop('placeholder', message)
          }
        } else {
          location.reload()
        }
      })
    }
    updateTransactions()
  }

  function updateTransactions() {
    $('#transactions').html('')
    sale.transactions.map((transaction) => {
      $('#transactions').append('<h5 class="pull-right">'+transaction.type+': <span id="tax" class="tax">$'+transaction.total+'</span> </h5>')
    })
    $('#collapseTwo').collapse('toggle')
    $('#collapseThree').collapse('toggle')
  }

  function calculateChangeDue() {
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
    }, 100)
  }

  $("#addSaleForm").on( "submit", function( event ) {
    event.preventDefault();
    if ( parseFloat(sale.grandTotal) <= 0 )
      return;
    if ($('#type').val() == 'cash') {
        var given = parseFloat($('#cash-given').val()).toFixed(2);
        var transactionPrice = parseFloat($('#transactionAmount').val()).toFixed(2)
        if (parseFloat(given) < parseFloat(transactionPrice)) {
          $('#cash-given').parent().addClass('has-error')
          return;
        } else {
          $('#cash-given').parent().removeClass('has-error')
        }
    }
    if (sale.saleID < 1) {
      var resource = this.getAttribute("data-resource")
      var params = {};
      $.each($(this).serializeArray(), function(_, kv) {
        params[kv.name] = kv.value;
      });
      sale.createSale({
        notes: $('#notes').val() || null
      , corporateID: $('#corporateID').val() || null
      }, (fields) => {
        if (fields) {
          for (field in fields) {
            var _field = $('#'+field)
            var message = fields[field].toString().replace('i d', 'ID')
            _field.parent().addClass('has-error')
            _field.prop('placeholder', message)
          }
        } else {
          sale.processTransaction({
            type: $('#type').val()
          , total: $('#transactionAmount').val()
        }, (errors, transaction) => {
          if (errors) {
            for (field in errors) {
              var _field = $('#'+field)
              var message = errors[field].toString().replace('i d', 'ID')
              _field.parent().addClass('has-error')
              _field.prop('placeholder', message)
            }
          } else {
            console.log("Transaction Succesfull", transaction);
            updateBill(sale.bill)
          }
        })
        }
      });
    } else {
      sale.processTransaction({
        type: $('#type').val()
      , total: $('#transactionAmount').val()
      }, (errors, transaction) => {
        if (errors) {
          for (field in errors) {
            var _field = $('#'+field)
            var message = errors[field].toString().replace('i d', 'ID')
            _field.parent().addClass('has-error')
            _field.prop('placeholder', message)
          }
        } else {
          console.log("Transaction Succesfull", transaction);
          updateBill(sale.bill)
        }
      })
    }
  });

  $('#add-payment').click(function(){
    $('#collapseTwo').collapse('toggle')
    $('#collapseThree').collapse('toggle')
  })
})

</script>
@endsection
