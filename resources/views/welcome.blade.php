<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css"/>
    <link rel="stylesheet"
          href="//cdnjs.cloudflare.com/ajax/libs/jquery.bootstrapvalidator/0.5.2/css/bootstrapValidator.min.css"/>
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">


    <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script
        src="https:////cdnjs.cloudflare.com/ajax/libs/jquery.bootstrapvalidator/0.5.2/js/bootstrapValidator.min.js"></script>
    <script src="https://cdn.rawgit.com/PascaleBeier/bootstrap-validate/v2.2.0/dist/bootstrap-validate.js"></script>


    <style type="text/css">
        button.dropdown-toggle {
            border-radius: 40px;
            font-size: 1em;
        }

        div.bootstrap-select {
            border-radius: 40px;
        }
    </style>
    <title>Login</title>

    {{--
    <link href="{{ asset('/fonts/css/glyphicon.css') }}" rel="stylesheet">
    --}}
    <link href="{{ asset('/css/style.css') }}" rel="stylesheet">

    {{--
    <link rel="stylesheet" type="text/css" href="{{ asset('fonts/font-awesome-4.7.0/css/font-awesome.min.css') }}">
    --}}
    {{--
    <link rel="stylesheet" type="text/css" href="{{ asset('fonts/Linearicons-Free-v1.0.0/icon-font.min.css') }}">
    --}}

</head>
<body>
<div class="main-background" style="background-image: url('img/bg-01.jpg');">
    <div class="container form-background" style="padding: 0px !important;">
        <h1 class="text-center">Hello user, please login</h1>
        <p class="text-center mb-4 mt-4"><a class="btn btn-success btn-rounded submitBtn" href="{{ url('login') }}"  id="submitBtn"  style="width: 300px;">Login</a></p>

    </div>
</div>
</body>

</html>
