@extends('layouts.master')

@section('title', 'Giant Approval Site Admin Project Details')

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
<link href="/css/lightbox.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.0.1/min/dropzone.min.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.0.1/dropzone.js"></script>
@section('content')
<div class="row">
    <div class="well well-lg">
        <form id="addItemForm" data-resource="projects">
            <div class="form-group col-md-6">
              <h4>{{$project->name}}</h4>
            </div>
            <div class="form-group col-md-6">
              <h4>{{$project->clientID}}</h4>
            </div>
            <div class="form-group col-md-6">
              <h4>{{$project->description}}</h4>
            </div>
            <div class="form-group col-md-12">
                <h4>Assets</h4>
                @foreach ($assets as $asset)
                   <a href="/uploads/{{$asset->name}}" data-lightbox="image-{{$asset->id}}"><img src="/uploads/{{$asset->name}}" class="preview-image img-rounded" /></a>
                @endforeach
            </div>
            <div class="col-md-12">
                <h4>Upload Assets</h4>
                <div class="dropzone" id="dropzoneFileUpload"></div>
            </div>
          <div class="modal-footer">
          </div>
        </form>
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
                <input type="text" class="form-control" name="clientID" id="clientID" placeholder="Client">
              </div>
              <div class="form-group col-md-6">
                <label for="contact">name</label>
                <input type="text" class="form-control" name="name" id="name" placeholder="name">
              </div>
              <div class="form-group col-md-12">
                <label for="description">description address</label>
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
<script src="/js/lightbox.js"></script>
<script type="text/javascript">
    var baseUrl = "{{ url('/') }}";
    var token = "{{ Session::getToken() }}";
    Dropzone.autoDiscover = false;
    var myDropzone = new Dropzone("div#dropzoneFileUpload", {
        url: baseUrl + "/dropzone/uploadFiles",
        params: {
            _token: token,
            clientID:  {{$project->clientID}},
            projectID: {{$project->id}}
        },
        addedfile: function(file) {
            console.log("NEW FILE", file)
        },
    });
    Dropzone.options.myAwesomeDropzone = {
        paramName: "file", // The name that will be used to transfer the file
        maxFilesize: 1000, // MB
        addRemoveLinks: true,
        acceptedFiles: 'audio/*,image/*,video/*',
    };
</script>
@endsection
