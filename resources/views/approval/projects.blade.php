@extends('layouts.master')

@section('title', 'Giant Approval Site Admin Projects')

@section('navbar')
<div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <a class="navbar-brand" href="#">Giant Approval</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
        <ul class="nav navbar-nav navbar-left api-routes">
          <li><a href="/clients">Clients</a></li>
          <li><a href="/projects">Projects</a></li>
        </ul>
        <ul class="nav navbar-nav navbar-right">
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Account <span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li><a href="/auth/logout">Logout</a></li>
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
                      <th>Client</th>
                      <th>Name</th>
                      <th>Description</th>
                      <th>Status</th>
                    </tr>
                  </thead>
                  <tbody>
                    @for ($i = 0; $i < count($projects); $i++)
                      <tr id="{{ 'row'.$i }}">
                          <th scope="row">
                              <a href="/projects/{{$projects[$i]->id}}">{{$projects[$i]->id}}</a>
                          </th>
                          <td>{{$projects[$i]->clientID}}</td>
                          <td>{{$projects[$i]->name}}</td>
                          <td>{{$projects[$i]->description}}</td>
                          <td>{{$projects[$i]->status}}</td>
                          <td>
                              <i class="remove-icon"
                                 onclick="removeItem(this)"
                                 data-row="{{'row'.$i}}"
                                 data-id="{{$projects[$i]->id}}"
                                 data-resource="projects"></i>
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
            <h4 class="modal-title" id="myModalLabel">Add New Project</h4>
          </div>
          <form id="addItemForm" data-resource="projects">
              <div id="errors" class="alert alert-danger" style="display: none;">
                  <ul>
                      @foreach ($errors->all() as $error)
                          <li>{{ $error }}</li>
                      @endforeach
                  </ul>
              </div>
            <input type="hidden" name="adminID" value="{{ Auth::user()->id }}" />
            <div class="modal-body">
              <div class="form-group col-md-6">
                <label for="clientID">Client</label>
                <select id="clientID" name="clientID" class="form-control">
                    @foreach ($clients as $client)
                        <option value="{{$client->id}}">{{$client->company}}</option>
                    @endforeach
                </select>
              </div>
              <div class="form-group col-md-6">
                <label for="contact">Name</label>
                <input type="text" class="form-control" name="name" id="name" placeholder="name">
              </div>
              <div class="form-group col-md-12">
                <label for="description">Description</label>
                <textarea class="form-control" name="description" id="description" placeholder="description"></textarea>
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
$(function(){

})
</script>
@endsection
