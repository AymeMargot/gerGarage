@extends('layouts.dashboard')
@section('title', 'accessories')
@section('content')

<div class="container">
<form action="{{ url('/accessories/'.$accessories->id) }}" method="post" enctype="multipart/form-data">
    @csrf
    {{ method_field('PATCH') }}

    @include('accessories.form',['mode'=>'editing'])  
    
</form>

</div>
@endsection