@extends('admin.layouts.master')

@section('title', 'North Woods Admin Dashboard')

@section('navbar')
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="col-md-6">
                <div class="well well-lg">
                  <span style="display: none;"
                    aria-hidden="true"
                    onclick="addItem()"
                    class="glyphicon glyphicon glyphicon-plus pull-right add-item">
                  </span>
                  <table class="table table-hover">
                      <thead>
                        <tr>
                          <th>Name</th>
                        </tr>
                      </thead>
                      <tbody>
                        @for ($i = 0; $i < count($groups); $i++)
                          <tr id="{{ 'row'.$i }}">
                              <td>{{$groups[$i]->name}}</td>
                          </tr>
                        @endfor
                      </tbody>
                  </table>
                </div>
                <div class="col-md-12 well">
                  <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel">Add New Product Modifier Group</h5>
                  </div>
                  <form id="add-product-modifier-group-form" data-resource="product-modifier-groups">
                    <div class="modal-body">
                      <div class="form-group col-md-12">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Name">
                      </div>
                    </div>
                    <div class="modal-footer">
                      <button type="submit" class="btn btn-success">Add</button>
                    </div>
                  </form>
                </div>
            </div>
            <div class="col-md-6">
                <div class="well well-lg">
                  <span style="display: none;"
                    aria-hidden="true"
                    onclick="addItem()"
                    class="glyphicon glyphicon glyphicon-plus pull-right add-item">
                  </span>
                  <table class="table table-hover">
                      <thead>
                        <tr>
                          <th>Group</th>
                          <th>Name</th>
                        </tr>
                      </thead>
                      <tbody>
                        @for ($i = 0; $i < count($modifiers); $i++)
                          <tr id="{{ 'row'.$i }}">
                              <td>{{$modifiers[$i]->group->name}}</td>
                              <td>{{$modifiers[$i]->name}}</td>
                          </tr>
                        @endfor
                      </tbody>
                  </table>
                </div>
                <div class="col-md-12 well">
                    <div class="modal-header">
                      <h5 class="modal-title" id="myModalLabel">Add New Product Modifier</h5>
                    </div>
                    <form id="add-product-modifier-form" data-resource="product-modifiers">
                      <div class="modal-body">
                        <div class="form-group col-md-6">
                          <label for="product-modifier-group">Name</label>
                          <select name="productModifierGroupID" id="productModifierGroupID" class="form-control">
                            <option disabled="" selected>-- Product Modifier Group --</option>
                          @for ($i = 0; $i < count($groups); $i++)
                            <option value="{{$groups[$i]->id}}">{{$groups[$i]->name}}</option>
                          @endfor
                          </select>
                        </div>
                        <div class="form-group col-md-6">
                          <label for="name">Name</label>
                          <input type="text" class="form-control" id="name" name="name" placeholder="Name">
                        </div>
                      </div>
                      <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Add</button>
                      </div>
                    </form>
                </div>
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
$("#add-product-modifier-group-form").on( "submit", function( event ) {
  event.preventDefault();
  var resource = this.getAttribute("data-resource")
  var params = {};
  $.each($(this).serializeArray(), function(_, kv) {
    params[kv.name] = kv.value;
  });
  if ( params.name.length ) {
    $.ajax({
      url: url + '/api/v1/' + resource,
      type: 'post',
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
  }
});
$("#add-product-modifier-form").on( "submit", function( event ) {
  event.preventDefault();
  var resource = this.getAttribute("data-resource")
  var params = {};
  $.each($(this).serializeArray(), function(_, kv) {
    params[kv.name] = kv.value;
  });
  if ( params.productModifierGroupID && params.name.length ) {
    $.ajax({
      url: url + '/api/v1/' + resource,
      type: 'post',
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
  }
});

</script>
@endsection
