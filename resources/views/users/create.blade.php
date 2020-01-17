@extends('layouts.admin')

@section('content')
    <div class="col-sm-9 offset-sm-3">
        <div class="row">
            <div class="col-md-6">
                <h1 class="display-4">Add user</h1>
            </div>
            <div class="col-md-6">
                <a style="margin: 19px;" href="{{ url('users')}}" class="btn btn-secondary btm-sm float-right">Back</a>
            </div>
        </div>

        <hr>
        <div>
            @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div><br />
            @endif
            <div class="container">
                <form method="post" action="{{ route('users.store') }}">
                    @csrf
                    <div class="row">
                        <div class="col">
                            <label for="branch_type">Branch Type</label>
                            <select id="branch_type" class="form-control" name="branch_type">
                                <option selected value="">Choose Branch type</option>
                                @foreach($branch_types as $type)
                                <option value="{{ $type->branch_type_id }}"> {{ $type->branch_type }} </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col">
                            <label for="branch_name">Branch Name:</label>
                            <input type="text" class="form-control" name="branch_name"/>
                        </div>
                    </div>
                    <hr>
                    
                

                    <div class="row">
                        
                        <div class="col">
                            <label for="email">Email:</label>
                            <input type="email" class="form-control" name="user_email"/>
                        </div>
                        <div class="col">
                            <label for="password">Password:</label>
                            <input type="text" class="form-control" value="{{ $password }}" name="password"/>
                            <small>Take this password, or choose your own!</small>
                        </div>
                    </div>

                    <div class="form-group">
                        
                    </div>
<!--                    <div class="form-group">-->
<!--                        <label for="job_title">Job Title:</label>-->
<!--                        <input type="text" class="form-control" name="job_title"/>-->
<!--                    </div>-->
                    <button type="submit" class="btn btn-primary">Add user</button>
                </form>
            </div>
        </div>
    </div>
@endsection
