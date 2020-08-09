@extends('layouts.templateFrm')
@section('title', 'Bookings')
@section('content')

<div class="container">
    <form action="{{ url('/invoice_supplies/'.$invoices->id) }}" method="post" enctype="multipart/form-data">
        @csrf
        {{ method_field('PATCH') }}
        @include('invoice_supplies.form',['mode'=>'editing'])

    </form> 
</div>
@endsection