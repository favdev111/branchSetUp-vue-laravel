@extends('layouts.admin')

@section('content')
<div class="col-sm-9 offset-3">
    <div class="col-sm-12" style="margin-top: 77px;">
        @if(session()->get('success'))
        <div class="alert alert-success">
            {{ session()->get('success') }}
        </div>
        @endif
    </div>
    <h1 class="display-5">Branch for user {{$user->first_name}} {{$user->last_name}}</h1>
    <div class="row">
        <div class="col-md-6">
            <div class="card rounded-0" style="margin-bottom: 15px;">
                <div class="card-header">
                    <h3 class="mb-0">Branch setup</h3>
                </div>
                <div class="card-body" style="height: 250px; overflow: auto">
                    <div class="form-group">
                        <label for="uname1">Type</label>
                        <input type="text" class="form-control form-control-lg rounded-0"
                               name="uname1" id="uname1" value="{{$user->branch->type->branch_type}}" disabled>
                    </div>
                    <div class="form-group">
                        <label for="uname1">Name</label>
                        <input type="text" class="form-control form-control-lg rounded-0"
                               name="uname1" id="uname1" value="{{$user->branch->branch_name}}" disabled>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card rounded-0" style="margin-bottom: 15px;">
                <div class="card-header">
                    <h3 class="mb-0">Address</h3>
                </div>
                <div class="card-body" style="height: 250px; overflow: auto">
                    @if($addresses)
                    @foreach($addresses as $address)
                    <div class="row">
                        <div class="col-sm-6">
                            <label for="uname1">Type</label>
                            <input type="text" class="form-control form-control-lg rounded-0"
                                   name="uname1" id="uname1" value="{{$address->address_type}}" disabled>
                        </div>
                        <div class="col-sm-6">
                            <label for="uname1">Country</label>
                            <input type="text" class="form-control form-control-lg rounded-0"
                                   name="uname1" id="uname1" value="{{$address->country}}" disabled>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <label for="uname1">Address</label>
                            <input type="text" class="form-control form-control-lg rounded-0"
                                   name="uname1" id="uname1" value="{{$address->address}}" disabled>
                        </div>
                        <div class="col-sm-6">
                            <label for="uname1">Zipcode</label>
                            <input type="text" class="form-control form-control-lg rounded-0"
                                   name="uname1" id="uname1" value="{{$address->zipcode}}" disabled>
                        </div>
                    </div>
                    <hr>
                    @endforeach
                    @endif
                </div>

            </div>
        </div>


        <div class="col-md-6">
            <div class="card rounded-0" style="margin-bottom: 15px;">
                <div class="card-header">
                    <h3 class="mb-0">Email</h3>
                </div>
                <div class="card-body" style="height: 250px; overflow: auto">
                    @if($emails)
                    @foreach($emails as $email)
                    <div class="row">
                        <div class="col-sm-6">
                            <label for="uname1">Email type</label>
                            <input type="text" class="form-control form-control-lg rounded-0"
                                   name="uname1" id="uname1" value="{{$email->email_type}}" disabled>
                        </div>
                        <div class="col-sm-6">
                            <label for="uname1">Status</label>
                            <input type="text" class="form-control form-control-lg rounded-0"
                                   name="uname1" id="uname1" value="{{$email->status}}" disabled>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <label for="uname1">Email</label>
                            <input type="text" class="form-control form-control-lg rounded-0"
                                   name="uname1" id="uname1" value="{{$email->email}}" disabled>
                        </div>
                    </div>
                    <hr>
                    @endforeach
                    @endif
                </div>

            </div>
        </div>



        <div class="col-md-6">
            <div class="card rounded-0" style="margin-bottom: 15px;">
                <div class="card-header">
                    <h3 class="mb-0">Provider</h3>
                </div>
                <div class="card-body" style="height: 250px; overflow: auto">
                    @if($providersArr)
                    @foreach($providersArr as $provider)
                    <div class="row">
                        <div class="col-sm-6">
                            <label for="uname1">Name</label>
                            <input type="text" class="form-control form-control-lg rounded-0"
                                   name="uname1" id="uname1" value="{{$provider->provider->provider_name}}" disabled>
                        </div>
                        <div class="col-sm-6">
                            <label for="uname1">Status</label>
                            <input type="text" class="form-control form-control-lg rounded-0"
                                   name="uname1" id="uname1" value="{{$provider->status}}" disabled>
                        </div>
                    </div>
                    <hr>
                    @endforeach
                    @endif
                </div>

            </div>
        </div>

        <div class="col-md-6">
            <div class="card rounded-0" style="margin-bottom: 15px;">
                <div class="card-header">
                    <h3 class="mb-0">Tax</h3>
                </div>
                <div class="card-body" style="height: 250px; overflow: auto">
                    @if($user->branch)
                    @foreach($user->branch->taxes as $tax)
                    <div class="row">
                        <div class="col-sm-6">
                            <label for="uname1">Type</label>
                            <input type="text" class="form-control form-control-lg rounded-0"
                                   name="uname1" id="uname1" value="{{$tax->tax_type}}" disabled>
                        </div>
                        <div class="col-sm-6">
                            <label for="uname1">Percentage</label>
                            <input type="text" class="form-control form-control-lg rounded-0"
                                   name="uname1" id="uname1" value="{{$tax->tax_percent}} %" disabled>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <label for="uname1">Status</label>
                            <input type="text" class="form-control form-control-lg rounded-0"
                                   name="uname1" id="uname1" value="{{$tax->status}}" disabled>
                        </div>
                    </div>
                    <hr>
                    @endforeach
                    @endif
                </div>

            </div>
        </div>

    </div>
    <div>

        @endsection
