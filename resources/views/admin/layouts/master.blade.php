<!DOCTYPE html>
<html>
    <head>
        <title>@yield('title')</title>

        <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">

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
        </style>
    </head>
    <body>
        <nav class="navbar navbar-default">
            @yield('navbar')
        </nav>
        <div class="container-fluid">
            @yield('content')
        </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
    <script>
    var path = location.href.split( '/' );
    var protocol = path[0];
    var host = path[2];
    var url = protocol + '//' + host;
    </script>
    @yield('scripts')
    </body>
</html>
