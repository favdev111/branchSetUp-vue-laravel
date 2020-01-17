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
    <h1 class="display-4">Users</h1>
    <a style="margin: 19px;" href="{{ route('users.create')}}" class="btn btn-primary">New user</a>
    <table class="table table-striped">
        <thead>
        <tr>
            <td>First name</td>
            <td>Last name</td>
            <td>Email</td>
            <td class="text-center">Status</td>
            <td style="text-align: center">Actions</td>
        </tr>
        </thead>
        <tbody>
        @foreach($users as $user)
        <tr>
            <td>
                @if($user->branch_id != null)
                <a href="{{ route('show.user', $user->user_id)}}">{{$user->branchType->branch_type}}</a>
                @else
                {{ $user->branchType->branch_type }}
                @endif
            </td>
            <td>{{$user->branch_name}}</td>
            <td>{{$user->user_email}}</td>
            <td class="text-center">
                <span class="badge badge-success">{{$user->status}}</span>
            </td>
            <td style="text-align: center">
                <div style="display: inline-block">
                    <a href="{{ route('users.edit',$user->user_id)}}" class="btn btn-primary btn-sm">Edit</a>
                </div>
                <div style="display: inline-block">
                    <form action="{{ route('users.destroy', $user->user_id)}}" method="post">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm" type="submit">Delete</button>
                    </form>
                </div>
            </td>
        </tr>
        @endforeach
        </tbody>
    </table>
    <div>

        @endsection
