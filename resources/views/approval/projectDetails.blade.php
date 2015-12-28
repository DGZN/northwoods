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

            <div class="form-group col-md-6">
              <h4>{{$project->name}}</h4>
            </div>
            @if ($project->status == "0")
              <div class="form-group col-md-2 pull-right">
                <input id="approve" data-projectID="{{$project->id}}" type="button" name="approve" value="Approve" class="form-control btn-sm btn-primary" />
              </div>
            @endif
            <div class="form-group col-md-6">
              <h5>{{$project->clientID}}</h5>
            </div>
            <div class="form-group col-md-12">
              <h5>{{$project->description}}</h5>
            </div>
            <div class="form-group col-md-12">
                <h5>Assets</h5>
				        @foreach ($project->assets as $asset)
                   <div class="asset pull-left">
                   @if ($asset->type() == 'image')
                      <a href="/uploads/{{$asset->name}}" data-lightbox="image-{{$asset->id}}">
                          <div
                            class="preview-image img-rounded"
                            style="background-image: url(/uploads/{{$asset->name}});">
                          </div>
                      </a>
                  @elseif ($asset->type() == 'video')
                      <div class="preview-image img-rounded" style="background-image: url(/uploads/{{$asset->thumb}});">
                        <span class="glyphicon glyphicon-play play-hover" onclick="playVideo('{{$asset->name}}')"></span>
                      </div>
                  @endif
                      <ul class="list-group asset-notes">
                        @foreach ($asset->notes as $note)
                          <li class="list-group-item">{{ $note->note }}</li>
                        @endforeach
                        <form class="addNoteForm" data-projectID="{{$project->id}}" data-assetID="{{$asset->id}}">
                          <input type="text" class="form-control" name="note" placeholder="Enter your note" />
                          <button type="submit" class="btn btn-primary pull-right">Submit</button>
                        </form>
                      </ul>
                  </div>
                @endforeach
            </div>
            <div class="col-md-12">
                <h5>Upload Assets</h5>
                <div class="dropzone" id="dropzoneFileUpload"></div>
            </div>
          <div class="modal-footer">
          </div>
    </div>
    </div>

    <div class="modal fade" id="videoPreview" tabindex="-1" role="dialog" aria-labelledby="videoPreviewLabel">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
              <video id="videoPlayer" width="578" height="330" controls>
              Your browser does not support the video tag.
              </video>
            </div>
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
        },
    });
    myDropzone.on("complete", function (file) {
      if (myDropzone.getUploadingFiles().length === 0 && myDropzone.getQueuedFiles().length === 0) {
        console.log("All Are Done");
        location.reload()
      }
    });
    Dropzone.options.myAwesomeDropzone = {
        paramName: "file", // The name that will be used to transfer the file
        maxFilesize: 1000, // MB
        addRemoveLinks: true,
        acceptedFiles: 'audio/*,image/*,video/*',
    };
    $(".addNoteForm").on( "submit", function( event ) {
      event.preventDefault();
      var projectID = this.getAttribute("data-projectID")
      var assetID   = this.getAttribute("data-assetID")
      var params = {};
      $.each($(this).serializeArray(), function(_, kv) {
        params[kv.name] = kv.value;
      });
      $.ajax({
        url: url + '/api/projects/'  + projectID + '/assets/' + assetID + '/notes',
        type: 'post',
        data:  params,
        success: function(data){
          location.reload()
        },
        error: function(error){
          console.error("!Error!", error)
        }
      })
    });
    $("#approve").click(function(){
      event.preventDefault();
      var projectID = this.getAttribute("data-projectID")
      $.ajax({
        url: url + '/api/projects/'  + projectID,
        type: 'put',
        data:  {
          "status": 1
        },
        success: function(data){
          console.log("Project Approved", data);
        }
      })
    });
</script>
@endsection
