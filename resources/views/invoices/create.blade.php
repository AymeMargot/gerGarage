@extends('layouts.list')
@section('title', 'Invoices')
@section('content')
<br>
<form class="shadow p-3 mb-5 bg-white rounded" action="{{ url('/invoices')  }}" method="post">
    @csrf
    @include('invoices.form',['mode'=>'adding'])
</form>
@endsection