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
        <div class="col-md-6 col-md-offset-3">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Add New Product</h4>
              </div>
              <form id="addProductForm" data-resource="products">
                <div class="modal-body">
                  <div class="form-group col-md-6">
                    <label for="group">Product Group</label>
                    <select class="form-control" id="groupID" name="groupID">
                      <option value="" selected="" disabled="">-- Product Group --</option>
                      @for ($i = 0; $i < count($groups); $i++)
                      <option value="{{$groups[$i]->id}}" data-scheduled="{{$groups[$i]->scheduled}}" data-types="{{$groups[$i]->types}}">{{$groups[$i]->name}}</option>
                      @endfor
                    </select>
                  </div>
                  <div class="form-group col-md-6">
                    <label for="typeID">Product Type</label>
                    <select class="form-control" id="typeID" name="typeID">
                      <option value="" selected="" disabled="">-- Product Type --</option>
                    </select>
                  </div>
                  <div class="form-group col-md-6">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Name">
                  </div>
                  <div class="form-group col-md-6">
                    <label for="price">Price</label>
                    <input type="text" class="form-control" id="price" name="price" placeholder="Price">
                  </div>
                  <div id="product-schedule-fields" style="display: none;">
                    <div class="form-group col-md-6">
                      <label for="timeID">Time</label>
                      <select class="form-control" id="timeID" name="timeID">
                        <option value="" selected="" disabled="">-- Start Time --</option>
                        @for ($i = 0; $i < count($times); $i++)
                          <option value="{{$times[$i]->id}}">{{$times[$i]->name}}</option>
                        @endfor
                      </select>
                    </div>
                  </div>
                  <div id="product-modifier-fields" style="display: none;">
                    <div class="col-md-12 well">
                        <h6>SUB PRODUCTS LIST</h6>
                        <ul class="list-group" id="sub-products" data-subProducts=[] >

                        </ul>
                    </div>
                    <div class="form-group well">
                        <h5>Sub Products</h5>
                        <div class="well form-group" style="min-height: 75px;">
                            <div class="form-group col-md-4">
                                <select name="productModifierGroupID" id="productModifierGroupID" class="form-control">
                                  <option disabled="" selected>-- Product Modifier Group --</option>
                                @for ($i = 0; $i < count($modifierGroups); $i++)
                                  <option value="{{$modifierGroups[$i]->id}}" data-modifiers="{{$modifierGroups[$i]->modifiers}}">{{$modifierGroups[$i]->name}}</option>
                                @endfor
                                </select>
                            </div>
                            <div class="form-group col-md-3">
                                <select name="productModifierID" id="productModifierID" class="form-control">
                                  <option disabled="" selected>-- Product Modifier --</option>
                                </select>
                            </div>
                            <div class="form-group col-md-2">
                              <input type="text" class="form-control" id="subTotal" name="subTotal" placeholder="Price">
                            </div>
                            <div class="form-group col-md-2">
                              <input type="text" class="form-control" id="subStock" name="subStock" placeholder="Qty">
                            </div>
                            <div class="col-md-1">
                                <button id="addSubProduct" type="button" class="btn btn-success">Add</button>
                            </div>
                        </div>
                    </div>
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="submit" class="btn btn-primary">Save</button>
                </div>
              </form>
            </div>
        </div>
    </div>
    <br/>
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="well well-lg">
              <span
                aria-hidden="true"
                onclick="addItem()"
                class="glyphicon glyphicon glyphicon-plus pull-right add-item">
              </span>
              <table class="table table-hover">
                  <thead>
                    <tr>
                      <th>Group</th>
                      <th>Type</th>
                      <th>Name</th>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody>
                    @for ($i = 0; $i < count($products); $i++)
                      @if ($products[$i]->parentID == 0)
                        <tr id="{{ 'row'.$i }}">
                            <td scope="row">{{$products[$i]->group->name or '--'}}</td>
                            <td>{{$products[$i]->type->name}}</td>
                            <td>{{$products[$i]->name}}
                              <h6>{{$products[$i]->substext()}}</h6>
                            </td>
                            <td>${{number_format($products[$i]->price, 2)}}</td>
                        </tr>
                      @endif
                    @endfor
                  </tbody>
              </table>
            </div>
        </div>
    </div>

    <div class="modal fade" id="addItemModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog" role="document">

      </div>
    </div>

@endsection

@section('scripts')
<script style="text/javascript">
subProducts = [];
$(function(){
  $('#groupID').change(() => {
    var group = $(this).find(":selected");
    if (group.data('scheduled')) {
      $('#product-modifier-fields').fadeOut(150)
      $('#product-schedule-fields').fadeIn(250)
      console.log("showing time");
    } else {
        console.log("showing modifiers");
      $('#product-schedule-fields').fadeOut(150)
      $('#product-modifier-fields').fadeIn(250)
    }
    $('#typeID').html('<option value="" selected="" disabled="">-- Product Type --</option>')
    group.data('types').forEach((type) => {
      $('#typeID').append('<option value="'+type.id+'">'+type.name+'</option>')
    })
  })
  $('#productModifierGroupID').change(() => {
     var group = $('#productModifierGroupID').find(':selected')
     if (group.data('modifiers')) {
       $('#productModifierID').html('<option value="" selected="" disabled="">-- Product Modifier --</option>')
       group.data('modifiers').forEach((modifier) => {
         $('#productModifierID').append('<option value="'+modifier.id+'">'+modifier.name+'</option>')
       })
     }
  })
  $('#addSubProduct').click(() => {
    var modifierGroup = $('#productModifierGroupID').find(':selected').text()
    var modifier = $('#productModifierID').find(':selected').text()
    var subTotal = $('#subTotal').val()
    var subStock = $('#subStock').val()
    subProducts = $('#sub-products').data('subProducts') || [];
    subProducts.push({
        modifierID:  $('#productModifierID').find(':selected').val()
      , groupID: $('#groupID').val()
      , name: $('#productModifierID').find(':selected').text()
      , price: subTotal
      , stock: subStock
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
    })
    var li = $('<li/>', {
      class: 'list-group-item'
    , html: modifier + ' - $' +  subTotal + ' (' + subStock + ')'
    }).append(i)
    $('#sub-products').append(li)
    $('#sub-products').data('subProducts', subProducts)
  })
  $("#addProductForm").on( "submit", function( event ) {
    event.preventDefault();
    var resource = this.getAttribute("data-resource")
    var params = {};
    $.each($(this).serializeArray(), function(_, kv) {
      params[kv.name] = kv.value;
    });
    $.ajax({
      url: url + '/api/v1/' + resource,
      type: 'post',
      data:  params,
      success: function(data){
        if (data.id) {
          subProducts.forEach((sub) => {
            sub['name'] = sub.name
            sub['groupID'] = sub.groupID
            sub['modifierID'] = sub.modifierID
            sub['parentID'] = data.id
            $.ajax({
              url: url + '/api/v1/' + resource + '/' + data.id,
              type: 'post',
              data:  sub,
              success: function(data){
              }
            })
          })
          location.reload()
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
  });
})
function bindSubProductionRemov(){
  $('.remove-sub-product').off()
  $('.remove-sub-product').on('click', function(){
    console.log("test");
  })
}
function removeSubProduct(index){
  delete subProducts[index]
  $('#sub-products').data('subProducts', subProducts)
  console.log(arguments);
}

</script>
@endsection
