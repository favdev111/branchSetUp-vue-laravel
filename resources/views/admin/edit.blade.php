@extends('layouts.admin')

@section('content')
<div class="col-sm-9 offset-sm-3">
    <div class="row">
        <div class="col-md-6">
            <span>
                <span class="display-4">My profile</span>

            </span>
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
    <form method="post" action="{{ url('edit-complete') }}">
        @csrf
        <div class="form-group">
            <label for="first_name">Name:</label>
            <input type="text" class="form-control" name="name" value={{ $admin->name }} />
        </div>
        <div class="form-group">
            <label for="username">Username:</label>
            <input type="text" class="form-control" name="username" value={{ $admin->username }} />
        </div>
        <div class="form-group">
            <label for="first_name">Email:</label>
            <input type="text" class="form-control" name="email" value={{ $admin->email }} />
        </div>
        <div class="form-group">
            <label for="first_name">Password:</label>
            <input type="text" class="form-control" name="password" />
            <small>If you don't want a change your password, leave this field empty.</small>
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>
@endsection
