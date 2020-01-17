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
    <link href="{{ asset('/css/style.css?v1.1') }}" rel="stylesheet">
    <link href="{{ asset('/geocoder_page/css/style.css?v1.1.2') }}" rel="stylesheet">


    {{-- <link rel="stylesheet" type="text/css" href="{{ asset('fonts/font-awesome-4.7.0/css/font-awesome.min.css') }}"> --}}
    {{-- <link rel="stylesheet" type="text/css" href="{{ asset('fonts/Linearicons-Free-v1.0.0/icon-font.min.css') }}"> --}}
    <meta name="csrf-token" content="{{ csrf_token() }}" />

</head>
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
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none">
				@csrf
				<a  href="{{ route('logout') }}"
					onclick="event.preventDefault();document.getElementById('logout-form').submit();">
					{{ __('Logout') }}
				</a>
			</form>
            <form id="registerForm" class="bv-form">
                <input type="hidden" id="smartystreets-api-key" value="{{ env('SMARTYSTREETS_API_KEY') }}">
                <input type="hidden" id="google-api-key" value="{{ env('GOOGLE_API_KEY') }}">

                @include('dashboard.branch-setup')

                @include('dashboard.address')

                @include('dashboard.phone')

                @include('dashboard.email')

                @include('dashboard.tax')

                @include('dashboard.branch-parameters')

                @include('dashboard.zipcodes')

                @include('dashboard.provider')

                @include('dashboard.supplier')

                <div class="tab report">
                        <span class="form-title"> Dashboard </span>

                        <div class="row">
                            <div class="col-md-6 col-xs-12">
                                @include('dashboard.report.setup')
                            </div>

                            <div class="col-md-6 col-xs-12">
                                @include('dashboard.report.address')
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 col-xs-12">
                                @include('dashboard.report.phone')
                            </div>

                            <div class="col-md-6 col-xs-12">
                                @include('dashboard.report.email')
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-md-6 col-xs-12">
                                @include('dashboard.report.tax')
                            </div>

                            <div class="col-md-6 col-xs-12">
                                @include('dashboard.report.provider')
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-xs-12">
                                @include('dashboard.report.parameters')
                            </div>
                            <div class="col-md-6 col-xs-12">
                                @include('dashboard.report.supplier')
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
                        <i class="fas fa-check-circle"></i>
                    </span>
                    <span class="step" data-number="6">
                        <i class="fas fa-parachute-box"></i>
                    </span>
                    <span class="step" data-number="7">
                        <i class="fas fa-check-circle"></i>
                    </span>
                    <span class="step" data-number="8">
                        <i class="fas fa-check-circle"></i>
                    </span>
                    <span class="step" data-number="9">
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
    <div id="parameters-provider" class="modal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5  class="modal-title">Parameters for </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                
					<form action="{{ route('branch.add_provider_parameters') }}" id='add-parameters' class="bv-form" method='POST'>
						
						<div class="parameter">
							<input type='hidden' name="provider_id" id="providerIdInput">
							<div class="input-parameters"></div>

						</div>
					</form>
                </div>
                <div class="modal-footer">
                    <button type="button" id="save-parameters" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>
    <div id="parameters-supplier" class="modal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5  class="modal-title">Parameters for </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                
					<form action="{{ route('branch.add_supplier_parameters') }}" id='add-supplier-parameters' class="bv-form" method='POST'>
						
						<div class="parameter">
							<input type='hidden' name="supplier_id" id="supplierIdInput">
							<div class="input-supplier-parameters"></div>

						</div>
					</form>
                </div>
                <div class="modal-footer">
                    <button type="button" id="save-supplier-parameters" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.1.1.min.js"> </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" ></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.bootstrapvalidator/0.5.2/js/bootstrapValidator.min.js"></script>
    <script src="https://cdn.rawgit.com/PascaleBeier/bootstrap-validate/v2.2.0/dist/bootstrap-validate.js"></script>

    <script>
        $(document).ready(function(){

            // Remove provider type
            // $('#provider_type').selectpicker();
            // $('#provider_name').selectpicker();
            $('#pr_type').selectpicker();
            $('#pr_name').selectpicker();
            $('#sp_name').selectpicker();

			
			$(document).on("changed.bs.select",'#provider_name, #pr_name', function(e, clickedIndex, newValue, oldValue) {
				if (newValue) {
					var branch_provider_name = $(this).find('option').eq(clickedIndex).text();
					var branch_provider_id = $(this).find('option').eq(clickedIndex).val();
					getProviderParameters(branch_provider_id, branch_provider_name)
				}
			});
			$(document).on("changed.bs.select",'#sp_name', function(e, clickedIndex, newValue, oldValue) {
				if (newValue) {
					var name = $(this).find('option').eq(clickedIndex).text();
					var id = $(this).find('option').eq(clickedIndex).val();
					getSupplierParameters(id, name)
				}
			});
			$('#add-parameters, #add-supplier-parameters').bootstrapValidator({
                message: 'This value is not valid',
                feedbackIcons: {
                    valid: 'fa fa-ok',
                    invalid: 'fa fa-remove',
                    validating: 'fa fa-refresh'
                },
                fields: {}
			});
			var oldParameters = [],
			    validator = $("#add-parameters").data('bootstrapValidator');
			function getProviderParameters(branch_provider_id, name) {
				$('#providerIdInput').val(branch_provider_id);
				$('#parameters-provider').find('.form-group').remove();
				$('#parameters-provider').find('.modal-title').html("Parameters for "+name);
					$.ajax({
						type:"GET",
						url: "{{ route('branch-type.provider-parameters') }}",
						data:{
							branch_provider_id: branch_provider_id
						},
						success: function(data) {
                            var fields = {},
                                newParameters = [];
                            
							data.parameters.forEach(function (param) {
								var type= '',
								    options = {};
								switch (param.parameter_type) {
									case "CHECK":
										type = "class='checkbox' type='checkbox'";
										if (param.parameter_value == "Y") {
											type += " checked";
										}
										break;
									case "INTEGER":
										type = "type='number' value='"+param.parameter_value+"' data-bv-integer='true' data-bv-integer-message='The "+param.parameter_desc+" must be integer'";
										break;
									case "DECIMAL":
										type = "type='number' step='0.01' lang='en' value='"+param.parameter_value+"'";
										options = {
        								    validators: {
        								        numeric: {
        								            message: 'The '+param.parameter_desc+' must be numeric'
        								        }
        								    }
        								};
										break;
									case "DATE":
									    type = "type='text' value='"+param.parameter_value+"' data-bv-date='true' data-bv-date-format='"+param.parameter_mask+"' data-bv-message='Please enter a valid date'";
										break;
									default:
										type = "type='text' value='"+param.parameter_value+"'";
								}
								if (param.parameter_type == "CHECK") {
										var paramBlock = "<div class='form-group custom-control custom-checkbox' style='padding-left: 2.5rem;'>" +
									   "<input class='custom-control-input' name='"+param.branch_provider_parameter_id+"'\n" + type +
									   "        id=\"parameter-value-" + param.branch_provider_parameter_id + "\">\n" +
									   "<label class='custom-control-label' for='parameter-value-"+param.branch_provider_parameter_id+"'>" + param.parameter_desc + "\n" +
									   "        </label>\n" +
									   "    </div>\n";

								} else {
									var paramBlock = "<div class='col-md-12 form-group'>" +
									   "<label for='\"parameter-value-"+param.branch_provider_parameter_id+"'><span>" + param.parameter_desc + "</span>\n" +
									   "                                </label>\n" +
									   "<input class='form-control' name='"+param.branch_provider_parameter_id+"'\n" + type +

									   "                                       id=\"\"parameter-value-" + param.branch_default_parameter_id + "\">\n" +
									   "                            </div>\n";
								}

                                newParameters.push(param.branch_provider_parameter_id);
								$('.input-parameters').after(paramBlock);
								$("#add-parameters").bootstrapValidator('addField', $("[name='"+param.branch_provider_parameter_id+"']"));
							});
							oldParameters.forEach(function(param){
							    validator.removeField(param);
							});
							oldParameters = newParameters;
						}
					});
					$('#parameters-provider').find('.parameter').removeAttr('id');
					$('#parameters-provider').find('.parameter').attr('id','parameter-'+branch_provider_id);
					$('#parameters-provider').modal('show');
				};
				
			$('#save-parameters').click(function() {
			    $('#add-parameters').data('bootstrapValidator').validate();
			    if($('#add-parameters').data('bootstrapValidator').isValid()) {
    				var $form = $('#add-parameters');
    				    $.ajaxSetup({
    						headers: {
    						  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    						}
    					  });
    					  $('#parameters-provider').modal('hide')
    				$.ajax({
                        type:"POST",
                        url: $form.attr('action'),
                        data: $form.serialize(),
    					success: function(data)
    					{
    						console.log(data);
    					}
    				});
    				$('#parameters-provider').find('.form-group').remove();
			    }
				
			});
			
			// SUPPLIER CODE
			var oldSupplierParameters = [],
			    supplierValidator = $("#add-supplier-parameters").data('bootstrapValidator');
			function getSupplierParameters(id, name) {
				$('#supplierIdInput').val(id);
				$('#parameters-supplier').find('.form-group').remove();
				$('#parameters-supplier').find('.modal-title').html("Parameters for "+name);
					$.ajax({
						type:"GET",
						url: "{{ route('branch-type.supplier-parameters') }}",
						data:{
							branch_supplier_id: id
						},
						success: function(data) {
                            var fields = {},
                                newParameters = [];
                            
							data.parameters.forEach(function (param) {
								var type= '',
								    options = {};
								switch (param.parameter_type) {
									case "CHECK":
										type = "class='checkbox' type='checkbox'";
										if (param.parameter_value == "Y") {
											type += " checked";
										}
										break;
									case "INTEGER":
										type = "type='number' value='"+param.parameter_value+"' data-bv-integer='true' data-bv-integer-message='The "+param.parameter_desc+" must be integer'";
										break;
									case "DECIMAL":
										type = "type='number' step='0.01' lang='en' value='"+param.parameter_value+"'";
										options = {
        								    validators: {
        								        numeric: {
        								            message: 'The '+param.parameter_desc+' must be numeric'
        								        }
        								    }
        								};
										break;
									case "DATE":
									    type = "type='text' value='"+param.parameter_value+"' data-bv-date='true' data-bv-date-format='"+param.parameter_mask+"' data-bv-message='Please enter a valid date'";
										break;
									default:
										type = "type='text' value='"+param.parameter_value+"'";
								}
								if (param.parameter_type == "CHECK") {
										var paramBlock = "<div class='form-group custom-control custom-checkbox' style='padding-left: 2.5rem;'>" +
									   "<input class='custom-control-input' name='"+param.branch_supplier_parameter_id+"'\n" + type +
									   "        id=\"supplier-parameter-value-" + param.branch_supplier_parameter_id + "\">\n" +
									   "<label class='custom-control-label' for='supplier-parameter-value-"+param.branch_supplier_parameter_id+"'>" + param.parameter_desc + "\n" +
									   "        </label>\n" +
									   "    </div>\n";

								} else {
									var paramBlock = "<div class='col-md-12 form-group'>" +
									   "<label for='\"supplier-parameter-value-"+param.branch_supplier_parameter_id+"'><span>" + param.parameter_desc + "</span>\n" +
									   "                                </label>\n" +
									   "<input class='form-control' name='"+param.branch_supplier_parameter_id+"'\n" + type +

									   "                                       id=\"\"supplier-parameter-value-" + param.branch_default_parameter_id + "\">\n" +
									   "                            </div>\n";
								}

                                newParameters.push(param.branch_supplier_parameter_id);
								$('.input-supplier-parameters').after(paramBlock);
								$("#add-supplier-parameters").bootstrapValidator('addField', $("[name='"+param.branch_supplier_parameter_id+"']"));
							});
							oldSupplierParameters.forEach(function(param){
							    validator.removeField(param);
							});
							oldSupplierParameters = newParameters;
						}
					});
					$('#parameters-supplier').find('.parameter').removeAttr('id');
					$('#parameters-supplier').find('.parameter').attr('id','parameter-'+id);
					$('#parameters-supplier').modal('show');
				};
				
			$('#save-supplier-parameters').click(function() {
			    $('#add-supplier-parameters').data('bootstrapValidator').validate();
			    if($('#add-supplier-parameters').data('bootstrapValidator').isValid()) {
    				var $form = $('#add-supplier-parameters');
    				    $.ajaxSetup({
    						headers: {
    						  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    						}
    					  });
    					  $('#parameters-supplier').modal('hide')
    				$.ajax({
                        type:"POST",
                        url: $form.attr('action'),
                        data: $form.serialize(),
    					success: function(data)
    					{
    						console.log(data);
    					}
    				});
    				$('#parameters-supplier').find('.form-group').remove();
			    }
				
			});
			
			$(function() { 
                var branchTypeId = $( "#branch_type option:selected" ).val();

                $("#br_type").val($(this).val());
                // 'provider-name-' . $type->branch_type_id
                $('.provider-name-' + $(this).val()).show();

                

                $.ajax({
                    type:"GET",
                    url:"{{ route('branch-type.providers') }}",
                    data:{
                        'branch_type_id': branchTypeId
                    },

                    success: function(data) {
                        var provs = data.providers;

                        if(provs.length == 0)
                            return;
                        @if (!$branch->branch_name)
                        $('#pr_name').empty();
						$('ol.provider-list').empty();
						@endif

                        for(var i in provs){
                            $('#pr_name').append('<option value="' + provs[i]['branch_provider_id'] + '">' + provs[i]['provider_name']+' ' + provs[i]['provider_type'] + '</option>');
							$('table.provider-list').append("<tr><td width='65%'><div class='form-group custom-control custom-checkbox' style='padding-left: 2.5rem;'>" +
									   "<input class='custom-control-input' type='checkbox' name='provider-list[]' value='"+provs[i]['branch_provider_id']+"'\n" +
									   "        id=\"parameter-value-" + provs[i]['branch_provider_id'] + "\" "+ (provs[i]['status']=='Active' ? "checked" : "")+ ">\n" +
									   "<label class='custom-control-label' for='parameter-value-"+provs[i]['branch_provider_id']+"'>" + provs[i]['provider_name'] +
									   '</label></div></td><td>' + provs[i]['provider_type'] + "\n" +
									   "        </td></tr>\n");
						}

                        $('#pr_name').selectpicker('refresh');
                    }
                });
                
                $.ajax({
                    type:"GET",
                    url:"{{ route('branch-type.suppliers') }}",
                    data:{
                        'branch_type_id': branchTypeId
                    },

                    success: function(data) {
                        var provs = data.suppliers;

                        if(provs.length == 0)
                            return;
                        @if (!$branch->branch_name)
                        $('#sp_name').empty();
						$('ol.supplier-list').empty();
						@endif

                        for(var i in provs){
                            $('#sp_name').append('<option value="' + provs[i]['branch_supplier_id'] + '">' + provs[i]['supplier_name']+' ' + provs[i]['supplier_type'] + '</option>');
							$('table.supplier-list').append("<tr><td width='65%'><div class='form-group custom-control custom-checkbox' style='padding-left: 2.5rem;'>" +
									   "<input class='custom-control-input' type='checkbox' name='supplier-list[]' value='"+provs[i]['branch_supplier_id']+"'\n" +
									   "        id=\"supplier-parameter-value-" + provs[i]['branch_supplier_id'] + "\" "+ (provs[i]['status']=='Active' ? "checked" : "")+ ">\n" +
									   "<label class='custom-control-label' for='supplier-parameter-value-"+provs[i]['branch_supplier_id']+"'>" + provs[i]['supplier_name'] +
									   '</label></div></td><td>' + provs[i]['supplier_type'] + "\n" +
									   "        </td></tr>\n");
						}

                        $('#sp_name').selectpicker('refresh');
                    }
                });
            });

			$(document).on('change', '.provider-list .custom-control-input', function() {
				if(this.checked) {
					var branch_provider_id = $(this).val();
					var branch_provider_name = $("label[for='"+$(this).attr("id")+"']").text();
					getProviderParameters(branch_provider_id, branch_provider_name);
				}
				var checkedVals = $('table.provider-list').find('.custom-control-input:checkbox:checked').map(function() {
					return this.value;
				}).get();
				$('#pr_name').val(checkedVals);
				$('#pr_name').selectpicker('refresh')

            });
            $(document).on('change', '.supplier-list .custom-control-input', function() {
				if(this.checked) {
					var branch_supplier_id = $(this).val();
					var branch_supplier_name = $("label[for='"+$(this).attr("id")+"']").text();
					getSupplierParameters(branch_supplier_id, branch_supplier_name);
				}
				var checkedVals = $('table.supplier-list').find('.custom-control-input:checkbox:checked').map(function() {
					return this.value;
				}).get();
				$('#sp_name').val(checkedVals);
				$('#sp_name').selectpicker('refresh')

            });

            $('#branch_timezone').change(function(){
                $("#br_timezone").val($(this).val());
            });
			@if ($branch->branch_name)
					for (i=1;i<10   ;i++) {
						$("#nextBtn").click();
					}
			@endif
            // $('#branch_radius').change(function(){
                // $("#br_radius").val($(this).val());
            // });
        });
    </script>

    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD2my6bwPBehUVpmOYxdFfwYHyRobrRok8&libraries=places"
            ></script>
    <script src="{{ asset('/geocoder_page/js/map.js?v1.0.12') }}"></script>
    <script src="{{ asset('/js/main.js?v1.2.27') }}"></script>
</body>
</html>
