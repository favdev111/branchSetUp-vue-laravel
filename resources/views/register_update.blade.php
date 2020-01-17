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
            <div class="container registration-successful">
                <div class="text-center pt-4">
                    <h2 class="text-center display-4 mt-4 font-weight-bold">Registered!</h2>
                    <!-- <p class="text-center mb-4 mt-4"><a class="btn btn-success btn-rounded submitBtn" href="{{ url('test') }}" style="width: 300px;">Go to dashboard</a></p> -->
                    <p class="text-center mb-4 mt-4"><a class="btn btn-success btn-rounded submitBtn" href="javascript: hiddenSuccess();" style="width: 300px;">Go to dashboard</a></p>
                </div>
            </div>
            <form id="logout-form" action="{{ route('logout') }}" method="POST">
				@csrf
				<a  href="{{ route('logout') }}"
					onclick="event.preventDefault();document.getElementById('logout-form').submit();">
					{{ __('Logout') }}
				</a>
			</form>

            <form id="registerForm">
                <input type="hidden" id="smartystreets-api-key" value="{{ env('SMARTYSTREETS_API_KEY') }}">
                <input type="hidden" id="google-api-key" value="{{ env('GOOGLE_API_KEY') }}">
                <input type="hidden" id="update" name="update" value="1" />
                <div class="tab">
                    <span class="form-title"> Branch Setup </span>
                    <div class="form-row branch-row">
                        <div class="form-group col-md-6">
                            <label for="branch_type">Branch Type</label>
                            <select id="branch_type" class="form-control" name="branch_type">
                                <option value="">Choose Branch type</option>
                                @foreach($branch_types as $type)
                                     <option value="{{ $type->branch_type_id }}" {{ $branch['branch_type_id'] == $type->branch_type_id? 'selected': '' }}> {{ $type->branch_type }} </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="branch_name">Branch Name</label>
                            <i class="fa fa-code-branch form-control-feedback icon"></i>
                            <input type="text" class="form-control" id="branch_name" name="branch_name" placeholder="Branch name" value="{{ $branch['branch_name'] }}" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="branch_timezone"> Branch Timezone </label>
                            <select id="branch_timezone" class="form-control" name="branch_timezone">
                                <option selected value="">Choose Branch Timezone</option>
                                <option value="1" {{ $branch['time_zone'] == 1? 'selected': '' }}> Central Daylight Time (CDT) </option>
                                <option value="2" {{ $branch['time_zone'] == 2? 'selected': '' }}> Mountain Daylight Time (MDT) </option>
                                <option value="3" {{ $branch['time_zone'] == 3? 'selected': '' }}> Mountain Standard Time (MST) </option>
                                <option value="4" {{ $branch['time_zone'] == 4? 'selected': '' }}> Pacific Daylight Time (PDT) </option>
                                <option value="5" {{ $branch['time_zone'] == 5? 'selected': '' }}> Alaska Daylight Time (ADT) </option>
                                <option value="6" {{ $branch['time_zone'] == 6? 'selected': '' }}> Hawaii-Aleutian Standard Time (HAST) </option>
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group my-1 col-md-4">
                            <label for="branch_radius">Radius</label>
                            <select id="branch_radius" class="form-control" name="branch_radius">
                                <option selected value="">Choose...</option>
                                <option value="1" {{ $branch['Service_Radius'] == 1? 'selected': '' }}>1</option>
                                <option value="2" {{ $branch['Service_Radius'] == 2? 'selected': '' }}>2</option>
                                <option value="3" {{ $branch['Service_Radius'] == 3? 'selected': '' }}>3</option>
                                <option value="4" {{ $branch['Service_Radius'] == 4? 'selected': '' }}>4</option>
                                <option value="5" {{ $branch['Service_Radius'] == 5? 'selected': '' }}>5</option>
                                <option value="6" {{ $branch['Service_Radius'] == 6? 'selected': '' }}>6</option>
                                <option value="7" {{ $branch['Service_Radius'] == 7? 'selected': '' }}>7</option>
                                <option value="8" {{ $branch['Service_Radius'] == 8? 'selected': '' }}>8</option>
                                <option value="9" {{ $branch['Service_Radius'] == 9? 'selected': '' }}>9</option>
                            </select>
                        </div>

                        <div class="form-group col-md-4 radio-group pl-5">
                            <label> Time format &nbsp;&nbsp; </label>
                            <div class="custom-control custom-radio radio form-group">
                                <input type="radio" id="branch_time_12" name="branch_time" class="custom-control-input form-group" {{ $branch['Time_Format'] == 12? 'checked': '' }} value="12">
                                <label class="custom-control-label" for="branch_time_12">12 </label>
                            </div>
                            <div class="custom-control custom-radio radio">
                                <input type="radio" id="branch_time_24" name="branch_time" class="custom-control-input form-group" {{ $branch['Time_Format'] == 24? 'checked': '' }} value="24">
                                <label class="custom-control-label" for="branch_time_24"> 24</label>
                            </div>
                        </div>
                        <div class="col-md-4 pt-3 ">
                            <div class="custom-control custom-checkbox form-group">
                                <input type="checkbox" class="custom-control-input" id="branch_mulreg" name="branch_mulreg" {{ $branch['Mult_Reg'] != false? 'checked': '' }}>
                                <label class="custom-control-label" for="branch_mulreg"> Multi Registeration </label>
                            </div>
                            <div class="custom-control custom-checkbox form-group">
                                <input type="checkbox" class="custom-control-input" id="branch_noskill" name="branch_noskill" {{ $branch['No_Skills'] != false? 'checked': '' }}>
                                <label class="custom-control-label" for="branch_noskill"> No Skills </label>
                            </div>
                        </div>
                    </div>

                </div>
                {{-- Begin Address Tab --}}
                <div class="tab">
                    <span class="form-title"> Address Setup</span>
                    @foreach($addresses as $address)
                        <div class="form-row address-row">
                            <div class="form-group col-3">
                                <label for="address_type">Address Type</label>
                                <select id="address_type" name="address_type[]" class="form-control">
                                    <option value="">Choose address</option>
                                    <option value="o" {{ $address->address_type == 'office'? 'selected': ''}}> Office </option>
                                    <option value="s" {{ $address->address_type == 'shipping'? 'selected': ''}}> Shipping </option>
                                    <option value="m" {{ $address->address_type == 'mail'? 'selected': ''}}> Mail </option>
                                    <option value="b" {{ $address->address_type == 'billing'? 'selected': ''}}> Billing </option>
                                </select>
                            </div>
                            <div class="form-group col-md-2">
                                <label for="address_zip">Zip</label>
                                <i class="fas fa-file-archive form-control-feedback icon"></i>
                                <input class="form-control" id="address_zip" name="address_zip[]" value="{{ $address->zipcode }}" required>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="address_county">County</label>
                                <i class="fas fa-globe-americas form-control-feedback icon"></i>
                                <input type="text" class="form-control" id="address_county" name="address_county[]" value="{{ $address->county }}">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="address_city">City</label>
                                <i class="fas fa-city form-control-feedback icon"></i>
                                <input type="text" class="form-control" id="address_city" name="address_city[]" value="{{ $address->city }}">
                            </div>
                            <div class="form-group col-6">
                                <label for="address_1">Address</label>
                                <i class="fas fa-address-card form-control-feedback icon"></i>
                                <i class="fas fa-address-card form-control-feedback icon"></i>
                                <input type="text" class="form-control" id="address_1" name="address_1[]" value="{{ $address->address }}" placeholder="1234 Main St" required>
                            </div>
                            <div class="form-group col-6">
                                <label for="address_2"> &nbsp; </label>
                                <i class="fas fa-address-card form-control-feedback icon"></i>
                                <input type="text" class="form-control" id="address_2" name="address_2[]" value="{{ $address->address2 }}" placeholder="Apartment, studio, or floor">
                            </div>
                        </div>
                    @endforeach
                    <hr/>
                    <div class="form-row">
                        <div class="col-md-2"></div>

                        <div class="col-md-4 mb-1" style="margin-right:0px;">
                            <button type="button" onclick="onAddAddress()" class="btn btn-success btn-rounded" id="btnAddAddress">
                                <span class="fas fa-plus mr-2"></span> Add </button>
                        </div>

                        <div class="col-md-4 mb-1" style="margin-right:0px;">
                            <button type="button" onclick="onDeleteAddress()" class="btn btn-danger btn-rounded" id="btnDeleteAddress">
                                <span class="fas fa-trash mr-2"></span>
                                Delete </button>
                        </div>

                        <div class="col-md-2"></div>
                    </div>
                </div>
                {{-- End Address Tab --}}
                {{-- Begin Phone Tab --}}
                <div class="tab phone">
                    <span class="form-title"> Phone number setup </span>
                    @foreach($phones as $phone)
                    <div class="form-row phone-row">
                        <div class="col-md-6 form-group">
                            <label> Type </label>
                            <select id="phone_type" class="form-control" name="phone_type[]">
                                <option value="">Choose phone type</option>
                                <option value="o" {{ $phone->phone_type == 'office'? 'selected': '' }}> Main office </option>
                                <option value="f" {{ $phone->phone_type == 'fax'? 'selected': '' }}> Fax </option>
                            </select>
                        </div>

                        <div class="col-md-6 form-group">
                            <label for="phone_number"> Number </label>
                            <i class="fas fa-phone-alt form-control-feedback icon"></i>
                            <input name="phone_number[]" class="form-control" id="phone_number" placeholder="" type="phonenumber" value={{ $phone->phone }}>
                        </div>
                    </div>
                    @endforeach
                    <hr/>
                    <div class="form-row">
                        <div class="col-md-2"></div>

                        <div class="col-md-4 col-xs-12 mb-1" style="margin-right:0px;">
                            <button type="button" onclick="onAddPhone()" class="btn btn-success btn-rounded" id="btnAddPhone">
                                <span class="fa fa-plus"></span>
                                Add </button>
                        </div>

                        <div class="col-md-4 col-xs-12 mb-1" style="margin-right:0px;">
                            <button type="button" onclick="onDeletePhone()" class="btn btn-danger btn-rounded" id="btnDeletePhone">
                                <span class="fa fa-trash"></span>
                                Delete </button>
                        </div>

                        <div class="col-md-2"></div>
                    </div>
                </div>
                {{-- End Phone Tab --}}
                {{-- Begin Email Tab --}}
                <div class="tab email">
                    <span class="form-title"> Email setup </span>
                    @foreach($emails as $email)
                    <div class="form-row email-row">
                        <div class="col-md-6 form-group">
                            <label> Type </label>
                            <select name="email_type[]" id="email_type" class="form-control">
                                <option value="">Choose email type</option>
                                <option value="o" {{ $email->email_type == 'office'? 'selected': '' }}> office </option>
                                <option value="s" {{ $email->email_type == 'support'? 'selected': '' }}> support </option>
                            </select>
                        </div>
                        <div class="col-md-6 form-group">
                            <label  for="email_address"> email </label>
                            <i class="fas fa-at form-control-feedback icon"></i>
                            <input name="email_address[]" class="form-control" id="email_address" placeholder="" value="{{ $email->email }}" type="email">
                        </div>
                    </div>
                    @endforeach
                    <hr/>
                    <div class="form-row">
                        <div class="col-md-2"></div>

                        <div class="col-md-4 col-xs-12 mb-1" style="margin-right:0px;">
                            <button type="button" onclick="onAddEmail()" class="btn btn-success btn-rounded">
                                <span class="fa fa-plus"></span>
                                Add </button>
                        </div>

                        <div class="col-md-4 col-xs-12 mb-1" style="margin-right:0px;">
                            <button type="button" onclick="onDeleteEmail()" class="btn btn-danger btn-rounded">
                                <span class="fa fa-trash"></span>
                                Delete </button>
                        </div>

                        <div class="col-md-2"></div>
                    </div>
                </div>
                {{-- End Email Tab --}}
                {{-- Begin Tax Tab --}}
                <div class="tab tax">
                    <span class="form-title"> Tax setup </span>
                    @foreach($taxes as $tax)
                    <div class="form-row tax-row">
                        <div class="col-md-6 fcol-xs-12 form-group">
                            <label> Type </label>
                            <i class="fas fa-credit-card form-control-feedback icon"></i>
                            <input name="tax_type" id="tax_type" value='{{ $tax->tax_type}}' class="form-control">
                        </div>

                        <div class="col-md-6 form-group">
                            <label  for="tax_percent"> Tax percent </label>
                            <i class="fas fa-percent form-control-feedback icon"></i>
                            <input name="tax_percent[]" class="form-control" value='{{ $tax->tax_percent }}' id="tax_percent">
                        </div>
                    </div>
                    @endforeach
                    <hr/>
                    <div class="form-row">
                        <div class="col-md-2"></div>

                        <div class="col-md-4 col-xs-12 mb-1" style="margin-right:0px;">
                            <button type="button" onclick="onAddTax()" class="btn btn-success btn-rounded">
                                <span class="fa fa-plus"></span>
                                Add </button>
                        </div>

                        <div class="col-md-4 col-xs-12 mb-1" style="margin-right:0px;">
                            <button type="button" onclick="onDeleteTax()" class="btn btn-danger btn-rounded">
                                <span class="fa fa-trash"></span>
                                Delete </button>
                        </div>

                        <div class="col-md-2"></div>
                    </div>
                </div>
                {{-- End Tax Tab --}}
                {{-- Begin Provider Tab --}}
                <div class="tab provider">
                    <span class="form-title"> Provider Setup </span>
                    
                    <div class="form-row provider-row">
                        <div class="col-md-6 form-group">
                            <label > Type </label>
                            <select name = "provider_type[]" id="provider_type" class="form-control selectpicker" multiple data-live-search="true">
                                @php $providertypes=json_decode(json_encode($providertypes), true); @endphp
                                <!--<option value=""> Choose type </option>-->
                                @foreach($providertypes as $row)
                                <option value="{{ $row['provider_type_id'] }} "
                                    @foreach($provider['branch_type_ids'] as $val)
                                        {{ $val == $row['provider_type_id']? 'selected': '' }}
                                    @endforeach
                                
                                > {{ $row['provider_type'] }} </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="provider_name">Provider name</label>
                            <i class="fas fa-university form-control-feedback icon"></i>
                           
                            <select name = "provider_name[]" id="provider_name" class="form-control selectpicker" value="" multiple data-live-search="true">
                                @foreach($provider['provider_names'] as $row)
                                <option value="{{ $row['provider_id'] }}" selected> {{ $row['provider_name'] }} </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="provider_acc_number">Account Number</label>
                            <i class="fas fa-credit-card form-control-feedback icon"></i>
                            <input name = "provider_acc_number[]" id="provider_acc_number" class="form-control" value="{{ $provider['acc_number'] }}">
                        </div>
                        <div class="form-group mt-1 col-md-6 col-xs-12 text-center pt-4">
                                <label> Do we provide b2b for it? </label>

                                <div class="custom-control custom-radio custom-control-inline mt-2 radio">
                                    <input type="radio" id="provider_b2b_yes" name="provider_b2b[]" class="custom-control-input" value="yes"
                                        {{$provider['b2b'] == 'yes'? 'checked': '' }} >
                                    <label class="custom-control-label" for="provider_b2b_yes">Yes </label>
                                </div>

                                <div class="custom-control custom-radio custom-control-inline radio">
                                    <input type="radio" id="provider_b2b_no" name="provider_b2b[]"  class="custom-control-input" value="no"
                                        {{ $provider['b2b'] == 'no'? 'checked': '' }} >
                                    <label class="custom-control-label" for="provider_b2b_no" checked=""> No </label>
                                </div>
                        </div>
                    </div>
                    
                    <hr/>
                </div>
                {{-- End Provider Tab --}}
                {{-- Report Tab --}}
                <div class="tab report">
                        <span class="form-title"> Dashboard </span>

                        <div class="row">
                            <div class="col-md-6 col-xs-12">
                                <div id="branch" class="report-col">
                                    <span class="row-title"> Branch Setup </span>
                                    <!--<div class="branch-row" style="display:none;">-->
                                        <div class="form-row">
                                            <div class="form-group col-md-12 has-feedback">
                                                <label for="br_type"> Type </label>
                                                <select id="br_type" class="form-control" name="br_type">
                                                <option value="">Choose Branch type</option>
                                                    @foreach($branch_types as $type)
                                                        <option value="{{ $type->branch_type_id }}" {{ $branch['branch_type_id'] == $type->branch_type_id? 'selected': '' }}> {{ $type->branch_type }} </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group col-md-6 has-feedback">
                                                <label for="br_name">Branch Name</label>
                                                <i class="fa fa-code-branch form-control-feedback icon"></i>
                                                <input type="text" class="form-control" id="br_name" name="br_name" placeholder="Branch name" value="{{ $branch['branch_name'] }}" required>
                                            </div>
                                        </div>

                                        <div class="form-row">
                                            <div class="form-group col-md-12 has-feedback">
                                            <label for="br_timezone"> Branch Timezone </label>
                                                <select id="br_timezone" class="form-control" name="br_timezone">
                                                    <option value="">Choose Branch Timezone</option>
                                                    <option value="1" {{ $branch['time_zone'] == 1? 'selected': '' }}> Central Daylight Time (CDT) </option>
                                                    <option value="2" {{ $branch['time_zone'] == 2? 'selected': '' }}> Mountain Daylight Time (MDT) </option>
                                                    <option value="3" {{ $branch['time_zone'] == 3? 'selected': '' }}> Mountain Standard Time (MST) </option>
                                                    <option value="4" {{ $branch['time_zone'] == 4? 'selected': '' }}> Pacific Daylight Time (PDT) </option>
                                                    <option value="5" {{ $branch['time_zone'] == 5? 'selected': '' }}> Alaska Daylight Time (ADT) </option>
                                                    <option value="6" {{ $branch['time_zone'] == 6? 'selected': '' }}> Hawaii-Aleutian Standard Time (HAST) </option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-row">
                                            <div class="form-group col-md-4 has-feedback">
                                            <label for="br_radius">Radius</label>
                                                <select id="br_radius" class="form-control" name="br_radius">
                                                    <option  value="">Choose...</option>
                                                    <option value="1" {{ $branch['Service_Radius'] == 1? 'selected': '' }}>1</option>
                                                    <option value="2" {{ $branch['Service_Radius'] == 2? 'selected': '' }}>2</option>
                                                    <option value="3" {{ $branch['Service_Radius'] == 3? 'selected': '' }}>3</option>
                                                    <option value="4" {{ $branch['Service_Radius'] == 4? 'selected': '' }}>4</option>
                                                    <option value="5" {{ $branch['Service_Radius'] == 5? 'selected': '' }}>5</option>
                                                    <option value="6" {{ $branch['Service_Radius'] == 6? 'selected': '' }}>6</option>
                                                    <option value="7" {{ $branch['Service_Radius'] == 7? 'selected': '' }}>7</option>
                                                    <option value="8" {{ $branch['Service_Radius'] == 8? 'selected': '' }}>8</option>
                                                    <option value="9" {{ $branch['Service_Radius'] == 9? 'selected': '' }}>9</option>
                                                </select>
                                            </div>
                                            <div class="form-group col-md-4 radio-group pl-2 has-feedback">
                                            <label> Time format &nbsp;&nbsp; </label>
                                                <br>
                                                <input type="radio" id="br_time12" name="br_time" class=" form-group" value="12" {{ $branch['Time_Format'] == 12? 'checked': '' }}> 12
                                                <br>
                                                <input type="radio" id="br_time24" name="br_time" class=" form-group" value="24" {{ $branch['Time_Format'] == 24? 'checked': '' }}> 24
                                            </div>
                                            <div class="col-md-4 pt-3 ">
                                                <div class="custom-control custom-checkbox form-group">
                                                    <input type="checkbox" class="custom-control-input" id="br_mulreg" name="br_mulreg" {{ $branch['Mult_Reg'] != false? 'checked': '' }}>
                                                    <label class="custom-control-label" for="br_mulreg"> Multi Registeration </label>
                                                </div>
                                                <div class="custom-control custom-checkbox form-group">
                                                    <input type="checkbox" class="custom-control-input" id="br_noskill" name="br_noskill" {{ $branch['No_Skills'] != false? 'checked': '' }}>
                                                    <label class="custom-control-label" for="br_noskill"> No Skills </label>
                                                </div>
                                            </div>
                                        </div>
                                    <!--</div>-->
                                </div>
                            </div>

                            <div class="col-md-6 col-xs-12">

                                <div id="address" class="report-col">
                                    <span class="row-title"> Address </span>
                                    <div class="address-row" style="display:none;">
                                        <div class="form-row">
                                            <div class="form-group col-md-6 col-xs-12 has-feedback">
                                                <label for="add_type">Type</label>
                                                <select id="add_type" class="form-control" name="add_type">
                                                    <option value="o">Office</option>
                                                    <option value="s">Shipping</option>
                                                    <option value="m">Mail</option>
                                                    <option value="b">Billing</option>
                                                </select>
                                            </div>

                                            <div class="form-group col-md-6 col-xs-12 has-feedback">
                                                <label for="add_county">County</label>

                                                <i class="fas fa-globe-americas form-control-feedback icon"></i>
                                                <input type="text" class="form-control" id="add_county" name="add_county">

                                            </div>

                                            <div class="form-group col-md-6 col-xs-12 has-feedback">
                                                <label for="add_city">City</label>

                                                <i class="fas fa-city form-control-feedback icon"></i>
                                                <input type="text" class="form-control" id="add_city" name="add_city" data-bv-field="add_city">

                                            </div>

                                            <div class="form-group col-md-6 col-xs-12 has-feedback">
                                                <label for="add_zip">Zip</label>

                                                <i class="fas fa-file-archive form-control-feedback icon"></i>
                                                <input class="form-control" id="add_zip" name="add_zip" required="" data-bv-field="add_zip">

                                            </div>

                                            <div class="form-group col-md-6 mb-1 col-xs-12 has-feedback">
                                                <label for="add_1">Address</label>

                                                <i class="fas fa-address-card form-control-feedback icon"></i>
                                                <input type="text" class="form-control" id="add_1" name="add_1">

                                            </div>

                                            <div class="form-group col-md-6 col-xs-12 mb-1 has-feedback">
                                                <label for="add_2"> &nbsp; </label>
                                                <i class="fas fa-address-card form-control-feedback icon"></i>
                                                <input type="text" class="form-control" id="add_2" name="add_2">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 col-xs-12">

                                <div id="phone" class="report-col">
                                    <span class="row-title"> Phone number </span>
                                    <div class="phone-row" style="display:none;">
                                        <div class="form-row">
                                            <div class="col-md-6 col-xs-12 form-group">
                                                <label> Type </label>
                                                <select id="ph_type" class="form-control" name="ph_type" data-bv-field="ph_type">
                                                    <option value="" selected="">Choose phone type</option>
                                                    <option value="o"> Main office </option>
                                                    <option value="f"> Fax </option>
                                                </select>
                                            </div>
                                            <div class="col-md-6 col-xs-12 form-group has-feedback">
                                                <label for="ph_number"> Number </label>
                                                <i class="fas fa-phone-alt form-control-feedback icon"></i>
                                                <input name="ph_number" class="form-control" id="ph_number">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="col-md-6 col-xs-12">
                                <div id="email" class="report-col">
                                    <span class="row-title"> Email </span>
                                    <div class="email-row" style="display:none;">
                                        <div class="form-row">
                                            <div class="col-md-6 col-xs-12 form-group">
                                                <label> Type </label>
                                                <select name="em_type" id="em_type" class="form-control" data-bv-field="em_type">
                                                    <option value="" selected="">Choose email type</option>
                                                    <option value="o"> office </option>
                                                    <option value="s"> support </option>
                                                </select>
                                            </div>

                                            <div class="col-md-6 col-xs-12 form-group has-feedback">
                                                <label for="em_address"> Email </label>

                                                <i class="fas fa-at form-control-feedback icon"></i>
                                                <input name="em_address" class="form-control" id="em_address" placeholder="" type="email">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 col-xs-12">
                                <div id="tax" class="report-col">
                                    <span class="row-title"> Tax </span>
                                    <div class="tax-row" style="display:none;">
                                        <div class="form-row">
                                            <div class="col-md-6 fcol-xs-12 form-group">
                                                <label> Type </label>
                                                <i class="fas fa-credit-card form-control-feedback icon"></i>
                                                <input name="tx_type" id="tx_type" class="form-control">
                                            </div>

                                            <div class="col-md-6 col-xs-12 form-group has-feedback">
                                                <label for="tx_percent"> Tax percent </label>
                                                <i class="fas fa-percent form-control-feedback icon"></i>
                                                <input name="tx_percent" class="form-control" id="tx_percent">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 col-xs-12">
                                <div id="provider" class="report-col">
                                    <span class="row-title"> Provider </span>
                                    <div class="provider-row">
                                        <div class="form-row">
                                            <div class="col-md-6 col-xs-12 form-group">
                                                <label> Type </label>
                                                <div class="form-group" id="clone_type">
                                                </div>
                                            </div>

                                            <div class="form-group col-md-6 col-xs-12 has-feedback">
                                                <label for="pr_name">Provider name</label>
                                                <i class="fas fa-university form-control-feedback icon"></i>
                                                <div class="form-group" id="clone_name">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-6 col-xs-12 has-feedback">
                                                <label for="pr_accnumber">Account Number</label>

                                                <i class="fas fa-credit-card form-control-feedback icon"></i>
                                                <input name="pr_accnumber" id="pr_accnumber" class="form-control" data-bv-field="pr_accnumber">

                                            </div>

                                            <div class="form-group mt-1 col-md-6 col-xs-12 text-center pt-4">
                                                    <label> Do we provide b2b for it? </label>

                                                    <!-- <div class="custom-control custom-radio custom-control-inline mt-2 radio"> -->
                                                        <br>
                                                        <input type="radio" id="provider_b2b_yes" name="pr_b2b[]"  value="yes"> Yes
                                                        <!-- <label class="custom-control-label" for="provider_b2b_yes">Yes </label> -->
                                                    <!-- </div> -->

                                                    <!-- <div class="custom-control custom-radio custom-control-inline radio"> -->
                                                        <input type="radio" id="provider_b2b_no" name="pr_b2b[]"  value="no"> No
                                                        <!-- <label class="custom-control-label" for="provider_b2b_no" checked=""> No </label> -->
                                                    <!-- </div> -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="updatedIds" id="updatedIds" value="">
                </div>
                {{-- End Report tab --}}
                <div class="steps mt-5">
                    <span class="step active" data-number="0">
                        <i class="fas fa-code-branch"></i>
                    </span>
                    <span class="step" data-number="1">
                        <i class="far fa-address-card"></i>
                    </span>
                    <span class="step" data-number="2">
                        <i class="fas fa-phone-alt"></i>
                    </span>
                    <span class="step" data-number="3">
                        <i class="far fa-envelope"></i>
                    </span>
                    <span class="step" data-number="4">
                        <i class="fas fa-funnel-dollar"></i>
                    </span>
                    <span class="step" data-number="5">
                        <i class="fas fa-parachute-box"></i>
                    </span>
                    <span class="step" data-number="6">
                        <i class="fas fa-check-circle"></i>
                    </span>
                </div>
                <div class="row p-5">
                    <div class="col-md-6 col-xs-12 mb-1">
                        <button class="btn btn-blue-grey btn-rounded prevBtn" type="button" id="prevBtn" onclick="nextPrev(-1)" style="display: none;">Previous</button>
                    </div>
                    <div class="col-md-6 col-xs-12 mb-1">
                        <button class="btn btn-success btn-rounded nextBtn" type="button" id="nextBtn" onclick="nextPrev(1)" style="display: inline;">Next</button>
                        <button class="btn btn-danger btn-rounded submitBtn" type="button" id="submitBtn" onclick="onSubmitBtn()" style="display: none;">Submit</button>
                    </div>
                    <div class="col-6">

                    </div>
                </div>
            </form>
        </div>
    </div>
    <script src="http://code.jquery.com/jquery-3.1.1.min.js"> </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" ></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.bootstrapvalidator/0.5.2/js/bootstrapValidator.min.js"></script>
    <script src="https://cdn.rawgit.com/PascaleBeier/bootstrap-validate/v2.2.0/dist/bootstrap-validate.js"></script>
    <script src="{{ asset('/js/main.js') }}"></script>
</body>
<script>
$(document).ready(function(){
    $('#provider_type').selectpicker();
    $('#provider_name').selectpicker();
    $('#pr_type').selectpicker();
    $('#pr_name').selectpicker();
    
    
    
    $('#provider_type').change(function(){
        $.ajax({
            type:"GET",
            url:"{{ route('user.getprovide_name') }}",
            data:{type_ids:$(this).val()},
            success:function(providers){
                provs = providers['names'];
                if(provs.length == 0)
                    return;
                $('#provider_name').empty();
                for(var i in provs){
                    $('#provider_name').append('<option value="' + provs[i]['provider_id'] + '">' + provs[i]['provider_name'] + '</option>');
                }
                $('#provider_name').selectpicker('refresh');
            }
        });
        $('#clone_type').find('*').remove();
        var clone_multiselect = $(this).clone();
        var pr_type=clone_multiselect.attr('id','pr_type');
        var pr_type=clone_multiselect.attr('name','pr_type[]');
        clone_multiselect.appendTo('#clone_type');
        $(clone_multiselect).selectpicker('refresh');
        $('#pr_type').selectpicker('val', $(this).val());
        
    });

    $('#provider_type').click(function(){
        $('#clone_type').find('*').remove();
        var clone_multiselect = $(this).clone();
        var pr_type=clone_multiselect.attr('id','pr_type');
        var pr_type=clone_multiselect.attr('name','pr_type[]');
        clone_multiselect.appendTo('#clone_type');
        $(clone_multiselect).selectpicker('refresh');
        $('#pr_type').selectpicker('val', $(this).val());
        
    });

    $('#provider_type').click();


    $('#provider_name').change(function(){
        $('#clone_name').find('*').remove();
        var clone_multiselect = $(this).clone();
        var pr_type=clone_multiselect.attr('id','pr_name');
        var pr_type=clone_multiselect.attr('name','pr_name[]');
        clone_multiselect.appendTo('#clone_name');
        $(clone_multiselect).selectpicker('refresh');
        $('#pr_name').selectpicker('val', $(this).val());
    });

    $('#provider_name').click(function(){
        $('#clone_name').find('*').remove();
        var clone_multiselect = $(this).clone();
        var pr_type=clone_multiselect.attr('id','pr_name');
        var pr_type=clone_multiselect.attr('name','pr_name[]');
        clone_multiselect.appendTo('#clone_name');
        $(clone_multiselect).selectpicker('refresh');
        $('#pr_name').selectpicker('val', $(this).val());
    });

    $('#provider_name').click();

    showTab(1);
    $("#nextBtn").click();
    showTab(2);
    $("#nextBtn").click();
    showTab(3);
    $("#nextBtn").click();
    showTab(4);
    $("#nextBtn").click();
    showTab(5);
    $("#nextBtn").click();
    showTab(6);
    $("#nextBtn").click();
  
    

    $('#branch_type').change(function(){
       $("#br_type").val($(this).val());
    });
    $('#branch_timezone').change(function(){
       $("#br_timezone").val($(this).val());
    });
    $('#branch_radius').change(function(){
       $("#br_radius").val($(this).val());
    });


});
</script>
</html>
