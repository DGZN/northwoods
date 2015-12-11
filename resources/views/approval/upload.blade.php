@extends('layouts.master')
<link rel="stylesheet" href="{{ asset('css/dropzone.css') }}">
@section('title', 'Giant Approval Site Admin Dashboard')

@section('navbar')
<div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <a class="navbar-brand" href="#">Giant Approval</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
        <ul class="nav navbar-nav navbar-left api-routes">
          <li><a href="/">Link One</a></li>
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
  <div class="container">
      <div class="dropzone" id="dropzoneFileUpload"></div>
  </div>
@endsection

@section('scripts')
<script src="{{ asset('js/dropzone.js') }}"></script>
<script type="text/javascript">
      var baseUrl = "{{ url('/') }}";
      var token = "{{ Session::getToken() }}";
      Dropzone.autoDiscover = false;
       var myDropzone = new Dropzone("div#dropzoneFileUpload", {
           url: baseUrl+"/uploads",
           params: {
              _token: token
            }
       });
       Dropzone.options.myAwesomeDropzone = {
          paramName: "file", // The name that will be used to transfer the file
          maxFilesize: 2, // MB
          addRemoveLinks: true,
          accept: function(file, done) {

          },
        };
   </script>
@endsection
