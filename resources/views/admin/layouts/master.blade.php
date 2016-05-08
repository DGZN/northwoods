<!DOCTYPE html>
<html>
    <head>
        <title>@yield('title')</title>

        <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">
        <link rel="stylesheet" href="/css/pickaday.css">
        <style>
            html, body {
                height: 100%;
            }

            body {
                margin: 0;
                padding: 0;
                width: 100%;
                display: table;
                /*font-family: 'Lato';*/
                background-image: url('/images/panel_bck.jpg');
            }

            .content {
                text-align: center;
                padding-top: 20px;
            }

            .title {
                font-size: 46px;
            }

            .navbar-header {
                font-weight: 20px;
                font-weight: 900;
                font-family: 'Lato', sans-serif !important;
            }

            .api-routes {
                font-size: 16px;
                font-weight: 300 !important;
                /*font-family: 'Lato', sans-serif !important;*/
            }

            .remove-icon {
                position: relative;
                font-size: 12px;
                margin: 1px 5px 2px 5px;
            }

            .remove-icon:before, .remove-icon:after {
                position: absolute;
                background: red;
                height: 12px;
                width: 2px;
                content: "";
                cursor: pointer;
            }

            .remove-icon:before {
                height: 12px;
                left: 14px;
                top: 5px;
                transform: rotate(-45deg);
            }

            .add-item {
                position: relative;
                font-size: 12px;
                margin: 1px 5px 2px 5px;
                color: #5cb85c;
                cursor: pointer;
            }

            .well {
              background: white;
            }

            .table {
              color: black;
            }

            .remove-icon:after {
                height: 12px;
                right: -15px;
                top: 5px;
                transform: rotate(45deg);
            }

            .confirmRemoveModal-content {
              width: 420px !important;
            }

            .modal-footer {
              border-top: 0px !important;
            }

            tbody>tr>td {
              cursor: pointer;
            }

            .hidden-fields {
              display: none;
            }
        </style>
    </head>
    <body>
        <nav class="navbar navbar-default">
          <div class="container-fluid">
              <!-- Brand and toggle get grouped for better mobile display -->
              <div class="navbar-header">
                <a class="navbar-brand" href="#">North Woods Admin</a>
              </div>

              <!-- Collect the nav links, forms, and other content for toggling -->
              <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                  <ul class="nav navbar-nav navbar-left api-routes">
                    <li><a href="/admin/sales">Sale</a></li>
                    <li><a href="/admin/reservations">Reservations</a></li>
                    <ul class="nav navbar-nav">
                        <li class="dropdown">
                          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Admin <span class="caret"></span></a>
                          <ul class="dropdown-menu">
                            <li><a href="/admin/sales-history">Sale History</a></li>
                            <li><a href="/admin/corporate-accounts">Corporate Accounts</a></li>
                            <li><a href="/admin/products">Products</a></li>
                            <li><a href="/admin/product-groups">Product Groups</a></li>
                            <li><a href="/admin/product-types">Product Types</a></li>
                            <li><a href="/admin/product-modifiers">Product Modifiers</a></li>
                            <li><a href="/admin/tour-times">Tour Times</a></li>
                            <li><a href="/admin/employees">Employees</a></li>
                            <li><a href="/admin/customers">Customers</a></li>
                            <li><a href="/admin/settings">Settings</a></li>
                          </ul>
                        </li>
                    </ul>
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
        </nav>
        <div class="container-fluid">
            @yield('content')
        </div>

        <div class="modal fade" id="confirmRemoveModal" tabindex="-1" role="dialog" aria-labelledby="confirmRemoveModalLabel">
          <div class="modal-dialog" role="document">
            <div class="modal-content confirmRemoveModal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="confirmRemoveModalLabel">:: Confirmation PIN ::</h4>
                <h5>Enter override PIN to delete this record</h5>
                <div id="pin-warning" class="form-group">
                  <label id="pin-label" class="control-label" for="pin" style="display: none;">Incorrect PIN</label>
                  <input class="form-control" type="password" placeholder="-- Manager Overide PIN" name="pin" id="pin" />
                </div>
              </div>
                <div class="modal-footer">
                  <form>
                    <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                    <button type="submit" id="confirmRemoveButton" onclick="confirmRemove()" class="btn btn-danger">Yes</button>
                  </form>
                </div>
            </div>
          </div>
        </div>

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
        <script src="/js/moment.min.js"></script>
        <script src="/js/pickaday.js"></script>
        <script src="/js/typeahead.js"></script>
    <script>
    var path = location.href.split( '/' );
    var url = path[0] + '//' + path[2];
    function addItem(){
      $('#addItemModal').modal()
    }
    $("#addItemForm").on( "submit", function( event ) {
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
    var remove = false,
    removing;
    function removeItem(item){
      var id = item.getAttribute("data-id")
      var row = item.getAttribute("data-row")
      var resource = item.getAttribute("data-resource")
      if (!remove){
        removing = item
        $('#confirmRemoveModal').modal({backdrop: 'static', keyboard: false})
        return;
      } else {
        $('#confirmRemoveModal').modal({backdrop: 'static', keyboard: false})
        //$('#confirmRemoveModal').modal('toggle')
      }
      $.ajax({
        url: url + '/api/v1/' + resource + '/' + id,
        type: 'post',
        data: {_method: 'delete'},
        success: function(data){
          $('#'+row).remove()
          location.reload()
        }
      })
    }
    function confirmRemove(){
      if ($('#pin').val() == '80110') {
        remove = true
        return removeItem(removing)
      } else {
        $('#has-warning').addClass('has-warning')
        $('#pin-label').show(250)
      }
    }
    </script>
    @yield('scripts')
    </body>
</html>
