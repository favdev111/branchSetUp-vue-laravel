@extends('layouts.main')

@section('content')
<div id="app">
    <form ref="logoutForm" id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none">
        @csrf
    </form>
    <dashboard></dashboard>
</div>

<script>
    data = {!! json_encode($data) !!};
</script>
@stop