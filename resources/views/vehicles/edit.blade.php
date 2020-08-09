@extends('layouts.templateFrm')
@section('title', 'Vehicles')
@section('content')

<div class="container">
    <form action="{{ url('/vehicles/'.$vehicles->id) }}" method="post" enctype="multipart/form-data">
        @csrf
        {{ method_field('PATCH') }}

        @include('vehicles.form',['mode'=>'editing'])

    </form>
</div>
@endsection