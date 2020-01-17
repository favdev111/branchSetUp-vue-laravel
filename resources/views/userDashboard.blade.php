<!--<!DOCTYPE html>-->
<!--<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">-->
<!--<head>-->
<!--    <meta charset="UTF-8">-->
<!--    <meta name="viewport" content="width=device-width, initial-scale=1.0">-->
<!--    <meta http-equiv="X-UA-Compatible" content="ie=edge">-->
<!--    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">-->
<!--    <link rel="stylesheet"-->
<!--          href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css"/>-->
<!--    <link rel="stylesheet"-->
<!--          href="//cdnjs.cloudflare.com/ajax/libs/jquery.bootstrapvalidator/0.5.2/css/bootstrapValidator.min.css"/>-->
<!--    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">-->
<!---->
<!---->
<!--    <style type="text/css">-->
<!--        button.dropdown-toggle {-->
<!--            border-radius: 40px;-->
<!--            font-size: 1em;-->
<!--        }-->
<!---->
<!--        div.bootstrap-select {-->
<!--            border-radius: 40px;-->
<!--        }-->
<!--    </style>-->
<!---->
<!--    <title>Registration</title>-->
<!---->
<!--    <link href="{{ asset('/css/style.css') }}" rel="stylesheet">-->
<!---->
<!---->
<!--</head>-->
<!---->
<!--<body>-->
<!--<div class="main-background" style="background-image: url('img/bg-01.jpg');">-->
<!--    <h1>Hello {{$user->first_name}} {{$user->last_name}}</h1>-->
<!--    <div class="container form-background">-->

<!--        <div class="row">-->
<!--            <div class="col-md-6">-->
<!--                <div class="card rounded-0" style="margin-bottom: 15px;">-->
<!--                    <div class="card-header">-->
<!--                        <h3 class="mb-0">Branch setup</h3>-->
<!--                    </div>-->
<!--                    <div class="card-body" style="height: 250px; overflow: auto">-->
<!--                        <div class="form-group">-->
<!--                            <label for="uname1">Type</label>-->
<!--                            <input type="text" class="form-control form-control-lg rounded-0"-->
<!--                                   name="uname1" id="uname1" value="{{$user->branch->type->branch_type}}" >-->
<!--                        </div>-->
<!--                        <div class="form-group">-->
<!--                            <label for="uname1">Name</label>-->
<!--                            <input type="text" class="form-control form-control-lg rounded-0"-->
<!--                                   name="uname1" id="uname1" value="{{$user->branch->branch_name}}" >-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
<!---->

<!--                </div>-->
<!--            </div>-->
<!---->





<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" />
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/jquery.bootstrapvalidator/0.5.2/css/bootstrapValidator.min.css"/>
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">


    <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" ></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" ></script>
    <script src="https:////cdnjs.cloudflare.com/ajax/libs/jquery.bootstrapvalidator/0.5.2/js/bootstrapValidator.min.js"></script>
    <script src="https://cdn.rawgit.com/PascaleBeier/bootstrap-validate/v2.2.0/dist/bootstrap-validate.js" ></script>

    <!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>-->
    <!--<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.bundle.min.js"></script>-->
    <!--<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>-->

    <style type="text/css">
        button.dropdown-toggle{
            border-radius: 40px;
            font-size: 1em;
        }
        div.bootstrap-select{
            border-radius: 40px;
        }
    </style>
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/angular.js/1.7.8/angular.js"></script> --}}
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/angular.js/1.7.8/angular-route.js"></script> --}}
    {{-- <script src="{{ asset('js/bootstrap-input-spinner.js') }}"> </script> --}}
    <title>Registration</title>

    {{-- <link href="{{ asset('/fonts/css/glyphicon.css') }}" rel="stylesheet"> --}}
<!--    <link href="{{ asset('/css/app.css') }}" rel="stylesheet">-->
    <link href="{{ asset('/css/style.css') }}" rel="stylesheet">

    {{-- <link rel="stylesheet" type="text/css" href="{{ asset('fonts/font-awesome-4.7.0/css/font-awesome.min.css') }}"> --}}
    {{-- <link rel="stylesheet" type="text/css" href="{{ asset('fonts/Linearicons-Free-v1.0.0/icon-font.min.css') }}"> --}}
    <meta name="csrf-token" content="{{ csrf_token() }}" />

</head>

<script type="text/javascript">

</script>
<body>
<div class="main-background" style="background-image: url('img/bg-01.jpg');">
    <div class="container form-background">
            <div class="report">
                <span class="form-title"> Dashboard </span>
                <form id="logout-form" action="{{ route('logout') }}" method="POST">
                    @csrf
                    <a  href="{{ route('logout') }}"
                        onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                        {{ __('Logout') }}
                    </a>
                </form>
                <div class="row">
                    <div class="col-md-6 col-xs-12">
                        <div id="branch" class="report-col">
                            <h2 class="row-title text-center"> Branch Setup </h2>
                            <hr>
                            <div class="form-row">
                                <div class="form-group col-md-6 has-feedback">
                                    <label for="br_name">Branch Name</label>
                                    <i class="fa fa-code-branch form-control-feedback icon"></i>
                                    <input  type="text" class="form-control" id="br_name" value="{{$user->branch->branch_name}}" name="br_name">
                                </div>
                                <div class="form-group col-md-6 has-feedback">
                                    <label for="br_name">Branch type</label>
                                    <i class="fa fa-code-branch form-control-feedback icon"></i>
                                    <input  type="text" class="form-control" id="br_name" value="{{$user->branch->type->branch_type}}" name="br_name">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6 has-feedback">
                                    <label for="br_name">Branch created</label>
                                    <i class="fa fa-code-branch form-control-feedback icon"></i>
                                    <input  type="text" class="form-control" id="br_name" value="{{$user->branch->status}}" name="br_name">
                                </div>
                                <div class="form-group col-md-6 has-feedback">
                                    <label for="br_name">Branch type status</label>
                                    <i class="fa fa-code-branch form-control-feedback icon"></i>
                                    <input  type="text" class="form-control" id="br_name" value="{{$user->branch->type->status}}" name="br_name">
                                </div>
                            </div>

                            <!--</div>-->
                        </div>
                    </div>

                    <div class="col-md-6 col-xs-12">

                        <div id="address" class="report-col">
                            <h2 class="row-title text-center"> Address </h2>
                                <hr>
                            @foreach($addresses as $address)
                            <div class="address-row">
                                <div class="form-row">
                                    <div class="form-group col-md-6 has-feedback">
                                        <label for="br_name">Type</label>
                                        <i class="fas fa-map-marked-alt form-control-feedback icon"></i>
                                        <input  type="text" class="form-control" id="br_name" value="{{$address->address_type}}" name="br_name">
                                    </div>
                                    <div class="form-group col-md-6 has-feedback">
                                        <label for="br_name">Country</label>
                                        <i class="fas fa-map-marked-alt form-control-feedback icon"></i>
                                        <input  type="text" class="form-control" id="br_name" value="{{$address->country}}" name="br_name">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-6 has-feedback">
                                        <label for="br_name">Address</label>
                                        <i class="fas fa-map-marked-alt form-control-feedback icon"></i>
                                        <input  type="text" class="form-control" id="br_name" value="{{$address->address}}" name="br_name">
                                    </div>
                                    <div class="form-group col-md-6 has-feedback">
                                        <label for="br_name">Zipcode</label>
                                        <i class="fas fa-map-marked-alt form-control-feedback icon"></i>
                                        <input  type="text" class="form-control" id="br_name" value="{{$address->zipcode}}" name="br_name">
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 col-xs-12">
                        <div id="phone" class="report-col">
                            <h2 class="row-title text-center"> Phone number </h2>
                            <hr>
                            @foreach($phones as $phone)
                            <div class="phone-row">
                                <div class="form-row">
                                    <div class="col-md-6 col-xs-12 form-group">
                                        <label for="ph_number"> Type </label>
                                        <i class="fas fa-phone-alt form-control-feedback icon"></i>
                                        <input  name="ph_number" value="{{$phone->phone_type}}" class="form-control" id="ph_number">
                                    </div>
                                    <div class="col-md-6 col-xs-12 form-group has-feedback">
                                        <label for="ph_number"> Status </label>
                                        <i class="fas fa-phone-alt form-control-feedback icon"></i>
                                        <input  name="ph_number" value="{{$phone->status}}" class="form-control" id="ph_number">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-md-12 col-xs-12 form-group has-feedback">
                                        <label for="ph_number"> Phone </label>
                                        <i class="fas fa-phone-alt form-control-feedback icon"></i>
                                        <input  name="ph_number" value="{{$phone->phone}}" class="form-control" id="ph_number">
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="col-md-6 col-xs-12">
                        <div id="email" class="report-col">
                            <h2 class="row-title text-center"> Email </h2>
                            <hr>
                            @foreach($emails as $email)
                            <div class="tax-row">
                                <div class="form-row">
                                    <div class="form-group col-md-6 has-feedback">
                                        <label for="br_name">Email type</label>
                                        <i class="fas fa-at form-control-feedback icon"></i>
                                        <input  type="text" class="form-control" id="br_name" value="{{$email->email_type}}" name="br_name">
                                    </div>
                                    <div class="form-group col-md-6 has-feedback">
                                        <label for="br_name">Status</label>
                                        <i class="fas fa-at form-control-feedback icon"></i>
                                        <input  type="text" class="form-control" id="br_name" value="{{$email->status}}" name="br_name">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-12 has-feedback">
                                        <label for="br_name">Email</label>
                                        <i class="fas fa-at form-control-feedback icon"></i>
                                        <input  type="text" class="form-control" id="br_name" value="{{$email->email}}" name="br_name">
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>



                <div class="row">
                    <div class="col-md-6 col-xs-12">
                        <div id="tax" class="report-col">
                            <h2 class="text-center row-title"> Tax </h2>
                            <hr>
                            @foreach($user->branch->taxes as $tax)
                            <div class="tax-row">
                                <div class="form-row">
                                    <div class="form-group col-md-6 has-feedback">
                                        <label for="br_name">Type</label>
                                        <i class="far fa-credit-card form-control-feedback icon"></i>
                                        <input  type="text" class="form-control" id="br_name" value="{{$tax->tax_type}}" name="br_name">
                                    </div>
                                    <div class="form-group col-md-6 has-feedback">
                                        <label for="br_name">Status</label>
                                        <i class="far fa-credit-card form-control-feedback icon"></i>
                                        <input  type="text" class="form-control" id="br_name" value="{{$tax->status}}" name="br_name">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-12 has-feedback">
                                        <label for="br_name">Percetage</label>
                                        <i class="far fa-credit-card form-control-feedback icon"></i>
                                        <input  type="text" class="form-control" id="br_name" value="{{$tax->tax_percent}}" name="br_name">
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>


                    <div class="col-md-6 col-xs-12">
                        <div id="provider" class="report-col">
                            <h2 class="text-center row-title"> Provider </h2>
                            <hr>
                           
                        </div>
                    </div>
                </div>
            </div>

    </div>
</div>
</body>

</html>

