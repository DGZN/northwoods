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
                      <th>Name</th>
                      <th>Description</th>
                      <th>Price</th>
                      <th>Group</th>
                      <th>Type</th>
                      <th style="text-align: center;">Stock</th>
                      <th style="text-align: center;">SKU</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    @for ($i = 0; $i < count($products); $i++)
                      <tr id="{{ 'row'.$i }}">
                          <th scope="row">{{$products[$i]->id}}</th>
                          <td>{{$products[$i]->name}}</td>
                          <td>{{$products[$i]->description}}</td>
                          <td>${{$products[$i]->price}}</td>
                          <td>{{$products[$i]['groupName']}}</td>
                          <td>{{$products[$i]['typeName']}}</td>
                          <td style="text-align: center;">
                            {{
                              $products[$i]->stock != "0" ? $products[$i]->stock : ''
                            }}
                          </td>
                          <td style="text-align: center;">
                            {{
                              $products[$i]->SKU != "0" ? $products[$i]->SKU : ''
                            }}
                          </td>
                          <td>
                              <i class="remove-icon"
                                 onclick="removeItem(this)"
                                 data-row="{{'row'.$i}}"
                                 data-id="{{$products[$i]->id}}"
                                 data-resource="products"></i>
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
            <h4 class="modal-title" id="myModalLabel">Add New Product</h4>
          </div>
          <form id="addItemForm" data-resource="products">
            <div class="modal-body">
              <div class="form-group col-md-6">
                <label for="name">Name</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Name">
              </div>
              <div class="form-group col-md-6">
                <label for="price">Price</label>
                <input type="text" class="form-control" id="price" name="price" placeholder="Price">
              </div>
              <div class="form-group col-md-12">
                <label for="description">Description</label>
                <textarea id="description" class="form-control" name="description" rows="3"></textarea>
              </div>
              <div class="form-group col-md-6">
                <label for="group">Product Group</label>
                <select class="form-control" id="groupID" name="groupID">
                  @for ($i = 0; $i < count($groups); $i++)
                    <option value="{{$groups[$i]->id}}">{{$groups[$i]->name}}</option>
                  @endfor
                </select>
              </div>
              <div class="form-group col-md-6">
                <label for="group">Product Type</label>
                <select class="form-control" id="groupID" name="typeID">
                  @for ($i = 0; $i < count($types); $i++)
                    <option value="{{$types[$i]->id}}">{{$types[$i]->name}}</option>
                  @endfor
                </select>
              </div>
              <div class="form-group col-md-6">
                <label for="stock">Stock</label>
                <input type="text" class="form-control" id="stock" name="stock" placeholder="Stock">
              </div>
              <div class="form-group col-md-6">
                <label for="sku">SKU</label>
                <input type="text" class="form-control" id="sku" name="SKU" placeholder="SKU">
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

</script>
@endsection
