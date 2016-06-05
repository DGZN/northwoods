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
                    <div class="col-md-3">
                      <h6>Name</h6>
                      <span style="font-weight: bold;">{{$product->name or ''}}</span>
                    </div>
                    <div class="col-md-3">
                      <h6>Group</h6>
                      <span style="font-weight: bold;">{{$product->group->name or ''}}</span>
                    </div>
                    <div class="col-md-3">
                      <h6>Type</h6>
                      <span style="font-weight: bold;">{{$product->type->name or ''}}</span>
                    </div>
                    <div class="col-md-3">
                      <h6>Price</h6>
                      <span style="font-weight: bold;">${{number_format($product->price, 2)}}</span>
                    </div>
                    <div class="col-md-6">
                      <h6>
                        Modifiers
                      </h6>
                      <ul class="list-group" id="tour-group">
                          @for ($i = 0; $i < count($product->modifiers); $i++)
                            <li class="list-group-item">
                              <h6>{{$product->modifiers[$i]->type->name or ''}} <span>${{$product->modifiers[$i]->price or ''}}</span> </h6>
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
    <div class="row">
        <div class="col-md-6  col-md-offset-3">
            <div class="well well-lg">
              <h4>Edit Product</h4>
              <div class="row">
                <div class="col-md-12">
                  <div class="row">
                    <div class="col-md-4">
                      <h6>Name</h6>
                      <span style="font-weight: bold;">{{$product->name or ''}}</span>
                    </div>
                    <div class="col-md-4">
                      <h6>Group</h6>
                      <span style="font-weight: bold;">{{$product->group->name or ''}}</span>
                    </div>
                    <div class="col-md-4">
                      <h6>Type</h6>
                      <span style="font-weight: bold;">{{$product->type->name or ''}}</span>
                    </div>
                 </div>
                 <div class="row">
                   <br>
                 </div>
                 <form id="addProductModifierForm" data-resource="products/{{$product->id}}">
                   <input type="hidden" name="productID" value="{{$product->id}}" >
                   <div class="row">
                      <div class="col-md-5">
                        <h6>
                          Modifier Groups
                        </h6>
                        <select name="productModifierGroupID" id="productModifierGroupID" class="form-control">
                          <option disabled="" selected>-- Product Modifier Group --</option>
                          @for ($i = 0; $i < count($modifierGroups); $i++)
                          <option value="{{$modifierGroups[$i]->id}}" data-modifiers="{{$modifierGroups[$i]->modifiers}}">{{$modifierGroups[$i]->name}}</option>
                          @endfor
                        </select>
                      </div>
                      <div class="col-md-4">
                        <h6>
                          Modifiers
                        </h6>
                        <select name="productModifierID" id="productModifierID" class="form-control">
                          <option disabled="" selected>-- Product Modifier --</option>
                        </select>
                      </div>
                      <div class="col-md-3">
                        <h6>
                          Price Adjustment
                        </h6>
                        <div class="input-group">
                          <span class="input-group-addon">$</span>
                          <input type="text" class="form-control" aria-label="Amount (to the nearest dollar)" name="price">
                        </div>
                      </div>
                      <div class="col-md-12">
                        </br>
                        <button id="addSubProduct" type="submit" class="btn btn-success   pull-right">Add</button>
                      </div>
                    </div>
                </form>
                </div>
              </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
$('#productModifierGroupID').change(() => {
   var group = $('#productModifierGroupID').find(':selected')
   if (group.data('modifiers')) {
     $('#productModifierID').html('<option value="" selected="" disabled="">-- Product Modifier --</option>')
     group.data('modifiers').forEach((modifier) => {
       $('#productModifierID').append('<option value="'+modifier.id+'">'+modifier.name+'</option>')
     })
   }
})

$("#addProductModifierForm").on( "submit", function( event ) {
  event.preventDefault();
  var resource = this.getAttribute("data-resource")
  var params = {};
  $.each($(this).serializeArray(), function(_, kv) {
    params[kv.name] = kv.value;
  });
  $.ajax({
    url: url + '/api/v1/' + resource,
    type: 'PUT',
    data:  params,
    success: function(data){
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
});
</script>
@endsection
