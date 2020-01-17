@extends('layouts.admin')

@section('content')
<div class="col-sm-9 offset-sm-3">
    <div class="row">
        <div class="col-md-6">
            <span>
                <span class="display-4">Update user</span>
                
            </span>
        </div>
        <div class="col-md-6" style="padding-top: 28px;">
            User status: <span class="badge badge-success">{{$user->status}}</span>
        </div>
    </div>

    <hr>

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    <br/>
    @endif
    <form method="post" action="{{ route('users.update', $user->user_id) }}">
        @method('PATCH')
        @csrf
        <div class="form-group">
            <label for="branch_type">Branch Type</label>
            <select id="branch_type" class="form-control" name="branch_type">
                <option selected value="{{$user->branchType->branch_type_id}}">{{$user->branchType->branch_type}}</option>
                @foreach($branch_types as $type)
                @if($type->branch_type_id !== $user->branchType->branch_type_id)
                <option value="{{ $type->branch_type_id }}"> {{ $type->branch_type }} </option>
                @endif
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="branch_name">Branch Name:</label>
            <input type="text" class="form-control" name="branch_name" value={{ $user->branch_name }} />
        </div>
       

        <div class="form-group">
            <label for="email">Email:</label>
            <input type="text" class="form-control" name="user_email" value={{ $user->user_email }} />
        </div>
        <div class="form-group">

        </div>

        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ url('users') }}" class="btn btn-secondary">cancel</a>
    </form>
</div>
@endsection
