@extends('layouts.templateFrm')
@section('title', 'Vehicles')
@section('content')

<div class="container">    
    <form action="{{ url('vehicles') }}" method="post" enctype="multipart/form-data">
        @csrf
        @include('vehicles.form',['mode'=>'adding'])

    </form>
</div>
@endsection