@extends('layouts.dashboard')
@section('title', 'accessories')
@section('content')

<div class="container">
<form action="{{ url('/accessories') }}" method="post" enctype="multipart/form-data">
    @csrf
    @include('accessories.form',['mode'=>'adding'])
    
</form>
</div>
@endsection