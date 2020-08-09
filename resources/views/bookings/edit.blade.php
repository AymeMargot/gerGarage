@extends('layouts.templateFrm')
@section('title', 'Bookings')
@section('content')

<div class="container">
    <form action="{{ url('/bookings/'.$bookings->id) }}" method="post" enctype="multipart/form-data">
        @csrf
        {{ method_field('PATCH') }}
        @include('bookings.form',['mode'=>'editing'])

    </form> 
</div>
@endsection