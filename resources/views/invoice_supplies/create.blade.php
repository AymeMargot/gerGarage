@extends('layouts.form')
@section('title', 'Invoices')
@section('content')
<form action="{{ url('/invoice_supplies/save/'.$invoices->id)  }}" method="post">
    @csrf
    @include('invoice_supplies.form',['mode'=>'adding'])
</form>
@endsection